import Vue from 'vue'
import './plugins/axios'
import App from './App.vue'
import vuetify from './plugins/vuetify';

import VuetifyDialog from "vuetify-dialog";
import "vuetify-dialog/dist/vuetify-dialog.css";


//import VueRx from 'vue-rx'
//import VuejsClipper from 'vuejs-clipper'

Vue.config.productionTip = false

new Vue({
  vuetify,
  render: h => h(App)
}).$mount('#app');

Vue.use(VuetifyDialog, {
  context: {
    vuetify,
  },
});
Vue.use(require('vue-moment'));

/*
Vue.use(VueRx);

Vue.use(VuejsClipper, {
 components: {
    clipperBasic: true,
    clipperPreview: true,
    clipperFixed: true,
    clipperUpload: true
 }
});
*/

