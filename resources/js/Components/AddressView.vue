<template>
  {{ renderedAddress }}
</template>

<script>
import PostalAddress from "i18n-postal-address";

export default {
  props: ["address"],

  watch: {
    address: function() {
      this.renderedAddress = new PostalAddress()
        .setAddress1(this.address.street1)
        .setAddress2(this.address.street2)
        .setCity(this.address.suburb)
        .setState(this.address.state)
        .setCountry(this.address.country)
        .setPostalCode(this.address.postcode)
        .setFormat({ country: "AU" })
        .output()
        .map((part) => part.join(" "))
        .join(", ");
    },
  },

  data() {
    return {
      renderedAddress: new PostalAddress()
        .setAddress1(this.address.street1)
        .setAddress2(this.address.street2)
        .setCity(this.address.suburb)
        .setState(this.address.state)
        .setCountry(this.address.country)
        .setPostalCode(this.address.postcode)
        .setFormat({ country: "AU" })
        .output()
        .map((part) => part.join(" "))
        .join(", "),
    };
  },
};
</script>

