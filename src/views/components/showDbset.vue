<template>
  <v-card class="my-5">
    <v-toolbar v-show="dbset" dark color="secondary">
      <v-toolbar-title>Database Status</v-toolbar-title>
      <!-- <v-spacer></v-spacer>
      <v-toolbar-items>
        <v-btn dark flat @click="refresh" style="text-transform:none;font-size:16px;letter-spacing:1px">OK, I got it!</v-btn>
      </v-toolbar-items> -->
    </v-toolbar>
    <div v-for="(item,i) in dbset" :key=i
      style="padding:8px 12px 0px 8px;">
      <v-icon>folder</v-icon>
      {{item.typename}}
      <v-layout row wrap style="padding:10px 25px;">
        <v-flex xs2 v-for="(file,j) in item.files" :key=j
          style="margin:2px 0px">
          <v-tooltip right style="cursor:default" color="#fcfcfc" lazy nudge-right="-60" >
            <div slot="activator" color="primary">
              <v-icon>image</v-icon>{{file}}
            </div>
            <img class="tooltip" :src="item.dirpath+'/'+file" :alt="file" >
          </v-tooltip>
        </v-flex>
      </v-layout>
      <v-btn outline
        style="float:right"
        color="red"
        :disabled="hasUploaded[i]"
        @click="upload(item.typename,i)">
        {{ hasUploaded[i] ? "Finished" : "Upload" }}
        <v-icon right dark>cloud_upload</v-icon>
      </v-btn>
      <v-divider class="mt-5"></v-divider>
    </div>
    
  </v-card>
</template>
<script>
export default {
  props:['dbset'],
  data:()=>({
    hasUploaded:[false,false,false,false],
  }),
  methods:{
    upload(dirname,i) {
      const URL = "http://localhost/AIDemo/public/input.php";
      // const URL = "/add/data/training";
      this.api.post(URL, dirname).then(() => {
        this.hasUploaded[i] = true
        this.$forceUpdate()
      }).catch((error) => {
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
<style>
.tooltip{
  width:100px;
  height:100px;
}
.v-tooltip__content{
  opacity: 1 !important;
  box-shadow: 0px 0px 4px grey
}
.realtooltip{
  opacity: 1 !important;
  box-shadow: 0px 0px 4px grey
}
</style>

<!-- <v-dialog v-model="modal" persistent fullscreen>
  <v-card >
    <v-toolbar dark color="#555" fixed app>
      <v-toolbar-title>Database Status</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-toolbar-items>
        <v-btn dark flat @click="refresh" style="text-transform:none;font-size:16px;letter-spacing:1px">OK, I got it!</v-btn>
      </v-toolbar-items>
    </v-toolbar>
    <v-divider style="margin-top:64px;"></v-divider>
    <div v-for="(item,i) in dirnames" :key=i
      style="padding:8px 12px 0px 8px">
      <v-icon>folder</v-icon>
      {{item.dirname}}
      <v-layout row wrap style="padding:10px 25px;">
        <v-flex xs2 v-for="(file,j) in item.files" :key=j
          style="margin:2px 0px">
          <v-icon>image</v-icon>
          {{file}}
        </v-flex>
      </v-layout>
      <v-divider></v-divider>
    </div>
  </v-card>
</v-dialog> -->