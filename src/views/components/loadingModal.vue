<template>
  <v-dialog v-model="dialog" persistent width="500">
    <v-card color="secondary" dark>
      <v-card-text>
        PLEASE WAIT FOR A MOMENT &nbsp;&nbsp; 
        ({{this.progress>1 ? this.progress+'/100' : 'Initializing...'}})
        <v-progress-linear v-model="progress" :indeterminate="this.progress<2" color="white" class="mb-0"></v-progress-linear>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  props: {
    loading: Number
  },
  data: () => ({
    dialog: false,
    progress: 0
  }),
  watch: {
    loading() {
      if (this.loading != 0 && this.loading != 100) {
        this.dialog = true;
        this.progress = this.loading;
      } else {
        this.dialog = false;
        this.progress = 0;
      }
    }
  }
};
</script>

<style>
</style>
