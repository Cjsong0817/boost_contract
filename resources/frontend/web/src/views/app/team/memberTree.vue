<template>
  <div class="main-content position-relative">
    <div
      v-if="isLoading"
      class="
        position-absolute
        h-100
        w-100
        d-flex
        justify-content-center
        align-items-center
      "
      style="background-color: rgba(211, 211, 211, 0.2); z-index: 3"
    >
      <span
        style="
          background-color: #c0dfff;
          color: #409eff;
          padding: 7px 30px;
          border-radius: 3px;
        "
        >{{ $t("loading...") }}</span
      >
    </div>
    <div
      class="position-absolute text-white d-flex align-items-center"
      v-if="getChild"
      @click="backToTop"
      style="top: -2.5rem; right: 4rem"
    >
      <!--<b-button
        @click="backToTop"
        :disabled="!getChild"
        variant="primary"
        class=""
      >
        {{ $t("top") }}
      </b-button>-->
      <p class="font-weight-bold mb-0 mr-2" style="position:fixed!important">{{ $t("top") }} <img height="20px" src="../../../assets/images/member/sort.svg" alt="" /></p>

      
    </div>
    <div
      class="mt-2 px-3 w-100"
      style="height: 73vh; overflow-y: scroll; position: relative"
    >
      <div v-for="(item, index) in getSponsorTree" :key="item.id">
        <b-card
          class="mb-2 px-3 pl-3 py-2 bg-gray"
          no-body
          style="z-index: 1"
          :class="{ 'text-white': index % 2 == 0 }"
        >
          <b-row @click="openChild(item)" no-gutters>
            <b-col cols="6" class="mb-1">
              <b-row no-gutters align-v="center">
                <b-col cols="4">
                  <div class="mx-auto">
                    <img
                      class=""
                      :src="returnIcon(item.rank_en)"
                      @error="imageLoadError"
                      height="45px"
                      width="auto"
                    />
                  </div>
                </b-col>
                <b-col cols="8">
                  <p
                    class="mb-0 text-18 font-weight-bold"
                    style="
                      white-space: nowrap;
                      overflow: hidden;
                      text-overflow: ellipsis;
                    "
                  >
                    {{ item.username }}
                  </p>
                  <p class="text-10 mb-0" style="line-height: 12px">
                    {{ $i18n.locale == "en" ? item.package_en : item.package }}
                  </p>
                </b-col>
              </b-row>
            </b-col>
            <b-col cols="6" class="text-14 mx-0 text-right">
              <div class="text-12 position-relative w-100 mt-2 text-white">
                <div
                  class="position-absolute w-100"
                  style="right: -1.9rem; top: -0.8rem; z-index: -1"
                >
                  <img
                    src="../../../assets/images/member/ribbon.svg"
                    height="35px"
                    alt=""
                  />
                </div>
                <div>
                  {{ $t("rank") }} :
                  {{ $i18n.locale == "en" ? item.rank_en : item.rank }}
                </div>
              </div>
            </b-col>
            <b-col cols="6">
              <b-row class="text-12 mx-0">
                <b-col cols="9" class="px-0"
                  ><p class="mb-0 font-weight-bold">
                    {{ $t("sponsor_amount") }}:
                  </p></b-col
                >
                <b-col class="px-0"
                  ><span class="text-12">{{ item.total_sponsor }}</span></b-col
                >
              </b-row>
              <b-row class="text-12 mx-0">
                <b-col class="px-0" cols="9"
                  ><p class="mb-0 font-weight-bold">{{ $t("team") }}:</p></b-col
                >
                <b-col class="px-0"
                  ><span class="text-12">{{ item.team }}</span></b-col
                >
              </b-row>
            </b-col>
            <b-col cols="6">
              <b-row class="text-12 mx-0">
                <b-col class="px-0" cols="6"
                  ><p class="mb-0 font-weight-bold">{{ $t("sales") }}</p></b-col
                >
                <b-col class="px-0"
                  ><span class="text-12">{{
                    item.sales == null ? 0 : item.sales
                  }}</span></b-col
                >
              </b-row>
              <b-row class="text-12 mx-0">
                <b-col cols="6" class="px-0"
                  ><p class="mb-0 font-weight-bold">
                    {{ $t("joined_date") }}:
                  </p></b-col
                >
                <b-col class="px-0">
                  <span class="text-12">{{ item.join_date }}</span></b-col
                >
              </b-row>
            </b-col>
          </b-row>
        </b-card>
        <div
          v-if="index == 0 && getChild"
          class="d-flex align-items-center mb-2"
        >
          <span class="flex-grow-1" style="border-top: 3px solid #bbb"></span>
          <span class="mx-1 text-white">{{ $t("downline") }}</span>
          <span class="flex-grow-1" style="border-top: 3px solid #bbb"></span>
        </div>
      </div>
    </div>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import { getMemberTree } from "../../../system/api/api";
