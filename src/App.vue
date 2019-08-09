<template>
  <v-app>
    <v-toolbar style="padding:0% calc(10% - 50px)" color="#343A40" dark>
      <div class="padding-helper"></div>
      <v-toolbar-title class="text-uppercase">
        <span @click="$router.push('/')">
          Colon/G/f9/gray/384/v6
        </span>
      </v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn
        flat round ripple target="_blank">
        <v-icon>help</v-icon> &nbsp; Help
      </v-btn>
    </v-toolbar>

    <router-view/>
  </v-app>
</template>

<script>
export default {
  data:()=>({
    isFullscreen:false
  }),    
}
</script>

