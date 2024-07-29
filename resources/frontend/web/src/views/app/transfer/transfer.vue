<template>
  <div v-if="confirmTransfer" class="main-content">
    <div class="d-flex flex-column mx-5" style="height: 100vh">
      <b-modal
        id="modal-message"
        size="md"
        class=""
        @hide="checkError"
        :hide-footer="true"
        :hide-header="true"
      >
        <div class="d-flex flex-column h-100">
          <div class="my-auto">
            <div class="circle text-80" :class="{ danger: message != null }">
              <i v-if="message != null" class="fa fa-times"></i>
              <i v-else class="fa fa-check"></i>
            </div>
            <h5 class="mt-4 text-black font-weight-bolder text-center">
              {{ message != null ? message : $t("success") }}
            </h5>
          </div>
          <b-button
            style="margin-bottom: 10vh"
            type="submit"
            class="btn-curved"
            variant="primary"
            @click="checkError"
            block
            >{{ $t("close") }}</b-button
          >
        </div>
      </b-modal>
      <div class="appBar">
        <span>{{ $t("transfer") }}</span>
      </div>
      <div
        class="
          flex-grow-1
          d-flex
          flex-column
          align-items-center
          justify-content-center
        "
      >
        <h4 class="font-weight-bold">{{ $t("transfer") }}</h4>
        <h3 class="font-weight-bold" style="font-style: italic">
          {{ receiver }}
        </h3>
        <b-card class="px-2 py-3 gradient-box w-100 my-3">
          <h4 class="text-30 text-center mb-0 text-black">
            {{ amount }}
          </h4>
        </b-card>
      </div>

      <b-button
        type="button"
        class="btn-curved"
        variant="primary"
        block
        @click="_transfer"
        :disabled="isLoading"
        >{{ $t("confirm") }}</b-button
      >

      <b-button
        type="button"
        class="btn-curved-white"
        @click="confirmTransfer = false"
        variant="light"
        block
        :disabled="isLoading"
        >{{ $t("cancel") }}</b-button
      >
    </div>
  </div>
  <div v-else class="main-content bg-dark">
    <div class="appBar">
      <a @click="$router.go(-1)">
        <i class="fa fa-chevron-left"></i>
      </a>
      <span>{{ $t("transfer") }}</span>
      <a
        class="right-side"
        @click="$router.push('/web/transfer/transferRecord')"
      >
        <i class="fa fa-history"></i>
      </a>
    </div>
    <div class="m-3 mx-5">
      <b-row align-h="center">
        <b-col cols="12">
          <b-form v-on:submit.prevent="confirmTransfer = true">
            <div class="form-group row">
              <label for="point1" class="col-sm-12 col-form-label">{{
                $t("wallet")
              }}</label>
              <div class="col-sm-12">
                <b-card class="px-2 py-1 gradient-box" no-body>
                  <h5 class="text-black font-weight-bolder">
                    {{ fromSelect ? $t("point3") : $t("point1") }}
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
                    <h4
                      class="
                        text-primary
                        flex-grow-3
                        text-center
                        mb-0
                        font-weight-bold
                      "
                    >
                      {{ fromSelect ? member.point3 : member.point1 }}
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
            </div>

            <div class="form-group row">
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
            </div>-->

            <div class="form-group row">
              <label for="payment" class="col-sm-12 col-form-label">{{
                $t("pay_type")
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
                  required
                />
              </div>
            </div>
            <div class="form-group row">
              <label for="username" class="col-sm-12 col-form-label">{{
                $t("username")
              }}</label>
              <div class="col-sm-12">
                <input
                  type="text"
                  class="form-control"
                  id="username"
                  v-model="username"
                  @keyup="checkUser"
                  required
                />
                <div v-if="searchingUser">
                  <small class="text-white">{{ $t("searching") }}</small>
                </div>
                <div v-else>
                  <small
                    v-if="username != ''"
                    class="form-text text-muted text-12"
                    ><span v-if="receiver == null" class="text-danger">
                      {{ $t("not_user") }}
                    </span>
                    <span v-else>
                      {{ $t("full_name") }} : {{ receiver }}
                    </span></small
                  >
                  <small v-else class="form-text text-muted text-12">{{
                    $t("searchHint")
                  }}</small>
                </div>
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
import { transfer, getMemberInfo, searchUser } from "../../../system/api/api";
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
      confirmTransfer: false,
      username: "",
      amount: "",
      sec_password: "",
      member: {
        point1: 0,
      },
      selectWalletType: "point1",

      isLoading: false,
      searchingUser: false,
      paymentOptions: [{ value: "point1", text: this.$t("point1") }],
      package: [],
      receiver: "",
      timeout: null,
      message: null,
      fromOptions: [
        { value: "point1", text: this.$t("point1") },
        { value: "point3", text: this.$t("point3") },
      ],
      fromSelect: false,
    };
  },
  methods: {
    from(value) {
      if(value=='point1'){
        this.fromSelect = false;
      }else{
        this.fromSelect = true;
      }
    },
    checkError() {
      if (this.message != null) {
        this.confirmTransfer = false;
        this.$bvModal.hide("modal-message");
      } else {
        this.$router.push("/web");
      }
    },
    _transfer() {
      var self = this;
      // e.preventDefault();
      this.isLoading = true;
      let formData = new FormData();
      formData.append("username", this.username);
      formData.append("amount", this.amount);
      formData.append("transfer_type", this.selectWalletType);
      formData.append("sec_password", this.sec_password);

      var result = transfer(formData);
      result
        .then(function (value) {
          self.isLoading = false;
          if (value.data.code == 0) {
            self.$bvModal.show("modal-message");
            // self.$root.makeToast("success", self.$t("successSubmit"));
            // self.$router.push("/web");
          } else {
            self.message = self.$t(value.data.message);
            self.$bvModal.show("modal-message");
            // self.$root.makeToast("danger", self.$t(value.data.message));
          }
        })
        .catch(function (error) {
          console.log(error);
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
    checkUser() {
      // clear timeout variable
      // console.log(this.username);
      var self = this;
      self.searchingUser = true;
      clearTimeout(this.timeout);
      this.timeout = setTimeout(function () {
        if (self.username != "") {
          let formData = new FormData();
          formData.append("username", self.username);
          var result = searchUser(formData);
          result
            .then(function (value) {
              self.searchingUser = false;
              if (value.data.code == 0) {
                self.receiver = value.data.data.fullname || "";
              } else {
                self.receiver = null;
              }
            })
            .catch(function () {
              self.receiver = null;
            });
        } else {
          self.searchingUser = false;
          self.receiver = "";
        }
      }, 1000);
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
  mounted() {
    // this.$bvModal.show("modal-message");
  },
  created() {
    this.memberInfo();
  },
};
</script>

<style scoped>
.main-content {
  max-width: 420px;
  margin: auto;
}
</style>

<style >
.hiddenClass {
  pointer-events: none;
  display: none;
}

.bodyWidth {
  min-width: 120px;
}
</style>

<style lang="scss">
#modal-message .modal-dialog {
  max-width: 420px;
  display: flex;
  -webkit-box-align: end;
  -ms-flex-align: end;
  align-items: end;
  height: 100vh;
  // margin: unset !important;

  .modal-content {
    height: 70vh;
    border-top-left-radius: 20px !important;
    border-top-right-radius: 20px !important;

    .danger {
      background-image: radial-gradient(#ed213a 0%, #93291e 100%) !important;
    }

    .circle {
      font-size: 80px;
      border-radius: 50%;
      height: 40vw;
      width: 40vw;
      max-width: 240px;
      max-height: 240px;
      margin: 0px auto;
      text-align: center;
      position: relative;
      color: white;
      background-image: radial-gradient(#8cf69a 0%, #085424 100%);

      i {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
      }
    }
  }
}
</style>