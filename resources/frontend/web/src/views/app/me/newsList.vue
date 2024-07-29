<template>
  <div class="main-content mb-5">
    <div class="appBar mb-3">
      <a @click="$router.go(-1)">
        <i class="fa fa-chevron-left"></i>
      </a>
      <span>{{ $t("news") }}</span>
    </div>
    <div
      class="mainpage m-1 px-2 position-relative"
      style="height:80vh"
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
        <p class="text-white">No Data</p>
      </div>
      <b-card
        class="mb-2 bg-gray"
        style="border-radius: 10px"
        v-for="item in dataList"
        :key="item.id"
      >
        <b-link @click="goNewsDetails(item)">
          <b-row align-v="center">
            <b-col cols="3">
              <img :src="item.public_path" height="50" />
            </b-col>
            <b-col cols="7">
              <h5 class="mb-1 font-weight-bold">
                {{ item.title }}
              </h5>
              <span>{{ item.created_at }}</span>
            </b-col>
            <b-col cols="2">
              <i
                class="fa fa-chevron-right"
                style="
                  right: 30px;
                  position: absolute;
                  top: 50%;
                  transform: translateY(-50%);
                "
              ></i>
            </b-col>
          </b-row>
        </b-link>
      </b-card>
      <b-button
        v-if="currentPage <= lastPage"
        class="mx-auto submit_button mb-5"
        variant="outline-secondary"
        :disabled="isLoading"
        @click="loadItems"
        >{{ isLoading ? $t("loading...") : $t("load_more") }}</b-button
      >
    </div>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import { getUserNewsList } from "../../../system/api/api";
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
      language: "",
      news_type: "",
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

    clipboardErrorHandler() {},
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
    goNewsDetails(data) {
      // this.$router.push({path:'/web/me/newsDetails', params: {title: title}});
      this.$router.push({
        name: "newDetails",
        params: {
          item: data,
        },
      });
    },
    loadItems() {
      var result = getUserNewsList(this.$i18n.locale=='en'?'en':'cn', 1, this.currentPage);
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          var dataList = value.data.data.record.data;
          self.currentPage += 1;
          self.lastPage = value.data.data.record.last_page;
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