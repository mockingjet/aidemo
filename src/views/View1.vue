<template>
  <div class="v-wrapper">
    <div class="my-5 v-frame" @click="uploadImage">
      {{ inputImage ? '' : 'Click Here To Upload An Image' }}
      <form id="upload-file" method="post" enctype="multipart/form-data">
        <input
          type="file"
          name="file"
          id="uploader"
          style="display:none"
          accept=".png, .jpg, .jpeg, .tif"
          @change="previewImage"
        >
      </form>
      <viewer :options="options" ref="viewer">
        <img :src="inputImage" alt style="display:none">
      </viewer>
      <!-- <div style>
        <img :src="inputImage" alt :style="zoomImage" class="zoomImage">
      </div>
      <v-icon @click="zoomInImage()" style="position:absolute;right:0px">zoom_in</v-icon>
      <v-icon @click="zoomOutImage()" style="position:absolute;left:0px">zoom_out</v-icon>-->
    </div>
  </div>
</template>
<script>
import "viewerjs/dist/viewer.css";
import Viewer from "v-viewer";
import Vue from "vue";
Vue.use(Viewer, {
  defaultOptions: {
    zIndex: 100
  }
});
export default {
  data: () => ({
    inputImage: null,
    options: {
      backdrop: false,
      inline: true,
      button: false,
      navbar: false,
      title: false,
      toolbar: false,
      tooltip: true,
      movable: true,
      rotatable: false,
      scalable: true,
      transition: true,
      fullscreen: true,
      keyboard: false,
      zoomable: true,
      zoomRatio: 0.3,
      minZoomRatio: 0.01,
      maxZoomRatio: 1
      // viewed(e){
      //   e.target.viewer.zoomTo(1)
      // }
    },
    zoomImage: { zoom: "3%" }
  }),
  mounted() {
    this.inputImage = this.$route.query.url;
  },
  methods: {
    uploadImage() {
      if (this.inputImage) return;
      document.getElementById("uploader").click();
    },
    previewImage(e) {
      const file = e.target.files[0];
      this.inputImage = URL.createObjectURL(file);
    }
    // zoomInImage() {
    //   const ratio = parseInt(this.zoomImage.zoom);
    //   if (ratio < 100) this.zoomImage.zoom = ratio + 5 + "%";
    // },
    // zoomOutImage() {
    //   const ratio = parseInt(this.zoomImage.zoom);
    //   if (ratio > 5) this.zoomImage.zoom = ratio - 5 + "%";
    // }
  }
};
</script>
<style scoped>
.v-wrapper {
  width: 80vw;
  height: calc(90vh - 100px);
  margin-left: 10vw;
}
.v-frame {
  width: 80vw;
  height: calc(90vh - 100px);
  background-color: #eee;
  box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.1);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 24px;
  color: #666;
  letter-spacing: 1px;
  cursor: pointer;
  position: relative;
}
.v-frame:hover {
  transition: all 0.5s;
  box-shadow: 1px 1px 5px 1px rgba(0, 0, 0, 0.3);
}
.zoomImage {
  display: inline-block;
  overflow: auto;
}
</style>

