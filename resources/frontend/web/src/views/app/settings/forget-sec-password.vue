<template>
  <div class="main-content">
    <div class="appBar">
      <a @click="$router.go(-1)">
        <i class="fa fa-chevron-left"></i>
      </a>
      <span>{{ $t("change_secpassword") }}</span>
    </div>
    <b-form @submit.prevent="sendOTP">
      <div class="mainpage">
        <b-form-group
          id="input-group-2"
          :label="$t('phone')"
          label-for="input-2"
        >
          <!-- <b-form-input
            id="input-2"
            v-model="phone"
            type="text"
            readonly
            required
          ></b-form-input> -->
          <b-input-group>
            <b-input-group-prepend>
              <span class="input-group-text">{{ country }}</span>
            </b-input-group-prepend>
            <b-form-input class="LoginInput" size="lg" v-model="phone" readonly>
            </b-form-input>
          </b-input-group>
        </b-form-group>

        <b-form-group
          id="input-group-2"
          :label="$t('vcode')"
          label-for="input-2"
        >
        <b-input-group>
        <b-form-input
          class="form-control mb-3 form-custom-prepend"
          label="text"
          type="number"
          v-model="otp"
          required
        >
        </b-form-input>
         <b-input-group-append
            class="form-custom-append"
            style="position: relative"
          >
            <b-button
              variant="light"
              style="
                border-bottom-right-radius: 0.5rem !important;
                border-top-right-radius: 0.5rem !important;
              "
              :disabled="startCount || sending"
              @click="getOTP"
            >
              <span v-if="!sending">{{ $t("get_vcode") }}</span
              ><span v-else class="text-white">{{ $t("loading...") }}</span>
            </b-button>
            <div v-if="startCount" class="text-center py-2 overlay-text">
              {{ timecount }} s
            </div>
          </b-input-group-append>
        </b-input-group>
        </b-form-group>
        

        <b-form-group
          id="input-group-2"
          :label="$t('new_password')"
          label-for="input-2"
        >
          <b-form-input
            id="input-2"
            v-model="password"
            type="password"
            required
          ></b-form-input>
        </b-form-group>

        <b-form-group
          id="input-group-2"
          :label="$t('confirm_new_password')"
          label-for="input-2"
        >
          <b-form-input
            id="input-2"
            v-model="password_confirmation"
            type="password"
            required
          ></b-form-input>
        </b-form-group>

        <b-button
          class="mx-auto submit_button"
          style="margin-top: 20vh"
          variant="outline-secondary"
          type="submit"
          >{{ isLoading ? $t("loading...") : $t("submit") }}</b-button
        >
      </div>
    </b-form>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import {
  getMemberInfo,
  requestOTP,
  checkOTP,
  forgetSecPassword,
} from "../../../system/api/api";
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
        phone: "",
        country: "",
        otp: "",
        password: "",
        password_confirmation: "",
        timecount: 60,
        startCount: false,
        myVar: null,
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
          self.phone = value.data.contact_number;
          self.country = value.data.country.country_code;
        })
        .catch(function (error) {
          self.isLoading = false;
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
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
      formData.append("password", this.password);
      formData.append("password_confirmation", this.password_confirmation);
      var result = forgetSecPassword(formData);
      self.isLoading = true;

      result
        .then(function (value) {
          console.log(value.data);
          if (value.data.code == 0) {
            self.$refs.msg.makeToast("success", self.$t(value.data.message));
            self.otp='';
            self.password='';
            self.password_confirmation='';
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
    loadItems() {},
  },
  created() {
    this.loadItems();
    this.getInfo();
    this.username = localStorage.getItem("username");
  },
};
</script>