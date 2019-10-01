<template>
  <v-card class="my-5">
    <v-toolbar v-show="dbset" dark color="secondary">
      <v-toolbar-title>Database Status</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn color="blue" @click="retrain()">
        Retrain
        <v-icon right dark>settings_backup_restore</v-icon>
      </v-btn>
    </v-toolbar>
    <div v-for="(item,i) in dbset" :key="i" style="padding:8px 12px 0px 8px;">
      <v-icon>folder</v-icon>
      {{item.typename}}
      <v-layout class="gallery" row wrap style="padding:10px 25px;">
        <v-flex xs5 sm4 md3 lg2 v-for="(file,j) in item.files" :key="j" style="margin:2px 0px">
          <v-tooltip right style="cursor:default" color="#fcfcfc" lazy nudge-right="-60">
            <div slot="activator" color="primary">
              <v-icon>image</v-icon>
              {{file}}
            </div>
            <img class="tooltip" :src="item.dirpath+'/'+file" :alt="file" />
          </v-tooltip>
        </v-flex>
      </v-layout>
      <v-btn
        outline
        style="float:right"
        color="red"
        :disabled="hasUploaded[i]"
        @click="upload(item.typename,i)"
      >
        {{ hasUploaded[i] ? "Finished" : "Upload" }}
        <v-icon right dark>cloud_upload</v-icon>
      </v-btn>

      <v-divider class="mt-5"></v-divider>
    </div>
  </v-card>
</template>
<script>
export default {
  props: ["dbset"],
  data: () => ({
    hasUploaded: [false, false, false, false]
  }),
  methods: {
    upload(dirname, i) {
      this.swal({
        customClass: "loadingModal",
        allowOutsideClick: false,
        onOpen: () => {
          this.swal.showLoading();
        }
      });
      this.api
        .post(this.url.view2upload, dirname)
        .then(() => {
          this.hasUploaded[i] = true;
          this.$forceUpdate();
          this.swal.close();
        })
        .catch(error => {
          this.swal({
            type: "error",
            title: "好像發生甚麼問題...",
            text: error
          });
        });
    },
    retrain() {
      this.swal({
        customClass: "loadingModal",
        allowOutsideClick: false,
        onOpen: () => {
          this.swal.showLoading();
        }
      });
      this.api
        .post(this.url.view2retrain)
        .then(() => {
          this.$forceUpdate();
          this.swal.close();
        })
        .catch(error => {
          this.swal({
            type: "error",
            title: "好像發生甚麼問題...",
            text: error
          });
        });
    }
  }
};
</script>
<style>
.tooltip {
  width: 100px;
  height: 100px;
}
.v-tooltip__content {
  opacity: 1 !important;
  box-shadow: 0px 0px 4px grey;
}
.realtooltip {
  opacity: 1 !important;
  box-shadow: 0px 0px 4px grey;
}
</style>
