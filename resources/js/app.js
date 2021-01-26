require('./bootstrap');

window.Vue = require('vue').default;
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import Vuelidate from 'vuelidate'

window.Vue.use(ElementUI);
window.Vue.use(Vuelidate);

Vue.component('almacenar-rut', require('./components/rut').default);

const app = new Vue({
    el: '#app'
});
