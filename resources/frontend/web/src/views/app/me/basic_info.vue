<template>
  <div class="main-content">
    <div class="appBar">
      <a @click="$router.go(-1)">
        <i class="fa fa-chevron-left"></i>
      </a>
      <span>{{ $t("basic_info") }}</span>
    </div>
    <div
      class="mainpage m-1 px-2"
      style="
        min-height: 90vh;
        padding-bottom: 15vh !important;
        position: relative;
      "
    >
      <b-card
        class="px-2 pb-1 mt-4 bg-gray"
        no-body
        style="margin-bottom: 1rem"
        @click="openModal('phone')"
      >
        <div class="d-flex align-items-center">
          <h6 class="py-2 px-2 mb-0 mx-1 text-16 flex-grow-1">
            {{ $t("update_phone") }}
          </h6>
          <div class="text-primary">
            <i class="fa fa-chevron-right"></i>
          </div>
        </div>
      </b-card>
      <b-card
        class="px-2 pb-1 bg-gray"
        no-body
        style="margin-bottom: 1rem"
        @click="openModal('ic')"
      >
        <div class="d-flex align-items-center">
          <h6 class="py-2 px-2 mb-0 mx-1 text-16 flex-grow-1">
            {{ $t("update_ic") }}
          </h6>
          <div class="text-primary">
            <i class="fa fa-chevron-right"></i>
          </div>
        </div>
      </b-card>
      <b-modal
        id="modal-info"
        size="md"
        centered
        :title="$t(name)"
        :hide-footer="true"
        class="text-black"
        style="color: #000 !important"
      >
        <b-form @submit.prevent="updateInfo" class="d-flex flex-column">
          <b-row v-if="name == 'update_phone'">
            <b-col cols="4" class="mb-2">
              <p class="mb-1 font-weight-bold text-14">
                {{ $t("country") }}
              </p>
            </b-col>
            <b-col cols="8" class="text-right mb-2">
              <b-form-select
                class="mb-1"
                v-model="country"
                :options="countryOptions"
                id="country"
              >
              </b-form-select>
            </b-col>
            <b-col cols="4" class="mb-2">
              <p class="mb-1 font-weight-bold text-14">
                {{ $t("mobile") }}
              </p>
            </b-col>
            <b-col cols="8" class="text-right mb-2">
              <div class="input-group mb-1">
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
            </b-col>
          </b-row>
          <b-row v-if="name == 'update_ic'">
            <b-col cols="4" class="mb-2">
              <p class="mb-0 font-weight-bold text-14">
                {{ $t("identity_no") }}
              </p>
            </b-col>
            <b-col cols="8" class="text-right mb-2">
              <input
                class="form-control"
                v-model="ic"
                type="text"
                required
                :readonly="isLoading"
              />
            </b-col>
          </b-row>
          <div class="flex-grow-1"></div>
          <div class="mt-4 float-right w-100">
            <b-button type="submit" class="btn-curved" :disabled="isLoading" block>
              <span class="font-weight-bold text-white">
                {{ isLoading ? $t("loading...") : $t("submit") }}
              </span></b-button
            >
          </div>
        </b-form>
      </b-modal>
    </div>
    <Dialog ref="msg"></Dialog>
  </div>
</template>
  
  <script>
import Dialog from "../../../components/dialog.vue";
import { mapGetters } from "vuex";
import {
  country_list,
  getMemberInfo,
  updateMemberInfo,
} from "../../../system/api/api";
import { handleError } from "../../../system/handleRes";
export default {
  props: ["item"],
  computed: {
    ...mapGetters(["lang"]),
  },
  watch: {
    country: "updateCode",
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
    },
  },
  components: {
    Dialog,
  },
  data() {
    return {
      isLoading: true,
      email: "",
      userID: 0,
      memberInfo: "",
      country: null,
      phone: null,
      phone_code: null,
      countryOptions: [],
      countryList: [],
      ic: null,
      name: "",
    };
  },
  methods: {
    openModal(type) {
      switch (type) {
        case "phone":
          this.name = "update_phone";
          this.$bvModal.show("modal-info");

          break;
        case "ic":
          this.name = "update_ic";
          this.$bvModal.show("modal-info");

          break;

        default:
          break;
      }
    },
    updateCode(id) {
      this.countryList.forEach((item) => {
        if (id == item.id) {
          this.phone_code = item.country_code;
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
          self.isLoading = false;
          self.countryList = value.data.data;
          // self.country = value.data.data[0].id;
          // self.phone_code = value.data.data[0].country_code;
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
    updateInfo() {
      let formData = new FormData();
      formData.append("auto_renew", this.memberInfo.auto_renew);
      formData.append("country_id", this.country);
      formData.append("contact_number", this.phone);
      formData.append("ic", this.ic);
      var result = updateMemberInfo(formData);

      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          if (value.data.code == 0) {
            self.$refs.msg.makeToast("success", self.$t(value.data.message));
            self.loadItems();
          self.$bvModal.hide("modal-info");
          } else {
            self.$refs.msg.makeToast("danger", self.$t(value.data.message));
          }
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
    loadItems() {
      var result = getMemberInfo();

      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          self.memberInfo = value.data.data;
          self.phone = value.data.data.contact_number;
          self.phone_code = value.data.data.country.phone_code;
          self.country = value.data.data.country.id;
          self.ic = value.data.data.ic;
          // self.wallets = value.data.data.wallet;
          self.isLoading = false;
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
  },
  created() {
    try {
      this.memberInfo = this.item;
      this.phone = this.item.contact_number;
      this.phone_code = this.item.country.phone_code;
      this.country = this.item.country.id;
      this.ic = this.item.ic;
    } catch (error) {
      this.loadItems();
    }
    this.getCountryList();

    if(this.phone == 'undefined'){
      this.phone = "";

    }
  },
};
</script>

<style>
.modal-body {
  height: auto;
}
.modal-title {
  color: black;
}
</style>