<template>
  <div
    class="main-content flex-grow-1 d-flex flex-column"
    style="
      height: 100%;
      width: 100%;
      max-height: 100%;
      min-height: 100%;
      position: fixed;
      overflow-y: scroll;
    "
  >
    <div class="appBar">
      <a @click="$router.go(-1)">
        <i class="fa fa-chevron-left"></i>
      </a>
    </div>
    <div class="mainpage mt-3 flex-grow-1 d-flex flex-column">
      <h4 class="font-weight-bold mb-3">{{ $t("invite_link") }}</h4>
      <b-row align-h="center" class="">
        <b-col md="8 my-4">
          <div class="form-group row">
            <div class="gradient-box p-4 sd-block mx-auto mb-0 rounded">
              <qrcode :size="size" :cls="qrCls" :value="inv_link"></qrcode>
            </div>
          </div>
        </b-col>
      </b-row>
      <div class="d-flex flex-column justify-content-center">
        <h6 class="text-center font-weight-bold">
          {{ $t("refer_register") }}
        </h6>
        <p class="text-center">{{ $t("scanDesc") }}</p>
      </div>
      <div class="form-group row">
        <label for="link" class="col-sm-12 col-form-label font-weight-bold">{{
          $t("invite_link")
        }}</label>
        <div class="col-sm-12">
          <input
            type="text"
            class="form-control text-white font-weight-bold"
            id="link"
            v-model="inv_link"
            readonly
          />
        </div>
      </div>
      <b-row no-gutters class="mb-5 pb-5">
        <b-col cols="12" class="">
          <b-button
            type="button"
            class="my-1 w-100 btn-curved"
            v-clipboard="() => inv_link"
            v-clipboard:success="clipboardSuccessHandler"
            v-clipboard:error="clipboardErrorHandler"
          >
            <span class="text-white font-weight-bold">
              <i class="fa fa-copy"></i>
              {{ $t("copy") }}
            </span></b-button
          ></b-col
        >
        <b-col cols="12" class="">
          <b-button
            type="button"
            class="my-1 w-100 btn-curved"
            @click="shareBtn"
          >
            <span class="text-white font-weight-bold">
              <i class="fa fa-share"></i>
              {{ $t("share") }}
            </span></b-button
          ></b-col
        >
      </b-row>
    </div>
    <Dialog ref="msg"></Dialog>
  </div>
</template>
  
  <script>
import { required } from "vuelidate/lib/validators";
import Qrcode from "v-qrcode/src/index";
import { getMemberInfo, getWallet } from "../../../system/api/api";
import { handleError } from "../../../system/handleRes";
import Dialog from "../../../components/dialog.vue";
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters(["lang"]),
  },
  components: {
    Dialog,
    Qrcode,
  },
  validations: {
    newCoinType: {
      required,
    },
    newAmount: {
      required,
    },
    tx_id: {
      required,
    },
    tx_id2: {
      required,
    },
    sec_pwd: {
      required,
    },
  },

  data() {
    return {
      bgImage: require("../../../assets/images/walletBg.jpg"),
      qrCls: "qrcode",
      size: 240,
      inv_link: "",

      newAmount: "",
      newCoinAddress: "",
      newCoinType: "",
      coin: null,
      coinList: [],
      coinOptions: [],
      isLoading: false,
      tx_id: "",
      tx_id2: "",
      address: "",
      sec_pwd: "",
      dfi_paid: "",
      option_paid: "",
      selected: "1",
      globalDfiAddress: "",
      globalDfiPrice: "",
      finalAmount: "",
      finalAmount2: "",
      depositName: "",
      is100: false,
      ref_code: "",
    };
  },
  props: ["success"],
  methods: {
    clipboardSuccessHandler() {
      this.$refs.msg.makeToast("success", this.$t("copied"));
    },
    clipboardErrorHandler() {},
    shareBtn() {
      let shareData = {
        title: "Winato Trade Network",
        text: "Let's join Winato Trade Network!",
        url: this.inv_link,
      };
      navigator.share(shareData);
    },
    getCoin() {
      var result = getWallet();
      var self = this;
      self.isLoading = true;

      result
        .then(function (value) {
          if (value.data.code == 0) {
            self.newCoinAddress = value.data.data;
          }
          self.isLoading = false;
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          self.isLoading = false;
        });
    },
    loadItems() {
      var result = getMemberInfo();

      var self = this;
      this.isLoading = true;
      self.inv_link = location.origin + "/register?ref_id=";
      result
        .then(function (value) {
          self.memberInfo = value.data.data;
          self.ref_code = value.data.data.ref_code;
          self.isLoading = false;
          self.inv_link = self.inv_link + self.ref_code;
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
  },
  created() {
    this.loadItems();
  },
};
</script>
  
  <style>
.stepTitle.active {
  color: aqua;
}

.stepTitle {
  color: white;
}

.vue-form-wizard .wizard-header {
  display: none;
}
.vue-form-wizard .wizard-nav-pills > li.active > a .wizard-icon {
  color: #003473;
}
.upload-box {
  height: 10vh;
  position: relative;
  width: 30vw;
}
.upload-hint {
  position: absolute;
  width: 100%;
  height: 100%;
  border-style: solid;
  border-width: 1px;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
}

.upload-hint.active {
  border-color: red;
  background-color: transparent !important;
  color: red !important;
}
</style>



<style scoped>
.main-content {
  max-width: 420px;
  margin: auto;
}
</style>