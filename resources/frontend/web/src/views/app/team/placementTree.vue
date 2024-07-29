<template>
  <div class="main-content mb-5 position-relative">
    <div
      v-if="isLoading"
      style="
        position: absolute;
        background-color: rgba(211, 211, 211, 0.2);
        height: 100%;
        width: 100%;
        z-index: 3;
        display: flex;
        justify-content: center;
        align-items: center;
      "
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
    <div class="">
      <div class="d-flex justify-content-end mb-2">
        <b-button
          @click="upOneLevel"
          :disabled="!getSelectedP"
          variant="primary"
          class="mr-1"
        >
          {{ $t("up_one_level") }}
        </b-button>
        <b-button
          @click="backToTop"
          :disabled="!getSelectedP"
          variant="primary"
        >
          {{ $t("top") }}
        </b-button>
      </div>

      <div class="d-flex mx-auto" style="max-height: 75vh; overflow: scroll">
        <div v-if="placementList.length > 0">
          <div class="d-flex flex-grow-1 justify-content-around">
            <div class="d-flex flex-column">
              <!-- 1 -->
              <Node :item="placementList[0]"></Node>
              <div class="vl"></div>
              <div class="d-flex flex-grow-1 justify-content-around">
                <div class="d-flex flex-column">
                  <!-- 21 -->
                  <div class="hl"></div>
                  <div class="vl"></div>
                  <Node
                    :item="placementList[1]"
                    group="A"
                    :previous="placementList[0]"
                  ></Node>
                  <div class="vl"></div>
                  <div class="d-flex flex-grow-1 justify-content-around">
                    <div class="d-flex flex-column">
                      <!-- 31 -->
                      <div class="hl"></div>
                      <div class="vl"></div>
                      <Node
                        :item="placementList[3]"
                        group="A"
                        :previous="placementList[1]"
                      ></Node>
                      <div class="vl"></div>
                      <div class="d-flex flex-grow-1 justify-content-around">
                        <div class="d-flex flex-column">
                          <!-- 41 -->
                          <div class="hl"></div>
                          <div class="vl"></div>
                          <Node
                            :item="placementList[7]"
                            group="A"
                            :previous="placementList[3]"
                          ></Node>
                          <div
                            class="d-flex flex-grow-1 justify-content-around"
                          ></div>
                        </div>
                        <div class="d-flex flex-column">
                          <!-- 42 -->
                          <div class="hr"></div>
                          <div class="vl"></div>
                          <Node
                            :item="placementList[8]"
                            group="B"
                            :previous="placementList[3]"
                          ></Node>
                          <div
                            class="d-flex flex-grow-1 justify-content-around"
                          ></div>
                        </div>
                      </div>
                    </div>
                    <div class="d-flex flex-column">
                      <!-- 32 -->
                      <div class="hr"></div>
                      <div class="vl"></div>
                      <Node
                        :item="placementList[4]"
                        group="B"
                        :previous="placementList[1]"
                      ></Node>
                      <div class="vl"></div>
                      <div class="d-flex flex-grow-1 justify-content-around">
                        <div class="d-flex flex-column">
                          <!-- 43 -->
                          <div class="hl"></div>
                          <div class="vl"></div>
                          <Node
                            :item="placementList[9]"
                            group="A"
                            :previous="placementList[4]"
                          ></Node>
                          <div
                            class="d-flex flex-grow-1 justify-content-around"
                          ></div>
                        </div>
                        <div class="d-flex flex-column">
                          <!-- 44 -->
                          <div class="hr"></div>
                          <div class="vl"></div>
                          <Node
                            :item="placementList[10]"
                            group="B"
                            :previous="placementList[4]"
                          ></Node>
                          <div
                            class="d-flex flex-grow-1 justify-content-around"
                          ></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="d-flex flex-column">
                  <!-- 22 -->
                  <div class="hr"></div>
                  <div class="vl"></div>
                  <Node
                    :item="placementList[2]"
                    group="B"
                    :previous="placementList[0]"
                  ></Node>
                  <div class="vl"></div>
                  <div class="d-flex flex-grow-1 justify-content-around">
                    <div class="d-flex flex-column">
                      <!-- 33 -->
                      <div class="hl"></div>
                      <div class="vl"></div>
                      <Node
                        :item="placementList[5]"
                        group="A"
                        :previous="placementList[2]"
                      ></Node>
                      <div class="vl"></div>
                      <div class="d-flex flex-grow-1 justify-content-around">
                        <div class="d-flex flex-column">
                          <!-- 45 -->
                          <div class="hl"></div>
                          <div class="vl"></div>
                          <Node
                            :item="placementList[11]"
                            group="A"
                            :previous="placementList[5]"
                          ></Node>
                          <div
                            class="d-flex flex-grow-1 justify-content-around"
                          ></div>
                        </div>
                        <div class="d-flex flex-column">
                          <!-- 46 -->
                          <div class="hr"></div>
                          <div class="vl"></div>
                          <Node
                            :item="placementList[12]"
                            group="B"
                            :previous="placementList[5]"
                          ></Node>
                          <div
                            class="d-flex flex-grow-1 justify-content-around"
                          ></div>
                        </div>
                      </div>
                    </div>
                    <div class="d-flex flex-column">
                      <!-- 34 -->
                      <div class="hr"></div>
                      <div class="vl"></div>
                      <Node
                        :item="placementList[6]"
                        group="B"
                        :previous="placementList[2]"
                      ></Node>
                      <div class="vl"></div>
                      <div class="d-flex flex-grow-1 justify-content-around">
                        <div class="d-flex flex-column">
                          <!-- 47 -->
                          <div class="hl"></div>
                          <div class="vl"></div>
                          <Node
                            :item="placementList[13]"
                            group="A"
                            :previous="placementList[6]"
                          ></Node>
                          <div
                            class="d-flex flex-grow-1 justify-content-around"
                          ></div>
                        </div>
                        <div class="d-flex flex-column">
                          <!-- 48 -->
                          <div class="hr"></div>
                          <div class="vl"></div>
                          <Node
                            :item="placementList[14]"
                            group="B"
                            :previous="placementList[6]"
                          ></Node>
                          <div
                            class="d-flex flex-grow-1 justify-content-around"
                          ></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import { getPlacementTree } from "../../../system/api/api";
