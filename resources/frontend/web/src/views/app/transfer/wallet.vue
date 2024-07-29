<template>
  <div class="main-content" :style="{ backgroundImage: 'url(' + bgImage + ')' }" style="
    padding-bottom: 10vh !important
      background-repeat: no-repeat;
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover;
      width: 100%;
      background-position: center;
    ">
    <div class="dashboard-banner position-relative">
      <div class="d-flex justify-content-center align-items-end">
        <h4 class="mt-5 mx-4 text-center text-white">{{ $t("dashboard") }}</h4>
      </div>

      <div class="position-absolute h-100 w-100" style="background: #d2d2d24d" v-if="isLoading">
        <div class="px-2 py-1 rounded" style="
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #add8e6;
          ">
          <p class="mb-0">{{ $t("loading...") }}</p>
        </div>
      </div>
      <div class="p-3 text-white" style="padding-bottom: 6vh !important">
        <div class="d-flex align-items-center justify-content-end mb-2">
          <h5 class="mb-0 flex-grow-1 text-white text-12">
            Binaxtion
            {{ $t("capital") }}
          </h5>
          <p class="text-right mb-0 text-10">
            ({{ $t("lastUpdated") + " " + refreshDate }})
          </p>

          <span class="py-0 px-1 mb-0 ml-1 bg-transparent" @click="boInfo">
            <i class="fa fa-refresh"></i>
          </span>
        </div>
        <b-row class="text-white">
          <b-col cols="8">
            <div class="d-flex flex-column align-items-start flex-grow-1">
              <h2 class="font-weight-bold mb-0 text-white">
                {{ boDetails? boDetails.capital : 0.0 }} USD
              </h2>
              <h5 class="text-white mb-2 font-weight-600">
                (
                {{
  boDetails
  ? checkInt(boDetails.profit) + boDetails.profit
                : 0.0
                }}
                )
              </h5>
              <b-row align-v="center">
                <b-col cols="4" class="mb-2">
                  <p v-if="activeCover == 0" class="mb-0 text-12 text-light font-weight-500">
                    <b-badge href="#" variant="success" class="p-1 text-12">{{
                      $t("insured")
                    }}</b-badge>
                  </p>
                  <p v-else class="mb-0 text-12 text-black font-weight-500">
                    <b-badge href="#" class="p-1 text-12 bg-white">{{
                      $t("uninsured")
                    }}</b-badge>
                  </p>
                </b-col>
              </b-row>
            </div>
          </b-col>
          <b-col cols="4">
            <div class="
                d-flex
                flex-column
                align-items-end
                justify-content-center
                h-100
              ">
              <b-button variant="danger" class="p-1 px-2 mb-2 btn-rounded-1" v-if="!expired"
                @click="openSurrenderModal">{{ $t("surrender") }}</b-button>
              <b-button class="p-1 px-2 bg-white btn-rounded-1" v-if="!boBalance" :href="boLink"
                :disabled="member.todayStatus.cover != 1" target="_blank" style="background: white !important">
                Binaxtion
                <!--<br v-if="$i18n.locale == 'en'" />-->
                {{ $t("log_in") }}
              </b-button>
            </div>
          </b-col>
        </b-row>
      </div>

      <div class="position-absolute w-100" style="bottom: -5vh">
        <div class="mx-3 text-white px-4 py-2 position-relative" style="height: 10vh">
          <div class="bg-semitrans"></div>
          <b-row class="">
            <b-col class="text-center" cols="3">
              <img height="60%" @click="$router.push('/web/transfer')" src="../../../assets/images/widget/transfer.svg"
                alt="" />

              <p class="mb-0">{{ $t("transfer") }}</p>
            </b-col>
            <b-col class="text-center" cols="3">
              <img height="60%" @click="$router.push('/web/transfer/changeWallet')"
                src="../../../assets/images/widget/swap.svg" alt="" />
              <p class="mb-0">{{ $t("swap") }}</p>
            </b-col>
            <b-col class="text-center" cols="3">
              <img height="60%" @click="$router.push('/web/deposit')" src="../../../assets/images/widget/deposit.svg"
                alt="" />
              <p class="mb-0">{{ $t("deposit") }}</p>
            </b-col>
            <b-col class="text-center" cols="3">
              <img height="60%" @click="checkWithdraw" src="../../../assets/images/widget/withdraw.svg" alt="" />
              <p class="mb-0">{{ $t("withdraw") }}</p>
            </b-col>
          </b-row>
        </div>
      </div>
    </div>
    <div class="m-3 mx-3 text-white" style="padding-top: 5vh">
      <b-row no-gutters>
        <b-col cols="6" class="pr-1">
          <b-card no-body class="bg-transparent p-3 px-3 position-relative" @click="upgradePackage">
            <div class="bg-semitrans"></div>

            <b-row no-gutters align-v="center">
              <b-col cols="10">
                <p class="font-weight-bold mb-1">{{ $t("purchasePackage") }}</p>
                <p class="mb-0 text-12 font-weight-500">
                  {{ $t("current") + " : " + getPackage }}
                </p>
              </b-col>
              <b-col cols="2">
                <img src="../../../assets/images/package.svg" alt="" />
              </b-col>
            </b-row>
          </b-card>
        </b-col>
        <b-col cols="6" class="pl-1">
          <b-card no-body class="bg-transparent p-3 px-3 position-relative" @click="checkInsurance">
            <div class="bg-semitrans"></div>
            <b-row no-gutters align-v="center">
              <b-col cols="10">
                <p class="font-weight-bold mb-1">{{ $t("claimInsurance") }}</p>
                <p v-if="activePackage == 1" class="mb-0 text-12 text-light font-weight-500">
                  <b-badge href="#" variant="success" class="p-1">{{
                    $t("consumed")
                  }}</b-badge>
                </p>
                <p v-else-if="activePackage == 0" class="mb-0 text-12 text-light font-weight-500">
                  <b-badge href="#" variant="warning" class="p-1">{{
                    $t("pending")
                  }}</b-badge>
                </p>
                <p v-else class="mb-0 text-12 text-light font-weight-500">
                  <b-badge href="#" variant="warning" class="p-1 text-white">{{
                    $t("apply")
                  }}</b-badge>
                </p>
              </b-col>
              <b-col cols="2">
                <img src="../../../assets/images/insurance.svg" alt="" />
              </b-col>
            </b-row>
          </b-card>
        </b-col>
      </b-row>
    </div>
    <div class="m-3 mx-3 py-0">
      <b-card class="bg-transparent position-relative px-3 py-3" no-body>
        <div class="bg-semitrans"></div>
        <b-row align-v="center">
          <b-col cols="9">
            <p class="text-white font-weight-bold mb-0">
              {{ $t("autoRenew") }}
            </p>
          </b-col>
          <b-col cols="3">
            <label class="switch switch-primary switch-xs mr-3">
              <input v-if="member" type="checkbox" v-model="auto_renew" @change="checkRenew"
                :disabled="member.myActivePackage == 'null'" />
              <span class="slider"></span>
            </label>
          </b-col>
        </b-row>
      </b-card>
    </div>

    <div class="m-3 mx-3 py-0">
      <b-card class="bg-transparent position-relative px-3 py-3" no-body>
        <div class="bg-semitrans"></div>
        <b-row align-v="center">
          <b-col cols="9">
            <p class="text-white font-weight-bold mb-0">
              {{ $t("follow_trade") }}
            </p>
          </b-col>
          <b-col cols="3" v-show="member.followPending == false">
            <label class="switch switch-primary switch-xs mr-3">
              <input v-if="member" type="checkbox" :checked="follow_trade" @change="comingSoon"
                :disabled="member.followPending == true || isLoading" />
              <span class="slider"></span>
            </label>
          </b-col>
          <b-col cols="3" v-show="member.followPending == true">
            <p class="text-white font-weight-bold mb-0">
              {{ $t("pending") }}
            </p>
          </b-col>
        </b-row>
      </b-card>
    </div>

    <b-card class="bg-transparent m-3 mx-3 py-2 px-3 text-white position-relative" no-body>
      <div class="bg-semitrans"></div>
      <b-row no-gutters>
        <b-col cols="8">
          <div class="d-flex flex-column align-items-start">
            <p class="mt-2 font-weight-bold mb-1">{{ $t("point1") }}</p>
            <h3 class="text-primary font-weight-bold mb-1">{{ getPoint1 }}</h3>
          </div>
        </b-col>
        <!-- <b-col cols="2" class="">
          <div
            class="d-flex flex-column align-items-center mt-1"
            @click="$router.push('/web/insurance/purchaseInsurance')"
          >
            <img
              height="60%"
              src="../../../assets/images/widget/purchase_insurance.svg"
              alt=""
            />
            <p class="text-12 mb-0 button-title">
              {{ $t("purchase_insurance") }}
            </p>
          </div>
        </b-col> -->
        <b-col cols="2" class="">
          <div class="d-flex flex-column align-items-center mt-1"
            @click="$router.push('/web/insurance/claimInsuranceHis')">
            <img height="60%" src="../../../assets/images/widget/insurance_record.svg" alt="" />
            <p class="text-12 mb-0 button-title">{{ $t("claimRecord") }}</p>
          </div>
        </b-col>
        <b-col cols="2" class="">
          <div class="d-flex flex-column align-items-center mt-1"
            @click="$router.push('/web/wallet/record?type=point1')">
            <img height="60%" src="../../../assets/images/widget/record.svg" alt="" />
            <p class="text-12 mb-0 button-title">{{ $t("record") }}</p>
          </div>
        </b-col>
      </b-row>
    </b-card>

    <b-card class="bg-transparent m-3 mx-3 py-2 px-3 text-white position-relative" no-body>
      <div class="bg-semitrans"></div>
      <b-row no-gutters>
        <b-col cols="10">
          <div class="d-flex flex-column align-items-start">
            <p class="mt-2 font-weight-bold mb-1">{{ $t("point2") }}</p>
            <h3 class="text-primary font-weight-bold mb-1">{{ getPoint2 }}</h3>
          </div>
        </b-col>
        <b-col cols="2" class="">
          <div class="d-flex flex-column align-items-center mt-1"
            @click="$router.push('/web/wallet/record?type=point2')">
            <img height="60%" src="../../../assets/images/widget/record.svg" alt="" />
            <p class="text-12 mb-0 button-title">{{ $t("record") }}</p>
          </div>
        </b-col>
      </b-row>
    </b-card>

    <b-card class="bg-transparent m-3 mx-3 py-2 px-3 text-white position-relative" no-body>
      <div class="bg-semitrans"></div>
      <b-row no-gutters>
        <b-col cols="8">
          <div class="d-flex flex-column align-items-start">
            <p class="mt-2 font-weight-bold mb-1">{{ $t("point3") }}</p>
            <h3 class="text-primary font-weight-bold mb-1">{{ getPoint3 }}</h3>
          </div>
        </b-col>
        <b-col cols="2" class="">
          <div class="d-flex flex-column align-items-center mt-1" @click="purchase_insurance">
            <img height="60%" src="../../../assets/images/widget/purchase_insurance.svg" alt="" />
            <p class="text-12 mb-0 button-title">
              {{ $t("purchase_insurance") }}
            </p>
          </div>
        </b-col>
        <b-col cols="2" class="">
          <div class="d-flex flex-column align-items-center mt-1"
            @click="$router.push('/web/wallet/record?type=point3')">
            <img height="60%" src="../../../assets/images/widget/record.svg" alt="" />
            <p class="text-12 mb-0 button-title">{{ $t("record") }}</p>
          </div>
        </b-col>
      </b-row>
    </b-card>

    <b-card class="bg-transparent m-3 mx-3 py-2 px-3 text-white position-relative" no-body>
      <div class="bg-semitrans"></div>
      <b-row no-gutters>
        <b-col cols="10">
          <div class="d-flex flex-column align-items-start">
            <p class="mt-2 font-weight-bold mb-1">
              {{ $t("team_sale") }} ({{ member.team_member + $t("person") }})
            </p>
            <h3 class="text-primary font-weight-bold mb-1">
              ${{ member.team_sales || 0 }}
            </h3>
          </div>
        </b-col>
        <!-- <b-col cols="2" class="">
      <div
        class="d-flex flex-column align-items-center mt-1"
        @click="$router.push('/web/wallet/record?type=point2')"
      >
        <img
          height="60%"
          @click="checkWithdraw"
          src="../../../assets/images/widget/record.svg"
          alt=""
        />
        <p class="text-12 mb-0 button-title">{{ $t("record") }}</p>
      </div>
    </b-col>-->
      </b-row>
    </b-card>

    <b-modal id="modal-surrender" size="md" centered :hide-footer="true" style="background-color: #5f646e !important">
      <b-form class="mx-5" @submit.prevent="surrender">
        <div class="form-group row mb-3">
          <label for="confirm_password" class="col-12 col-form-label text-black font-weight-bold">{{
            $t("sec_password")
          }}</label>
          <div class="col-12">
            <input class="form-control bg-white text-black" v-model="sec_password" type="password" required />
          </div>
        </div>

        <b-button type="submit" class="my-1 btn-curved" variant="primary" block :disabled="isLoading">{{
          $t("submit")
        }}</b-button>
      </b-form>
    </b-modal>

    <b-modal id="modal-password" size="md" centered :hide-footer="true" style="background-color: #5f646e !important">
      <b-form class="mx-5" @submit.prevent="claiming">
        <div class="form-group row mb-3">
          <label for="confirm_password" class="col-12 col-form-label text-black font-weight-bold">{{
            $t("sec_password")
          }}</label>
          <div class="col-12">
            <input class="form-control bg-white text-black" v-model="sec_password" type="password" required />
          </div>
        </div>

        <b-button type="submit" class="my-1 btn-curved" variant="primary" block :disabled="isLoading">{{
          $t("submit")
        }}</b-button>
      </b-form>
    </b-modal>

    <b-modal id="modal-follow" size="sm" centered :hide-footer="true" style="background-color: #5f646e !important"
      @hidden="cancelFollowAction">
      <template #modal-header>
        <div class="mx-auto">
          <h5 class="modal-title">{{ $t('t&c') }}</h5>
        </div>
      </template>
      <div v-html="$t('followTNC')"></div>
      <b-row>
        <b-col><b-button type="button" @click="checkFollowTrade" class="my-1" variant="success" block
            :disabled="isLoading">{{
              $t("confirm")
            }}</b-button></b-col>
        <b-col><b-button type="button" @click="cancelFollowAction" class="my-1" variant="danger" block
            :disabled="isLoading">{{
  $t("cancel")
            }}</b-button></b-col>
      </b-row>
    </b-modal>
    <Dialog ref="msg"></Dialog>
  </div>
