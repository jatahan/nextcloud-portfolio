import Vue from 'vue'
import App from './App'

Vue.config.productionTip = false

const View = Vue.extend(App);
new View().$mount('#app');

/* eslint-disable no-new */
/*new Vue({
	  el: '#app',
	  template: '<App/>',
	  components: { App }
}) */
