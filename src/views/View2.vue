<template>
  <div class="v-wrapper">
    <div class="pa-5 ma-5 v-frame" @click="uploadImage">
      <span v-if="!inputImage">Upload A Full View Image Here</span>
      <form id="upload-file" method="post" enctype="multipart/form-data">
        <input 
          type="file" 
          name="file"
          id="uploader" 
          style="display:none" 
          accept=".png, .jpg, .jpeg, .tif"
          @change="previewImage">
      </form>
      <quarterImage
        v-if="inputImage"
        :inputImage="inputImage">
      </quarterImage>
    </div>
  </div>
</template>
<script>
import $ from 'jquery'
import quarterImage from '@/views/components/quarterImage.vue'
export default {
  components:{
    quarterImage,
  },
  data: ()=>({
    inputImage:null,
    options: {
      inline: true,
      button: false,
      navbar: false,
      title: false,
      toolbar: false,
      tooltip: true,
      movable: true,
      zoomable: true,
      rotatable: false,
      scalable: false,
      transition: true,
      fullscreen: false,
      keyboard: false,
    },
  }),
  methods:{
    uploadImage(){
      if(this.inputImage) return
      document.getElementById('uploader').click()
    },
    previewImage(){
      this.swal({
        customClass:'loadingModal',
        onOpen:() => {
          this.swal.showLoading();
        }
      })
      // const URL = "http://localhost/AIDemo/public/modify.php";
      const URL = "/colon/map/v1";
      const formData = new FormData($('#upload-file')[0]);
      this.api.post(URL, formData, {
        headers: {
          'accept': 'application/json',
          'Accept-Language': 'en-US,en;q=0.8',
          'Content-Type': `multipart/form-data; boundary=${formData._boundary}`,
        }
      }).then((response) => {
        this.swal.close()
        this.inputImage = response.data.image_file
      }).catch((error) => {
        this.swal.close();
        this.swal({
          type:'error',
          title:'好像發生甚麼問題...',
          text:error
        })
      })
    }
  }
}
</script>
<style scoped>
.v-wrapper{
  background-color: #fff;
  width:calc(100vw - 16px);
  height:calc(100vh - 64px);
}
.v-frame{
  background-color: #eee;
  box-shadow: 0 2px 2px 0 rgba(0,0,0,0.1);
  border:2px solid #aaa;
  text-align: center;
  font-size:24px;
  color:#666;
  letter-spacing: 1px;
  cursor: pointer;
}
.v-frame:hover{
  transition:all .5s;
  box-shadow: 0 2px 4px 0 rgba(0,0,0,0.3);
}
.v-image{
  max-width:100%;
  height:720px;
  cursor: default;
}
</style>

