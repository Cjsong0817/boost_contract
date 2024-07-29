<template>
  <div class="main-content d-flex flex-column" style="height: 100vh;">
    <div
      class="gradient-banner position-relative"
      style="padding: 8vh 0px; margin-bottom: 6vh"
    >
      <h5 class="text-center">{{ $t("bonus_record") }}</h5>
      <div class="position-absolute w-100 px-4" style="bottom: -4vh">
        <b-row class="gx-1">
          <b-col cols="3">
            <b-card
              :class="{ 'gradient-box': target }"
              class="square-box"
              @click="clear(bonus1)"
              no-body
            >
              <div class="inside-box">
                <div class="text-center mb-2 mx-4">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="100%"
                    height="auto"
                    viewBox="0 0 29.979 18.132"
                  >
                    <g
                      id="baseline-trending_up-24px"
                      transform="translate(-2.75 -8.735)"
                    >
                      <path
                        id="Path_545"
                        data-name="Path 545"
                        d="M22.732,6l3.391,3.391L18.9,16.618l-5.923-5.923L2,21.682,4.088,23.77l8.885-8.885L18.9,20.808l9.329-9.314,3.391,3.391V6Z"
                        transform="translate(0.962 2.885)"
                        :fill="!target ? '#e1c497' : '#fff'"
                        stroke="#97683a"
                        stroke-width="0.3"
                      />
                    </g>
                  </svg>
                </div>
                <h6 class="text-black font-weight-bold text-center text-bottom">
                  {{ $t("special_bonus") }}
                </h6>
              </div>
            </b-card>
          </b-col>
          <b-col cols="3">
            <b-card
              :class="{ 'gradient-box': target2 }"
              class="square-box"
              @click="clear(bonus2)"
              no-body
            >
              <div class="inside-box">
                <div class="text-center mb-2 mx-4">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="23.3"
                    height="23.3"
                    viewBox="0 0 23.3 23.3"
                  >
                    <g
                      id="baseline-equalizer-24px"
                      transform="translate(-5.6 -5.6)"
                    >
                      <path
                        id="Path_631"
                        data-name="Path 631"
                        d="M12.625,27h5.75V4h-5.75ZM4,27H9.75V15.5H4ZM21.25,11.188V27H27V11.188Z"
                        transform="translate(1.75 1.75)"
                        :fill="!target2 ? '#e1c497' : '#fff'"
                        stroke="#97683a"
                        stroke-width="0.3"
                      />
                    </g>
                  </svg>
                </div>
                <h6 class="text-black font-weight-bold text-center text-bottom">
                  {{ $t("dynamic_bonus") }}
                </h6>
              </div>
            </b-card>
          </b-col>
          <b-col cols="3">
            <b-card
              :class="{ 'gradient-box': target3 }"
              class="square-box"
              @click="clear(bonus3)"
              no-body
            >
              <div class="inside-box">
                <div class="text-center mb-2 mx-4">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="31"
                    height="31"
                    viewBox="0 0 31 31"
                  >
                    <g id="emoji_events-24px" transform="translate(0 0.133)">
                      <g id="Bounding_Box">
                        <rect
                          id="Rectangle_340"
                          data-name="Rectangle 340"
                          width="31"
                          height="31"
                          transform="translate(0 -0.133)"
                          fill="none"
                        />
                      </g>
                      <g id="Flat" transform="translate(3.858 3.858)">
                        <g id="Group_511" data-name="Group 511">
                          <path
                            id="Path_6501"
                            data-name="Path 6501"
                            d="M23.578,5.572H21.006V3H8.144V5.572H5.572A2.58,2.58,0,0,0,3,8.144V9.431a6.42,6.42,0,0,0,5.646,6.353,6.443,6.443,0,0,0,4.643,3.807v3.987H8.144V26.15H21.006V23.578H15.861V19.591A6.443,6.443,0,0,0,20.5,15.784,6.42,6.42,0,0,0,26.15,9.431V8.144A2.58,2.58,0,0,0,23.578,5.572ZM5.572,9.431V8.144H8.144v4.913A3.872,3.872,0,0,1,5.572,9.431Zm9,7.717a3.87,3.87,0,0,1-3.858-3.858V5.572h7.717v7.717A3.87,3.87,0,0,1,14.575,17.147Zm9-7.717a3.872,3.872,0,0,1-2.572,3.627V8.144h2.572Z"
                            transform="translate(-3 -3)"
                            :fill="!target3 ? '#e1c497' : '#fff'"
                            stroke="#97683a"
                            stroke-width="0.3"
                          />
                        </g>
                      </g>
                    </g>
                  </svg>
                </div>
                <h6 class="text-black font-weight-bold text-center text-bottom">
                  {{ $t("sponsor_bonus") }}
                </h6>
              </div>
            </b-card>
          </b-col>
          <b-col cols="3">
            <b-card
              :class="{ 'gradient-box': target4 }"
              class="square-box"
              @click="clear(bonus4)"
              no-body
            >
              <div class="inside-box">
                <div class="text-center mb-2 mx-4">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="23.197"
                    height="23.197"
                    viewBox="0 0 23.197 23.197"
                  >
                    <g
                      id="baseline-device_hub-24px"
                      transform="translate(-3.666 -3.666)"
                    >
                      <path
                        id="Path_1395"
                        data-name="Path 1395"
                        d="M20.809,19.537l-5.088-5.088V10.4a3.816,3.816,0,1,0-2.544,0v4.045L8.088,19.537H3V25.9H9.36v-3.88l5.088-5.343,5.088,5.343V25.9H25.9v-6.36Z"
                        transform="translate(0.816 0.816)"
                        :fill="!target4 ? '#e1c497' : '#fff'"
                        stroke="#97683a"
                        stroke-width="0.3"
                      />
                    </g>
                  </svg>
                </div>
                <h6 class="text-black font-weight-bold text-center text-bottom">
                  {{ $t("level_bonus") }}
                </h6>
              </div>
            </b-card>
          </b-col>
        </b-row>
      </div>
    </div>
    <div
      class="mx-4 my-2 bg-white"
      style="
        flex-grow: 1;
        border-radius: 10px;
        padding-bottom: 15vh;
        position: relative;
        overflow-y: scroll;
      "
    >
      <div v-for="item in dataList" :key="item.id">
        <div class="px-3 py-2">
          <b-row align-v="center">
            <b-col cols="7">
              <p class="mb-0"
                style="line-height: 18px">
                {{ $i18n.locale == "zh" ? item.detail : item.detailen }}
              </p>
            </b-col>
            <b-col cols="5" class="text-right">
              <p
                class="font-weight-bolder mb-0 text-20"
                style="line-height: 16px"
              >
                {{ item.current }}
              </p>
              <span class="text-10 font-weight-bold" style="line-height: 10px; letter-spacing: normal; color: rgb(127,127,127);">{{ item.updated_at }}</span>
            </b-col>
          </b-row>
        </div>
        <div class="mx-3" style="height:1px; background-color: gray;"> </div>
      </div>
      <!--<b-card v-for="item in dataList" :key="item.id" class="mb-2 mt-3">
        <b-row align-v="center">
          <b-col cols="7">
            <p class="mb-1">
              {{ $i18n.locale == "zh" ? item.detail : item.detailen }}
            </p>
            <span>{{ item.updated_at }}</span>
          </b-col>
          <b-col cols="5">
            <span> {{ $t("total") }} : {{ item.current }}<br /> </span>
          </b-col>
        </b-row>
      </b-card>-->

      <b-button
        v-if="currentPage <= lastPage || isLoading"
        class="mx-auto submit_button mb-5 mt-3"
        variant="primary"
        @click="loadItems"
        >{{ isLoading ? $t("loading...") : $t("load_more") }}</b-button
      >

      <div
        v-else-if="dataList.length == 0"
        style="
          position: absolute;
          top: 50%;
          left: 50%;
          transform: translate(-50%, -50%);
        "
      >
        <p>No Data</p>
      </div>
    </div>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import { getUserBonusRecord } from "../../../system/api/api";
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
      tabIndex: 0,
      isLoading: true,
      point1: "point1",
      point2: "point2",
      dataList: [],
      canClear: false,
      bonus1: "special_bonus",
      bonus2: "dynamic_bonus",
      bonus3: "sponsor_bonus",
      bonus4: "level_bonus",
      pageNumber: 1,
      currentPage: 1,
      lastPage: 1,
      target: true,
      target2: false,
      target3: false,
      target4: false,
      bonusName: "special_bonus",
    };
  },
  props: ["success"],
  methods: {
    clear(bonus) {
      this.isLoading = true;
      this.dataList = [];
      this.currentPage = 1;
      this.loadItems2(bonus);
      if (bonus == "special_bonus") {
        this.target = true;
        this.target2 = false;
        this.target3 = false;
        this.target4 = false;
        this.bonusName = "special_bonus";
      } else if (bonus == "dynamic_bonus") {
        this.target = false;
        this.target2 = true;
        this.target3 = false;
        this.target4 = false;
        this.bonusName = "dynamic_bonus";
      } else if (bonus == "sponsor_bonus") {
        this.target = false;
        this.target2 = false;
        this.target3 = true;
        this.target4 = false;
        this.bonusName = "sponsor_bonus";
      } else if (bonus == "level_bonus") {
        this.target = false;
        this.target2 = false;
        this.target3 = false;
        this.target4 = true;
        this.bonusName = "level_bonus";
      }
    },
    loadItems(wallet) {
      var result = getUserBonusRecord(wallet, 1);
      var self = this;
      self.isLoading = true;
      result
        .then(function (value) {
          var dataList = value.data.data.data;
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
    loadItems2(bonus) {
      var result = getUserBonusRecord(bonus, this.currentPage);
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          var _data = value.data.data;
          var _list = _data.record.data;
          console.log(_data.record);
          self.currentPage += 1;
          self.lastPage = _data.last_page;
          for (let i = 0; i < _list.length; i++) {
            self.dataList.push(_list[i]);
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
    this.loadItems2("special_bonus");
  },
};
</script>

<style>
.gx-1 {
  margin-right: -5px;
  margin-left: -5px;
}
.gx-1 > .col,
.gx-1 > [class*="col-"] {
  padding-right: 5px;
  padding-left: 5px;
}
</style>