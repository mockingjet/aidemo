<template>
<div>
  <div class="bigger" @click="traceback">
    <img :src="bigger[bigger.length-2] ? bigger[bigger.length-2] : bigger[bigger.length-1]" alt="">
    <v-icon large>restore</v-icon>
  </div>
  <div class="whole">
    <img class="theImage" :src="nowImage" width="512px" height="512px">
    <div class="quarter" @click="quarter(1)" ></div>
    <div class="quarter" @click="quarter(2)" ></div>
    <div class="quarter" @click="quarter(3)" ></div>
    <div class="quarter" @click="quarter(4)" ></div>
  </div>
</div>

</template>
<script>
import $ from 'jquery'
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
      var img = document.querySelector('.theImage'),
          c = document.createElement("canvas"),
          ctx = c.getContext('2d')
      c.width = 512
      c.height = 512
      switch(coord) {
        case 1:
          ctx.drawImage(img, 0, 0, img.naturalWidth/2, img.naturalHeight/2, 0, 0, 512, 512)
          break
        case 2:
          ctx.drawImage(img, img.naturalWidth/2, 0, img.naturalWidth/2, img.naturalHeight/2, 0, 0, 512, 512)
          break
        case 3:
          ctx.drawImage(img, 0, img.naturalHeight/2, img.naturalWidth/2, img.naturalHeight, 0, 0, 512, 1024)
          break
        case 4:
          ctx.drawImage(img, img.naturalWidth/2, img.naturalHeight/2, img.naturalWidth, img.naturalHeight, 0, 0, 1024, 1024)            
          break
      }
      console.log(img.naturalWidth,img.naturalHeight)
      var newImage = c.toDataURL()
      this.nowImage = newImage
      this.bigger.push(newImage)
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
.whole{
  width:512px;
  height:512px;
  background-position: center;
  background-size: contain; 
  display:flex;
  flex-direction: row;
  flex-wrap: wrap;
  margin-left:calc(50% - 256px);
  position:relative;
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
  position:absolute;
  width:128px;
}
.bigger img{
  height:128px;
  width:128px;
  box-shadow:1px 2px 3px 1px rgb(0,0,0,0.5)
}

</style>
