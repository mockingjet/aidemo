<template>
  <div class="container pt-5">
    <carousel ref="carousel"
      style="position:relative;"
      :items=2
      :nav=false
      :dots=false
      :rewind=false
      :mouseDrag=false
      :touchDrag=false>
      <template slot="prev">
        <span class="prev">
          <v-btn fab>
            <v-icon>chevron_left</v-icon>
          </v-btn>
        </span>
      </template>
      <div class="slide">
        <div class="imgblock">
          <div v-if="!inputUrl" style="cursor:pointer" @click="uploadImage">Click here to upload</div>
          <form id="upload-file" method="post" enctype="multipart/form-data">
            <input 
              type="file" 
              name="file"
              id="imageUpload" 
              style="display:none" 
              accept=".png, .jpg, .jpeg, .tif"
              @change="previewImage">
          </form>
          <img class="imgshow original" v-if="inputUrl" :src="inputUrl" alt="">
          <v-btn fab 
            class="closeOriginal"
            style="position:absolute;z-index:1;left:calc(50% - 28px);top:calc(50% - 28px)" 
            v-if="inputUrl" @click="refresh">
            <v-icon style="line-height:56px;">close</v-icon>
          </v-btn>
        </div>
        <v-btn color="secondary" block 
          style="margin:15px 0px; width:94%; margin-left:3%; color:white"
          :disabled="!inputUrl"
          @click="dignoseImage">
          Diagnose
        </v-btn>
      </div>
      <div class="slide">
        <div class="imgblock" id="testImage">
          <div v-if="!output.image_file">Analysis Result</div>
          <img class="imgshow" v-if="output.image_file" :src="output.image_file" alt="">
          <image-circle 
            v-for="(circle,i) in output.image_circles" :key="i" 
            :circle="circle" 
            :nth="i"
            @returnColor="getColor">
          </image-circle>
        </div>
        <v-btn color="secondary" block
          style="margin:15px 0px; width:94%; margin-left:3%; color:white"
          :disabled="!output.image_file"
          @click="download(output.image_file)">
          Download
        </v-btn>
      </div>
      <div class="slide">
        <div class="imgblock" id="modifiedImage">
          <div v-if="!modified.image_file">Modified Result</div>
          <img class="imgshow" v-if="modified.image_file" :src="modified.image_file" alt="">
        </div>
        <v-btn color="secondary" block
          style="margin:15px 0px; width:94%; margin-left:3%; color:white"
          :disabled="!modified.image_file"
          @click="sendConfirm">
          CONFIRM
        </v-btn>
      </div>
      <template slot="next" v-show="modified.image_file!=''">
        <span class="next">
          <v-btn fab>
            <v-icon>chevron_right</v-icon>
          </v-btn>
        </span>
      </template>
    </carousel>
    <div class="row"
      v-if="output.image_file">
      <div class="col-md-4">
        <predict-set 
          :predictsets="output.data"></predict-set>
      </div>
      <div class="col-md-4">
        <predict-pie 
          :percentages="output.predicts">
        </predict-pie>
      </div>
      <div class="col-md-4">
        <img src="@/assets/preindex.jpg" alt="" style="max-width:100%;">
      </div>
    </div>
    <show-dbset :dbset="dbset" id="dbset"></show-dbset>
  </div>
</template>

