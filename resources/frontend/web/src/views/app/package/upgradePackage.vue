<template>
  <div class="main-content">
    <div
      class="
        d-flex
        justify-content-between
        align-items-center
        m-3
        mx-4
        text-white
      "
    >
      <a @click="$router.push('/web')">
        <i class="fa fa-chevron-left"></i>
      </a>

      <span class="text-18">
        {{ $t("upgradePackage") }}
      </span>
      <a
        class="right-side text-28"
        @click="$router.push('/web/package/packageHistory')"
      >
        <i class="fa fa-history"></i>
      </a>
    </div>
    <div class="m-3 mx-4">
      <b-row align-h="center">
        <b-col cols="12">
          <b-form v-on:submit.prevent="check_submit">
            <div class="form-group row">
              <label for="point1" class="col-12 col-form-label">{{
                $t("package")
              }}</label>
              <div
                class="col-6"
                v-for="item in selectList"
                :key="item.id"
                @click="selectItem(item)"
              >
                <b-card
                  :class="{ 'gradient-box': packageType == item.id }"
                  class="
                    px-2
                    py-2
                    position-relative
                    text-center
                    mb-3
                  "
                  no-body
                >
                  <h6 class="text-black text-center font-weight-bolder">
                    {{ $t("Bet") }} {{ item.month_cap }}
                  </h6>
                  <h5 class="text-primary font-weight-bold">
                    {{ item.display_price }} USD
                  </h5>
                  <p class="text-black mb-0 text-10">
                    {{ $t("premium_fee") }} <br />
                    USD {{ item.day_cap }} / {{ $t("daily") }}
                  </p>
                  <div v-if="packageType == item.id" class="position-absolute" style="right: 5px; top: 5px">
                    <img
                      height="18px"
                      src="../../../assets/images/widget/selected.svg"
                      alt=""
                    />
                  </div>
                </b-card>
              </div>
            </div>
            <div class="form-group row">
              <label for="package" class="col-sm-12 col-form-label">{{
                $t("package_price")
              }}</label>
              <div class="col-sm-12">
                <input
                  type="number"
                  class="form-control"
                  v-model="displayPackage"
                  readonly
                  @click="$bvModal.show('modal-package')"
                />
                <!--<b-form-select
                  v-model="packageType"
                  :options="selectOptions"
                  id="package"
                >
                </b-form-select>-->
              </div>
            </div>

             <div class="form-group row">
              <label for="payment" class="col-sm-12 col-form-label">{{
                $t("pay_type")
              }}</label>
              <div class="col-sm-12">
                <b-form-select
                  v-model="selectWalletType"
                  :options="paymentOptions"
                  id="payment"
                >
                </b-form-select>
              </div>
            </div>
            
            <div class="form-group row" v-show="selectWalletType!='point1'">
              <label for="price" class="col-sm-12 col-form-label">{{
                $t("enter_insurance_wallet_amount")
              }}</label>
              <div class="col-sm-12">
                <input
                  type="number"
                  class="form-control"
                  id="price"
                  v-model="pay1"
                  required
                />
              </div>
            </div>

            <div class="form-group row" v-show="selectWalletType!='point1'">
              <label for="price" class="col-sm-12 col-form-label">{{
                $t("enter_trade_wallet_amount")
              }}</label>
              <div class="col-sm-12">
                <input
                  type="number"
                  class="form-control"
                  id="price"
                  v-model="pay2"
                  required
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
            <div class="form-group row justify-content-end">
              <div class="col-sm-12">
                <div class="mt-4 float-right w-100">
                  <b-button type="submit" class="m-1 btn-curved" :disabled="isLoading"><span class="text-white font-weight-bold">
                    {{
                    $t("submit")
                  }}
                  </span></b-button>
                </div>
              </div>
            </div>
          </b-form>
        </b-col>
      </b-row>
    </div>
    <Dialog ref="msg"></Dialog>

    <b-modal
      id="modal-package"
      size="lg"
      centered
      :title="$t('package')"
      hide-footer
    >
      <b-list-group>
        <b-list-group-item
          href="#"
          v-for="item in selectList"
          :key="item.id"
          @click="selectItem(item)"
        >
          <div class="d-flex align-items-center">
            <span class="text-50 text-gradient" :class="color(item.price)">
              <i class="fa fa-trophy" aria-hidden="true"></i>
            </span>
            <div class="ml-4 flex-grow-1">
              <h5 class="text-bold text-black">{{ item.display_price }} USD</h5>
              <h6 class="text-black mb-0 font-weight-700">
                {{ $t("Bet") }} {{ item.month_cap }}
              </h6>
              <p class="text-black mb-0">
                {{ $t("premium_fee") }} : USD {{ item.day_cap }} ({{
                  $t("daily")
                }})
              </p>
            </div>
            <span class="text-22 text-black">
              <i class="fa fa-chevron-right" aria-hidden="true"></i>
            </span>
          </div>
        </b-list-group-item>
      </b-list-group>
    </b-modal>
  </div>
</template>

