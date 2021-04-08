<template>
  <jet-form-section @submitted="updateProfileAddresses">
    <template #title> Addresses </template>

    <template #description> Update your account's saved addresses. </template>

    <template #form>
      <div class="col-span-6 sm:col-span-4">
        <jet-label for="address_list" value="Stored Addresses" />

        <ol id="address_list">
          <li v-for="address in addresses" :key="address.id">
            {{ address.street }} - {{ address.city }} - {{ address.state }} - {{ address.country }} - {{ address.postcode }}

          </li>
        </ol>
      </div>
    </template>

    <template #actions>
      <jet-button> Save </jet-button>
    </template>
  </jet-form-section>
</template>

<script>
import JetButton from "@/Jetstream/Button";
import JetFormSection from "@/Jetstream/FormSection";
import JetInput from "@/Jetstream/Input";
import JetInputError from "@/Jetstream/InputError";
import JetLabel from "@/Jetstream/Label";
import JetActionMessage from "@/Jetstream/ActionMessage";
import JetSecondaryButton from "@/Jetstream/SecondaryButton";

export default {
  components: {
    JetActionMessage,
    JetButton,
    JetFormSection,
    JetInput,
    JetInputError,
    JetLabel,
    JetSecondaryButton,
  },

  props: ["user", "addresses"],

  data() {
    return {
      form: this.$inertia.form({
        _method: "PUT",
      })
    };
  },

  methods: {
    updateProfileAddresses() {
      this.form.post(route("user-profile-information.update"), {
        errorBag: "updateProfileInformation",
        preserveScroll: true,
      });
    },
  },
};
</script>
