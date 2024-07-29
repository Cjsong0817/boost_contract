<template>
  <div class="main-content">
    <div class="appBar">
      <a @click="$router.go(-1)">
        <i class="fa fa-chevron-left"></i>
      </a>
      <span>{{ $t("purchase_insurance") }}</span>
      <a
        class="right-side"
        @click="$router.push('/web/insurance/insuranceRecord')"
      >
        <i class="fa fa-history"></i>
      </a>
    </div>
    <div class="m-3 mx-5">
      <b-row align-h="center">
        <b-col cols="12">
          <b-form v-on:submit.prevent="_purchaseInsurance">
            <!-- <div class="form-group row">
              <label for="point1" class="col-sm-2 col-form-label">{{
                $t("point1")
              }}</label>
              <div class="col-sm-10">
                <input
                  type="number"
                  class="form-control"
                  id="point1"
                  v-model="member.point1"
                  readonly
                />
              </div>
            </div> -->

            <div class="form-group row">
              <label for="point1" class="col-sm-2 col-form-label">{{
                $t("point3")
              }}</label>
              <div class="col-sm-10">
                <input
                  type="number"
                  class="form-control"
                  id="point3"
                  v-model="member.point3"
                  readonly
                />
              </div>
            </div>

            <div class="form-group row">
              <label for="payment" class="col-sm-2 col-form-label">{{
                $t("pay_type")
              }}</label>
              <div class="col-sm-10">
                <b-form-select
                  v-model="selectWalletType"
                  :options="paymentOptions"
                  id="payment"
                >
                </b-form-select>
              </div>
            </div>
            
            <div class="form-group row">
              <label for="price" class="col-sm-2 col-form-label">{{
                $t("price_insurance")
              }}</label>
              <div class="col-sm-10">
                <input
                  type="number"
                  class="form-control"
                  id="price"
                  v-model="member.package.insurance_pay"
                  readonly
                />
              </div>
            </div>
            <div class="form-group row">
              <label for="sec_password" class="col-sm-2 col-form-label">{{
                $t("sec_password")
              }}</label>
              <div class="col-sm-10">
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
              class="my-5 btn-curved"
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
import { purchaseInsurance, getMemberInfo } from "../../../system/api/api";
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
      },
      selectWalletType: "point3",

      isLoading: false,
      paymentOptions: [
        // { value: "point1", text: this.$t("point1") },
        { value: "point3", text: this.$t("point3") },
      ],
      package: [],
    };
  },
  methods: {
    _purchaseInsurance() {
      // e.preventDefault();
      let formData = new FormData();
      formData.append("pay_type", this.selectWalletType);
      formData.append("sec_password", this.sec_password);

      var result = purchaseInsurance(formData);
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          if (value.data.code == 0) {
            self.$root.makeToast("success", self.$t("purchase_success"));
            self.$router.push("/web");
          } else {
            self.$root.makeToast("danger", self.$t(value.data.message));
          }
          self.isLoading = false;
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
  },
};
</script>

<style>
.hiddenClass {
  pointer-events: none;
  display: none;
}

.bodyWidth {
  min-width: 120px;
}
</style>