import Dialog from "../../../components/dialog.vue";
import { handleError } from "../../../system/handleRes";
import { mapGetters, mapActions } from "vuex";
// import VJstree from "vue-jstree";
export default {
  computed: {
    ...mapGetters(["lang", "getSponsorTree", "getChild"]),
  },
  components: {
    Dialog,
    // VJstree,
  },
  data() {
    return {
      username: "",
      editingItem: {},
      editingNode: null,
      canClear: false,
      isChild: false,
      parent: null,
      uid: "",
      asyncData: [],
      testData: [],
      isLoading: true,
      userIcon: require("../../../assets/images/faces/user.png"),
    };
  },
  methods: {
    ...mapActions(["changeSponsorTree", "changeS"]),
    imageLoadError(event) {
      event.target.src = this.userIcon;
    },

    returnIcon(rank) {
      if (rank != null) {
        // return location.origin + this.rank.icon;
        return (
          "https://ibo.greatwallsolution.com/images/rank/" +
          rank.toLowerCase() +
          ".png"
        );
      }
      return "";
    },
    openChild(item) {
      if (item.team > 0) {
        this.loadItems(item.id);
        this.testData = [];
        this.testData.push(item);
        this.changeS(true);
      } else {
        this.$refs.msg.makeToast("warning", this.$t("no_team"));
      }
    },
    backToTop() {
      this.changeS(false);
      this.testData = [];
      this.loadItems(null);
    },
    loadData: async function (oriNode, resolve) {
      var data;

      if (oriNode.data.id) {
        data = await this.loadItems(oriNode.data.id);
      } else {
        data = await this.loadItems(null);
      }

      if (data) {
        resolve(data);
      }
    },

    async loadItems(parent) {
      var userID = parent == null ? encodeURIComponent("#") : parent;
      var result = getMemberTree(userID);
      var self = this;
      this.isLoading = true;
      var returnData;
      returnData = await result
        .then(async function (value) {
          var returnData = value.data.data;
          for (let i = 0; i < returnData.length; i++) {
            self.testData.push(returnData[i]);
          }
          self.changeSponsorTree(self.testData);
          self.isLoading = false;

          return self.testData;
        })
        .catch(function (error) {
          self.isLoading = false;
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
      return returnData;
    },

    processText(info) {
      var name = info["username"] + "-";
      var member =
        this.$i18n.locale == "en" ? info["package_en"] : info["package"];
      var sale =
        info["sales"] != null ? "(Sales:" + info["sales"] + ")" : "(Sales:)";
      var total = "(Total:" + info["total_sponsor"] + ")";
      var active = "(Active:" + info["active"] + ")";

      var text = name + member + sale + total + active;

      return text;
    },
  },
  created() {
    // this.testData = this.getMemberTree;
    // if (this.getSponsorTree.length == 0) {
    //   this.loadItems(null);
    // } else {
    //   this.isLoading = false;
    // }
    this.loadItems(null);
  },
  watch: {},
};
</script>

<style>
.hiddenClass {
  pointer-events: none;
  display: none;
}

.no_checkbox > i.tree-checkbox {
  display: none;
}

.bodyWidth {
  min-width: 120px;
}

.dateWidth {
  min-width: 100px;
}
</style>