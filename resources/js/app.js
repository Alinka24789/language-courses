import Vue from 'vue';
import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.css';
import router from './routes';

Vue.use(Vuetify);

new Vue({
    el: '#app',
    router,
});