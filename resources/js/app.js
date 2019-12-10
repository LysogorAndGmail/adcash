import VueRouter from 'vue-router';
import VeeValidate from 'vee-validate';
import Toastr from 'vue-toastr';
import VueBase64FileUpload from 'vue-base64-file-upload';

import router from './routes';
import {filters} from './filters';
import store from './store/store';

import ToggleButton from 'vue-js-toggle-button';
import VModal from 'vue-js-modal';

import VueI18n from 'vue-i18n';
import {languages} from './lang/languages';
import {defaultLocale} from './lang/languages';


const messages = Object.assign(languages);

require('vue-toastr/src/vue-toastr.scss');
require('./bootstrap');

window.Vue = require('vue');
window.EventBus = new Vue;

Vue.config.productionTip = false;

Vue.use(VeeValidate);
Vue.use(VueRouter);
Vue.use(ToggleButton);
Vue.use(VModal);
Vue.use(VueI18n);
Vue.use(Toastr, {
    defaultTimeout: 3500,
    defaultPosition: "toast-bottom-right",
});

const i18n = new VueI18n({
  locale: defaultLocale,
  fallbackLocale: 'en',
  messages
});

Vue.component('app-wrapper', require('./components/Wrapper.vue').default);
Vue.component('app-file-upload', VueBase64FileUpload);

Vue.directive('focus', {
  inserted: function (el) {
    el.focus()
  }
})

const app = new Vue({
    el: '#app',
    i18n,
    router,
    filters,
    store
});
