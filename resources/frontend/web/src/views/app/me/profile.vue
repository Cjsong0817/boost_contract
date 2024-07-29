<template>
  <div
    class="main-content px-0"
    :style="{ backgroundImage: 'url(' + bgImage + ')' }"
    style="
      background-repeat: no-repeat;
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover;
      width: 100%;
      background-position: center;
      overflow-y: scroll;
    "
  >
    <div v-if="memberInfo != ''">
      <div
        class="profile-banner text-white position-relative text-center"
        style="padding: 6vh 0px 6vh 0px"
      >
        <h5 class="">{{ $t("profile") }}</h5>
        <img :src="returnIcon()" alt="" @error="imageLoadError" height="60px" />
        <p class="mb-0 font-weight-bold text-16">
          {{ memberInfo.username }}
        </p>
        <!--<div class="position-absolute w-100 px-3">
        <div class="position-relative w-100">
          <div class="bg-semitrans"></div>
          <b-card
            class="mb-0 text-black px-3 py-2"
            style="background-color: rgba(255, 255, 255, 0.7)"
            no-body
            ><b-row class="mr-0" no-gutters align-v="center">
              <b-col cols="4">
                <p class="mb-1 text-left font-weight-bold text-14">ID</p>
              </b-col>
              <b-col cols="2">
                <p class="mb-1 text-left font-weight-bold text-14">:</p>
              </b-col>
              <b-col cols="6" class="text-right">
                <p class="mb-1 font-weight-bold text-14">
                  {{ userID }}
                </p>
              </b-col>
              <b-col cols="4">
                <p class="mb-1 text-left font-weight-bold text-14">
                  {{ $t("email") }}
                </p>
              </b-col>
              <b-col cols="1">
                <p class="mb-1 text-left font-weight-bold text-14">:</p>
              </b-col>
              <b-col cols="7" class="text-right">
                <p class="mb-1 font-weight-bold text-14">
                  {{ memberInfo.email }}
                </p>
              </b-col>
              <b-col cols="4">
                <p class="mb-1 text-left font-weight-bold text-14">
                  {{ $t("rank") }}
                </p>
              </b-col>
              <b-col cols="2">
                <p class="mb-1 text-left font-weight-bold text-14">:</p>
              </b-col>
              <b-col cols="6" class="text-right">
                <p v-if="memberInfo" class="mb-1 font-weight-bold text-14">
                  {{
                    $i18n.locale == "en"
                      ? memberInfo.rank.rank_name_en
                      : memberInfo.rank.rank_name
                  }}
                </p>
              </b-col>
              <b-col cols="4" v-if="editing">
                <p class="mb-1 font-weight-bold text-14">
                  {{ $t("country") }}
                </p>
              </b-col>
              <b-col cols="6" class="text-right" v-if="editing">
                <b-form-select
                  class="mb-1"
                  v-model="country"
                  :options="countryOptions"
                  id="country"
                >
                </b-form-select>
              </b-col>
              <b-col cols="4">
                <p class="mb-1 text-left font-weight-bold text-14">
                  {{ $t("mobile") }}
                </p>
              </b-col>
              <b-col cols="2">
                <p class="mb-1 text-left font-weight-bold text-14">:</p>
              </b-col>
              <b-col cols="6" class="text-right" v-if="memberInfo">
                <div v-if="editing" class="input-group mb-1">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">
                      {{ phone_code }}
                    </span>
                  </div>
                  <input
                    class="form-control"
                    v-model="phone"
                    type="text"
                    required
                    :readonly="isLoading"
                  />
                </div>
                <p v-else class="mb-1 font-weight-bold text-14">
                  +{{
                    memberInfo.country.phone_code + memberInfo.contact_number
                  }}
                </p>
              </b-col>
              <b-col cols="4">
                <p class="mb-1 text-left font-weight-bold text-14">
                  {{ $t("identity_no") }}
                </p>
              </b-col>
              <b-col cols="2">
                <p class="mb-1 text-left font-weight-bold text-14">:</p>
              </b-col>
              <b-col cols="6" class="text-right" v-if="memberInfo">
                <p
                  v-if="memberInfo.check_kyc.can_withdraw == 'approved'"
                  class="mb-1 font-weight-bold text-14"
                >
                  {{ memberInfo.ic }}
                </p>
                <input
                  v-else-if="editing"
                  class="form-control"
                  v-model="ic"
                  type="text"
                  required
                  :readonly="isLoading"
                />
                <p v-else class="mb-1 font-weight-bold text-14">
                  {{ memberInfo.ic }}
                </p>
              </b-col>
              <b-col cols="4" v-if="lockPeriod">
                <p class="mb-1 text-left font-weight-bold text-14">
                  {{ $t("exp") }}
                </p>
              </b-col>
              <b-col cols="2">
                <p class="mb-1 text-left font-weight-bold text-14">:</p>
              </b-col>
              <b-col cols="6" class="text-right" v-if="lockPeriod">
                <p class="mb-1 font-weight-bold text-14">
                  {{ lockPeriod }}
                </p>
              </b-col>
            </b-row>
          </b-card>
        </div>
      </div>-->
      </div>
      <div class="mx-3" style="transform: translateY(-5vh)">
        <div class="position-relative w-100">
          <div class="bg-semitrans"></div>
          <b-card
            class="mb-0 text-black px-3 py-2"
            style="background-color: rgba(255, 255, 255, 0.7)"
            no-body
            ><b-row class="mr-0" no-gutters align-v="center">
              <b-col cols="4">
                <p class="mb-1 text-left font-weight-bold text-14">ID</p>
              </b-col>
              <b-col cols="2">
                <p class="mb-1 text-left font-weight-bold text-14">:</p>
              </b-col>
              <b-col cols="6" class="text-right">
                <p class="mb-1 font-weight-bold text-14">
                  {{ userID }}
                </p>
              </b-col>
              <b-col cols="4">
                <p class="mb-1 text-left font-weight-bold text-14">
                  {{ $t("email") }}
                </p>
              </b-col>
              <b-col cols="1">
                <p class="mb-1 text-left font-weight-bold text-14">:</p>
              </b-col>
              <b-col cols="7" class="text-right">
                <p class="mb-1 font-weight-bold text-14">
                  {{ memberInfo.email }}
                </p>
              </b-col>
              <b-col cols="4">
                <p class="mb-1 text-left font-weight-bold text-14">
                  {{ $t("rank") }}
                </p>
              </b-col>
              <b-col cols="2">
                <p class="mb-1 text-left font-weight-bold text-14">:</p>
              </b-col>
              <b-col cols="6" class="text-right">
                <p v-if="memberInfo" class="mb-1 font-weight-bold text-14">
                  {{
                    $i18n.locale == "en"
                      ? memberInfo.rank.rank_name_en
                      : memberInfo.rank.rank_name
                  }}
                </p>
              </b-col>
              <b-col cols="4" v-if="editing">
                <p class="mb-1 font-weight-bold text-14">
                  {{ $t("country") }}
                </p>
              </b-col>
              <b-col cols="6" class="text-right" v-if="editing">
                <b-form-select
                  class="mb-1"
                  v-model="country"
                  :options="countryOptions"
                  id="country"
                >
                </b-form-select>
              </b-col>
              <b-col cols="4">
                <p class="mb-1 text-left font-weight-bold text-14">
                  {{ $t("mobile") }}
                </p>
              </b-col>
              <b-col cols="2">
                <p class="mb-1 text-left font-weight-bold text-14">:</p>
              </b-col>
              <b-col cols="6" class="text-right" v-if="memberInfo">
                <div v-if="editing" class="input-group mb-1">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">
                      {{ phone_code }}
                    </span>
                  </div>
                  <input
                    class="form-control"
                    v-model="phone"
                    type="text"
                    required
                    :readonly="isLoading"
                  />
                </div>
                <p v-else class="mb-1 font-weight-bold text-14">
                  +{{
                    memberInfo.country.phone_code + memberInfo.contact_number
                  }}
                </p>
              </b-col>
              <b-col cols="4">
                <p class="mb-1 text-left font-weight-bold text-14">
                  {{ $t("identity_no") }}
                </p>
              </b-col>
              <b-col cols="2">
                <p class="mb-1 text-left font-weight-bold text-14">:</p>
              </b-col>
              <b-col cols="6" class="text-right" v-if="memberInfo">
                <p
                  v-if="memberInfo.check_kyc.can_withdraw == 'approved'"
                  class="mb-1 font-weight-bold text-14"
                >
                  {{ memberInfo.ic }}
                </p>
                <input
                  v-else-if="editing"
                  class="form-control"
                  v-model="ic"
                  type="text"
                  required
                  :readonly="isLoading"
                />
                <p v-else class="mb-1 font-weight-bold text-14">
                  {{ memberInfo.ic }}
                </p>
              </b-col>
              <b-col cols="4" v-if="lockPeriod">
                <p class="mb-1 text-left font-weight-bold text-14">
                  {{ $t("exp") }}
                </p>
              </b-col>
              <b-col cols="2" v-if="lockPeriod">
                <p class="mb-1 text-left font-weight-bold text-14">:</p>
              </b-col>
              <b-col cols="6" class="text-right" v-if="lockPeriod">
                <p class="mb-1 font-weight-bold text-14">
                  {{ lockPeriod }}
                </p>
              </b-col>
            </b-row>
          </b-card>
        </div>
        <h6 class="ml-2 mt-3">{{ $t("settings") }}</h6>
        <!--<b-card
        class="mb-4 bg-semitrans position-relative"
        style="background-color: rgba(255, 255, 255, 0.7)"
      >
        <b-form @submit.prevent="updateInfo">
          <div class="d-flex justify-content-end">
            <b-button
              v-if="editing"
              :disabled="isLoading"
              type="submit"
              variant="primary"
              class="py-1 px-2 mb-2 mr-2"
              >{{ $t("submit") }}</b-button
            >
            <b-button @click="editing = !editing" class="py-1 px-2 mb-2">{{
              editing ? $t("cancel") : $t("edit")
            }}</b-button>
          </div>
          <b-row class="mr-0" no-gutters align-v="center">
            <b-col cols="6">
              <p class="mb-1 font-weight-bold text-14">ID</p>
            </b-col>
            <b-col cols="6" class="text-right">
              <p class="mb-1 font-weight-bold text-14">
                {{ userID }}
              </p>
            </b-col>
            <b-col cols="6">
              <p class="mb-1 font-weight-bold text-14">
                {{ $t("username") }}
              </p>
            </b-col>
            <b-col cols="6" class="text-right">
              <p class="mb-1 font-weight-bold text-14">
                {{ memberInfo.username }}
              </p>
            </b-col>
            <b-col cols="6">
              <p class="mb-1 font-weight-bold text-14">
                {{ $t("full_name") }}
              </p>
            </b-col>
            <b-col cols="6" class="text-right">
              <p class="mb-1 font-weight-bold text-14">
                {{ memberInfo.fullname }}
              </p>
            </b-col>
            <b-col cols="6">
              <p class="mb-1 font-weight-bold text-14">
                {{ $t("email") }}
              </p>
            </b-col>
            <b-col cols="6" class="text-right">
              <p class="mb-1 font-weight-bold text-14">
                {{ memberInfo.email }}
              </p>
            </b-col>
            <b-col cols="6">
              <p class="mb-1 font-weight-bold text-14">
                {{ $t("rank") }}
              </p>
            </b-col>
            <b-col cols="6" class="text-right">
              <p v-if="memberInfo" class="mb-1 font-weight-bold text-14">
                {{
                  $i18n.locale == "en"
                    ? memberInfo.rank.rank_name_en
                    : memberInfo.rank.rank_name
                }}
              </p>
            </b-col>
            <b-col cols="6" v-if="editing">
              <p class="mb-1 font-weight-bold text-14">
                {{ $t("country") }}
              </p>
            </b-col>
            <b-col cols="6" class="text-right" v-if="editing">
              <b-form-select
                class="mb-1"
                v-model="country"
                :options="countryOptions"
                id="country"
              >
              </b-form-select>
            </b-col>
            <b-col cols="6">
              <p class="mb-1 font-weight-bold text-14">
                {{ $t("mobile") }}
              </p>
            </b-col>
            <b-col cols="6" class="text-right" v-if="memberInfo">
              <div v-if="editing" class="input-group mb-1">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1">
                    {{ phone_code }}
                  </span>
                </div>
                <input
                  class="form-control"
                  v-model="phone"
                  type="text"
                  required
                  :readonly="isLoading"
                />
              </div>
              <p v-else class="mb-1 font-weight-bold text-14">
                +{{ memberInfo.country.phone_code + memberInfo.contact_number }}
              </p>
            </b-col>
            <b-col cols="6">
              <p class="mb-1 font-weight-bold text-14">
                {{ $t("identity_no") }}
              </p>
            </b-col>
            <b-col cols="6" class="text-right" v-if="memberInfo">
              <p
                v-if="memberInfo.check_kyc.can_withdraw == 'approved'"
                class="mb-1 font-weight-bold text-14"
              >
                {{ memberInfo.ic }}
              </p>
              <input
                v-else-if="editing"
                class="form-control"
                v-model="ic"
                type="text"
                required
                :readonly="isLoading"
              />
              <p v-else class="mb-1 font-weight-bold text-14">
                {{ memberInfo.ic }}
              </p>
            </b-col>
            <b-col cols="6" v-if="lockPeriod">
              <p class="mb-1 font-weight-bold text-14">
                {{ $t("exp") }}
              </p>
            </b-col>
            <b-col cols="6" class="text-right" v-if="lockPeriod">
              <p class="mb-1 font-weight-bold text-14">
                {{ lockPeriod }}
              </p>
            </b-col>
          </b-row>
        </b-form>
      </b-card>-->
        <div v-if="memberInfo != ''">
          <b-link
            to="/web/me/KYC"
            v-if="memberInfo.check_kyc.can_withdraw == 'failed'"
          >
            <ProfileBox info="kyc"></ProfileBox>
          </b-link>
          <b-link v-else>
            <b-card
              class="px-2 pb-1 bg-gray"
              no-body
              style="margin-bottom: 0.75rem"
            >
              <div class="d-flex align-items-center">
                <div
                  class="text-center text-24"
                  style="margin-right: 10px; width: 40px"
                >
                  <img
                    height="24px"
                    src="../../../assets/images/profile/kyc.svg"
                    alt=""
                  />
                </div>

                <h6 class="mb-0 mx-1 text-12 flex-grow-1">
                  {{ $t("KYC") }}
                </h6>
                <b-badge
                  v-if="memberInfo.check_kyc.can_withdraw == 'pending'"
                  href="#"
                  variant="warning"
                  class="p-1 text-white"
                  >{{ $t("pending") }}</b-badge
                >
                <b-badge
                  v-else
                  href="#"
                  variant="success"
                  class="p-1 text-white"
                  >{{ $t("approved") }}</b-badge
                >
              </div>
            </b-card>
          </b-link>
        </div>

        <b-link @click="goInfo">
          <ProfileBox info="basic_info"></ProfileBox>
        </b-link>
        <b-link to="/web/me/invitation_link">
          <ProfileBox info="invite_link"></ProfileBox>
        </b-link>
        <b-link to="/web/me/news">
          <b-card
            class="px-2 pb-1 bg-gray"
            no-body
            style="margin-bottom: 0.75rem"
          >
            <div class="d-flex align-items-center">
              <div
                class="text-center text-24"
                style="margin-right: 10px; width: 40px"
              >
                <i class="fa fa-newspaper-o"></i>
              </div>

              <h6 class="mb-0 mx-1 text-12 flex-grow-1">
                {{ $t("news") }}
              </h6>
              <i class="fa fa-chevron-right"></i>
            </div>
          </b-card>
        </b-link>
        <b-link to="/web/me/password?type=pwd">
          <ProfileBox info="change_login_pwd"></ProfileBox>
        </b-link>
        <b-link to="/web/me/password?type=sec_pwd">
          <ProfileBox info="reset_sec_password"></ProfileBox>
        </b-link>
        <!--<b-link to="/web/registration">
        <ProfileBox info="register"></ProfileBox>
      </b-link>-->
        <b-link @click="openLanguage()">
          <ProfileBox info="languageSetting"></ProfileBox>
        </b-link>
        <a :href="$i18n.locale == 'en' ? supportEN : supportCN">
          <b-card
            class="px-2 pb-1 bg-gray"
            no-body
            style="margin-bottom: 0.75rem"
          >
            <div class="d-flex align-items-center">
              <div
                class="text-center text-24"
                style="margin-right: 10px; width: 40px"
              >
                <i class="fa fa-question-circle"></i>
              </div>

              <h6 class="mb-0 mx-1 text-12 flex-grow-1">
                {{ $t("support") }}
              </h6>
              <i class="fa fa-chevron-right"></i>
            </div>
          </b-card>
        </a>

        <div class="px-4">
          <b-button
            class="
              mt-4
              mb-5
              btn-square
              d-flex
              justify-content-center
              align-items-center
            "
            @click="logoutUser"
            block
          >
            <span class="text-white mr-2 text-16">
              <i class="fa fa-sign-out"></i>
            </span>
            <h5 class="mb-0">{{ $t("sign_out") }}</h5>
          </b-button>
        </div>
      </div>
    </div>

    <div style="height: 60px"></div>

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

    <b-modal
      id="modal-language"
      size="md"
      centered
      :title="$t('languageSetting')"
      :hide-footer="true"
      class="text-black"
      style="color: #000 !important"
    >
      <b-container class="bv-example-row">
        <b-button @click="changeLang('en')" class="btn-square w-100">
          <div class="text-white font-weight-bold d-flex text-18">
            <i class="header-icon-country"><flag iso="GB" /></i
            ><span class="ml-2">{{ $t("en") }}</span>
          </div>
        </b-button>
        <b-button @click="changeLang('zh')" class="btn-square w-100 mt-2">
          <div class="text-white font-weight-bold d-flex text-18">
            <i class="header-icon-country"><flag iso="CN" /></i
            ><span class="ml-2">{{ $t("zh") }}</span>
          </div>
        </b-button>
      </b-container>
    </b-modal>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import { getMemberInfo } from "../../../system/api/api";
