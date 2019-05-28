<template>
  <div class="v-wrapper">
    <div class="pa-5 my-5 v-frame" @click="uploadImage">
      {{ inputImage ? '' : 'Upload A Full View Image Here' }}
      <form id="upload-file" method="post" enctype="multipart/form-data">
        <input 
          type="file" 
          name="file"
          id="uploader" 
          style="display:none" 
          accept=".png, .jpg, .jpeg, .tif"
          @change="previewImage">
      </form>
          <viewer :options="options">
      <img :src="inputImage" alt="" style="display:none">
    </viewer>
    </div>

  </div>
</template>
<script>
import $ from 'jquery'
import 'viewerjs/dist/viewer.css'
import Viewer from 'v-viewer'
import Vue from 'vue'
Vue.use(Viewer, {
  defaultOptions: {
    zIndex: 100
  }
})
export default {
  data: ()=>({
    inputImage:null,
    options: {
      backdrop:false,
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
      fullscreen: true,
      keyboard: false,
      loading:true
    },
  }),
  methods:{
    uploadImage(){
      if(this.inputImage) return
      document.getElementById('uploader').click()
    },
    previewImage(e){
      this.swal({
        customClass:'loadingModal',
        onOpen:() => {
          this.swal.showLoading();
        }
      })
      // const URL = "http://localhost/AIDemo/public/modify.php";
      const URL = "/colon/map/v1 ";
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
      // document.body.requestFullscreen();
    }
  }
}
</script>
<style scoped>
.v-wrapper{
  background-color: #fff;
  width:512px;
  height:512px;
  margin-left:calc(50vw - 256px);
}
.v-frame{
  width:512px;
  height:512px;
  background-color: #eee;
  box-shadow: 0 2px 2px 0 rgba(0,0,0,0.1);
  border:2px solid #aaa;
  display:flex;
  align-items: center;
  justify-content: center;
  font-size:24px;
  color:#666;
  letter-spacing: 1px;
  cursor: pointer;
}
.v-frame:hover{
  transition:all .5s;
  box-shadow: 0 2px 4px 0 rgba(0,0,0,0.3);
}
</style>