<script>
import $ from 'jquery'
import carousel from 'vue-owl-carousel'
import predictSet from '@/views/components/predictSet.vue'
import ImageCircle from '@/views/components/imageCircle.vue'
import predictPie from '@/views/components/predictPie.vue'
import showDbset from '@/views/components/showDbset.vue'
export default{
  components:{
    predictSet,
    ImageCircle,
    predictPie,
    showDbset,
    carousel
  },
  data:()=>({
    inputUrl:null,
    output:{
      data:"",
      image_file:"",
      predicts:{},
      image_circles:[],
    },
    modified_cricles:[],
    modified:{
      image_file:""
    },
    modal: false,
    dbset: null,
  }),
  mounted(){
    $(document).on("mouseenter",".original, .closeOriginal",function(){
      $(".closeOriginal").css("display","block")
    })
    $(document).on("mouseleave",".original",function(){
      $(".closeOriginal").css("display","none")
    })
  },
  methods:{
    refresh() {
      window.location.reload()
    },
    uploadImage() {
      $("#imageUpload").click();
    },
    previewImage(e) {
      const file = e.target.files[0];
      this.inputUrl = URL.createObjectURL(file);
    },
    dignoseImage() {
      if(!this.inputUrl) return
      this.swal({
        customClass:'loadingModal',
        onOpen:() => {
          this.swal.showLoading();
        }
      })
      const formData = new FormData($('#upload-file')[0]);
      const URL = "http://localhost/AIDemo/public/input.php";
      // const URL = "/predict/send/new";
      this.api.post(URL, formData, {
        headers: {
          'accept': 'application/json',
          'Accept-Language': 'en-US,en;q=0.8',
          'Content-Type': `multipart/form-data; boundary=${formData._boundary}`,
        }
      }).then((response) => {
        this.swal.close()
        this.output = response.data
        for(var i = 0; i< this.output.image_circles.length; i++){
          this.modified_cricles[i] = {x:this.output.image_circles[i].x, y:this.output.image_circles[i].y, type:''}
        }
      }).catch((error) => {
        this.swal.close();
        this.swal({
          type:'error',
          title:'好像發生甚麼問題...',
          text:error
        })
      });
    },

    /*
      Every modification to each circle will issue a post.
      The response image will be shown on the third slide.
    */

    getColor(nth,type){
      if(this.output.image_circles[nth].type === type || type === 'No Change') {
        this.modified_cricles[nth].type = ''
      } else {
        this.modified_cricles[nth].type = type
      }

      this.swal({
        customClass:'loadingModal',
        onOpen:() => {
          this.swal.showLoading();
        }
      })
      const URL = "http://localhost/AIDemo/public/modify.php";
      // const URL = "/send/img/back";
      this.api.post(URL, this.modified_cricles).then((response) => {
        this.swal.close()
        var d = new Date();
        this.modified.image_file = response.data.image_file + '?time=' + d.getTime()
        var next = document.querySelector('.next')
        next.click()
      }).catch((error) => {
        this.swal.close();
        this.swal({
          type:'error',
          title:'好像發生甚麼問題...',
          text:error
        })
      })
    },
    download(url){
      var pom = document.createElement('a');
      var filename = url.replace(/^.*[\\/]/, '');
      filename = filename.replace('.','_result.')
      pom.setAttribute('href', url);
      pom.setAttribute('download', filename);
      pom.style.display = 'none';
      document.body.appendChild(pom);
      pom.click();
      document.body.removeChild(pom);
    },
    sendConfirm(){
      this.swal({
        title:'Are you sure?',
        text: 'We will save all the results and changes into the database!',
        showCancelButton: true,
        cancelButtonText: 'Not now',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Do it!',
        cancelButtonColor: '#d33',
      }).then((result) => {
        if (result.value) {
          this.swal({
            customClass:'loadingModal',
            onOpen:() => {
              this.swal.showLoading();
            }
          })
          const URL = "http://localhost/AIDemo/public/confirm.php";
          // const URL = "/send/dbset";
          this.api.get(URL).then((response) => {
            this.swal.close()
            this.dbset = response.data
            this.modal = true
            $('html,body').animate({
                scrollTop: $("#dbset").offset().top
            }, 'slow');
          }).catch((error) => {
            this.swal.close();
            this.swal({
              type:'error',
              title:'好像發生甚麼問題...',
              text:error
            })
          })
        }
      })
    },
  }
}

</script>
<style>
.loadingModal{
  background:transparent !important;
}
.slide{
  padding:8px 8px 0px 8px;
  height:700px;
}
.imgblock{
  box-shadow: 0px 0px 10px 2px rgba(0, 0, 0, 0.3);
  height:512px;
  width:512px;
  display: flex;
  margin-left:calc(50% - 256px);
  justify-content: center;
  line-height:512px;
  font-size:24px;
  position: relative;
}
.imgshow{
  width:100%;
  height:100%;
}
.closeOriginal{
  opacity: 0.5;
}
.closeOriginal:hover{
  opacity: 1;
}
.prev{
  position: absolute;
  left:-60px;
  top:calc(50% - 96px);
}
.next{
  position: absolute;
  right:-60px;
  top:calc(50% - 96px);
}
.prev i, .next i{
  zoom:1.5;
  cursor: pointer;
}
</style>
