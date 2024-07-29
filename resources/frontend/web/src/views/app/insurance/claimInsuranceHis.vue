<template>
  <div class="main-content d-flex flex-column" style="height: 100vh">
    <div class="appBar">
      <a @click="$router.go(-1)">
        <i class="fa fa-chevron-left"></i>
      </a>
      <span>{{ $t("insuranceClaimedRecord")}}</span>
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

      <div v-for="item in dataList" :key="item.id">
        <div class="px-3 py-2">
          <b-row align-v="center">
            <b-col cols="7">
              <p class="mb-0 font-weight-bold">
                {{ $t("insuranceClaimed") }}
                <br />
                <span>
                  <b-badge
                    href="#"
                    v-if="item.status == 0"
                    variant="warning"
                    class="p-1 text-10"
                    >{{ $t("pending") }}</b-badge
                  >
                  <b-badge
                    href="#"
                    v-else-if="item.status == 1"
                    variant="success"
                    class="p-1 text-10"
                    >{{ $t("authorized") }}</b-badge
                  >
                  <b-badge
                    href="#"
                    v-else-if="item.status == 2"
                    variant="danger"
                    class="p-1 text-10"
                    >{{ $t("rejected") }}</b-badge
                  ></span
                >
              </p>
            </b-col>
            <b-col cols="5" class="text-right">
              <p
                class="font-weight-bolder mb-0 text-20"
                style="line-height: 16px"
              >
                {{ item.claim_amount }}
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
        v-if="currentPage <= lastPage"
        class="mx-auto submit_button btn-square text-white mb-5"
        variant="outline-secondary"
        @click="loadItems"
        >{{ isLoading ? $t("loading...") : $t("load_more") }}</b-button
      >
    </div>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import { getMemberInfo, getClaimInsuranceHis } from "../../../system/api/api";
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
    };
  },
  props: ["success"],
  methods: {
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
    getInfo() {
      var result = getMemberInfo();
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          self.balance = value.data.point1;
          self.isLoading = false;
        })
        .catch(function (error) {
          self.isLoading = false;
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
    loadItems() {
      var result = getClaimInsuranceHis(this.currentPage);
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          var dataList = value.data.data.data;
          console.log(value.data.data);
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
    this.loadItems();
  },
};
</script>

<style scoped>
.main-content {
  max-width: 420px;
  margin: auto;
}
</style>

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