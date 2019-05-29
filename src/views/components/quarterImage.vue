<template>
  <div class="v-cabinet my-5">
    <div class="origin">
      <img :src="inputImage" alt="">
      <div class="focus"></div>
    </div>
    <div class="whole">
      <img class="theImage" :src="nowImage" width="512px" height="512px">
      <img class="trueImage" :src="nowImage" style="display:none">
      <div class="quarter" @click="quarter(1)" ></div>
      <div class="quarter" @click="quarter(2)" ></div>
      <div class="quarter" @click="quarter(3)" ></div>
      <div class="quarter" @click="quarter(4)" ></div>
      <img 
        @click="traceback"
        style="position:absolute; right:-120px; width: 90px; height:90px; top:216px;"
        v-show="former[former.length-2]"
        :src="former[former.length-2] ? former[former.length-2] : former[former.length-1]">
      <v-icon 
        x-large
        @click="traceback"
        v-show="former[former.length-2]"
        style="position:absolute; right:-95px; top:240px"
      >restore</v-icon>
    </div>
    <!-- <v-alert
      style="position:absolute; bottom:calc(50% - 40px); right:calc(50% - 450px); z-index:999"
      :value="tip"
      color="warning"
      icon="priority_high"
      transition="scale-transition">
      100% Image can't be split further
    </v-alert> -->
  </div>
</template>
<script>
// import $ from 'jquery'
export default {
  props:['inputImage'],
  data: () => ({
    nowImage:null,
    former:[],
    record:[],
    // tip:false
  }),
  mounted() {
    this.nowImage = this.inputImage
    this.former.push(this.inputImage)
  },
  methods:{
    quarter(coord) {
      this.swal({
        customClass:'loadingModal',
        allowOutsideClick: false,
        onOpen:() => {
          this.swal.showLoading();
        }
      })
      setTimeout(function(){
        this.proceed(coord)
      }.bind(this),100)
    },
    proceed(coord) {
      var img = document.querySelector('.trueImage'),
          c = document.createElement("canvas"),
          ctx = c.getContext('2d')
      c.width = img.naturalWidth/2
      c.height = img.naturalHeight/2
      if( c.width < 512 || c.height < 512) {
        this.swal.close()
        // this.tip = !this.tip
        return
      }
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
      var newImage = c.toDataURL()
      this.nowImage = newImage
      this.former.push(newImage)
      this.record.push(coord)
      this.focusOn(coord)
      this.swal.close()
    },
    focusOn(coord){
      var focus = document.querySelector('.focus')
      focus.style.width = focus.offsetWidth / 2 +'px'
      focus.style.height = focus.offsetHeight / 2 + 'px'
      switch(coord) {
        case 1:
          //原封不動
          break
        case 2:
          //向右移動一個width
          focus.style.left = focus.offsetLeft + focus.offsetWidth + 'px'
          break
        case 3:
          //向下移動一個width
          focus.style.top = focus.offsetTop + focus.offsetHeight + 'px'
          break
        case 4:
          //向右跟下各移動一個width
          focus.style.left = focus.offsetLeft + focus.offsetWidth + 'px'
          focus.style.top = focus.offsetTop + focus.offsetHeight + 'px'
          break
      }
    },
    traceback() {
      if(this.former.length==1) 
        return
      else {
        this.nowImage = this.former[this.former.length-2]
        this.former.pop()
        var coord = this.record.pop()
        this.focusOff(coord)
      }
    },
    focusOff(coord) {
      var focus = document.querySelector('.focus')
      focus.style.width = focus.offsetWidth * 2 +'px'
      focus.style.height = focus.offsetHeight * 2 + 'px'
      switch(coord) {
        case 1:
          //原封不動
          break
        case 2:
          //向左移動半個width
          focus.style.left = focus.offsetLeft - focus.offsetWidth/2 + 'px'
          break
        case 3:
          //向上移動半個width
          focus.style.top = focus.offsetTop - focus.offsetHeight/2 + 'px'
          break
        case 4:
          //向左跟上各移動半個width
          focus.style.left = focus.offsetLeft - focus.offsetWidth/2 + 'px'
          focus.style.top = focus.offsetTop - focus.offsetHeight/2 + 'px'
          break
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
.origin{
  width:512px;
  height:512px;
  position: relative;
}
.origin img{
  height:512px;
  width:512px;
  box-shadow:1px 2px 3px 1px rgb(0,0,0,0.5)
}
.focus{
  position:absolute;
  top:0px;
  width:512px;
  height:512px;
  border:3px dashed darkred;
}
.btn-restore{
  position:absolute;
  z-index:999;
  right:240px;
  top:240px
}

</style>
