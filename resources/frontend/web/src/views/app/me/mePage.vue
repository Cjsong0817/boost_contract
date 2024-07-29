<template>
  <div class="main-content">
    <div class="banner-image2">
      <b-row class="mx-0 mt-4">
        <b-col cols="7" class="px-0">
          <b-row class="ml-4 mr-0">
            <img src="../../../assets/images/boost/profile.png" height="50" />
            <b-col class="px-1">
              <p class="my-0 font-weight-bold text-14 text-white">
                {{ userID }}
                <button
                  class="my-auto mx-2"
                  type="button"
                  v-clipboard="() => inv_link + ref_code"
                  v-clipboard:success="clipboardSuccessHandler"
                  v-clipboard:error="clipboardErrorHandler"
                  >
                  <span>{{ $t("copy") }}</span>
                </button>
              </p>
              <p class="my-0 font-weight-bold text-10 text-white">
                {{ $t("invi_code") }} {{ ref_code }}
              </p>
              <span class="mt-4 font-weight-bold text-10" style="color: white">
                {{ $t("member") }} {{ total_sponsor }}</span
              >
            </b-col>
          </b-row>
        </b-col>
        <b-col class="pl-0 pr-4">
          <img
            src="../../../assets/images/boost/banner_tr.png"
            height="auto"
            width="100%"
          />
        </b-col>
      </b-row>
      <div class="wallet-box mx-auto mt-4 py-1">
        <b-row align-h="center" class="mt-2 mx-0 px-4">
          <b-col cols="7" class="px-0">
            <div class="p-1">
              <span class="mt-4 font-weight-bold text-14 text-black">
                {{ $t("balance") }} (SGD)</span
              >
            </div>
          </b-col>
          <b-col cols="5" class="px-0">
            <div class="label-box p-1">
              <span class="text-black pl-1">{{ point1 }}</span>
            </div>
          </b-col>
        </b-row>
        <b-row align-h="center" class="mt-1 mx-0 px-4">
          <b-col cols="7" class="px-0">
            <div class="p-1">
              <span class="mt-4 font-weight-bold text-14 text-black">
                {{ $t("account_freeze_amount") }} (SGD)</span
              ><br />
            </div>
          </b-col>
          <b-col cols="5" class="px-0">
            <div class="label-box p-1">
              <span class="text-black pl-1">{{ point2 }}</span>
            </div>
          </b-col>
        </b-row>
        <div class="my-3 mx-1" style="border-top: 1px solid #000"></div>
        <b-row class="px-4">
          <b-col cols="3" class="px-0">
            <b-link to="/web/myWallet/walletRecord">
              <div class="imgBox mx-auto">
                <img
                  class=""
                  src="../../../assets/images/boost/recordd.png"
                  alt=""
                />
              </div>
              <div class="text-center font-weight-bold text-12">
                {{ $t("record") }}
              </div>
            </b-link>
          </b-col>
          <b-col cols="3" class="px-0">
            <div class="imgBox mx-auto" @click="checkApproval">
              <img class="" src="../../../assets/images/boost/in.png" alt="" />
            </div>
            <div class="text-center font-weight-bold text-12">
              {{ $t("topup") }}
            </div>
          </b-col>
          <b-col cols="3" class="px-0">
            <b-link to="/web/withdraw/withdraw">
              <div class="imgBox mx-auto">
                <img
                  class=""
                  src="../../../assets/images/boost/out.png"
                  alt=""
                />
              </div>
              <div class="text-center font-weight-bold text-12">
                {{ $t("withdraw") }}
              </div>
            </b-link>
          </b-col>
          <b-col cols="3" class="px-0">
            <b-link to="/web/me/faq">
              <div class="imgBox mx-auto">
                <i class="fa fa-exclamation-circle" v-if="show==true"></i>
                <img
                  class=""
                  src="../../../assets/images/boost/faq.png"
                  alt=""
                />
              </div>
              <div class="text-center font-weight-bold text-12">
                {{ $t("faq") }}
              </div>
            </b-link>
          </b-col>
        </b-row>
      </div>

      <div style="padding: 5px 20px">
        <!-- <b-card style="margin-bottom:10px;background: linear-gradient(to bottom, #FEBEC1, #D329E6)!important;">
            <b-row align-h="between" align-v="center">
                <b-row align-h="start" align-v="center" class="m-0" style="width:100%;padding:0 10px 0 10px">
                    
                    <div
                    class="text-center"
                    style="width: 25px; height: 25px;margin-right:10px;background: white;border-radius:4px;padding:2px"
                    >
                    <img src="../../../assets/images/me_wallet.png"/>
                    </div>
                    
                    <h6 class="text-muted mb-0 mx-1 text-12" style="color:white!important">
                       {{ $t('account_details') }}
                    </h6>
                    <i class="fa fa-chevron-right" style="right: 20px;position: absolute;color:white"></i>
                  
                   
                </b-row>
            </b-row>
        </b-card>
        <b-card style="margin-bottom:10px;background: linear-gradient(to bottom, #FEBEC1, #D329E6)!important;">
            <b-row align-h="between" align-v="center">
                <b-row align-h="start" align-v="center" class="m-0" style="width:100%;padding:0 10px 0 10px">
                    
                    <div
                    class="text-center"
                    style="width: 25px; height: 25px;margin-right:10px;background: white;border-radius:4px;padding:2px"
                    >
                    <img src="../../../assets/images/me_wallet.png"/>
                    </div>
                    
                    <h6 class="text-muted mb-0 mx-1 text-12" style="color:white!important">
                       {{ $t('account_details') }}
                    </h6>
                    <i class="fa fa-chevron-right" style="right: 20px;position: absolute;color:white"></i>
                  
                   
                </b-row>
            </b-row>
        </b-card> -->
          <div class="list-box"  @click="checkBank">
            <b-row align-h="start" align-v="center" class="m-0">
              <div
                class="text-center"
                style="
                  margin-right: 10px;
                  background: white;
                  border-radius: 4px;
                  padding: 8px;
                  width: 40px;

                "
              >
                <img
                  src="../../../assets/images/boost/deposit.png"
                  height="25px"
                />
              </div>

              <h6
                class="text-muted mb-0 mx-1 text-12"
                style="color: white !important"
              >
                {{ $t("bind_bank") }}
              </h6>
              
              <i
                class="fa fa-check"
                style="right: 30px; position: absolute; color: lightgreen;"
                v-if="bind==false"
              >{{$t('bound')}}</i>
              <i
                class="fa fa-times"
                style="right: 30px; position: absolute; color: white"
                v-if="bind==true"
              >{{$t('unbound')}}</i>
            </b-row>
          </div>
        <b-link to="/web/myTeam">
          <div class="list-box">
            <b-row align-h="start" align-v="center" class="m-0">
              <div
                class="text-center"
                style="
                  margin-right: 10px;
                  background: white;
                  border-radius: 4px;
                  padding: 8px;
                  width: 40px;
                "
              >
                <img
                  src="../../../assets/images/boost/setting.png"
                  height="25px"
                />
              </div>

              <h6
                class="text-muted mb-0 mx-1 text-12"
                style="color: white !important"
              >
                {{ $t("my_team") }}
              </h6>
              <i
                class="fa fa-chevron-right"
                style="right: 30px; position: absolute; color: white"
              ></i>
            </b-row>
          </div>
        </b-link>
        <b-link to="/web/settings/settingCenter">
          <div class="list-box">
            <b-row align-h="start" align-v="center" class="m-0">
              <div
                class="text-center"
                style="
                  margin-right: 10px;
                  background: white;
                  border-radius: 4px;
                  padding: 8px;
                  width: 40px;
                "
              >
                <img
                  src="../../../assets/images/boost/setting.png"
                  height="25px"
                />
              </div>

              <h6
                class="text-muted mb-0 mx-1 text-12"
                style="color: white !important"
              >
                {{ $t("settings") }}
              </h6>
              <i
                class="fa fa-chevron-right"
                style="right: 30px; position: absolute; color: white"
              ></i>
            </b-row>
          </div>
        </b-link>

        <div class="list-box" @click="openRecord">
          <b-row align-h="start" align-v="center" class="m-0">
            <div
              class="text-center"
              style="
                margin-right: 10px;
                background: white;
                border-radius: 4px;
                padding: 8px;
                width: 40px;
              "
            >
              <img src="../../../assets/images/boost/bonus.png" height="25px" />
            </div>

            <h6
              class="text-muted mb-0 mx-1 text-12"
              style="color: white !important"
            >
              {{ $t("bonus_record") }}
            </h6>
            <i
              class="fa fa-chevron-right"
              style="right: 30px; position: absolute; color: white"
            ></i>
          </b-row>
        </div>

        <div class="list-box" style="margin-bottom: 100px" @click="openOtp()">
          <b-row align-h="start" align-v="center" class="m-0">
            <div
              class="text-center"
              style="
                margin-right: 10px;
                background: white;
                border-radius: 4px;
                padding: 8px;
                width: 40px;
              "
            >
              <img
                src="../../../assets/images/boost/logout.png"
                height="25px"
              />
            </div>

            <h6
              class="text-muted mb-0 mx-1 text-12"
              style="color: white !important"
            >
              {{ $t("sign_out") }}
            </h6>
            <i
              class="fa fa-chevron-right"
              style="right: 30px; position: absolute; color: white"
            ></i>
          </b-row>
        </div>
      </div>
    </div>

    <b-modal
      id="modal-logout"
      size="md"
      centered
      :title="$t('sign_out')"
      :hide-footer="true"
      style="background-color: #5f646e !important"
      :no-close-on-backdrop="true"
      :no-close-on-esc="true"
    >
      <b-form class="mx-5" @submit.prevent="logoutUser">
        <b-row align-h="center">
          <b-col md="12 mb-30">
            <b-row align-h="center" style="margin-bottom: 10px">
              <div class="form-group">
                <div class="col-sm-12">
                  <div class="mt-4 float-left">
                    <b-button
                      type="submit"
                      class="m-1"
                      variant="outline-secondary"
                      style="
                        background: linear-gradient(
                          to bottom,
                          #febec1,
                          #d329e6
                        ) !important;
                      "
                      >{{ $t("sign_out") }}</b-button
                    >
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-12">
                  <div class="mt-4 float-right">
                    <b-button
                      class="m-1"
                      variant="outline-secondary"
                      style="border: 2px solid #febec1; border-radius: 10px"
                      @click="close()"
                      >{{ $t("cancel") }}</b-button
                    >
                  </div>
                </div>
              </div>
            </b-row>
          </b-col>
        </b-row>
      </b-form>
    </b-modal>
    <b-modal
      id="modal-pending"
      size="md"
      centered
      :hide-footer="true"
      style="background-color: #5f646e !important"
    >
      <b-form class="mx-5">
        <b-row align-h="center">
          <b-col md="12 mb-30">
            <b-row align-h="center" style="margin-bottom: 10px">
              <!-- <div class="form-group">
                   <i class="fa fa-clock-o" style="font-size:100px;color:purple"></i>
              </div> -->
              <div class="spinner spinner-primary m-2 text-50"></div>
              <div class="col-sm-12">
                <center>
                  <b-button
                    class="mx-auto submit_button mt-5"
                    variant="outline-secondary"
                    @click="close()"
                    >{{ $t("close") }}</b-button
                  >
                </center>
              </div>
            </b-row>
          </b-col>
        </b-row>
      </b-form>
    </b-modal>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import { getMemberInfo, checkAllowDeposit, getTicket,getBankInfo } from "../../../system/api/api";