</template>
<script>
import {
  getMemberInfo,
  getDownloadLink,
  bo_login,
  bo_info,
  claimInsurance,
  _surrender,
  updateMemberInfo,
  updateFollowTrade,
} from "../../../system/api/api";
import { mapGetters, mapActions } from "vuex";
import { handleError } from "../../../system/handleRes";
import Dialog from "../../../components/dialog.vue";
export default {
  computed: {
    ...mapGetters([
      "getPoint1",
      "getPoint2",
      "getPoint3",
      "getPoint4",
      "getIncome",
      "getTotal",
      "getPackage",
    ]),
  },
  components: {
    Dialog,
  },
  data() {
    return {
      bgImage: require("../../../assets/images/background_black.jpeg"),
      member: {
        team_member: 0,
        team_sales: 0,
      },
      dfi_price: 0,
      boBalance: null,
      boDetails: null,
      winPrint: null,
      isLoading: false,
      activePackage: 0,
      activeCover: 1,
      follow_trade: false,
      auto_renew: false,
      refreshDate: null,
      sec_password: "",
      expired: true,
      link: null,
      showedMsg: false,
      boLink:
        location.origin +
        "/api/bo/login?token=" +
        localStorage.getItem("boostToken"),
    };
  },
  methods: {
    ...mapActions([
      "updateP1",
      "updateP2",
      "updateP3",
      "updateP4",
      "updateIncome",
      "updateTotal",
      "updatePackage",
    ]),
    purchase_insurance() {
      if (this.follow_trade) {
        this.$root.makeToast("danger", this.$t("FOLLOWING_TRADE"));

      } else {
        this.$router.push('/web/insurance/purchaseInsurance');
      }

    },
    upgradePackage() {
      if (this.follow_trade) {
        this.$root.makeToast("danger", this.$t("FOLLOWING_TRADE"));

      } else {
        this.$router.push('/web/upgradePackage')
      }

    },
    openSurrenderModal() {

      if (this.follow_trade) {
        this.$root.makeToast("danger", this.$t("FOLLOWING_TRADE"));

      } else {
        this.$bvModal.show("modal-surrender");
      }

    },
    checkInt(profit) {
      if (profit >= 0) {
        return "+";
      } else {
        return "-";
      }
    },
    checkWithdraw() {
      if (this.member.check_kyc.can_withdraw == "pending") {
        this.$root.makeToast("danger", this.$t("pendingBeforeWithdraw"));
      } else if (this.member.check_kyc.can_withdraw == "failed") {
        this.$root.makeToast("danger", this.$t("submitImageBeforeWithdraw"));
        this.$router.push("/web/me/KYC");
      } else {
        this.$router.push("/web/withdraw");
      }
    },
    surrender() {
      let formData = new FormData();
      formData.append("sec_password", this.sec_password);
      var result = _surrender(formData);
      var self = this;
      self.isLoading = true;
      result
        .then(function (value) {
          if (value.data.code == 0) {
            self.$refs.msg.makeToast("success", self.$t(value.data.message));
            self.memberInfo();
          } else {
            self.$refs.msg.makeToast("danger", self.$t(value.data.message));
          }
          self.isLoading = false;
          self.$bvModal.hide("modal-surrender");
          // self.expired = true;
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          self.isLoading = false;
        });
      self.sec_password = "";
    },
    claiming() {
      let formData = new FormData();
      formData.append("sec_password", this.sec_password);
      var result = claimInsurance(formData);
      var self = this;
      self.isLoading = true;
      result
        .then(function (value) {
          if (value.data.code == 0) {
            self.$refs.msg.makeToast("success", self.$t(value.data.message));
            self.$bvModal.hide("modal-password");
            self.sec_password = "";
            self.memberInfo();
          } else {
            self.$refs.msg.makeToast("danger", self.$t(value.data.message));
          }
          self.isLoading = false;
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          self.isLoading = false;
        });
      self.sec_password = "";
    },
    checkRenew(e) {
      if (this.member.myActivePackage == null) {
        this.$refs.msg.makeToast("warning", this.$t("no_package"));
        this.auto_renew = false;
        this.memberInfo();
        e.preventDefault();
      } else {
        let formData = new FormData();
        formData.append("auto_renew", this.auto_renew ? "1" : "0");
        this.isLoading = true;
        var result = updateMemberInfo(formData);
        var self = this;
        result.then(function (value) {
          if (value.data.code == 0) {
            self.$refs.msg.makeToast("success", self.$t(value.data.message));
          } else {
            self.$refs.msg.makeToast("danger", self.$t(value.data.message));
          }
          self.memberInfo();
          self.isLoading = false;
        });
      }
    },
    cancelFollowAction() {
      this.$bvModal.hide('modal-follow');
      this.follow_trade = !this.follow_trade;
      this.memberInfo();

    },
    comingSoon() {
      this.follow_trade = !this.follow_trade;
      this.memberInfo();
      this.$refs.msg.makeToast("danger", this.$t('coming_soon'));

    },
    checkFollowTrade(e) {
      if (this.member == null) {
        this.follow_trade = !this.follow_trade;
        this.memberInfo();
        e.preventDefault();
        // } else if (this.boDetails == null) {
        //   this.$refs.msg.makeToast("warning", this.$t("no_package"));
        //   this.follow_trade = false;
        //   this.memberInfo();
        //   e.preventDefault();
        //   console.log(this.follow_trade);
        // } else if (this.boDetails.profit >0 && this.follow_trade == true) {
        //   this.$refs.msg.makeToast("warning", this.$t("got_profit_in_bnx"));
        //   this.follow_trade = false;
        //   this.memberInfo();
        //   e.preventDefault();
        //   console.log(this.follow_trade);
      } else {
        let formData = new FormData();
        formData.append("follow_trade", this.follow_trade ? "1" : "0");
        this.isLoading = true;
        var result = updateFollowTrade(formData);
        var self = this;
        result.then(function (value) {
          if (value.data.code == 0) {
            self.$refs.msg.makeToast("success", self.$t(value.data.message));
            self.memberInfo();
          } else {
            self.follow_trade = !self.follow_trade;
            self.$refs.msg.makeToast("danger", self.$t(value.data.message));
          }
          self.isLoading = false;
          self.$bvModal.hide('modal-follow');
        });
      }
    },
    checkInsurance() {
      if (this.follow_trade) {
        this.$root.makeToast("danger", this.$t("FOLLOWING_TRADE"));

      } else {
        if (this.member.todayStatus.pending) {
          this.$refs.msg.makeToast("warning", this.$t("pending"));
        } else {
          if (this.member.todayStatus.cover == 0) {
            this.$refs.msg.makeToast("warning", this.$t("no_package"));
          } else {
            if (this.member.todayStatus.can_claim == 0) {
              this.$refs.msg.makeToast("warning", this.$t("insuranceClaimed"));
            } else {
              this.$bvModal.show("modal-password");
            }
          }
        }
      }
    },
    boLogin() {
      // var winPrint = window;

      const elem = this.$refs.login;
      var result = bo_login();
      var self = this;
      result.then(function (value) {
        var val = value.data;
        const b = document.getElementById("ads");
        b.innerHTML = val;

        let myForm = document.getElementById("depositForm");
        let path = myForm.action;
        let formData = new FormData(myForm);
        const data = {};
        // need to convert it before using not with XMLHttpRequest
        for (let [key, val] of formData.entries()) {
          Object.assign(data, { [key]: val });
        }
        var searchParam = "";
        for (const item in data) {
          var tmp = item + "=" + data[item] + "&";
          searchParam = searchParam + tmp;
        }
        self.link = path + "?" + searchParam;

        console.log(self.link);
        elem.click();

        // document.getElementById("depositForm").submit();

        // // winPrint.open("");
        // document.write(data);
        // window.location = "";

        // setTimeout(() => {
        //   self.boInfo();
        //   // winPrint.close();

        // }, 1000);
      });
    },
    boInfo() {
      var result = bo_info();
      var self = this;
      self.isLoading = true;
      result
        .then(function (value) {
          // console.log(value.data);
          self.memberInfo();
          self.boDetails = value.data.data;
          self.isLoading = false;
          var d = new Date();
          self.refreshDate =
            d.toLocaleDateString() + " " + d.toLocaleTimeString();
        })
        .catch(function () { });
    },
    memberInfo() {
      var result = getMemberInfo();
      var self = this;
      result
        .then(function (value) {
          self.member = value.data.data;
          if (!self.$root.showedMsg) {
            if (self.member.check_kyc.can_withdraw == "failed") {
              self.$root.showedMsg = true;
              self.$root.makeStaticToast(
                "danger",
                self.$t("kycFailure"),
                self.member.check_kyc.failed_reason
              );
            }
          }
          self.updateP1(self.member.point1);
          self.updateP2(self.member.point2);
          self.updateP3(self.member.point3);
          self.updateP4(self.member.point4);
          self.updateIncome(self.member.total_income);
          self.updateTotal(self.member.total_cap);
          self.updatePackage(self.member.package.package_name_en);
          self.activePackage = self.member.activePackage.data.status;
          self.auto_renew = self.member.auto_renew == 1 ? true : false;
          self.follow_trade = self.member.follow_trade == 1 ? true : false;
          if (self.member.active_cover != null) {
            self.activeCover = self.member.active_cover.code;
          }
          var expireDate = self.member.activePackage.data.exp_date;
          var expire = new Date(expireDate);
          if (expire == "Invalid Date") {
            self.expired = true;
          } else {
            var current = new Date();
            self.expired = current < expire;
          }
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    globalInfo() {
      var result = getDownloadLink();
      var self = this;
      result
        .then(function (value) {
          self.dfi_price = value.data.data.system.DFI_PRICE;
        })
        .catch(function () { });
    },
  },
  mounted() {
    window.addEventListener("beforeunload", this.unload);
    this.boLogin();
  },
  created() {
    this.memberInfo();
    this.globalInfo();
    this.boInfo();
  },
};
</script>
<style>
ol {
  padding-inline-start: 20px !important;
}

li {
  font-size: 0.94rem;
}
</style>
<style scoped>
.modal-title {
  margin: auto;
  font-weight: bold;
  color: black !important;
  text-align: center;

}

.nav-btn {
  padding: 10px 14px !important;
  background: linear-gradient(217deg, #fed901, #e5b80b);
  color: white !important;
  border-radius: 14px;
}

.walletBG {
  background-position: 100% 100%;
  background-size: cover;
}
</style>