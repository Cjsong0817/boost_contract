// import "babel-polyfill";
import Vue from "vue";
import App from "./App.vue";
import router from "./router";
// import VueRouter from "vue-router";
import GullKit from "./plugins/gull.kit";
import Clipboard from 'v-clipboard';
import store from "./store";
import Breadcumb from "./components/breadcumb";
import firebase from "firebase/app";
import "firebase/auth";
import { firebaseSettings } from "@/data/config";
import i18n from "./lang/lang";
import Vuelidate from 'vuelidate'
import 'vue2-daterange-picker/dist/vue2-daterange-picker.css'
//import material-icon scss
import "font-awesome/css/font-awesome.min.css";

//defined as global component
Vue.component('VueFontawesome', require('vue-fontawesome-icon/VueFontawesome.vue').default);

Vue.component("breadcumb", Breadcumb);
import InstantSearch from 'vue-instantsearch';
import { setLanguage } from "./system/api/api";
// Vue.use(VueRouter);



Vue.use(InstantSearch);
Vue.use(GullKit);
Vue.use(Clipboard);
Vue.use(Vuelidate)

firebase.initializeApp(firebaseSettings);



Vue.config.productionTip = false;

new Vue({
  watch: {
    "$i18n.locale": "setLang"
  },
  data() {
    return { showedMsg: false }
  },
  methods: {
    makeStaticToast(variant = null, title, msg) {
      this.$bvToast.toast(msg, {
        title: title,
        variant: variant,
        solid: true,
        noAutoHide: true,
        noCloseButton: false

      });
    },
    makeToast(variant = null, msg) {
      this.$bvToast.toast(msg, {
        // // title: ` ${variant || "default"}`,
        variant: variant,
        solid: true,
      });
    },
    setLang() {
      let formData = new FormData();
      formData.append('language', this.$i18n.locale == 'en' ? 'en' : 'cn');
      setLanguage(formData);
      // var self = this;
      // result.then(function () {

      // });
    }
  },
  store,
  router,
  i18n,
  render: h => h(App)
}).$mount("#app");
