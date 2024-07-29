<template>
  <div class="main-content d-flex flex-column" style="height:100vh">
    <div class="appBar">
      <a @click="$router.go(-1)">
        <i class="fa fa-chevron-left"></i>
      </a>
      <span>{{ $t("deposit_record") }}</span>
    </div>

    <!-- <div class="mainpage">
      <b-row align-h="between" class="mt-3">
        <b-col cols="5" class="pr-0">
          <div
            class="tabContainer text-center"
            :class="{ active: selected == 'BANK' }"
            @click="selectIndex('BANK')"
          >
            <div class="tabImage">
              <img
                src="../../../assets/images/boost/bank.png"
                alt=""
                height="15px"
              />
            </div>
            <span>{{ $t("bank") }}</span>
          </div>
        </b-col>
        <b-col cols="5" class="pl-0">
          <div
            class="tabContainer text-center"
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
    </div> -->

    <div
      class="pt-4 py-2 flex-grow-1 mt-4"
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
                {{ $t("deposit") }} {{ $t("success") }}<br />
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
        <div class="mx-3 my-1" style="height: 1px; background-color: gray"></div>
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
    <!--<div
      class="m-3 px-2 mt-3 py-2"
      style="
        min-height: 90vh;
        border-radius: 10px;
        padding-bottom: 15vh !important;
        position: relative;
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
      <b-card
        class="px-2 py-2 mb-2"
        style="border-radius: 10px"
        v-for="item in dataList"
        :key="item.id"
      >
        <b-row align-v="center">
          <b-col cols="2" class="text-20">
            <i class="ml-1 fa fa-university" alt="" />
          </b-col>
          <b-col cols="6">
            <p class="mb-0">TXID</p>
            <span class="text-10">{{ item.txid }}</span
            ><br />
            <span class="text-10">{{ item.updated_at }}</span>
          </b-col>
          <b-col cols="4">
            <p class="mb-0">
              {{ $t("deposit") }} {{ $t("success") }}<br />
              {{ item.amount }} USDT
            </p>
          </b-col>
        </b-row>
      </b-card>
      <b-button
        v-if="currentPage <= lastPage && dataList.length != 0"
        class="mx-auto submit_button mb-5"
        variant="outline-secondary"
        @click="getRecord"
        >{{ isLoading ? $t("loading...") : $t("load_more") }}</b-button
      >
    </div>-->
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import { getBoDepositRecord } from "../../../system/api/api";
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
          type: 'deposit'
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
      var result = getBoDepositRecord(this.currentPage);
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