<template>
  <div class="main-content d-flex flex-column" style="height: 100vh">
    <div class="appBar">
      <a @click="$router.go(-1)">
        <i class="fa fa-chevron-left"></i>
      </a>
      <span>{{ $t("withdraw_record") }}</span>
    </div>

    <div class="mainpage">
      <b-row align-h="between" class="mt-3">
        <b-col cols="5" class="pl-0">
          <div
            class="tabContainer text-center"
            style="display: none"
            :class="{ active: selected == 'COIN' }"
            @click="selectIndex('COIN')"
          >
            <div class="tabImage">
              <img
                src="../../../assets/images/boost/crypto.png"
                alt=""
                height="15px"
              />
            </div>
            <span>{{ $t("crypto") }}</span>
          </div></b-col
        >
      </b-row>
    </div>
    <div
      class="pt-4 py-2 flex-grow-1"
      style="
        background: white;
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
        position: relative;
        overflow-y: scroll;
      "
    >
      <div
        v-if="currentPage > lastPage && dataList.length == 0"
        style="
          position: absolute;
          top: 50%;
          left: 50%;
          transform: translate(-50%, -50%);
        "
      >
        <p>No Data</p>
      </div>
      <div
        v-else-if="dataList.length == 0"
        style="
          position: absolute;
          top: 50%;
          left: 50%;
          transform: translate(-50%, -50%);
        "
      >
        <p>{{ $t("loading...") }}</p>
      </div>

      <div v-for="item in dataList" :key="item.id">
        <div class="px-3 py-2" @click="goDetails(item)">
          <b-row align-v="center">
            <b-col cols="5">
              <p class="mb-0 font-weight-bold">
                {{ $t("withdraw") }} {{ $t(site[item.status]) }}<br />
              </p>
            </b-col>
            <b-col cols="7" class="text-right">
              <p
                class="font-weight-bolder mb-0 text-20"
                style="line-height: 16px"
              >
                {{ item.amount }} USDT
              </p>
              <span
                class="text-10 font-weight-bold"
                style="
                  line-height: 10px;
                  letter-spacing: normal;
                  color: rgb(127, 127, 127);
                "
                >{{ item.updated_at }}</span
              >
            </b-col>
          </b-row>
        </div>
        <div
          class="mx-3 my-1"
          style="height: 1px; background-color: gray"
        ></div>
      </div>
      <b-button
        v-if="currentPage <= lastPage && dataList.length != 0"
        class="mx-auto submit_button mb-5 mt-4 btn-square"
        @click="getRecord"
        ><span class="text-white font-weight-bold">{{
          isLoading ? $t("loading...") : $t("load_more")
        }}</span></b-button
      >
    </div>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import { getWithdrawRecord } from "../../../system/api/api";
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
      address: "",
      totalAmount: 0,
      amount: 0,
      confirm_amount: 0,
      fee: 0,
      sec_pwd: "",
      selected: "COIN",
      isLoading: false,
      dataList: [],
      currentPage: 1,
      lastPage: 1,
      site: ["pending", "approved", "success", "rejected"],
    };
  },
  props: ["success"],
  methods: {
    goDetails(item) {
      this.$router.push({
        name: "recordDetails",
        params: {
          item: item,
          type: 'withdraw'
        },
      });
    },
    selectIndex(i) {
      this.selected = i;
      this.sec_pwd = "";
      this.dataList = [];
      this.currentPage = 1;
      this.lastPage = 1;

      this.getRecord();
    },

    getRecord() {
      var result = getWithdrawRecord(this.selected, this.currentPage);
      var self = this;
      self.isLoading = true;

      result
        .then(function (value) {
          var dataList = value.data.data.data;
          self.currentPage += 1;
          self.lastPage = value.data.data.last_page;
          for (let i = 0; i < dataList.length; i++) {
            self.dataList.push(dataList[i]);
          }
          self.isLoading = false;
        })
        .catch(function (error) {
          self.isLoading = false;
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
  },
  created() {
    this.getRecord();
  },
};
</script>

<style scoped>
.main-content {
  max-width: 420px;
  margin: auto;
}
</style>