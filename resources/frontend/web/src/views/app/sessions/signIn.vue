<template>
  <div
    class="auth-layout-wrap h-100 w-100 mx-auto"
    :style="{ backgroundImage: 'url(' + bgImage + ')' }"
    style="
      background-repeat: no-repeat;
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover;
      max-height: 100vh;
      background-position: 100% 100%;
      max-width: 440px;
      overflow-y: scroll;
    "
  >
    <div class="col-10 h-100 d-flex flex-column flex-grow-1">
      <div class="flex-grow-2"></div>
      <div class="auth-logo text-center">
        <img :src="logo" />
      </div>
      <h1 class="mb-3 text-18 text-white text-center">
        {{ $t("welcome_back") }}
      </h1>
      <b-form
        @submit.prevent="formSubmit"
        class="d-flex flex-column flex-grow-3"
      >
        <b-form-group class="">
          <label for="username" class="col-form-label">{{
            $t("username")
          }}</label>
          <b-form-input
            class="form-control-rounded form-custom"
            type="text"
            v-model="username"
            :placeholder="$t('username')"
            required
          ></b-form-input>
        </b-form-group>

        <b-form-group class="">
          <label for="password" class="col-form-label">{{
            $t("password")
          }}</label>
          <b-form-input
            class="form-control-rounded form-custom"
            type="password"
            v-model="password"
            :placeholder="$t('password')"
            required
          ></b-form-input>
        </b-form-group>
        <router-link
          to="/web/settings/forget-password"
          tag="a"
          class="text-primary text-center text-12 mt-4"
          >{{ $t("forget_password") }}?
        </router-link>
        <div class="text-12 d-flex text-white justify-content-center">
          {{ $t("don_have_an_account") }}
          <router-link to="/register" tag="a" class="text-primary ml-1">
            <div>
              {{ $t("register") }}
            </div>
          </router-link>
        </div>
        <div class="flex-grow-2"></div>
        <b-button
          type="submit"
          tag="button"
          class="btn-block mt-3 btn-square"
          variant="primary"
          :disabled="loading"
        >
          {{ $t("sign_in") }}
        </b-button>
        <div v-once class="typo__p" v-if="loading">
          <div class="spinner sm spinner-light mt-3"></div>
        </div>
        <div class="flex-grow-1"></div>

        <div class="auth-logo text-center mb-0">
          <img :src="systemlogo" />
        </div>
      </b-form>
    </div>
    <b-modal
      id="modal-maintenance"
      size="md"
      centered
      :title="$t('system_maintenance')"
      :hide-footer="true"
      style="background-color: #5f646e !important"
      :no-close-on-backdrop="true"
      :no-close-on-esc="true"
    >
      <b-form class="mx-5">
        <b-row align-h="center">
          <b-col md="12 mb-30">
            <b-row align-h="center" style="margin-bottom: 10px">
              <div class="form-group">
                <i
                  class="fa fa-cog"
                  style="font-size: 100px; color: purple"
                ></i>
              </div>
              <div class="col-sm-12">
                <center>
                  {{ $t("maintanence") }}
                </center>
              </div>
            </b-row>
          </b-col>
        </b-row>
      </b-form>
    </b-modal>
    <Dialog ref="msg"></Dialog>
  </div>
</template>
<script>
import { getDownloadLink } from "../../../system/api/api";
import { handleError } from "../../../system/handleRes";
import { mapGetters, mapActions } from "vuex";
import Dialog from "../../../components/dialog.vue";
export default {
  metaInfo: {
    // if no subcomponents specify a metaInfo.title, this title will be used
    title: "Sign In",
  },
  data() {
    return {
      username: "",
      password: "",
      // // password: "vue006",
      userId: "",
      bgImage: require("../../../assets/images/loginBG.jpg"),
      logo: require("../../../assets/images/logo.png"),
      systemlogo: require("../../../assets/images/system_logo.png"),
      signInImage: require("../../../assets/images/photo-long-3.jpg"),
    };
  },
  computed: {
    validation() {
      return this.userId.length > 4 && this.userId.length < 13;
    },
    ...mapGetters(["loggedInUser", "loading", "error"]),
  },
  components: {
    Dialog,
  },
  methods: {
    ...mapActions(["login", "changeLan"]),
    async formSubmit() {
      await this.login({
        username: this.username,
        password: this.password,
        lang: this.$i18n.locale,
      });
    },
    makeToast(variant = null, msg) {
      this.$bvToast.toast(msg, {
        // title: ` ${variant || "default"}`,
        variant: variant,
        solid: true,
      });
    },
    changeLang(lang) {
      console.log(lang);
      this.$i18n.locale = lang;
      this.changeLan(lang);
    },
    maintenance() {
      var result = getDownloadLink();
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          var siteOn = value.data.data.system.SITE_ON;
          if (siteOn == 0) {
            self.$bvModal.show("modal-maintenance");
          }
        })
        .catch(function (error) {
          self.isLoading = false;
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
  },
  created() {
    this.maintenance();
  },
  watch: {
    loggedInUser(val) {
      if (val && val.length > 0) {
        this.makeToast("success", this.$t("login_ok"));

        setTimeout(() => {
          this.$router.push("/web");
        }, 500);
      }
    },
    error(val) {
      if (val != null) {
        this.makeToast("danger", this.$t(val));
      }
    },
  },
};
</script>

<style>
h5#modal-maintenance___BV_modal_title_ {
  margin: auto;
}
button.close {
  display: none;
}
.spinner.sm {
  height: 2em;
  width: 2em;
}

.form-custom {
  font-size: 16px !important;
  border-radius: 0.5rem !important;
  /* height: calc(2.5rem + 2px); */
  /* color: #fff !important; */
  /* background: linear-gradient(58deg, #001c53, #001c53); */
  border: none !important;
}
</style>
