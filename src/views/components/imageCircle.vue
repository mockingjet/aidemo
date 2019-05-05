<template>
  <div class="imgcircle" 
    slot="activator"
    @click="show=!show"
    :style="
      this.color == 'white'
      ? 'top:'+this.y+'px;left:'+this.x+'px;border-color:'+this.color
      : 'top:'+this.y+'px;left:'+this.x+'px;border-color:'+this.color+';border-width:5px;border-style:solid'
    ">
    <div class="options" v-show="show">
      <div class="option"
        v-for="(option, index) in options"
        :key="index">
        <v-list-tile-title small
          style="text-align:center"
          @click="change($event,option.color)"
        >{{ option.text }}</v-list-tile-title>
      </div>
    </div>
  </div>
</template>
<script>
import $ from 'jquery'
export default {
  props:['circle','nth'],
  data:()=>({
    show:false,
    x:null,
    y:null,
    color:'white',
    options: [
      { text: 'x', color: '' },
      { text: 'Adenoma', color:'#FB000A' },
      { text: 'Hyperplastic', color:'#FFF200' },
      { text: 'Normal', color:'#26E32C' },
      { text: 'Unknown', color:'black' },
      { text: 'No Change', color:'white'}
    ]
  }),
  mounted() {
    var w = $(".imgshow").width();
    var h = $(".imgshow").height();
    this.x = (this.circle.x*w-10)/100
    this.y = ((100 - this.circle.y)*h-10)/100 
  },
  methods:{
    change(e,color) {
      if(color){
        this.color = color
        var type=''
        for(var i=0;i<6;i++) 
        {
          if(this.options[i].color==color)
            type = this.options[i].text
        }
        this.$emit('returnColor',this.nth,type);
      }
    }
  }
}
</script>
<style>
.imgcircle{
  cursor: pointer;
  position:absolute;
  width:30px;
  height:30px;
}
.imgcircle:hover{
  transition:all .2s;
  border-width:5px;
  border-style :solid;
}
.options{
  position: absolute;
  top:10px;
  left:10px;
  z-index:9 !important;
  background: white;
  border-radius: 2px;
  box-shadow:1px 1px 10px black;
}
.option{
  padding:3px 8px;
  font-size:14px;
  position: relative;
}
.option:hover{
  background-color: rgba(0,0,0,0.1);
  transition: all .2s;
}
</style>
