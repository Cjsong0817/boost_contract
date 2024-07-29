<template>
  <div class="main-content">
    <breadcumb :page="$t('transaction_record')" :folder="$t('transaction')" />

    <b-card
      :title="
        $t('transaction_record') + ' ( ' + $t(searchParam['wallet']) + ' )'
      "
    >
      <div class="d-flex justify-content-end">
        <b-button
          variant="primary"
          class="mr-2"
          @click="$bvModal.show('modal-search')"
          >{{ $t("search") }}</b-button
        >
        <b-button variant="danger" v-if="canClear" @click="onCancel">{{
          $t("clear")
        }}</b-button>

       
      </div>
      <vue-good-table
        id="table"
        mode="remote"
        @on-page-change="onPageChange"
        @on-search="onSearch"
        :totalRows="totalRecords"
        :isLoading="isLoading"
        :columns="columns"
        :search-options="{
          enabled: false,
          placeholder: 'Search this table',
        }"
        :pagination-options="{
          enabled: false,
          perPageDropdownEnabled: false,
          perPageDropdown: [10],
          dropdownAllowAll: false,
          rowsPerPageLabel: $t('rowPerPage'),
          nextLabel: $t('next'),
          prevLabel: $t('previous'),
          mode: 'pages',
          pageLabel: $t('page'),
          setCurrentPage: pageNumber,
        }"
        styleClass="tableOne vgt-table table-striped"
        :selectOptions="{
          enabled: false,
          selectionInfoClass: 'table-alert__box',
        }"
        :rows="rows"
      >
        <!-- <div slot="table-actions" class="mb-3">
          <b-button variant="primary" class="btn-rounded"> Add Button </b-button>
        </div> -->

        <template slot="table-row" slot-scope="props">
          <span v-if="props.column.field == 'contact_number'">
            <span v-if="props.row.contact_number">
              {{ props.row.country.country_code + props.row.contact_number }}
            </span>
          </span>
          <span v-else-if="props.column.field == 'found'">
            <span v-if="props.row.out_type > 0" style="color: red">
              -{{ props.row.found }}
            </span>
            <span v-else style="color: green"> +{{ props.row.found }} </span>
          </span>
          <span v-else-if="props.column.field == 'created_at'">
            {{ processDate(props.row.created_at) }}
          </span>
          <span v-else-if="props.column.field == 'wallet'">
            {{ $t(searchParam["wallet"]) }}
          </span>
          <span v-else-if="props.column.field == 'found_type'">
            {{ checkFType(props.row.found_type) }}
          </span>
          <span v-else-if="props.column.field == 'action'">
            <button
              type="button"
              class="btn btn-default btn-edit"
              v-b-popover.hover.top="$t('editUser')"
              @click="editUser(props.row)"
            >
              <i class="fa fa-pencil"></i>
            </button>
            <button
              type="button"
              class="btn btn-default btn-push mx-1 px-2"
              v-b-popover.hover.top="$t('updatePwd')"
              @click="showModal(props.row)"
            >
              <i class="fa fa-shield"></i>
            </button>
            <button
              type="button"
              class="btn btn-default btn-wallet mr-1"
              v-b-popover.hover.top="$t('walletRecord')"
              @click="showWallet(props.row.username)"
            >
              <i class="fa fa-money"></i>
            </button>
            <!-- <button
                    type="button"
                    class="btn btn-default btn-delete"
                    v-b-popover.hover.top="$t('settings')"
                    @click="showSettings(props.row.id, props.row.setting)"
                  >
                    <i class="fa fa-gear"></i>
                  </button> -->
          </span>
        </template>
      </vue-good-table>

      <div class="align-items-center mobile-adjust">
        <div
          v-if="totalRecords > 0"
          class="d-flex flex-wrap align-items-center justify-content-start mt-3"
        >
          <p class="text-light text-16 mr-2">{{ $t("total") }}</p>
          <p class="text-muted text-16" style="font-weight: bold">
            {{ totalRecords }}
          </p>
        </div>
        <div v-else></div>
        <div class="d-flex flex-wrap align-items-center justify-content-end">
          <b-pagination
            class="pagi-margin pt-3"
            v-model="pageNumber"
            :total-rows="totalRecords"
            :per-page="10"
            :first-text="$t('first')"
            :prev-text="$t('prev')"
            :next-text="$t('next')"
            :last-text="$t('last')"
            @input="loadItems()"
          >
          </b-pagination>

          <b-input-group class="ml-3" style="width: 160px">
            <b-form-input
              v-model="pageNumber"
              :placeholder="$t('PageNo')"
            ></b-form-input>
            <b-input-group-append>
              <b-button
                variant="primary"
                @keypress="loadItems()"
                @click="loadItems()"
                >{{ $t("go") }}</b-button
              >
            </b-input-group-append>
          </b-input-group>
        </div>
      </div>
    </b-card>
    <b-modal
      id="modal-search"
      size="md"
      centered
      :title="$t('search')"
      :hide-footer="true"
    >
      <b-row align-h="center">
        <b-col cols="10">
          <b-form @submit.prevent="onSearch">
              <b-col md="1" class="mt-3 mt-md-0">
        </b-col>
            <b-button variant="primary" class="mb-2 d-block text-right ml-auto" @click="exportFile">
                {{$t("export")}}
            </b-button>
            <b-form-group
              class="mb-3"
              v-for="(item, index) in searchParam"
              :key="item.id"
              label-for="item"
              :label="$t(index)"
            >

              <b-form-input
                type="date"
                v-model="searchParam[index]"
                v-if="index == 'start_date' || index == 'end_date'"
              ></b-form-input>
              <b-form-input
                type="date"
                v-model="searchParam[index]"
                v-else-if="index == 'from' || index == 'to'"
              ></b-form-input>

             

              <div v-else-if="index == 'wallet'">
                <b-form-select
                  v-model="searchParam[index]"
                  :options="walletOptions"
                ></b-form-select>
              </div>

              <div v-else-if="index == 'found_type'">
                <b-form-checkbox-group
                  id="checkbox-group-2"
                  v-model="searchParam[index]"
                  :options="selectOptions"
                  value-field="item"
                  text-field="name"
                >
                </b-form-checkbox-group>
              </div>
              <b-form-input
                type="text"
                v-model="searchParam[index]"
                v-else
              ></b-form-input>
            </b-form-group>
            <div class="form-group">
              <div class="row">
                <div class="col-sm-12">
                  <b-button
                    class="mt-3 w-100"
                    variant="primary"
                    type="submit"
                    >{{ $t("submit") }}</b-button
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
import { country_list, userWalletRecord } from "../../../system/api/api";
import Dialog from "../../../components/dialog.vue";
import { handleError } from "../../../system/handleRes";
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters(["lang"]),
    walletOptions() {
      return [
        { value: "point1", text: this.$t("point1") },
        { value: "point2", text: this.$t("point2") },
        { value: "point3", text: this.$t("point3") },
      ];
    },
    columns() {
      return [
        {
          label: this.$t("id"),
          text: "id",
          field: "id",
          thClass: "gull-th-class",
          value: "id",
          sortable: false,
        },
        {
          label: this.$t("user_id"),
          text: "user_id",
          field: "user_id",
          thClass: "gull-th-class",
          value: "user_id",
          sortable: false,
        },
        {
          label: this.$t("username"),
          text: "username",
          field: "user.username",
          thClass: "gull-th-class",
          value: "username",
          sortable: false,
        },
        {
          label: this.$t("full_name"),
          text: "full_name",
          field: "user.fullname",
          thClass: "gull-th-class",
          value: "full_name",
          sortable: false,
        },
        // {
        //   label: this.$t("wallet"),
        //   text: "wallet",
        //   field: "wallet",
        //   thClass: "gull-th-class",
        //   value: "wallet",
        //   sortable: false,
        // },
        {
          label: this.$t("previousBalance"),
          text: "previous",
          field: "previous",
          thClass: "gull-th-class",
          value: "previous",
          sortable: false,
        },
        {
          label: this.$t("founds"),
          text: "found",
          field: "found",
          thClass: "gull-th-class",
          value: "found",
          sortable: false,
        },
        {
          label: this.$t("currentBalance"),
          text: "current",
          field: "current",
          thClass: "gull-th-class",
          value: "current",
          sortable: false,
        },
        {
          label: this.$t("detail"),
          text: "detail",
          field: this.$i18n.locale == "zh" ? "detail" : "detailen",
          thClass: "gull-th-class",
          value: "detail",
          sortable: false,
        },
        {
          label: this.$t("found_type"),
          text: "found_type",
          field: "found_type",
          thClass: "gull-th-class",
          value: "found_type",
          sortable: false,
        },
        {
          label: this.$t("created_at"),
          text: "created_at",
          field: "created_at",
          thClass: "gull-th-class",
          value: "created_at",
          tdClass: "dateWidth",
          sortable: false,
        },
      ];
    },
  },
  components: {
    Dialog,
  },
  data() {
    return {
      adminToken: "",
      username: "",
      form: {
        user_id: "",
        setting: [],
      },
      setting: [],
      password: "",
      password2: "",
      contact_number: "",
      country_id: "",
      user_group_id: "",
      wr: false,
      rb: false,
      wt: false,
      auto_renew: false,

      selectWalletType: "point1",
      from: "",
      to: "",
      canClearWallet: false,
      searchUsernameWallet: "",
      uid: "",
      user_setting: [],
      totalBalance: 0,
      totalWalletRecords: 0,

      searchUsername: "",
      searchPhone: "",
      searchUID: "",
      isLoading: false,
      canClear: false,
      totalRecords: 0,
      pageNumber: 1,
      walletPageNumber: 1,
      rows: [],
      walletRows: [],
      tabIndex: 0,
      canEdit: false,
      canShow: false,
      canSettings: false,
      packageType: "1",
      productType: "",
      country: null,
      countryOptions: [],
      package: [],
      foundList: [],
      product: [],
      selectOptions: [],
      productOptions: [],
      countryList: [],
      fields: { text: "text", value: "value" },
      user_rank_id: "",
      set_rank: "",
      total_cap: "",
      special: "0",
      specialOptions: [
        { value: "0", text: this.$t("normal") },
        { value: "1", text: this.$t("special") },
      ],
      user_rank_idOptions: [
        { value: "0", text: this.$t("normal") },
        { value: "1", text: this.$t("bronze") },
        { value: "2", text: this.$t("silver") },
        { value: "3", text: this.$t("gold") },
        { value: "4", text: this.$t("diamond") },
        { value: "5", text: this.$t("king") },
      ],
      searchParam: {},
    };
  },
  methods: {
    exportFile(){
      var exportParam = '/admin-api/export/exportWallet?token='+this.adminToken;

      for (const key in this.searchParam) {
        var tmp = "";
        if (Object.hasOwnProperty.call(this.searchParam, key)) {
          tmp = '&'+ key + '=' + this.searchParam[key];
          
        }
        exportParam += tmp
      }

      window.location.href = exportParam;
    },
    searchSetup() {
      var tmp = {};
      tmp["wallet"] = "point1";
      var col = this.columns;
      for (const item in col) {
        if (
          col[item].text != "created_at" &&
          col[item].text != "previous" &&
          col[item].text != "current" &&
          col[item].text != "detail" &&
          col[item].text != "found"
        ) {
          if (col[item].text == "found_type") {
            tmp[col[item].text] = [];
          }
          // else if (col[item].text == "wallet") {
          //   tmp[col[item].text] = "point1";
          // }
          else {
            tmp[col[item].text] = "";
          }
        }
      }
      // tmp["wallet"] = "point1";
      tmp["from"] = "";
      tmp["to"] = "";
      // console.log(tmp);
      this.searchParam = tmp;
    },

    processDate(rawDate) {
      var d = new Date(rawDate);
      var dMinute = d.getMinutes();
      var dHour = d.getHours();
      if (dMinute.toString().length == 1) {
        dMinute = "0" + dMinute;
      }
      if (dHour.toString().length == 1) {
        dHour = "0" + dHour;
      }
      var date =
        d.getFullYear() +
        "-" +
        (d.getMonth() + 1) +
        "-" +
        d.getDate() +
        " " +
        dHour +
        ":" +
        dMinute;
      return date;
    },
    checkFType(id) {
      for (let i = 0; i < this.foundList.length; i++) {
        if (this.foundList[i]["found_type"] == id) {
          return this.$i18n.locale == "en"
            ? this.foundList[i]["comments_en"]
            : this.foundList[i]["comments_cn"];
        }
      }
    },
    makeToast(variant = null, msg) {
      this.$bvToast.toast(msg, {
        // title: ` ${variant || "default"}`,
        variant: variant,
        solid: true,
      });
    },
    onPageChange(params) {
      this.pageNumber = params.currentPage;
      this.loadItems();
      var container = this.$el.querySelector("#table");
      var top = container.offsetTop;

      window.scrollTo(0, top);
    },
    onSearch() {
      this.pageNumber = 1;
      this.loadItems();
      this.$bvModal.hide("modal-search");
      for (const key in this.searchParam) {
        if (this.searchParam[key].length > 0) {
          this.canClear = true;
        }
      }
    },
    onCancel() {
      this.searchSetup();
      this.canClear = false;
      this.loadItems();
    },

    clearData() {
      if (this.$refs.dropdownObj != undefined) {
        for (let i = 0; i < this.$refs.dropdownObj.length; i++) {
          this.$refs.dropdownObj[i].ej2Instances.value = null;
        }
      }
      this.canEdit = false;
      this.canShow = false;
      this.canSettings = false;
      var self = this;
      self.selectedId = null;
    },
    showModal(row) {
      this.$bvModal.show("modal-1");

      var self = this;
      var contentData = row;
      self.username = contentData.username;
    },
    checkRank(user) {
      if (user.user_group_id == 1) {
        return this.$t("nonMember");
      } else {
        if (this.$i18n.locale == "en") {
          return user.rank.rank_name_en;
        } else {
          return user.rank.rank_name;
        }
      }
    },
    checkLowestRank(userID) {
      for (let i = 0; i < this.user_rank_idOptions.length; i++) {
        if (this.user_rank_idOptions[i].value == userID) {
          return this.user_rank_idOptions[i].text;
        }
      }
    },
    getCountryList() {
      var result = country_list();
      var self = this;
      self.countryOptions = [];
      this.isLoading = true;
      result
        .then(function (value) {
          // console.log(value.data);
          self.countryList = value.data.data;
          for (let i = 0; i < value.data.data.length; i++) {
            var jsonObject = {};
            jsonObject["value"] = value.data.data[i].id;
            jsonObject["text"] =
              self.$i18n.locale == "en"
                ? value.data.data[i].name_en
                : value.data.data[i].name;
            self.countryOptions.push(jsonObject);
          }
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          // localStorage.removeItem("userToken");
          // self.$router.push("/admin/sessions/signIn");
          // self.isLoading = false;
        });
    },
    loadItems() {
      this.adminToken = localStorage.getItem("userToken");
      var search = "";
      for (const item in this.searchParam) {
        var tmp = "&" + item + "=" + this.searchParam[item];
        search = search + tmp;
      }
      // this.getCountryList();
      var result = userWalletRecord(this.pageNumber, search);
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          var dataList = value.data.data.record.data;
          self.rows = dataList;
          self.totalRecords = value.data.data.record.total;
          self.isLoading = false;

          self.selectOptions = [];
          if (value.data.data.found_type) {
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
            self.selectOptions = tmp;
          }
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
  },
  watch: {
    // 'columns': 'searchSetup',
    lang(val) {
      var self = this;
      self.selectOptions = [];
      for (let i = 0; i < self.foundList.length; i++) {
        var jsonObject = {};
        jsonObject["item"] = self.foundList[i].found_type;
        jsonObject["name"] =
          self.$i18n.locale == "en"
            ? self.foundList[i].comments_en
            : self.foundList[i].comments_cn;
        self.selectOptions.push(jsonObject);
      }

      self.countryOptions = [];
      for (let i = 0; i < self.countryList.length; i++) {
        var jsonContry = {};
        jsonContry["value"] = self.countryList[i].id;
        jsonContry["text"] =
          val == "en" ? self.countryList[i].name_en : self.countryList[i].name;
        self.countryOptions.push(jsonContry);
      }
    },
  },
  created() {
    this.searchSetup();
    this.loadItems();
  },
};
</script>
  
  <style>
@import "../../../../node_modules/@syncfusion/ej2-base/styles/material.css";
@import "../../../../node_modules/@syncfusion/ej2-inputs/styles/material.css";
@import "../../../../node_modules/@syncfusion/ej2-vue-dropdowns/styles/material.css";
</style>
  <style>
.hiddenClass {
  pointer-events: none;
  display: none;
}

.bodyWidth {
  min-width: 140px;
}

.dateWidth {
  min-width: 100px;
}

.e-input-group {
  border-width: 1px !important;
  padding: 0px 10px;
  border-radius: 15px;
}
</style>