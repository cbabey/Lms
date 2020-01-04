import Vue from 'vue'
import App from './App.vue'
import router from './router'
import './registerServiceWorker'
import ArgonDashboard from './plugins/argon-dashboard'
import BootstrapVue from 'bootstrap-vue'
import VueResource from 'vue-resource';
import Vuelidate from 'vuelidate'
import VueSession from 'vue-session'


Vue.config.productionTip = false

Vue.use(ArgonDashboard)
Vue.use(BootstrapVue)
Vue.use(Vuelidate)
Vue.use(VueResource);
Vue.use(VueSession)
new Vue({
  router,
  
  render: h => h(App)
}).$mount('#app')
