import firebase from "firebase/app";
import "firebase/auth";
import { login, setLanguage, } from "../../system/api/api";
import { checkRes } from "../../system/handleRes";
import Cookies from 'js-cookie';

export default {
  state: {
    loggedInUser:
      localStorage.getItem("boostToken") != null
        ? localStorage.getItem("boostToken")
        : null,
    loading: false,
    error: null,
    lang: 'zh',
    unread: 0,
    fHeight: 0
  },
  getters: {
    loggedInUser: state => state.loggedInUser,
    loading: state => state.loading,
    error: state => state.error,
    lang: state => state.lang,
    unread: state => state.unread,
    fHeight: state => state.fHeight
  },
  mutations: {
    setLang(state, data) {
      Cookies.set('lang', data);
      state.lang = data;

    },
    setHeight(state, data) {
      state.fHeight = data;

    },
    setUnread(state, data) {
      state.unread = data;

    },
    setUser(state, data) {
      state.loggedInUser = data;
      state.loading = false;
      state.error = null;
    },
    setLogout(state) {
      state.loggedInUser = null;
      state.loading = false;
      state.error = null;
      // this.$router.go("/");
    },
    setLoading(state, data) {
      state.loading = data;
      state.error = null;
    },
    setError(state, data) {
      state.error = data;
      state.loggedInUser = null;
      state.loading = false;
    },
    clearError(state) {
      state.error = null;
    }
  },
  actions: {
    login({ commit }, data) {
      commit("clearError");
      commit("setLoading", true);

      var result = login(data);
      // var self = this;
      result.then(function (value) {
        if (checkRes(value.data) && value.data.data.user.role_info.name == 'user') {
          const newToken = value.data.data.token;
          localStorage.setItem("boostToken", newToken);
          localStorage.setItem("web_username", value.data.data.user.username);
          localStorage.setItem("path", value.data.data.user.role_info.pages);
          commit("setUser", newToken);

          let formData = new FormData();
          formData.append('language', data.lang);
          setLanguage(formData);

        } else {
          localStorage.removeItem("boostToken");
          commit("setError", value.data.message);

        }
      }).catch(function (error) {
        console.log(error);
        localStorage.removeItem("boostToken");
        commit("setError", error);

      });
    },

    changeLan({ commit }, data) {
      commit("setLang", data);

    },

    changeUnread({ commit }, data) {
      console.log(data)
      commit("setUnread", data);

    },

    storeHeight({ commit }, data) {
      console.log(data)
      commit("setHeight", data);

    },


    // firebase
    //   .auth()
    //   .signInWithEmailAndPassword(data.email, data.password)
    //   .then(user => {
    //     const newToken = {uid: user.user.uid};
    //     localStorage.setItem("boostToken", JSON.stringify(newToken));
    //     commit("setUser", {uid: user.user.uid});
    //     console.log("user");
    //   })
    //   .catch(function(error) {
    //     // Handle Errors here.
    //     // var errorCode = error.code;
    //     // var errorMessage = error.message;
    //     // console.log(error);
    //     localStorage.removeItem("boostToken");
    //     commit("setError", error);
    //     // ...
    //   });

    signUserUp({ commit }, data) {
      commit("setLoading", true);
      commit("clearError");
      firebase
        .auth()
        .createUserWithEmailAndPassword(data.email, data.password)
        .then(user => {
          commit("setLoading", false);

          const newToken = {
            uid: user.user.uid
          };
          console.log(newToken);
          localStorage.setItem("boostToken", JSON.stringify(newToken));
          commit("setUser", newToken);
        })
        .catch(error => {
          commit("setLoading", false);
          commit("setError", error);
          localStorage.removeItem("boostToken");
          console.log(error);
        });
    },
    signOut({ commit }) {
      // firebase
      //   .auth()
      //   .signOut()
      //   .then(
      //     () => {
      //       localStorage.removeItem("boostToken");
      //       commit("setLogout");
      //     },
      //     // _error => { }
      //   );

      localStorage.removeItem("boostToken");
      localStorage.removeItem("can_pop");
      commit("setLogout");
    }
  }
};
