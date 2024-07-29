<template>
  <div class="main-content d-flex flex-column" style="height: 100vh">
    <div class="appBar position-relative">
      <a @click="$router.go(-1)" class="text-20">
        <i class="fa fa-chevron-left"></i>
      </a>
      <span class="font-weight-bold text-20">{{
        $t("wallet") + " " + $t("record")
      }}</span>
      <div class="position-absolute" style="right: 10px; top: 10px">
        <b-button
          :class="{ 'text-dark': !searched }"
          :variant="searched ? 'primary' : 'outline-secondary'"
          @click="$bvModal.show('modal-search')"
        >
          <i class="fa fa-filter">
            <span class="ml-1" :class="{ 'text-white': searched }">
              {{ $t("filter") }}
            </span>
          </i>
        </b-button>
      </div>
    </div>
    <div>
      <h4 class="text-right px-3 mt-4">
        {{ searched ? $t("totalSearchAmount") : $t("totalAmount") }}
        : {{ totalAmount }}
      </h4>
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
        <div class="px-3 py-2">
          <b-row align-v="center">
            <b-col cols="7">
              <p class="mb-0 font-weight-bold">
                {{ $i18n.locale == "zh" ? item.detail : item.detailen }}<br />
              </p>
            </b-col>
            <b-col cols="5" class="text-right">
              <p
                class="font-weight-bolder mb-0 text-20"
                style="line-height: 16px"
              >
                {{ item.action }}{{ parseFloat(item.found).toFixed(2) }}
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
        @click="loadItems"
        ><span class="text-white font-weight-bold">{{
          isLoading ? $t("loading...") : $t("load_more")
        }}</span></b-button
      >
    </div>
    <b-modal
      id="modal-search"
      size="md"
      centered
      class=""
      :title="$t('filter')"
      :hide-footer="true"
    >
      <b-row align-h="center">
        <b-col cols="10">
          <b-form>
            <b-form-group
              class="mb-3"
              v-for="(item, index) in filterParam"
              :key="item.id"
              label-for="item"
              :label="$t(index)"
            >
              <b-form-input
                type="date"
                v-model="filterParam[index]"
                v-if="index == 'start_date' || index == 'end_date'"
              ></b-form-input>

              <div v-else-if="index == 'found_type'">
                <b-form-checkbox-group
                  id="checkbox-group-2"
                  v-model="filterParam[index]"
                  :options="foundOptions"
                  value-field="item"
                  text-field="name"
                >
                </b-form-checkbox-group>
              </div>
              <b-form-input
                type="text"
                v-model="filterParam[index]"
                v-else
              ></b-form-input>
            </b-form-group>
            <div class="form-group">
              <div class="row">
                <div class="col-sm-12">
                  <b-button
                    class="mt-3 w-100"
                    variant="primary"
                    @click="filter()"
                    >{{ $t("submit") }}</b-button
                  >
                </div>
                <div class="col-sm-12" v-if="searched">
                  <b-button
                    class="mt-2 w-100"
                    variant="danger"
                    @click="clearFilter"
                  >
                    <i class="fa fa-filter"
                      ><span class="ml-1">
                        {{ $t("clear") }}
                      </span></i
                    ></b-button
                  >
                </div>
              </div>
            </div>
          </b-form>
        </b-col>
      </b-row>
    </b-modal>
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
      totalAmount: 0,
      pageNumber: 1,
      message: "",
      stock: "",
      money: "",
      status: true,
      searched: false,
      filterParam: {
        start_date: "",
        end_date: "",
        found_type: [],
        // type: "3",
        // amount: "4",
      },
      balance: "",
      currentPage: 1,
      lastPage: 1,
      foundList: [],
      foundOptions: [],
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
    clearFilter() {
      this.$bvModal.hide("modal-search");
      this.dataList = [];
      this.currentPage = 1;
      for (const item in this.filterParam) {
        this.filterParam[item] = "";
      }
      this.searched = false;
      this.loadItems();
    },
    filter() {
      this.$bvModal.hide("modal-search");
      this.currentPage = 1;
      this.dataList = [];
      for (const item in this.filterParam) {
        if (this.filterParam[item] != "") {
          this.searched = true;
        }
      }
      this.loadItems();
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
      var searchParam = "";
      for (const item in this.filterParam) {
        var tmp = "&" + item + "=" + this.filterParam[item];
        searchParam = searchParam + tmp;
      }
      var result = getUserWalletRecord(
        this.$route.query.type,
        this.currentPage,
        searchParam
      );
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          self.foundList = value.data.data.found_type;
          var tmp = [];
          for (let i = 0; i < value.data.data.found_type.length; i++) {
            var jsonObject = {};
            jsonObject["item"] = value.data.data.found_type[i].found_type;
            jsonObject["name"] =
              self.$i18n.locale == "en"
                ? value.data.data.found_type[i].comments_en
                : value.data.data.found_type[i].comments_cn;
            tmp.push(jsonObject);
          }
          self.foundOptions = tmp;

          self.totalAmount = parseFloat(value.data.data.total_amount).toFixed(
            2
          );
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
    if (this.$route.query.type == null) {
      this.$router.push("*");
    }
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
#modal-search .modal-content {
  height: auto;
  background: #2b2e36;
}
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