<template>
  <div class="mt-3" style="position: relative">
    <div
      v-if="startLoading"
      style="
        position: absolute;
        background-color: rgba(211, 211, 211, 0.2);
        height: 100%;
        width: 100%;
        z-index: 3;
        display: flex;
        justify-content: center;
        align-items: center;
      "
    >
      <span
        style="
          background-color: #c0dfff;
          color: #409eff;
          padding: 7px 30px;
          border-radius: 3px;
        "
        >{{ $t("loading...") }}</span
      >
    </div>

    <b-row align-h="center">
      <b-col cols="10">
        <b-form @submit.prevent="doWithdraw">
          <div class="form-group row">
            <label for="point1" class="col-sm-12 col-form-label">{{
              $t("point2")
            }}</label>
            <div class="col-sm-12">
              <b-card class="px-2 py-1 gradient-box" no-body>
                <h5 class="text-black font-weight-bolder mb-0">
                  {{ $t("balance") }}
                </h5>
                <div
                  class="
                    d-flex
                    align-items-center
                    justify-content-center
                    my-1
                    mb-2
                  "
                >
                  <h4
                    class="
                      text-primary
                      font-weight-bold
                      flex-grow-3
                      text-center
                      mb-0
                    "
                  >
                    {{ member.point2 }}
                  </h4>
                </div>
              </b-card>
            </div>
          </div>

          <div class="form-group row">
            <label for="withdrawAmount" class="col-sm-12 col-form-label">{{
              $t("withdrawAmount")
            }}</label>
            <div class="col-sm-12">
              <input
                class="form-control"
                v-model="amount"
                type="number"
                :placeholder="$t('withdrawHint')"
                @change="updateAmount"
                @input="updateAmount"
                min="10"
                step="0.01"
              />
            </div>
          </div>

          <div class="form-group row">
            <label for="wallet_type" class="col-sm-12 col-form-label">{{
              $t("wallet_type")
            }}</label>
            <div class="col-sm-12">
              <b-form-select
                class="font-weight-bolder"
                v-model="walletSelected"
                :options="walletOptions"
              >
              </b-form-select>
            </div>
          </div>

          <div class="form-group row">
            <label for="address" class="col-sm-12 col-form-label">{{
              "TRC20-USDT " + $t("address")
            }}</label>
            <div class="col-sm-12">
              <input
                type="text"
                class="form-control"
                v-model="preset_address"
                required
              />
            </div>
          </div>

          <div class="form-group row">
            <label for="fees" class="col-sm-12 col-form-label">{{
              $t("fees") + " ( " + fee + $t("in") + " )"
            }}</label>
            <div class="col-sm-12">
              <input
                type="text"
                class="form-control"
                v-model="totalFee"
                readonly
              />
            </div>
          </div>

          <div class="form-group row">
            <label for="fees" class="col-sm-12 col-form-label">{{
              $t("usdt_get_amount")
            }}</label>
            <div class="col-sm-12">
              <input
                type="text"
                class="form-control"
                v-model="u_amount"
                readonly
              />
            </div>
          </div>

          <div class="form-group row">
            <label for="fees" class="col-sm-12 col-form-label">{{
              $t("sec_password")
            }}</label>
            <div class="col-sm-12">
              <input
                type="password"
                class="form-control"
                v-model="sec_pwd"
                required
              />
            </div>
          </div>
          <!--<h5 style="color:red">{{$t("remark")}}</h5>
            <h6 style="color:red">{{ $t("withdraw_rules") }}</h6>-->

          <b-button
            type="submit"
            class="mt-5 btn-curved"
            variant="primary"
            block
            :disabled="isLoading"
            >{{ isLoading ? $t("loading...") : $t("withdraw") }}</b-button
          >
        </b-form>
      </b-col>
    </b-row>

    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import {
  withdraw,
  getDownloadLink,
  getMemberInfo,
} from "../../../system/api/api";
import { handleError } from "../../../system/handleRes";
import { mapGetters } from "vuex";
import Dialog from "../../../components/dialog.vue";
export default {
  props: [
    "fee",
    "preset_address",
    "totalAmount",
    "canWithdraw",
    "startLoading",
  ],
  computed: {
    ...mapGetters(["lang"]),
  },
  components: {
    Dialog,
  },
  data() {
    return {
      address: "",
      amount: 0,
      u_amount: 0,
      sec_pwd: "",
      walletSelected: "point2",
      dfi_price: "",
      isLoading: false,
      totalFee: 0,
      member: {
        point1: 0,
      },
      walletOptions: [
        {
          value: "point2",
          text: this.$t("point2"),
        },
      ],
    };
  },
  methods: {
    updateAmount() {
      this.u_amount = ((this.amount * (100 - this.fee)) / 100).toFixed(3);
      if (this.u_amount < 0) {
        this.u_amount = 0;
      }
      this.totalFee = ((this.amount * this.fee) / 100).toFixed(3);
    },

    doWithdraw() {
      let formData = new FormData();
      formData.append("amount", this.amount);
      formData.append("address", this.preset_address);
      formData.append("wallet_type", this.walletSelected);
      formData.append("sec_password", this.sec_pwd);
      console.log(formData);

      var self = this;
      self.isLoading = true;
      var result = withdraw(formData);

      result
        .then(function (value) {
          if (value.data.code == 0) {
            self.$root.makeToast("success", self.$t(value.data.message));
            setTimeout(() => {
              self.$router.push("/web/");
            }, 2000);
          } else {
            self.$refs.msg.makeToast("danger", self.$t(value.data.message));
          }
          self.sec_pwd = "";
          self.isLoading = false;
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          self.isLoading = false;
          self.sec_pwd = "";
        });
    },
    globalInfo() {
      var result = getDownloadLink();
      var self = this;
      result
        .then(function (value) {
          self.dfi_price = value.data.data.system.DFI_PRICE;
        })
        .catch(function () {});
    },
    memberInfo() {
      var result = getMemberInfo();
      var self = this;
      result
        .then(function (value) {
          self.member = value.data.data;
        })
        .catch(function () {});
    },
  },
  created() {
    this.globalInfo();
    this.memberInfo();
  },
};
</script>

<style>
</style>