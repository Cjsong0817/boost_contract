<template>
  <div class="main-content">
    <div class="appBar">
      <a @click="$router.go(-1)">
        <i class="fa fa-chevron-left"></i>
      </a>
      <span>{{ $t("withdraw") }}</span>
      <a
        class="right-side"
        @click="$router.push('/web/withdraw/withdrawHistory')"
      >
        <i class="fa fa-history"></i>
      </a>
    </div>

    <div class="mainpage">
      <b-row align-h="between" class="mt-3">
        <!-- <b-col cols="5" class="pr-0">
          <div
            class="tabContainer text-center"
            :class="{ active: selected == 0 }"
            @click="selectIndex(0)"
          >
            <div class="tabImage">
              <img
                src="../../../assets/images/boost/bank.png"
                alt=""
                height="15px"
              />
            </div>
            <span>{{ $t("bank") }}</span>
          </div>
        </b-col> -->
        <!-- <b-col cols="5" class="pl-0">
          <div
            class="tabContainer text-center"
            :class="{ active: selected == 1 }"
            @click="selectIndex(1)"
          >
            <div class="tabImage">
              <img
                src="../../../assets/images/boost/crypto.png"
                alt=""
                height="15px"
              />
            </div>
            <span>{{ $t("crypto") }}</span>
          </div></b-col
        > -->
      </b-row>
      <!-- <bank
        :fee="fee"
        :totalAmount="totalAmount"
        v-if="selected == 0"
        :canWithdraw="canWithdraw"
        :startLoading="isLoading"
      ></bank> -->
      <coin
        :fee="fee"
        :preset_address="preset_address"
        :totalAmount="totalAmount"
        v-if="selected == 0"
        :canWithdraw="canWithdraw"
        :startLoading="isLoading"
      ></coin>
    </div>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import {
  getWithdrawRecord,
  getMemberInfo,
  withdraw,
} from "../../../system/api/api";
import { handleError } from "../../../system/handleRes";
import Dialog from "../../../components/dialog.vue";
import { mapGetters } from "vuex";
import coin from "../withdraw/coin.vue";
export default {
  computed: {
    ...mapGetters(["lang"]),
  },
  components: {
    Dialog,
    coin,
  },
  data() {
    return {
      address: "",
      totalAmount: 0,
      amount: 0,
      confirm_amount: 0,
      fee: 0,
      sec_pwd: "",
      selected: 0,
      isLoading: false,
      canWithdraw: false,
      preset_address: "",
    };
  },
  props: ["success"],
  methods: {
    selectIndex(i) {
      this.selected = i;
      this.sec_pwd = "";
      this.getInfo();
      this.getRecord();
    },
    updateAmount() {
      this.confirm_amount = (this.amount * this.fee) / 100;
      if (this.confirm_amount < 0) {
        this.confirm_amount = 0;
      }
    },
    inputAll() {
      this.amount = this.totalAmount;
      this.confirm_amount = (this.amount * this.fee) / 100;
    },

    getInfo() {
      var result = getMemberInfo();
      var self = this;
      // self.isLoading = true;

      result
        .then(function (value) {
          if (value.data.data.check_kyc.can_withdraw == "pending") {
            self.$root.makeToast("danger", self.$t("pendingBeforeWithdraw"));
            self.$router.push("/web");

          } else if (value.data.data.check_kyc.can_withdraw == "failed") {
            self.$root.makeToast("danger",self.$t("submitImageBeforeWithdraw"));
            self.$router.push("/web/me/KYC");
            
          }
          // self.isLoading = false;
          self.totalAmount = value.data.point1;
        })
        .catch(function (error) {
          console.log(error);
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          self.isLoading = false;
        });
    },

    getRecord() {
      var result = getWithdrawRecord('COIN', 1);
      var self = this;
      self.isLoading = true;

      result
        .then(function (value) {
          var dataList = value.data.data.data;
          for (let i = 0; i < dataList.length; i++) {
            console.log(dataList[i]);
            if(dataList[i].status==2){
              self.preset_address = dataList[i].address;
             
              break;
            }
          }
          self.fee = value.data.fee;
          self.canWithdraw = !value.data.can_withdraw;
          self.isLoading = false;
        })
        .catch(function (error) {
          self.isLoading = false;
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },

    doWithdraw() {
      let formData = new FormData();
      formData.append("amount", this.amount);
      formData.append("address", this.address);
      formData.append("sec_password", this.sec_pwd);
      console.log(formData);

      var self = this;
      self.isLoading = true;
      var result = withdraw(formData);

      result
        .then(function (value) {
          if (value.data.code == 0) {
            self.$refs.msg.makeToast("success", self.$t(value.data.message));
          } else {
            self.$refs.msg.makeToast("danger", self.$t(value.data.message));
          }
          self.getInfo();
          self.getRecord();
          self.sec_pwd = "";
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          self.isLoading = false;
          self.sec_pwd = "";
        });
    },
  },
  created() {
    this.getInfo();
    this.getRecord();
  },
};
</script>

<style scoped>
.main-content {
  max-width: 420px;
  margin: auto;
}
</style>