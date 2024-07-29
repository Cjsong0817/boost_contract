<template>
  <div class="main-content">
    <div class="appBar">
      <a @click="$router.go(-1)">
        <i class="fa fa-chevron-left"></i>
      </a>
      <a
        class="right-side"
        @click="$router.push('/web/deposit/depositHistory')"
      >
        <i class="fa fa-history"></i>
      </a>
    </div>
    <div class="mainpage mt-3">
      <h4 class="font-weight-bold mb-3">{{ $t("deposit") }} USDT</h4>
      <b-row align-h="center">
        <b-col cols="12">
          <div class="form-group row">
            <div class="gradient-box p-4 sd-block mx-auto mb-2 rounded">
              <qrcode
                :size="size"
                :cls="qrCls"
                :value="newCoinAddress"
              ></qrcode>
            </div>
          </div>
          <div>
            <p
              class="text-light text-center mb-5"
              style="font-size: 12px !important"
            >
              {{ $t("deposit_desc") }}
            </p>
          </div>
          <div class="mx-0">
            <h6 class="mb-2 text-light">
              {{ "USDT " + $t("deposit_address") }}
            </h6>
            <b-row class="mb-4 bg-gray mx-1 py-2 rounded">
              <b-col cols="10" class="w-100" style="word-break: break-all">
                <h5 class="mb-0">{{ newCoinAddress }}</h5></b-col
              >
              <b-col cols="2">
                <span class="text-20 text-white">
                  <i
                    class="fa fa-clone"
                    v-clipboard="() => newCoinAddress"
                    v-clipboard:success="clipboardSuccessHandler"
                    v-clipboard:error="clipboardErrorHandler"
                  ></i> </span
              ></b-col>
            </b-row>
            <h6 class="mb-1 text-light">
              {{ $t("network") }}
            </h6>
            <b-row class="text-white" align-v="center">
              <b-col cols="12">
                <div class="bg-gray p-2 px-3 rounded">
                  <h5 class="mb-0">Tron (TRC20)</h5>
                </div>
              </b-col>
            </b-row>
          </div>
        </b-col>
      </b-row>
    </div>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import { required } from "vuelidate/lib/validators";
import Qrcode from "v-qrcode/src/index";
import { getWallet } from "../../../system/api/api";
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
      qrCls: "qrcode",
      size: 180,

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
    };
  },
  props: ["success"],
  methods: {
    clipboardSuccessHandler() {
      this.$refs.msg.makeToast("success", this.$t("copied"));
    },
    clipboardErrorHandler() {},

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
  },
  created() {
    this.getCoin();
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