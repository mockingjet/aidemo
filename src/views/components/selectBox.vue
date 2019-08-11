<template>
  <v-dialog v-model="open" width="500">
    <v-card>
      <v-card-title class="headline grey lighten-2" primary-title>Select A Parameter</v-card-title>
      <v-btn-toggle v-model="index" mandatory class="_optionBox">
        <v-btn flat v-for="(option,i) in newOptions" :key="i" class="_option">{{option}}</v-btn>
      </v-btn-toggle>
      <v-card-actions>
        <v-btn color="secondary" block dark @click="returnOptions">Confirm</v-btn>
        <v-btn color="secondary" block dark class="red" @click="deleteOption">DELETE</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  props: ["options"],
  data: () => ({
    open: false,
    index: null,
    newOptions: null
  }),
  methods: {
    returnOptions() {
      this.$emit("returnSelect", this.newOptions[this.index]);
      this.open = false;
    },
    deleteOption() {
      this.api
        .delete(this.url.deleteParam + "?param=" + this.newOptions[this.index])
        .then(() => {
          this.newOptions.splice(this.index, 1);
          this.open = false;
        })
        .catch(err =>
          this.swal({
            title: err
          })
        );
    }
  },
  watch: {
    options() {
      this.newOptions = this.options;
      this.open = this.options ? true : false;
    }
  }
};
</script>

<style>
._optionBox {
  display: block;
  padding: 10px 20px;
  min-height: 40vh;
  box-shadow: 0px !important;
}
._option {
  width: calc(100% - 10px) !important;
  box-shadow: 0px !important;
}
._option.v-btn.v-btn--active {
  border: 1px solid blue;
}
._option.v-btn.v-btn--active::before {
  background-color: lightblue;
}
._option .v-btn__content {
  justify-content: right;
}
</style>
