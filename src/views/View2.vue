<template>
  <div>
    <div class="v-wrapper">
      <div v-if="!inputImage" class="pa-5 my-5 v-frame" @click="uploadImage">
        <span>Upload A Full View Image Here</span>
        <form id="upload-file" method="post" enctype="multipart/form-data">
          <input
            type="file"
            name="file"
            id="uploader"
            style="display:none"
            accept=".png, .jpg, .jpeg, .tif"
            @change="previewImage"
          />
        </form>
      </div>
      <quarterImage v-if="inputImage" :inputImage="inputImage" @returnOutput="getOutput"></quarterImage>
    </div>
    <div class="container">
      <div class="row" v-if="output.image_file">
        <div class="col-md-4">
          <predict-set :predictsets="output.data"></predict-set>
        </div>
        <div class="col-md-4">
          <predict-pie :percentages="output.predicts"></predict-pie>
        </div>
        <div class="col-md-4">
          <img src="@/assets/view2index.png" alt style="max-width:100%;" />
        </div>
      </div>
      <show-dbset :dbset="output.dbset" id="dbset"></show-dbset>
    </div>
  </div>
</template>
<script>
import quarterImage from "@/views/components/quarterImage.vue";
import predictSet from "@/views/components/predictSet.vue";
import predictPie from "@/views/components/predictPie.vue";
import showDbset from "@/views/components/showDbset.vue";
export default {
  components: {
    quarterImage,predictSet,predictPie,showDbset
  },
  data: () => ({
    inputImage: null,
    output: {
      data: "",
      image_file: "",
      color: {},
      predicts: {},
      dbset:null
    },
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
    },
    getOutput(output) {
      this.output = output
      this.inputImage = output.image_file
    }
  }
};
</script>
<style scoped>
.v-wrapper {
  width: 1024px;
  display: flex;
  justify-content: center;
  margin-left: calc(50vw - 512px);
}
.v-frame {
  width: 512px;
  height: 512px;
  background-color: #eee;
  box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.1);
  border: 2px solid #aaa;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 24px;
  color: #666;
  letter-spacing: 1px;
  cursor: pointer;
}
.v-frame:hover {
  transition: all 0.5s;
  box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.3);
}
.v-image {
  max-width: 100%;
  height: 720px;
  cursor: default;
}
</style>