import Dialog from "../../../components/dialog.vue";
import { handleError } from "../../../system/handleRes";
import { mapGetters, mapActions } from "vuex";
import Node from "./placementUnit.vue";
export default {
  computed: {
    ...mapGetters(["lang", "getSelectedP"]),
  },
  components: {
    Dialog,
    Node,
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
      placementList: [],
      isLoading: true,
      userIcon: require("../../../assets/images/faces/user.png"),
    };
  },
  methods: {
    ...mapActions([]),
    imageLoadError(event) {
      event.target.src = this.userIcon;
    },
    backToTop() {
      this.placementList = [];
      this.loadItems(null);
    },
    upOneLevel(){
      this.loadItems(this.getSelectedP);

    },

    async loadItems(parent) {
      this.placementList = [];
      var userID = parent == null ? encodeURIComponent("#") : parent;
      var result = getPlacementTree(userID);
      var self = this;
      this.isLoading = true;
      var returnData;
      returnData = await result
        .then(async function (value) {
          self.placementList = value.data.data;
          self.isLoading = false;
        })
        .catch(function (error) {
          self.isLoading = false;
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
      return returnData;
    },
  },
  created() {
    // this.placementList = this.getMemberTree;
    // if (this.getSponsorTree.length == 0) {
    //   this.loadItems(null);
    // } else {
    //   this.isLoading = false;
    // }
    this.loadItems(this.getSelectedP);
  },
  watch: {},
};
</script>

<style>
.vl {
  background-color: black;
  height: 25px;
  width: 3px;
  display: block;
  margin: 0 auto;
}

.hl {
  background-color: black;
  height: 3px;
  width: 50%;
  display: block;
  margin-left: auto;
}

.hr {
  background-color: black;
  height: 3px;
  width: 50%;
  display: block;
  margin-right: auto;
}
</style>