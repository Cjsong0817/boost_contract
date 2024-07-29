<template>
  <div>
    <div class="m-3 mx-4">
      <b-row align-h="center">
        <b-col cols="10">
          <b-form @submit.prevent="sendOTP">
            <div class="form-group row">
              <label for="email" class="col-sm-12 col-form-label">{{
                $t("email")
              }}</label>
              <div class="col-sm-12">
                <b-input-group>
                  <b-form-input
                    v-model="email"
                    type="text"
                    readonly
                  ></b-form-input>
                  <b-input-group-append class="" style="position: relative">
                    <b-button
                      variant="primary"
                      :disabled="startCount || sending"
                      @click="getOTP"
                    >
                      <span v-if="!sending">{{ $t("getCode") }}</span
                      ><span v-else class="text-white">{{
                        $t("loading...")
                      }}</span>
                    </b-button>
                    <div
                      v-if="startCount"
                      class="text-center py-2 overlay-text"
                    >
                      {{ timecount }} s
                    </div>
                  </b-input-group-append>
                </b-input-group>
              </div>
            </div>

            <div class="form-group row">
              <label for="vcode" class="col-sm-12 col-form-label">{{
                $t("vcode")
              }}</label>
              <div class="col-sm-12">
                <input
                  type="number"
                  class="form-control"
                  v-model="otp"
                  required
                />
              </div>
            </div>

            <!-- <div class="form-group row">
              <label for="old_sec_password" class="col-sm-2 col-form-label">{{
                $t("old_sec_password")
              }}</label>
              <div class="col-sm-10">
                <input
                  type="password"
                  class="form-control"
                  v-model="sec_password"
                  required
                />
              </div>
            </div> -->

            <div class="form-group row">
              <label for="new_sec_password" class="col-sm-12 col-form-label">{{
                $t("new_sec_password")
              }}</label>
              <div class="col-sm-12">
                <input
                  type="password"
                  class="form-control"
                  v-model="password"
                  required
                />
              </div>
            </div>

            <div class="form-group row">
              <label
                for="confirm_sec_new_password"
                class="col-sm-12 col-form-label"
                >{{ $t("confirm_sec_new_password") }}</label
              >
              <div class="col-sm-12">
                <input
                  type="password"
                  class="form-control"
                  v-model="password_confirmation"
                  required
                />
              </div>
            </div>

            <div class="form-group row justify-content-end">
              <div class="col-sm-12">
                <div class="float-right w-100" style="margin-top: 10vh">
                  <b-button type="submit" class="m-1 btn-curved" :disabled="isLoading" block>
                    <span class="text-white font-weight-bold"
                      >{{ isLoading ? $t("loading...") : $t("submit") }}
                    </span></b-button
                  >
                </div>
              </div>
            </div>
          </b-form>
        </b-col>
      </b-row>
    </div>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import { forgetSecPassword,getMemberInfo,requestOTP,checkOTP, } from "../../../system/api/api";
import { handleError } from "../../../system/handleRes";
import Dialog from "../../../components/dialog.vue";
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters(["lang"]),
  },
  components: {
    Dialog,
  },
  data() {
    return {
      email: "",
      otp: "",
      timecount: 60,
      startCount: false,
      sec_password: "",
      password: "",
      password_confirmation: "",
      sending: false,
      isLoading: false,
    };
  },
  props: ["success"],
  methods: {
    getInfo() {
      var result = getMemberInfo();
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          self.isLoading = false;
          self.email = value.data.data.email;
        })
        .catch(function (error) {
          self.isLoading = false;
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
    getOTP() {
      if (this.username == "") {
        this.$refs.msg.makeToast("danger", this.$t("emailEmpty"));
      } else {
        this.sending = true;
        this.isLoading = true;
        let formData = new FormData();
        var self = this;
        formData.append("otp_type", "email");
        var result = requestOTP(formData);

        result
          .then(function (value) {
            console.log(value.data);
            if (value.data.code == 0) {
              self.$refs.msg.makeToast("success", self.$t("otp_sent"));
              self.startCount = true;
              self.myVar = setInterval(() => {
                self.timecount -= 1;
                if (self.timecount == 0) {
                  self.timecount = 60;
                  clearInterval(self.myVar);
                  self.startCount = false;
                }
              }, 1000);
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
      }
    },
    sendOTP() {
      let formData = new FormData();
      var self = this;
      formData.append("otp", this.otp);
      var result = checkOTP(formData);
      self.isLoading = true;

      result
        .then(function (value) {
          console.log(value.data);
          if (value.data.code == 0) {
            self.$refs.msg.makeToast("success", self.$t(value.data.message));
            self.submitForm();
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
    submitForm() {
      let formData = new FormData();
      var self = this;
      // formData.append("sec_password", this.sec_password);
      formData.append("password", this.password);
      formData.append("password_confirmation", this.password_confirmation);
      var result = forgetSecPassword(formData);
      self.isLoading = true;

      result
        .then(function (value) {
          if (value.data.code == 0) {
            self.$root.makeToast("success", self.$t(value.data.message));
            // self.sec_password = "";
            self.password = "";
            self.password_confirmation = "";
            self.$router.push("/web/me/mePage");
          } else {
            self.$root.makeToast("danger", self.$t(value.data.message));
          }
          self.sending = false;
          self.isLoading = false;
        })
        .catch(function (error) {
          self.$root.makeToast("warning", self.$t(handleError(error)));
          self.sending = false;
          self.isLoading = false;
        });
    },
  },
  created() {
    this.getInfo();
  },
};
</script>