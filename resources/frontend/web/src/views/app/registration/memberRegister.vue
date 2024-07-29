<template>
  <div class="main-content">
    <div class="appBar">
      <a @click="$router.go(-1)">
        <i class="fa fa-chevron-left"></i>
      </a>
      <span class="text-14">{{ $t("registerMember") }}</span>
    </div>
    <div class="m-3 mx-4">
      <b-row align-h="center">
        <b-col cols="12">
          <b-form v-on:submit.prevent="register_member">
            <div class="form-group row">
              <label for="username2" class="col-sm-2 col-form-label">{{
                $t("username")
              }}</label>
              <div class="col-sm-10">
                <input
                  type="text"
                  class="form-control"
                  id="username"
                  v-model="username"
                  @keydown="checkKeyDownAlphaNumeric($event)"
                  required
                />
                <b-alert
                  show
                  variant="danger"
                  class="error col mt-1"
                  v-if="!name2Valid"
                  >{{ $t("not_valid") }}</b-alert
                >
              </div>
            </div>
            <!-- <div class="form-group row">
              <label for="point2" class="col-sm-2 col-form-label">{{
                "DSP"
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
            </div>

            <div class="form-group row">
              <label for="point3" class="col-sm-2 col-form-label">{{
                "DRP"
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
            </div> -->

            <!-- <div class="form-group row">
              <label for="payment" class="col-sm-2 col-form-label">{{
                $t("type_of_wallet")
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
              <label for="package" class="col-sm-2 col-form-label">{{
                $t("package")
              }}</label>
              <div class="col-sm-10">
                <b-form-select
                  v-model="packageType"
                  :options="selectOptions"
                  id="package"
                >
                </b-form-select>
              </div>
            </div> -->

            <!-- <div class="form-group row">
              <label for="price" class="col-sm-2 col-form-label">{{
                "Package Price"
              }}</label>
              <div class="col-sm-10">
                <input
                  type="number"
                  class="form-control"
                  id="price"
                  v-model="packagePrice"
                  readonly
                />
              </div>
            </div> -->

            <div class="form-group row">
              <label for="email" class="col-sm-2 col-form-label">{{
                $t("email")
              }}</label>
              <div class="col-sm-10">
                <input
                  type="email"
                  class="form-control"
                  id="email"
                  v-model="email"
                  @keydown="checkKeyDownAlphaNumeric2($event)"
                  required
                />
                <b-alert
                  show
                  variant="danger"
                  class="error col mt-1"
                  v-if="!name3Valid"
                  >{{ $t("email_not_valid") }}</b-alert
                >
              </div>
            </div>
            <div class="form-group row">
              <label for="country" class="col-sm-2 col-form-label">{{
                $t("country")
              }}</label>
              <div class="col-sm-10">
                <b-form-select
                  v-model="country"
                  :options="countryOptions"
                  id="country"
                >
                </b-form-select>
              </div>
            </div>
            <div class="form-group row">
              <label for="package" class="col-sm-2 col-form-label">{{
                $t("phone")
              }}</label>
              <div class="col-sm-10">
                <b-input-group>
                  <b-input-group-prepend class="mb-3">
                    <span class="input-group-text">{{ countryCode }}</span>
                  </b-input-group-prepend>
                  <b-form-input
                    class="form-control mb-3"
                    v-model="contact_number"
                    type="number"
                    :placeholder="$t('phone')"
                    required
                  >
                  </b-form-input>
                </b-input-group>
              </div>
            </div>
            <div class="form-group row">
              <label for="ref_id" class="col-sm-2 col-form-label">{{
                $t("password")
              }}</label>
              <div class="col-sm-10">
                <b-form-input
                  class="form-control"
                  label="Name"
                  type="password"
                  v-model.trim="password"
                  required
                >
                </b-form-input>

                <b-alert
                  show
                  variant="danger"
                  class="error col mt-1"
                  v-if="!$v.password.minLength"
                  >{{ $t("min") }} {{ $v.password.$params.minLength.min }}
                  {{ $t("character") }}</b-alert
                >
              </div>
            </div>
            <div class="form-group row">
              <label for="ref_id" class="col-sm-2 col-form-label">{{
                $t("confirm_password")
              }}</label>
              <div class="col-sm-10">
                <b-form-input
                  class="form-control"
                  label="Name"
                  type="password"
                  v-model.trim="$v.repeatPassword.$model"
                  required
                >
                </b-form-input>

                <b-alert
                  show
                  variant="danger"
                  class="error col mt-1"
                  v-if="!$v.repeatPassword.sameAsPassword"
                  >{{ $t("passwordNotMatch") }}</b-alert
                >
              </div>
            </div>
            <div class="form-group row">
              <label for="ref_id" class="col-sm-2 col-form-label">{{
                $t("sponsor_amount")
              }}</label>
              <div class="col-sm-10">
                <input
                  class="form-control"
                  label="ref_id"
                  v-model="refID"
                  required
                />
              </div>
            </div>
            <!-- <div class="form-group row">
              <label for="placement_id" class="col-sm-2 col-form-label">{{
                $t("placement_id")
              }}</label>
              <div class="col-sm-10">
                <input
                  class="form-control"
                  label="placement_id"
                  v-model="placement_id"
                />
              </div>
            </div>
            <div class="form-group row">
              <label for="placement" class="col-sm-2 col-form-label">{{
                $t("placement")
              }}</label>
              <div class="col-sm-10">
                <b-form-select
                  v-model="placement"
                  :options="placementOptions"
                  id="placement"
                >
                </b-form-select>
              </div>
            </div> -->
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
            <div class="form-group row justify-content-end">
              <div class="col-sm-12">
                <div class="mt-3  float-right w-100">
                  <b-button
                    type="submit"
                    class="m-1 btn-curved"
                    :disabled="!name2Valid || !name3Valid"
                    ><span class="text-white font-weight-bold"
                      >{{ $t("register") }}
                    </span></b-button
                  >
                </div>
              </div>
            </div>
          </b-form>
        </b-col>
      </b-row>
    </div>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import {
  registerMember,
  country_list,
  // getPackage,
  getMemberInfo,
} from "../../../system/api/api";
import Dialog from "../../../components/dialog.vue";
import { handleError } from "../../../system/handleRes";
import { required, sameAs, minLength } from "vuelidate/lib/validators";
import { mapGetters } from "vuex";
export default {
  computed: {
    name2Valid() {
      if (this.username == null) {
        return true;
      } else {
        return /^[ A-Za-z0-9]+$/.test(this.username);
      }
    },
    name3Valid() {
      if (this.email == null) {
        return true;
      } else {
        return /^[ A-Za-z0-9@.]+$/.test(this.email);
      }
    },

    ...mapGetters(["lang"]),
  },
  components: {
    Dialog,
  },
  data() {
    return {
      username: "",
      countryCode: "",
      contact_number: "",
      country_id: "",
      placement_id: "",
      user_group_id: "",
      email: "",
      password: "",
      repeatPassword: "",
      sec_password: "",
      refID: "",
      member: {
        point1: 0,
        point2: 0,
      },
      selectWalletType: "point1",

      isLoading: false,
      packageType: "1",
      packagePrice: 0,
      country: null,
      countryList: [],
      selectList: [],
      countryOptions: [],
      selectOptions: [],
      placement: "A",
      placementOptions: [
        { value: "A", text: "Left" },
        { value: "B", text: "Right" },
      ],
      paymentOptions: [
        { value: "point2", text: "100% DSP" },
        {
          value: "point2&point3",
          text: "50% DSP & 50% DRP",
        },
      ],
      package: [],
    };
  },
  validations: {
    password: {
      required,
      minLength: minLength(5),
    },
    repeatPassword: {
      sameAsPassword: sameAs("password"),
    },
  },
  methods: {
    checkKeyDownAlphaNumeric(event) {
      if (!/^[A-Za-z0-9]+$/.test(event.key)) {
        this.username = "";
        event.preventDefault();
      }
    },
    checkKeyDownAlphaNumeric2(event) {
      if (!/^[A-Za-z0-9@.]+$/.test(event.key)) {
        this.email = "";
        event.preventDefault();
      }
    },
    register_member() {
      // e.preventDefault();
      let formData = new FormData();
      formData.append("username", this.username);
      formData.append("user_group", this.packageType);
      formData.append("country_id", this.country);
      formData.append("email", this.email);
      formData.append("contact_number", this.contact_number);
      formData.append("password", this.password);
      formData.append("password_confirmation", this.repeatPassword);
      formData.append("sec_password", this.sec_password);
      formData.append("ref_id", this.refID);
      // formData.append("jid", this.placement_id);
      // formData.append("group_type", this.placement);
      formData.append("pay_type", "point2");

      var result = registerMember(formData);
      var self = this;
      result
        .then(function (value) {
          console.log(value.data);
          if (value.data.code == 0) {
            self.$refs.msg.makeToast("success", self.$t("register_success"));
            setTimeout(() => {
              self.$router.push("/web/");
            }, 1500);
          } else {
            self.$refs.msg.makeToast("danger", self.$t(value.data.message));
          }
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          // self.makeToast("warning", error.response.statusText+", Please Login Again!");
          //   localStorage.removeItem("boostToken");
          //   self.$router.push("/admin/sessions/signIn");
        });
    },
    // _getPackage() {
    //   var result = getPackage();
    //   var self = this;
    //   this.isLoading = true;
    //   result
    //     .then(function (value) {
    //       self.selectList = value.data.data;
    //       self.packageType = value.data.data[0].id;
    //       for (let i = 0; i < value.data.data.length; i++) {
    //         var jsonObject = {};
    //         jsonObject["value"] = value.data.data[i].id;
    //         jsonObject["text"] =
    //           self.$i18n.locale == "en"
    //             ? value.data.data[i].package_name_en
    //             : value.data.data[i].package_name;
    //         self.selectOptions.push(jsonObject);
    //       }
    //     })
    //     .catch(function (error) {
    //       self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
    //     });
    // },
    memberInfo() {
      var result = getMemberInfo();
      var self = this;
      result
        .then(function (value) {
          self.member = value.data;
          self.refID = value.data.username;
        })
        .catch(function () {});
    },

    updateCode(id) {
      this.countryList.forEach((item) => {
        if (id == item.id) {
          this.countryCode = item.country_code;
        }
      });
    },
    getCountryList() {
      this.username = null;
      this.email = null;
      var result = country_list();
      var self = this;
      self.countryOptions = [];
      this.isLoading = true;
      result
        .then(function (value) {
          self.countryList = value.data.data;
          self.country = value.data.data[0].id;
          self.countryCode = value.data.data[0].country_code;
          for (let i = 0; i < value.data.data.length; i++) {
            var jsonObject = {};
            jsonObject["value"] = value.data.data[i].id;
            jsonObject["text"] =
              self.$i18n.locale == "en"
                ? value.data.data[i].name_en
                : value.data.data[i].name;
            self.countryOptions.push(jsonObject);
          }
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          // localStorage.removeItem("boostToken");
          // self.$router.push("/admin/sessions/signIn");
          // self.isLoading = false;
        });
    },
  },
  watch: {
    lang(val) {
      console.log(val);
      var self = this;
      self.countryOptions = [];
      for (let i = 0; i < self.countryList.length; i++) {
        var jsonContry = {};
        jsonContry["value"] = self.countryList[i].id;
        jsonContry["text"] =
          val == "en" ? self.countryList[i].name_en : self.countryList[i].name;
        self.countryOptions.push(jsonContry);
      }

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
    // packageType() {
    //   this.selectList.forEach((item) => {
    //     if (this.packageType == item.id) {
    //       this.packagePrice = item.price;
    //     }
    //   });
    // },
    country: "updateCode",
  },
  created() {
    if (this.$route.query.jid) {
      this.placement_id = this.$route.query.jid;
    }

    if (this.$route.query.group_type == "B") {
      this.placement = this.$route.query.group_type;
    }
    console.log(this.placement);

    this.getCountryList();
    // this._getPackage();
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