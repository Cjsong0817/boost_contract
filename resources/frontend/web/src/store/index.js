import Vuex from "vuex";
import Vue from "vue";
import largeSidebar from "./modules/largeSidebar";
import config from "./modules/config";
import authData from "./modules/authData";
import invoice from "./modules/invoice";
import cart from "./modules/cart";
import verticalSidebar from "./modules/verticalSidebar";
import wallets from "./modules/wallets";
import memberTree from "./modules/memberTree";


// Load Vuex
Vue.use(Vuex);

// Create store
export default new Vuex.Store({
  modules: {
    largeSidebar,
    config,
    authData,
    invoice,
    cart,
    verticalSidebar,
    wallets,
    memberTree
  }
});
