<template>
  <div class="main-content">
    <div class="appBar">
      <a @click="$router.go(-1)">
        <i class="fa fa-chevron-left"></i>
      </a>
      <span>{{ $t("purchase_record") }}</span>
    </div>

    <div
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
        v-else-if="isLoading && dataList.length == 0"
        style="
          position: absolute;
          top: 50%;
          left: 50%;
          transform: translate(-50%, -50%);
        "
      >
        <p>{{ $t("loading...") }}</p>
      </div>
      <div
        class="card px-2 py-2 mb-2"
        style="border-radius: 10px"
        v-for="item in dataList"
        :key="item.id"
      >
        <b-row align-v="center">
          <b-col cols="2">
            <img src="../../../assets/images/boost/withdraw_color.png" alt="" />
          </b-col>
          <b-col cols="6">
            <p class="mb-0">{{ $t("successfully_purchase_insurance") }}</p>
            <span class="text-10">{{ item.updated_at }}</span>
          </b-col>
          <b-col cols="4">
            <p class="mb-0">
             - {{ item.pay }} {{ $t("point1") }}
            </p>
          </b-col>
        </b-row>
      </div>
      <b-button
        v-if="currentPage <= lastPage && dataList.length != 0"
        class="mx-auto submit_button mb-5"
        variant="outline-secondary"
        @click="getRecord"
        >{{ isLoading ? $t("loading...") : $t("load_more") }}</b-button
      >
    </div>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import { getInsuranceHis } from "../../../system/api/api";
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
      isLoading: false,
      dataList: [],
      currentPage: 1,
      lastPage: 1,
    };
  },
  props: ["success"],
  methods: {
    getRecord() {
      var result = getInsuranceHis(this.currentPage);
      var self = this;
      self.isLoading = true;

      result
        .then(function (value) {
          var dataList = value.data.data.data;
          console.log(dataList);
          self.currentPage += 1;
          self.lastPage = value.data.data.data.last_page;
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

<style>
</style>