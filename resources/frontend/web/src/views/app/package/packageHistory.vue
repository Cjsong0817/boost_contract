<template>
  <div class="main-content d-flex flex-column" style="height: 100vh">
    <div class="appBar">
      <a @click="$router.go(-1)">
        <i class="fa fa-chevron-left"></i>
      </a>
      <span>{{ $t("packageRecord") }}</span>
    </div>
    <div
      class="pt-4 py-2 flex-grow-1 mt-5"
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
        v-else-if="isLoading"
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
        <div class="px-3 py-2">
          <b-row align-v="center">
            <b-col cols="7">
              <p class="mb-0 font-weight-bold">
                {{ $t(site[item.status]) }}
              </p>
            </b-col>
            <b-col cols="5" class="text-right">
              <p
                class="font-weight-bolder mb-0 text-20"
                style="line-height: 16px"
              >
                {{ item.price }}<br />
                <span v-if="item.pay_type == 'point2'"
                  >( 100% {{ $t("point2") }} )</span
                >
                <span v-if="item.pay_type == 'point2&point3'"
                  >( 50% {{ $t("point2") }} / 50% {{ $t("point3") }} )</span
                >
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
import { getUpgradeRecord } from "../../../system/api/api";
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
      site: ["unactive", "active", "end"],
    };
  },
  props: ["success"],
  methods: {
    getRecord() {
      var result = getUpgradeRecord(this.currentPage);
      var self = this;
      self.isLoading = true;

      result
        .then(function (value) {
          var dataList = value.data.data;
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