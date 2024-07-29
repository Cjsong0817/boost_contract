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
    <b-form @submit.prevent="doWithdraw">
      <h5 style="color: red; font-weight: bold">{{ $t("important_notes") }}</h5>
      <p
        style="color: red; font-weight: bold; margin: 0px 0px 10px 0px"
        @click="warning"
      >
        {{ $t("click_rules") }}
      </p>

      <p class="mb-0">{{ $t("withdrawAmount") }} (SGD)</p>
      <!-- <span class="label px-1">{{ $t("withdrawRate") }} 1.5%</span> -->

      <b-form-group class="form-custom mt-2 p-0 mb-1">
        <b-form-input
          class="custom-input text-left"
          v-model="amount"
          type="number"
          :placeholder="$t('withdrawHint')"
          @change="updateAmount"
          @input="updateAmount"
          step="any"
          min="10"
          required
        >
        </b-form-input>
      </b-form-group>

      <b-row align-h="between" class="mb-1">
        <b-col>
          <span>{{ $t("amount") }}: {{ this.totalAmount }}</span>
        </b-col>
        <b-col class="text-right">
          <a target="_blank" rel="noopener noreferrer" @click="inputAll">{{
            $t("withdrawAll")
          }}</a>
        </b-col>
      </b-row>

      <b-form-group :label="$t('bank_country')" class="form-customize mt-3">
        <b-form-select v-model="country" :options="countryOptions" id="country">
        </b-form-select>
      </b-form-group>

      <b-form-group :label="$t('bank_name')" class="form-customize mt-3">
        <b-input-group>
          <b-form-input
            class="form-control form-custom"
            v-model="bank_name"
            type="text"
            readonly
          >
          </b-form-input>
        </b-input-group>
      </b-form-group>

      <b-form-group :label="$t('bank_user')" class="form-customize mt-3">
        <b-input-group>
          <b-form-input
            class="form-control form-custom"
            v-model="bank_user"
            type="text"
            readonly
          >
          </b-form-input>
        </b-input-group>
      </b-form-group>

      <b-form-group :label="$t('bank_number')" class="form-customize mt-3">
        <b-input-group>
          <b-form-input
            class="form-control form-custom"
            v-model="bank_number"
            type="number"
            readonly
          >
          </b-form-input>
          <!-- <b-input-group-append class="form-custom-append">
            <button
              class="my-auto mx-2"
              type="button"
              @click="$router.push('/web/withdraw/setBank')"
            >
              <span>{{ $t("change") }}</span>
            </button>
          </b-input-group-append> -->
        </b-input-group>
      </b-form-group>

      <b-form-group :label="$t('branch')" class="form-customize mt-3">
        <b-input-group>
          <b-form-input
            class="form-control form-custom"
            v-model="branch"
            type="text"
            readonly
          >
          </b-form-input>
        </b-input-group>
      </b-form-group>

      <b-form-group
        :label="$t('fees') + ' % (SGD)'"
        class="form-customize mt-3"
      >
        <b-input-group>
          <b-form-input
            class="form-control form-custom"
            v-model="fee"
            type="number"
            readonly
          >
          </b-form-input>
        </b-input-group>
      </b-form-group>

      <b-form-group
        :label="$t('get_amount') + ' (SGD)'"
        class="form-customize mt-3"
      >
        <b-input-group>
          <b-form-input
            class="form-control form-custom"
            v-model="confirm_amount"
            type="number"
            readonly
          >
          </b-form-input>
        </b-input-group>
      </b-form-group>

      <!-- <b-form-group
        :label="$t('get_amount') + ' (' + pSymbol + ')'"
        class="form-customize mt-3"
      >
        <b-input-group>
          <b-form-input
            class="form-control form-custom"
            v-model="convert_amount"
            type="number"
            readonly
          >
          </b-form-input>
        </b-input-group>
      </b-form-group> -->

      <b-form-group :label="$t('sec_password')" class="form-customize mt-3">
        <b-input-group>
          <b-form-input
            class="form-control form-custom"
            :placeholder="$t('assetPwdHint')"
            type="password"
            v-model="sec_pwd"
            required
          >
          </b-form-input>
        </b-input-group>
      </b-form-group>

      <b-button
        :disabled="isLoading"
        class="mx-auto submit_button my-5"
        variant="outline-secondary"
        type="submit"
        >{{ isLoading ? $t("loading...") : $t("withdraw") }}</b-button
      >
    </b-form>
    <b-modal
      id="modal-warning"
      size="md"
      centered
      :title="$t('withdrawal_rules')"
      :hide-footer="true"
      style="background-color: #5f646e !important"
    >
      <b-form>
        <b-row align-h="center">
          <b-col md="12 mb-30">
            <div class="form-group">
              <div class="col-sm-12">
                <p>
                  {{ $t("withdrawal_rules1") }}
                </p>
                <p>
                  {{ $t("withdrawal_rules2") }}
                </p>
                <p>
                  {{ $t("withdrawal_rules3") }}
                </p>
                <p>
                  {{ $t("withdrawal_rules4") }}
                </p>
                <p>
                  {{ $t("withdrawal_rules5") }}
                </p>
                <p>
                  {{ $t("withdrawal_rules6") }}
                </p>
                <p>
                  {{ $t("withdrawal_rules7") }}
                </p>
                <p>
                  {{ $t("withdrawal_rules8") }}
                </p>
              </div>
              <div class="col-sm-12">
                <center>
                  <b-button
                    :disabled="isLoading"
                    class="mx-auto submit_button mt-5"
                    variant="outline-secondary"
                    @click="close()"
                    >{{ $t("close") }}</b-button
                  >
                </center>
              </div>
            </div>
          </b-col>
        </b-row>
      </b-form>
    </b-modal>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import {
  withdrawCash,
  country_list,
  getBankInfo,
} from "../../../system/api/api";
import { handleError } from "../../../system/handleRes";
import Dialog from "../../../components/dialog.vue";
import { mapGetters } from "vuex";
export default {
  props: ["fee", "totalAmount", "canWithdraw", "startLoading"],
  computed: {
    ...mapGetters(["lang"]),
  },
  components: {
    Dialog,
  },
  data() {
    return {
      bank_name: "",
      bank_user: "",
      bank_number: "",
      branch: "",
      amount: 0,
      confirm_amount: 0,
      convert_amount: 0,
      bankRate: 0,
      sec_pwd: "",
      selected: 0,
      isLoading: false,
      country: null,
      pSymbol: "",
      countryOptions: [],
      rows: [],
    };
  },
  methods: {
    warning() {
      this.$bvModal.show("modal-warning");
    },
    close() {
      this.$bvModal.hide("modal-warning");
    },
    getCountryList() {
      var result = country_list();
      var self = this;
      self.countryOptions = [];
      this.isLoading = true;
      result
        .then(function (value) {
          console.log(value.data);
          self.country = value.data.data[0].id;
          self.bankRate = value.data.data[0].buy;
          self.pSymbol = value.data.data[0].short_form;
          for (let i = 0; i < value.data.data.length; i++) {
            if (value.data.data[i].id == 4) {
              self.country = value.data.data[i].id;
              var jsonObject = {};
              jsonObject["value"] = value.data.data[i].id;
              jsonObject["text"] =
                self.$i18n.locale == "en"
                  ? value.data.data[i].name_en
                  : value.data.data[i].name;
              self.countryOptions.push(jsonObject);
              self.rows = value.data.data;
            }
          }
          self.isLoading = false;
        })
        .catch(function (error) {
          self.isLoading = false;
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
    updateAmount() {
      this.confirm_amount = this.amount - (this.amount * this.fee) / 100;
      if (this.confirm_amount < 0) {
        this.confirm_amount = 0;
      }
      this.changeRate();
    },
    inputAll() {
      this.amount = this.totalAmount;
      this.confirm_amount = this.amount - (this.amount * this.fee) / 100;
      this.changeRate();
    },
    changeRate() {
      var price = this.confirm_amount * this.bankRate;
      this.convert_amount = price.toString();
    },

    doWithdraw() {
      if (this.canWithdraw) {
        let formData = new FormData();
        formData.append("amount", this.amount);
        formData.append("bank_country", this.country);
        formData.append("bank_name", this.bank_name);
        formData.append("bank_user", this.bank_user);
        formData.append("bank_number", this.bank_number);
        formData.append("branch", this.branch);
        formData.append("sec_password", this.sec_pwd);

        var self = this;
        self.isLoading = true;
        var result = withdrawCash(formData);

        result
          .then(function (value) {
            console.log(value.data);
            if (value.data.code == 0) {
              self.$refs.msg.makeToast("success", self.$t(value.data.message));
              setTimeout(() => {
                self.$router.push("/web/");
              }, 2000);
            } else {
              self.$refs.msg.makeToast("danger", self.$t(value.data.message));
            }
            self.sec_pwd = "";
            // self.isLoading = false;
          })
          .catch(function (error) {
            console.log(error);
            self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
            self.isLoading = false;
            self.sec_pwd = "";
          });
      } else {
        this.$refs.msg.makeToast(
          "danger",
          this.$t("TODAY_HAVEN_COMPLETE_TASK")
        );
      }
    },
  },
  watch: {
    country: function () {
      var self = this;
      for (let i = 0; i < self.rows.length; i++) {
        if (self.rows[i].id == self.country) {
          self.bankRate = self.rows[i].buy;
          self.pSymbol = self.rows[i].short_form;
        }
      }
      self.changeRate();
    },
  },
  created() {
    var result = getBankInfo();
    var self = this;
    this.isLoading = true;
    result
      .then(function (value) {
        console.log(value.data);
        self.bank_number = value.data.data.bank_number;
        self.bank_name = value.data.data.bank_name;
        self.bank_user = value.data.data.bank_user;
        self.branch = value.data.data.branch;
        if (value.data.data.bank_number != null) {
          // self.$bvModal.show("modal-otp");
        }
        self.isLoading = false;
      })
      .catch(function (e) {
        console.log(e);
        self.isLoading = false;
      });
    this.getCountryList();
  },
};
</script>

<style>
button.close {
  display: none;
}
h5#modal-warning___BV_modal_title_ {
  margin: auto;
}
</style>