import { handleError } from "../../../system/handleRes";
import Dialog from "../../../components/dialog.vue";
import { mapGetters, mapActions } from "vuex";
export default {
  computed: {
    ...mapGetters(["lang"]),
  },
  components: {
    Dialog,
  },
  data() {
    return {
      otp: "",
      email: "",
      isLoading: false,
      userID: 0,
      total_sponsor: "",
      point1: 0,
      point2: 0,
      ref_code: "",
      approval: "",
      dataList: [],
      notic: [],
      show: false,
      inv_link: "",
      bind:true,
    };
  },
  props: ["success"],
  methods: {
    ...mapActions(["signOut"]),
    checkApproval() {
      if (this.approval == 2 || this.approval == 3) {
        this.$router.push("/web/requestDeposit");
      } else if (this.approval == 1) {
        this.$router.push("/web/deposit");
      } else if (this.approval == 0) {
        this.$bvModal.show("modal-pending");
        this.getSpin();
      }
    },
    checkBank() {
      var self = this;
      if (self.bind == true) {
        this.$router.push("/web/withdraw/setBank");
      } else {
        self.bind=false;
      } 
    },
    getSpin() {
      var result = checkAllowDeposit();
      var self = this;
      // self.isLoading = true;

      result
        .then(function (value) {
          self.approval = value.data.data.approval;
          if (self.approval == 0) {
            setTimeout(() => {
              self.getSpin();
            }, 3000);
          } else {
            self.$router.push("/web/deposit");
          }

          console.log(value);
        })
        .catch(function (error) {
          console.log(error);
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          self.isLoading = false;
        });
    },
    openOtp() {
      this.$bvModal.show("modal-logout");
    },
    close() {
      this.$bvModal.hide("modal-logout");
    },
    logoutUser() {
      this.signOut();

      this.$router.push("/web/sessions/signIn");
    },
    openRecord() {
      this.$router.push("/web/bonus/bonusCenter");
    },
    clipboardSuccessHandler() {
      this.$refs.msg.makeToast("success", this.$t("copied"));
    },
    clipboardErrorHandler() {
      //// console.log('error', value)
    },
    getInfo() {
      var result = checkAllowDeposit();
      var self = this;
      // self.isLoading = true;

      result
        .then(function (value) {
          self.approval = value.data.data.approval;
          console.log(value);
        })
        .catch(function (error) {
          console.log(error);
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          self.isLoading = false;
        });
    },
    getBankInfo() {
      var result = getBankInfo();
      var self = this;
      // self.isLoading = true;

      result.then(function (value) {
          console.log(value.data)
          if (value.data.data != null) {
              self.bind = false;
          } else {
             self.bind = true;
          }
      }).catch(function (error) {
          console.log(error);
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          self.isLoading = false;
        });
    },
    Notic() {
      var result = getTicket();
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          var dataList = value.data.data.ticket;
          for (let i = 0; i < dataList.length; i++) {
            console.log(dataList[i]);
            self.dataList.push(dataList[i].user_read);
           
           
          }
          self.showNotic();
          self.isLoading = false;
        })
        .catch(function (error) {
          console.log(error);
          self.isLoading = false;
        });
    },
    showNotic(){
      this.notic = this.dataList.includes(0);

      if(this.notic==true){
        this.show = true;
      }
    },
    loadItems() {
      var result = getMemberInfo();

      var self = this;
      this.isLoading = true;
      self.inv_link = location.origin + "/register?ref_id=";
      result
        .then(function (value) {
          console.log(value);
          self.userID = value.data.id;
          self.total_sponsor = value.data.total_sponsor;
          self.point1 = parseFloat(value.data.point1).toFixed(0);
          self.point2 = parseFloat(value.data.point2).toFixed(0);
          self.ref_code = value.data.ref_code;
          // self.wallets = value.data.data.wallet;
          self.isLoading = false;
          self.getBankInfo();
          self.Notic();
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
  },
  created() {
    this.getInfo();
    this.loadItems();
    this.email = localStorage.getItem("username");
  },
};
</script>

<style>
.imgBox {
  background: rgb(113, 33, 179);
  border-radius: 10px;
  padding: 4px;
  height: 40px;
  width: 40px;
  position: relative;
}

.imgBox img {
  padding: 8px;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

.list-box {
  margin-bottom: 10px;
  background: linear-gradient(to bottom, #910ee4, #bf28e1) !important;
  border-radius: 10px;
  padding: 8px 10px;
}
.label-box {
  background: rgb(201, 135, 243);
  border-radius: 5px;
  width: 100%;
  color: white;
}

.wallet-box {
  background: white;
  border-radius: 15px;
  position: relative;
  margin-bottom: 20px;
  width: 90%;
  box-shadow: 0px 5px 6px rgb(201, 135, 243);
}
.hiddenClass {
  pointer-events: none;
  display: none;
}

.overlay-text {
  position: absolute;
  z-index: 2;
  height: 100%;
  width: 100%;
  color: #000;
  font-weight: 700;
  line-height: 1.5;
}

.form-custom-append {
  height: calc(2.5rem + 2px);
}

.form-custom-prepend {
  background-color: transparent !important;
  height: calc(2.5rem + 2px) !important;
}
h5#modal-logout___BV_modal_title_ {
  margin: auto;
}
button.close {
  display: none;
}
.banner-image2 {
  background-image: url("../../../assets/images/purple_banner.png");
  background-size: 100% 100%;
  height: 30vh;
  background-repeat: no-repeat;
  padding-top: 25px;
  color: black;
  width: 100%;
  position: absolute;
  left: 0;
  top: 0;
}
i.fa.fa-exclamation-circle{
    color: red;
    font-size: 25px;
    position: absolute;
    right: -10px;
    top: -10px;
    border-radius: 25px;
    background: #000;
}
</style>