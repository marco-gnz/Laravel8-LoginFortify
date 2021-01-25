require('./bootstrap');

window.Vue = require('vue').default;
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';

window.Vue.use(ElementUI);

Vue.component('almacenar-rut', require('./components/rut').default);

const app = new Vue({
    el: '#app'
});