<script>
import {
  upgradePackage,
  getUpgradePackage,
  getMemberInfo,
  bo_info,
} from "../../../system/api/api";
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
      boDetails:"",
      user_group_id: "",
      sec_password: "",
      member: {
        point1: 0,
        point2: 0,
      },
      selectWalletType: "point1",
      pay1: 0,
      pay2: 0,
      displayPackage: "",
      isLoading: false,
      packageType: "1",
      packagePrice: 0,
      packageRemark: "",
      selectList: [],
      selectOptions: [],
      paymentOptions: [
        { value: "point1", text: this.$t("point1") + '100%' },
        { value: "point1&point3", text: this.$t("point1") + ' /' + ' ' +this.$t("point3") },
      ],
      package: [],
    };
  },
  methods: {
    color(i) {
      switch (i) {
        case "630.00":
          return "red";
        case "1260.00":
          return "orange";

        case "3150.00":
          return "green";

        case "6300.00":
          return "blue";

        default:
          break;
      }
    },
    selectItem(item) {
      console.log(item);
      this.displayPackage = item.package_name_en;
      this.packageType = item.id;
      // this.packageRemark = item.remark;
      this.$bvModal.hide("modal-package");
    },
    check_submit(){
      if(this.selectWalletType=='point1&point3'){
        var d = (parseFloat(this.displayPackage) - parseFloat(this.boDetails.capital)) * parseFloat(0.5).toFixed(2);
        console.log(d);
        if(this.pay2 > d){
          this.$refs.msg.makeToast("danger", this.$t("trade_wallet_hint"));
          return false;
        }

        if(parseFloat(this.pay1) + parseFloat(this.pay2) != parseFloat(this.displayPackage) - parseFloat(this.boDetails.capital)){
          this.$refs.msg.makeToast("danger", this.$t("incorrect key in amount"));
          return false;
        }
        this.upgrade_package();
      }else{
        this.upgrade_package();
      }
    },
    upgrade_package() {
      if(this.packageRemark=='E'){
        this.$refs.msg.makeToast("danger", this.$t("contact_customer"));
      }else{
        let formData = new FormData();
        formData.append("user_group", this.packageType);
        formData.append("sec_password", this.sec_password);
        formData.append("pay_type", this.selectWalletType);
        formData.append("pay1", this.pay1);
        formData.append("pay2", this.pay2);

        var result = upgradePackage(formData);
        var self = this;
        this.isLoading = true;
        result
          .then(function (value) {
            if (value.data.code == 0) {
              self.$refs.msg.makeToast("success", self.$t("purchase_success"));
              setTimeout(() => {
                self.$router.push("/web/");
              }, 2000);
            } else {
              self.$refs.msg.makeToast("danger", self.$t(value.data.message));
            }
            
            self.isLoading = false;
          })
          .catch(function (error) {
            self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          });
      }
    },
    _getUpgradePackage() {
      var result = getUpgradePackage();
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          self.selectList = value.data.data;
          self.packageType = value.data.data[0].id;
          for (let i = 0; i < value.data.data.length; i++) {
            var jsonObject = {};
            jsonObject["value"] = value.data.data[i].id;
            jsonObject["text"] =
              self.$i18n.locale == "en"
                ? value.data.data[i].package_name_en
                : value.data.data[i].package_name;
            self.selectOptions.push(jsonObject);
            
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
          // self.member = value.data.data;
          self.packageRemark = value.data.data.package.remark;
        })
        .catch(function () {});
    },
    boInfo() {
      var result = bo_info();
      var self = this;
      self.isLoading = true;
      result
        .then(function (value) {
          self.boDetails = value.data.data;
          console.log(self.boDetails);
        })
        .catch(function () {});
    },
  },
  watch: {
    lang(val) {
      console.log(val);
      var self = this;

      self.selectOptions = [];
      for (let i = 0; i < self.selectList.length; i++) {
        var jsonPrice = {};
        jsonPrice["value"] = self.selectList[i].id;
        jsonPrice["text"] =
          val == "en"
            ? self.selectList[i].package_name_en
            : self.selectList[i].package_name;
        self.selectOptions.push(jsonPrice);
      }
    },
    packageType() {
      this.selectList.forEach((item) => {
        if (this.packageType == item.id) {
          this.packagePrice = item.price;
          this.displayPackage = item.package_name_en;
          // this.packageRemark = item.remark;
        }
      });
    },
  },
  created() {
    this._getUpgradePackage();
    this.memberInfo();
    this.boInfo();
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

/* .list-group-item {
  background: transparent;
} */
</style>

<style scoped>
.text-bold {
  font-weight: bold;
}

.text-gradient.red {
  background: -webkit-linear-gradient(#ff0844, #ffb199);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

.text-gradient.orange {
  background: -webkit-linear-gradient(#f83600, #f9d423);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}
.text-gradient.green {
  background: -webkit-linear-gradient(#9be15d, #00e3ae);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}
.text-gradient.blue {
  background: -webkit-linear-gradient(#243949, #517fa4);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

.text-black {
  color: black;
}
</style>