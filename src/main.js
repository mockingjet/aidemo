import 'babel-polyfill'
import Vue from 'vue'
import './plugins/vuetify'
import App from './App.vue'
import router from './router'
import store from './store'
import './registerServiceWorker'
import 'roboto-fontface/css/roboto/roboto-fontface.css'
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import swal from 'sweetalert2'
import api from 'axios'
import 'chartjs-plugin-labels'
import url from './plugins/url'

Vue.config.productionTip = false
Vue.prototype.swal = swal;
Vue.prototype.api = api;
Vue.prototype.url = url;
new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
