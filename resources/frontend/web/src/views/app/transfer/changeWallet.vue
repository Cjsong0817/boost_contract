<template>
  <div class="main-content">
    <div class="appBar">
      <a @click="$router.go(-1)">
        <i class="fa fa-chevron-left"></i>
      </a>
      <span>{{ $t("change_wallet") }}</span>
    </div>
    <div class="m-3 mx-5">
      <b-row align-h="center">
        <b-col cols="12">
          <b-form v-on:submit.prevent="_userChangeWallet">
            <div class="form-group row">
              <label for="point1" class="col-sm-12 col-form-label">{{
                $t("wallet")
              }}</label>
              <div class="col-sm-12">
                <b-card class="px-2 py-2 gradient-box" no-body>
                  <h5 class="text-black font-weight-bolder">
                    {{ fromSelect ? $t("point2") : $t("point1") }}
                  </h5>
                  <div
                    class="
                      d-flex
                      align-items-center
                      justify-content-between
                      my-2
                    "
                  >
                    <small class="text-10 flex-grow-1"
                      >{{ $t("balance") }}
                    </small>
                    <h4 class="text-primary font-weight-bold flex-grow-3 text-center mb-0">
                      {{ fromSelect ? member.point2 : member.point1 }}
                    </h4>
                    <div class="flex-grow-2"></div>
                  </div>
                  <div class="d-flex justify-content-end">
                    <img
                      height="24px"
                      src="../../../assets/images/widget/selected.svg"
                      alt=""
                    />
                  </div>
                </b-card>
              </div>
            </div>

            <!--<div class="form-group row">
              <label for="point2" class="col-sm-2 col-form-label">{{
                $t("point2")
              }}</label>
              <div class="col-sm-10">
                <input
                  type="number"
                  class="form-control"
                  id="point2"
                  v-model="member.point2"
                  readonly
                />
              </div>
            </div>-->

            <div class="form-group row">
              <label for="payment" class="col-sm-12 col-form-label">{{
                $t("swap_from")
              }}</label>
              <div class="col-sm-12">
                <b-form-select
                  v-model="selectWalletType"
                  :options="fromOptions"
                  @change="from"
                  id="payment"
                >
                </b-form-select>
              </div>
            </div>

            <div class="form-group row">
              <label for="point2" class="col-sm-12 col-form-label">{{
                $t("swap_to")
              }}</label>
              <div class="col-sm-12">
                <input
                  type="text"
                  class="form-control"
                  id="point3"
                  :value="$t('point3')"
                  readonly
                />
              </div>
            </div>

            <!-- <div class="form-group row">
              <label for="payment" class="col-sm-2 col-form-label">{{
                $t("swap_to")
              }}</label>
              <div class="col-sm-10">
                <b-form-select
                  v-model="selectWalletType"
                  :options="paymentOptions"
                  id="payment"
                >
                </b-form-select>
              </div>
            </div> -->

            <div class="form-group row">
              <label for="price" class="col-sm-12 col-form-label">{{
                $t("amount")
              }}</label>
              <div class="col-sm-12">
                <input
                  type="number"
                  class="form-control"
                  id="price"
                  v-model="amount"
                  min="0.01"
                  step="0.01"
                  @change="updateAmount"
                  @input="updateAmount"
                  required
                />
              </div>
            </div>

            <div class="form-group row" v-show="selectWalletType=='point2'">
              <label for="free_extra" class="col-sm-12 col-form-label">{{
                $t("free_extra")
              }}</label>
              <div class="col-sm-12">
                <input
                  type="text"
                  class="form-control"
                  id="point3"
                  v-model="free_extra"
                  readonly
                />
              </div>
            </div>

            <div class="form-group row">
              <label for="get_amount" class="col-sm-12 col-form-label">{{
                $t("get_amount")
              }}</label>
              <div class="col-sm-12">
                <input
                  type="text"
                  class="form-control"
                  id="point3"
                  v-model="get_amount"
                  readonly
                />
              </div>
            </div>

            <div class="form-group row">
              <label for="sec_password" class="col-sm-12 col-form-label">{{
                $t("sec_password")
              }}</label>
              <div class="col-sm-12">
                <input
                  class="form-control"
                  label="sec_password"
                  v-model="sec_password"
                  type="password"
                  required
                />
              </div>
            </div>

            <b-button
              type="submit"
              class="mt-5 btn-curved"
              variant="primary"
              block
              :disabled="isLoading"
              >{{ $t("submit") }}</b-button
            >
          </b-form>
        </b-col>
      </b-row>
    </div>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import { userChangeWallet, getMemberInfo,getDownloadLink, } from "../../../system/api/api";
import Dialog from "../../../components/dialog.vue";
import { handleError } from "../../../system/handleRes";
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
      amount: "",
      sec_password: "",
      member: {
        point1: 0,
        point2: 0,
      },
      selectWalletType: "point1",
      free_extra: "",
      get_amount: "",

      isLoading: false,
      fromOptions: [
        { value: "point1", text: this.$t("point1") },
        { value: "point2", text: this.$t("point2") },
      ],
      // paymentOptions: [
      //   { value: "point1", text: this.$t("point1") },
      //   { value: "point3", text: this.$t("point3") },
      // ],
      package: [],
      fromSelect: false,
    };
  },
  methods: {
    from(value) {
      if(value=='point1'){
        this.fromSelect = false;
        this.amount='';
        this.get_amount='';
      }else{
        this.fromSelect = true;
        this.amount='';
        this.get_amount='';
      }
    },
    updateAmount() {
      if(this.fromSelect==true){
        this.get_amount = parseInt(this.amount) + parseInt(this.amount * this.free_extra / 100);
        if (this.get_amount < 0) {
          this.get_amount = 0;
        }
      }else{
        this.get_amount = parseInt(this.amount);
        if (this.get_amount < 0) {
          this.get_amount = 0;
        }
      }
      
    },
    getFees() {
      var result = getDownloadLink();
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          self.isLoading = false;
          self.free_extra = value.data.data.system.TRADE_WALLET;
        })
        .catch(function (error) {
          self.isLoading = false;
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
    _userChangeWallet() {
      // e.preventDefault();
      this.isLoading = true;
      let formData = new FormData();
      formData.append("amount", Number(this.amount));
      formData.append("transfer_type", this.selectWalletType);
      formData.append("sec_password", this.sec_password);

      var result = userChangeWallet(formData);
      var self = this;
      result
        .then(function (value) {
          self.isLoading = false;
          if (value.data.code == 0) {
            self.$refs.msg.makeToast("success", self.$t("successSubmit"));
            self.$router.go(0);
          } else {
            self.$refs.msg.makeToast("danger", self.$t(value.data.message));
            // self.$router.go(0);
          }
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
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
  watch: {
    lang(val) {
      console.log(val);
    },
  },
  created() {
    this.memberInfo();
    this.getFees();
  },
};
</script>

<style scoped>
.main-content {
  max-width: 420px;
  margin: auto;
}
</style>

<style>
.hiddenClass {
  pointer-events: none;
  display: none;
}

.bodyWidth {
  min-width: 120px;
}
</style>