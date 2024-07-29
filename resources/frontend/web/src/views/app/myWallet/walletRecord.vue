<template>
  <div class="main-content">
    <div class="appBar">
      <span>{{ $t("record") }}</span>
    </div>
    <div
      class="mainpage m-1 px-2"
      style="
        background: rgb(210 210 210);
        min-height: 90vh;
        border-radius: 10px;
        padding-bottom: 15vh !important;
        position: relative;
      "
    >
      <div
        v-if="currentPage > lastPage && dataList.length==0"
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
        class="bg-white px-2 py-1 mb-2"
        style="border-radius: 10px"
        v-for="item in dataList"
        :key="item.id"
      >
        <b-row align-v="center">
          <b-col cols="2" >
            <!-- <img src="../../../assets/images/boost/deposit.png" alt="" /> -->
            <img class="ml-1" v-if="item.detailen.toLowerCase().includes('withdraw')" src="../../../assets/images/boost/withdraw_color.png" alt="" />
            <img class="ml-1" v-else-if="item.detailen.toLowerCase().includes('boost')" src="../../../assets/images/boost/shop_color.png" alt="" />
            <img class="ml-1" v-else-if="item.detailen.toLowerCase().includes('deposit')" src="../../../assets/images/boost/deposit_color.png" alt="" />
            <img class="ml-1" v-else-if="item.detailen.toLowerCase().includes('admin')" src="../../../assets/images/boost/admin.png" alt="" />
          </b-col>
          <b-col cols="6">
            <p class="mb-1">{{ ($i18n.locale=="zh")?item.detail:item.detailen }}</p>
            <span>{{ item.updated_at }}</span>
          </b-col>
          <b-col cols="4">
            <span>{{ item.action }}{{ item.found }}</span>
          </b-col>
        </b-row>
      </div>
      <b-button
        v-if="currentPage <= lastPage"
        class="mx-auto submit_button mb-5"
        variant="outline-secondary"
        @click="loadItems"
        >{{ isLoading ? $t("loading...") : $t("load_more") }}</b-button
      >
    </div>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import { getUserWalletRecord, getMemberInfo } from "../../../system/api/api";
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
      var result = getUserWalletRecord(this.wallet, this.currentPage);
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