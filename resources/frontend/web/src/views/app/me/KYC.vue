<template>
  <div class="main-content">
    <div class="appBar">
      <a @click="$router.push('/web/me/mePage')">
        <i class="fa fa-chevron-left"></i>
      </a>
      <span>{{ $t("KYC") }}</span>
    </div>
    <div class="m-3 mx-5">
      <h5 style="color: red">{{ $t("remark") }}</h5>
      <h6 style="color: red">{{ $t("submitImageBeforeWithdraw") }}</h6>
    </div>
    <div class="m-3 mx-5">
      <b-row align-h="center">
        <b-col md="10">
          <b-form @submit.prevent="submitForm">
            <div class="form-group row">
              <label for="new_password" class="col-sm-12 col-form-label">{{
                $t("ic_front") + "/" + $t("passport")
              }}</label>
              <input
                type="file"
                name="image"
                accept="image/*"
                style="display: none"
                @change="setImage"
                ref="myBtn"
              />

              <div class="col-12">
                <div class="upload-box" @click="myClickEvent">
                  <div
                    v-if="!imgSrc"
                    class="upload-hint text-28"
                    :class="{ active: showAlert }"
                  >
                    <i class="fa fa-plus text-25"></i>
                  </div>
                  <img
                    v-if="imgSrc"
                    :src="imgSrc"
                    style="
                      width: auto;
                      height: 100%;
                      position: absolute;
                      z-index: 2;
                    "
                  />
                </div>
              </div>
            </div>
            <div class="form-group row mt-5">
              <label for="new_password" class="col-sm-12 col-form-label">{{
                $t("ic_back")
              }}</label>
              <input
                type="file"
                name="image"
                accept="image/*"
                style="display: none"
                @change="setImage2"
                ref="myBtn2"
              />
              <div class="col-12">
                <div class="upload-box" @click="myClickEvent2">
                  <div v-if="!imgSrc2" class="upload-hint text-28">
                    <i class="fa fa-plus"></i>
                  </div>
                  <img
                    v-if="imgSrc2"
                    :src="imgSrc2"
                    style="
                      width: auto;
                      height: 100%;
                      position: absolute;
                      z-index: 2;
                    "
                  />
                </div>
              </div>
            </div>

            <div class="mt-4 float-right w-100">
              <b-button type="submit" class="btn-curved" block :disabled="isLoading">
                <span class="font-weight-bold text-white">
                  {{ isLoading ? $t("loading...") : $t("submit") }}
                </span></b-button
              >
            </div>
          </b-form>
        </b-col>
      </b-row>
    </div>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import { getTicket, userKYC } from "../../../system/api/api";
import { handleError } from "../../../system/handleRes";
import Dialog from "../../../components/dialog.vue";
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
      isLoading: true,
      point1: [],
      dataList: [],
      canClear: false,
      wallet: "point1",
      wallet2: "point2",
      totalRecords: 0,
      pageNumber: 1,
      message: "",
      stock: "",
      money: "",
      status: true,
      balance: "",
      currentPage: 1,
      lastPage: 1,
      imgSrc: "",
      imgSrc2: "",
      image: null,
      image2: null,
      showAlert: false,
    };
  },
  props: ["success"],
  methods: {
    myClickEvent() {
      const elem = this.$refs.myBtn;
      elem.click();
    },
    myClickEvent2() {
      const elem = this.$refs.myBtn2;
      elem.click();
    },
    setImage(e) {
      const file = e.target.files[0];
      this.image = file;
      if (!file.type.includes("image/")) {
        alert("Please select an image file");
        return;
      }
      if (typeof FileReader === "function") {
        const reader = new FileReader();
        reader.onload = (event) => {
          this.imgSrc = event.target.result;
        };
        reader.readAsDataURL(file);
      } else {
        alert("Sorry, FileReader API not supported");
      }
    },
    setImage2(e) {
      const file = e.target.files[0];
      this.image2 = file;
      if (!file.type.includes("image/")) {
        alert("Please select an image file");
        return;
      }
      if (typeof FileReader === "function") {
        const reader = new FileReader();
        reader.onload = (event) => {
          this.imgSrc2 = event.target.result;
        };
        reader.readAsDataURL(file);
      } else {
        alert("Sorry, FileReader API not supported");
      }
    },
    submitForm() {
      if (this.image == null) {
        this.showAlert = true;
        this.$refs.msg.makeToast("danger", this.$t("submitImageWarn"));
      } else {
        let formData = new FormData();
        var self = this;
        if (this.image != null && this.image2 == null) {
          formData.append("passport", this.image);
        } else {
          formData.append("ic_front", this.image);
          formData.append("ic_back", this.image2);
        }
        var result = userKYC(formData);
        self.isLoading = true;

        result
          .then(function (value) {
            if (value.data.code == 0) {
              self.$refs.msg.makeToast("success", self.$t(value.data.message));
              self.image = null;
              self.image2 = null;

              self.imgSrc = null;
              self.imgSrc2 = null;
              self.$router.push("/web");
            } else {
              self.$refs.msg.makeToast("danger", self.$t(value.data.message));
              // self.$router.push('/web')
            }
            self.isLoading = false;
          })
          .catch(function (error) {
            self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
            self.isLoading = false;
          });
      }
    },
    clipboardSuccessHandler({ value }) {
      this.$bvToast.toast(value, {
        title: this.$t("copied"),
        variant: "success",
        solid: true,
      });
    },

    clipboardErrorHandler() {
      //// console.log('error', value)
    },
    onPageChange(params) {
      this.pageNumber = params.currentPage;
      this.loadItems(this.wallet);
      var container = this.$el.querySelector("#table");
      var top = container.offsetTop;

      window.scrollTo(0, top);
    },
    onSearch() {
      this.pageNumber = 1;
      this.loadItems(this.wallet);
    },
    onCancel() {
      this.canClear = false;
      this.loadItems(this.wallet);
    },
    loadItems() {
      var result = getTicket(this.currentPage);
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          var dataList = value.data.data.ticket;
          self.currentPage += 1;
          self.lastPage = value.data.data.last_page;
          for (let i = 0; i < dataList.length; i++) {
            console.log(dataList[i]);
            self.dataList.push(dataList[i]);
          }
          self.isLoading = false;
        })
        .catch(function (error) {
          console.log(error);
          self.isLoading = false;
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
  },
  created() {
    this.loadItems();
  },
};
</script>

<style>
#fileName span {
  white-space: nowrap;
  overflow: hidden;
  display: inline-block;
}
#fileName span:first-child {
  width: 60px;
  text-overflow: ellipsis;
}
#fileName span + span {
  width: 34px;
  direction: rtl;
  text-align: right;
  /* text-overflow: ellipsis; */
}

.upload-hint {
  position: absolute;
  width: 100%;
  height: 100%;
  border-style: dotted;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
}

.hiddenClass {
  pointer-events: none;
  display: none;
}

.addressWidth {
  max-width: 200px;
}

.txidWidth {
  max-width: 275px;
}
</style>

<style scoped>
.upload-box {
  height: 22vh;
  position: relative;
  width: 100%;
}
.upload-hint {
  background-image: linear-gradient(
    180deg,
    #fff 0%,
    #d9c3a2 100%,
    #d5b878 100%,
    #ac7b43 100%
  );
  position: absolute;
  width: 100%;
  height: 100%;
  border-style: solid;
  border-width: 1px;
  display: flex;
  border-radius: 20px;
  justify-content: center;
  align-items: center;
  flex-direction: column;
}

.upload-hint.active {
  border-color: red;
  background-color: transparent !important;
  color: red !important;
}
</style>