import { handleError } from "../../../system/handleRes";
import Dialog from "../../../components/dialog.vue";
import ProfileBox from "./profileBox.vue";
import { mapGetters, mapActions } from "vuex";
export default {
  computed: {
    ...mapGetters(["lang"]),
  },
  components: {
    Dialog,
    ProfileBox,
  },
  data() {
    return {
      bgImage: require("../../../assets/images/background_black.jpeg"),
      otp: "",
      email: "",
      isLoading: false,
      editing: false,
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
      bind: true,
      memberInfo: "",
      rank: null,
      country: null,
      phone: null,
      phone_code: null,
      countryOptions: [],
      countryList: [],
      ic: null,
      userIcon: require("../../../assets/images/faces/user.png"),
      lockPeriod: null,
      supportEN: localStorage.getItem("SUPPORT_URL_EN"),
      // supportCN: 'https://ibo.greatwallsolution.com'+localStorage.getItem('SUPPORT_QR_CN')
      supportCN:
        location.origin +
        "/upload" +
        localStorage.getItem("SUPPORT_QR_CN") +
        ".jpg",
    };
  },
  watch: {},
  props: ["success"],
  methods: {
    ...mapActions(["signOut", "changeLan"]),
    imageLoadError(event) {
      event.target.src = this.userIcon;
    },
    goInfo() {
      this.$router.push({
        name: "basic_info",
        params: {
          item: this.memberInfo,
        },
      });
    },
    returnIcon() {
      if (this.rank != null) {
        // return location.origin + this.rank.icon;
        return (
          "https://ibo.greatwallsolution.com" + this.rank.icon.toLowerCase()
        );
      }
      return "";
    },

    openLanguage() {
      this.$bvModal.show("modal-language");
    },
    changeLang(lang) {
      console.log(lang);
      this.$i18n.locale = lang;
      this.changeLan(lang);
      this.$bvModal.hide("modal-language");
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
    clipboardSuccessHandler() {
      this.$refs.msg.makeToast("success", this.$t("copied"));
    },
    clipboardErrorHandler() {
      //// console.log('error', value)
    },
    loadItems() {
      var result = getMemberInfo();

      var self = this;
      this.isLoading = true;
      self.inv_link = location.origin + "/register?ref_id=";
      result
        .then(function (value) {
          self.editing = false;
          self.memberInfo = value.data.data;

          self.userID = value.data.data.id;
          self.total_sponsor = value.data.total_sponsor;
          self.point1 = parseFloat(value.data.data.point1).toFixed(0);
          self.point2 = parseFloat(value.data.data.point2).toFixed(0);
          self.ref_code = value.data.data.ref_code;
          self.rank = value.data.data.rank;
          self.phone = value.data.data.contact_number;
          self.phone_code = value.data.data.country.phone_code;
          self.country = value.data.data.country.id;
          self.ic = value.data.data.ic;
          self.lockPeriod = value.data.data.activePackage.data.exp_date;
          // self.wallets = value.data.data.wallet;
          self.isLoading = false;
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
  },
  created() {
    this.loadItems();
    this.email = localStorage.getItem("username");
  },
};
</script>

<style>
.modal-title {
  color: black;
}
.modal-body {
  height: 50vh;
}
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
  background-color: white;
  margin-bottom: 10px;
  border-radius: 10px;
  padding: 8px 10px;
  color: #000;
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
  width: 100%;
  position: absolute;
  left: 0;
  top: 0;
}
i.fa.fa-exclamation-circle {
  color: red;
  font-size: 25px;
  position: absolute;
  right: -10px;
  top: -10px;
  border-radius: 25px;
  background: #000;
}
</style>