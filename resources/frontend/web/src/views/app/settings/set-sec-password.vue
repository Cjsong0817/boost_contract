<template>
  <div class="main-content">
    <div class="appBar">
      <a @click="goBack">
        <i class="fa fa-chevron-left"></i>
      </a>
      <span>{{ $t("set_sec_password") }}</span>
    </div>
    <div class="mx-3 my-3 px-3 mt-5">
      <b-row align-h="center">
        <b-col cols="12">
          <b-form @submit.prevent="submitForm">
            <div class="form-group row">
              <label for="new_password" class="col-sm-12 col-form-label">{{
                $t("new_password")
              }}</label>
              <div class="col-sm-12">
                <input
                  class="form-control"
                  v-model="password"
                  type="password"
                  required
                />
              </div>
            </div>

            <div class="form-group row">
              <label
                for="confirm_new_password"
                class="col-sm-12 col-form-label"
                >{{ $t("confirm_new_password") }}</label
              >
              <div class="col-sm-12">
                <input
                  class="form-control"
                  v-model="password_confirmation"
                  type="password"
                  required
                />
              </div>
            </div>

            <b-button
              class="mx-auto btn-square font-weight-bold w-100"
              style="margin-top: 30px; color: #fff"
              variant="outline-secondary"
              type="submit"
              >{{ isLoading ? $t("loading...") : $t("submit") }}</b-button
            >
          </b-form>
        </b-col>
      </b-row>
    </div>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import { setSecPassword } from "../../../system/api/api";
import { handleError } from "../../../system/handleRes";
import Dialog from "../../../components/dialog.vue";
import { mapGetters, mapActions } from "vuex";
export default {
  computed: {
    ...mapGetters(["lang"]),
  },
  components: {
    Dialog,
  },
  data() {
    return {
      password: "",
      password_confirmation: "",
      myVar: null,
      sending: false,
      isLoading: false,
    };
  },
  props: ["success"],
  methods: {
    ...mapActions(["signOut"]),
    goBack() {
      this.signOut();

      this.$router.push("/web/sessions/signIn");
    },
    submitForm() {
      let formData = new FormData();
      var self = this;
      formData.append("password", this.password);
      formData.append("password_confirmation", this.password_confirmation);
      var result = setSecPassword(formData);
      self.isLoading = true;

      result
        .then(function (value) {
          console.log(value.data);
          if (value.data.code == 0) {
            self.$refs.msg.makeToast("success", self.$t(value.data.message));
            self.password = "";
            self.password_confirmation = "";
            setTimeout(() => {
              var current = location.origin + "/";
              window.location.href = current + "web";
            }, 2000);
          } else {
            self.$refs.msg.makeToast("danger", self.$t(value.data.message));
          }
          self.sending = false;
          self.isLoading = false;
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          self.sending = false;
          self.isLoading = false;
        });
    },
    loadItems() {},
  },
  created() {
    this.loadItems();
    this.username = localStorage.getItem("username");
  },
};
</script>

<style scoped>
.main-content {
  max-width: 420px;
  margin: auto;
}
</style>