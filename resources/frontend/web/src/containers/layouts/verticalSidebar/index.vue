<template>
  <div class="app-admin-wrap layout-sidebar-vertical clearfix sidebar-full">
    <!-- <verticalSidebar v-bind:unread='count'/> -->
    <main>
      <div
        class="main-content-wrap mt-0 d-flex flex-column p-0"
        :class="{
          'vertical-sidebar': getVerticalSidebar.isVerticalSidebar,
          compact: getVerticalSidebar.isVerticalCompact,
        }"
        style="max-height: 100vh; max-width: 100vw"
      >
        <!-- <verticalTopbar/> -->
        <transition name="page" mode="out-in">
          <router-view />
        </transition>
        <appFooter />
      </div>
    </main>
    <b-modal
      id="modal-news"
      size="md"
      centered
      :title="$t('news')"
      :hide-footer="true"
      style="background-color: #5f646e !important"
    >
      <b-row class="mx-0" v-if="item">
        <b-col cols="12" class="px-2">
          <div class="imgbox">
            <img :src="item.public_path" alt="" height="100%" />
          </div>
        </b-col>
        <b-col cols="12">
          <h6 class="text-black" style="text-align: right !important">
            {{ item.created_at }}
          </h6>
        </b-col>
        <b-col cols="12">
          <h3 class="text-black font-weight-bold" style="margin-bottom: 10px">
            {{ item.title }}
          </h3>
        </b-col>
        <b-col cols="12">
          <h5 class="text-black" style="margin-bottom: 10px">
            {{ item.description }}
          </h5>
        </b-col>
        <b-col cols="12">
          <h5 class="text-black" style="margin-bottom: 10px">
            {{ $t('winato') }}
          </h5>
        </b-col>
      </b-row>
    </b-modal>
  </div>
</template>
<script>
// import verticalSidebar from "./verticalSidebar";
// import verticalTopbar from "./verticalTopbar";
import appFooter from "../common/footer";
import { mapGetters } from "vuex";
import { getUserNewsList } from "../../../system/api/api";
import { handleError } from "../../../system/handleRes";

export default {
  components: {
    // verticalSidebar,
    // verticalTopbar,
    appFooter,
  },
  computed: {
    ...mapGetters(["getVerticalSidebar"]),
  },
  data() {
    return {
      count: 0,
      item: null,
    };
  },
  methods: {
    getNews() {
      var result = getUserNewsList(
        this.$i18n.locale == "en" ? "en" : "cn",
        1,
        this.currentPage
      );
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          self.item = value.data.data.latest;
          var check = localStorage.getItem("can_pop");
          if (self.item != null) {
            if (check == null) {
              self.$bvModal.show("modal-news");
              localStorage.setItem("can_pop", 0);
            } else if (check == 1) {
              self.$bvModal.show("modal-news");
              localStorage.setItem("can_pop", 0);
            }
          }
        })
        .catch(function (error) {
          self.isLoading = false;
          self.$root.makeToast("warning", self.$t(handleError(error)));
        });
    },
  },
  created() {
    this.getNews();
  },
};
</script>

<style scoped>
.imgbox {
  height: 20vh;
}

.imgbox img {
  height: 100%;
  display: block;
  margin: auto;
}
</style>
