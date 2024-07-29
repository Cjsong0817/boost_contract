import Vue from "vue";
import VueI18n from "vue-i18n";
import Cookies from 'js-cookie';
Vue.use(VueI18n);

var lang = Cookies.get('lang');

const DEFAULT_LANG = lang?lang:"zh";

const locales = {
  en: require("./i18n/en.json"),
  zh: require("./i18n/zh.json")
};
const i18n = new VueI18n({
  locale: DEFAULT_LANG,
  messages: locales
});

export default i18n;
