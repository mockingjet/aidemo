<template>
  <div class="v-cabinet my-5">
    <div class="bigger" @click="traceback">
      <img :src="bigger[bigger.length-2] ? bigger[bigger.length-2] : bigger[bigger.length-1]">
      <v-icon x-large class="btn-restore">restore</v-icon>
    </div>
    <div class="whole">
      <img class="theImage" :src="nowImage" width="512px" height="512px">
      <img class="trueImage" :src="nowImage" style="display:none">
      <div class="quarter" @click="quarter(1)" ></div>
      <div class="quarter" @click="quarter(2)" ></div>
      <div class="quarter" @click="quarter(3)" ></div>
      <div class="quarter" @click="quarter(4)" ></div>
    </div>
  </div>
</template>
<script>
// import $ from 'jquery'
export default {
  props:['inputImage'],
  data: () => ({
    nowImage:null,
    bigger:[],
  }),
  mounted() {
    this.nowImage = this.inputImage
    this.bigger.push(this.inputImage)
  },
  methods:{
    quarter(coord) {
      this.swal({
        customClass:'loadingModal',
        onOpen:() => {
          this.swal.showLoading();
        }
      })
      var v = this;
      setTimeout(function(){
        v.proceed(coord)
      },100)
    },
    proceed(coord) {
      var img = document.querySelector('.trueImage'),
          c = document.createElement("canvas"),
          ctx = c.getContext('2d')
      c.width = img.naturalWidth/2
      c.height = img.naturalHeight/2
      switch(coord) {
        case 1:
          ctx.drawImage(img, 0, 0, img.naturalWidth/2, img.naturalHeight/2, 0, 0, img.naturalWidth/2, img.naturalHeight/2)
          break
        case 2:
          ctx.drawImage(img, img.naturalWidth/2, 0, img.naturalWidth/2, img.naturalHeight/2, 0, 0, img.naturalWidth/2, img.naturalHeight/2)
          break
        case 3:
          ctx.drawImage(img, 0, img.naturalHeight/2, img.naturalWidth/2, img.naturalHeight, 0, 0, img.naturalWidth/2, img.naturalHeight)
          break
        case 4:
          ctx.drawImage(img, img.naturalWidth/2, img.naturalHeight/2, img.naturalWidth, img.naturalHeight, 0, 0, img.naturalWidth, img.naturalHeight)            
          break
      }
      // console.log(img.naturalWidth,img.naturalHeight)
      var newImage = c.toDataURL()
      this.nowImage = newImage
      this.bigger.push(newImage)
      this.swal.close()
    },
    traceback() {
      if(this.bigger.length==1) 
        return
      else {
        this.nowImage = this.bigger[this.bigger.length-2]
        this.bigger.pop()
      }

    }
  },
}
</script>
<style>
.v-cabinet{
  width:1024px + 90px;
  display:flex;
  flex-direction: row;
  margin-left:calc(50vw - 768px - 45px);
}
.whole{
  width:512px;
  height:512px;
  background-position: center;
  background-size: contain; 
  display:flex;
  flex-direction: row;
  flex-wrap: wrap;
  position:relative;
  margin-left:90px;
}
.theImage{
  position:absolute;
  z-index:1;
}
.quarter{
  z-index:2;
  border:1px solid blue;
  width:256px;
  height:256px;
}
.quarter:hover{
  border:2px solid darkblue;
}
.bigger{
  width:512px;
  height:512px;
  position: relative;
}
.bigger img{
  height:512px;
  width:512px;
  box-shadow:1px 2px 3px 1px rgb(0,0,0,0.5)
}
.btn-restore{
  position:absolute;
  z-index:999;
  right:240px;
  top:240px
}

</style>
