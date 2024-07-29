<template>
  <div class="main-content">
    <div class="appBar">
      <a @click="$router.go(-1)">
        <i class="fa fa-chevron-left"></i>
      </a>
      <span>{{ $t("setWithdraw") }}</span>
    </div>

    <div class="mainpage">
      <div class="mt-3" style="position: relative">
        <b-card class="m-3 mx-4">
          <b-row align-h="center">
            <b-col cols="12">
              <b-form @submit.prevent="setCoin">
                <!-- <p style="color: red; font-weight: bold; margin: 0px 0px 10px 0px">
                  {{ $t("setWithdrawHintCoin") }}
                </p> -->

                <div class="form-group row">
                    <label for="address" class="col-sm-2 col-form-label">{{
                      'DFI '+$t("address")
                    }}</label>
                    <div class="col-sm-10">
                      <input
                        class="form-control"
                        label="address"
                        v-model="address"
                        type="text"
                      required
                      />
                    </div>
                  </div>


                <b-button
                  class="mx-auto submit_button"
                  style="margin-top: 10vh"
                  variant="outline-secondary"
                  type="submit"
                  :disabled="isLoading"
                  >{{ isLoading ? $t("loading...") : $t("submit") }}</b-button
                >
              </b-form>
            </b-col>
          </b-row>
        </b-card>

        
        <Dialog ref="msg"></Dialog>
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
      </div>
    </div>
  </div>
</template>

<script>
import { setCoinInfo } from "../../../system/api/api";
import { handleError } from "../../../system/handleRes";
import { mapGetters } from "vuex";
import Dialog from "../../../components/dialog.vue";
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
      address: "",
      amount: 0,
      confirm_amount: 0,
      sec_pwd: "",
      selected: 0,
      isLoading: false,
    };
  },
  methods: {
    warning() {
      this.$bvModal.show("modal-warning");
    },
    close() {
      this.$bvModal.hide("modal-warning");
    },

    setCoin() {
      let formData = new FormData();
      formData.append("address", this.address);
      console.log(formData);

      var self = this;
      self.isLoading = true;
      var result = setCoinInfo(formData);

      result
        .then(function (value) {
          if (value.data.code == 0) {
            self.$refs.msg.makeToast("success", self.$t(value.data.message));
            setTimeout(() => {
              self.$router.push("/web/withdraw");
            }, 2000);
          } else {
            self.$refs.msg.makeToast("danger", self.$t(value.data.message));
          }
          self.sec_pwd = "";
          // self.isLoading = false;
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          self.isLoading = false;
          self.sec_pwd = "";
        });
    },
  },
  created() {},
};
</script>

<style>
</style>