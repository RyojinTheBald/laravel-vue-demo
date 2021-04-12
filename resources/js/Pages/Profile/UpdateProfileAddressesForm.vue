<template>
  <jet-form-section>
    <template #title> Addresses </template>

    <template #description> Update your account's saved addresses. </template>

    <template #form>
      <div class="col-span-6 sm:col-span-6">
        <jet-label for="address_list" value="Stored Addresses" />

        <ol id="address_list" v-if="addresses">
          <li
            class="grid grid-cols-6 gap-6"
            v-for="address in addresses"
            :key="address.id"
          >
            <div
              class="col-span-4 mt-1 rounded-md border-gray-300 shadow-sm block py-2"
              style="border-width: 1px; text-overflow: ellipsis; height: 32px; white-space: nowrap; line-height: 1; word-break: break-all; overflow: hidden;"
            >
              <address-view :address="address" />
            </div>
            
            <div class="col-span-2" style="text-align: right">
              <jet-edit-button
                type="button"
                class="mt-1"
                @click="openEdit(address)"
                >Edit</jet-edit-button
              >
              <jet-danger-button class="ml-1" @click="openConfirm(address)"
                >Delete</jet-danger-button
              >
            </div>
          </li>
        </ol>
      </div>

      <jet-dialog-modal :show="modalOpen" @close="closeEdit">
        <template #title> {{ editMode ? "Edit" : "Add" }} Address </template>

        <template #content>
          <div class="mt-4">
            <div class="col-span-6 sm:col-span-4">
              <jet-label for="street1" value="Street (line 1)" />
              <jet-input
                id="street1"
                type="text"
                class="mt-1 block w-full"
                v-model="form.street1"
              />
              <jet-input-error :message="form.errors.street1" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
              <jet-label for="street2" value="Street (line 2)" />
              <jet-input
                id="street2"
                type="text"
                class="mt-1 block w-full"
                v-model="form.street2"
              />
              <jet-input-error :message="form.errors.street2" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
              <jet-label for="suburb" value="Suburb" />
              <jet-input
                id="suburb"
                type="text"
                class="mt-1 block w-full"
                v-model="form.suburb"
              />
              <jet-input-error :message="form.errors.suburb" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
              <jet-label for="state" value="State" />
              <jet-input
                id="state"
                type="text"
                class="mt-1 block w-full"
                v-model="form.state"
              />
              <jet-input-error :message="form.errors.state" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
              <jet-label for="country" value="Country" />
              <select id="country" class="mt-1 block w-full" v-model="form.country">
                <option v-for="(country, code) in countries.codes" :key="code" :value="code">{{country}}</option>
              </select>
              <jet-input-error :message="form.errors.country" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
              <jet-label for="postcode" value="Postcode" />
              <jet-input
                id="postcode"
                type="text"
                class="mt-1 block w-full"
                v-model="form.postcode"
              />
              <jet-input-error :message="form.errors.postcode" class="mt-2" />
            </div>
          </div>
        </template>

        <template #footer>
          <jet-secondary-button @click="closeEdit">
            Cancel
          </jet-secondary-button>

          <jet-edit-button
            class="ml-2"
            @click="editMode ? confirmEdit() : confirmAdd()"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            Save
          </jet-edit-button>
        </template>
      </jet-dialog-modal>

      <jet-dialog-modal :show="confirmOpen" @close="closeConfirm">
        <template #title> Delete Address </template>

        <template #content>
          Are you sure you want to delete the address:
          <div
            class="col-span-4 mt-1 rounded-md border-gray-300 shadow-sm block py-2"
            style="border-width: 1px"
          >
            <address-view :address="this.form" />
          </div>
        </template>

        <template #footer>
          <jet-secondary-button @click="closeConfirm">
            Cancel
          </jet-secondary-button>

          <jet-danger-button
            class="ml-2"
            @click="confirmDelete"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            Delete Address
          </jet-danger-button>
        </template>
      </jet-dialog-modal>
    </template>

    <template #actions>
      <jet-button @click="openAdd"> Add </jet-button>
    </template>
  </jet-form-section>
</template>

<script>
import JetButton from "@/Jetstream/Button";
import JetDialogModal from "@/Jetstream/DialogModal";
import JetDangerButton from "@/Jetstream/DangerButton";
import JetEditButton from "@/Jetstream/EditButton";
import JetFormSection from "@/Jetstream/FormSection";
import JetInput from "@/Jetstream/Input";
import JetInputError from "@/Jetstream/InputError";
import JetLabel from "@/Jetstream/Label";
import JetActionMessage from "@/Jetstream/ActionMessage";
import JetSecondaryButton from "@/Jetstream/SecondaryButton";
import AddressView from "@/Components/AddressView";

export default {
  components: {
    JetDialogModal,
    JetActionMessage,
    JetButton,
    JetDangerButton,
    JetEditButton,
    JetFormSection,
    JetInput,
    JetInputError,
    JetLabel,
    JetSecondaryButton,
    AddressView
  },

  props: ["addresses", "countries"],

  data() {
    return {
      form: this.$inertia.form({
        id: "",
        street1: "",
        street2: "",
        suburb: "",
        state: "",
        postcode: "",
        country: this.countries.default,
      }),
      confirmOpen: false,
      modalOpen: false,
      editMode: false,
    };
  },

  methods: {
    openConfirm(address) {
      for (const field in address) {
        this.form[field] = address[field];
      }

      this.confirmOpen = true;
    },
    closeConfirm() {
      this.confirmOpen = false;
      this.form.reset();
    },
    confirmDelete() {
      this.form.delete(route("addresses.destroy", this.form.id), {
        preserveScroll: true,
        onSuccess: () => this.closeConfirm(),
        onError: (err) => console.error(err),
      });
    },
    openEdit(address) {
      for (const field in address) {
        this.form[field] = address[field];
      }
      this.editMode = true;
      this.modalOpen = true;
    },
    closeEdit() {
      this.modalOpen = false;
      this.form.reset();
    },
    confirmEdit() {
      this.form.patch(route("addresses.update", this.form.id), {
        preserveScroll: true,
        onSuccess: () => this.closeEdit(),
        onError: (err) => console.error(err),
      });
    },
    openAdd() {
      this.form.reset();
      this.editMode = false;
      this.modalOpen = true;
    },
    closeAdd() {
      this.modalOpen = false;
      this.form.reset();
    },
    confirmAdd() {
      this.form.post(route("addresses.store"), {
        preserveScroll: true,
        onSuccess: () => this.closeAdd(),
        onError: (err) => console.error(err),
      });
    },
  },
};
</script>
