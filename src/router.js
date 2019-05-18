import Vue from 'vue'
import Router from 'vue-router'
import Home from './views/Home.vue'
import View1 from './views/View1.vue'
import View2 from './views/View2.vue'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home
    },
    {
      path: '/view1',
      name: 'view1',
      component: View1
    },
    {
      path: '/view2',
      name: 'view2',
      component: View2
    }
  ]
})
