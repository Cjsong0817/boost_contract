<template>
  <div class="app-admin-wrap layout-sidebar-large clearfix">
    <top-nav />

    <sidebar />

    <main>
      <div
        :class="{ 'sidenav-open': getSideBarToggleProperties.isSideNavOpen }"
        class="main-content-wrap d-flex flex-column"
      >
        <transition name="page" mode="out-in">
          <router-view />
        </transition>
        <appFooter />
      </div>
    </main>
  </div>
</template>

<script>
import Sidebar from "./Sidebar";
import TopNav from "./TopNav";
import appFooter from "../common/footer";
import { mapGetters } from "vuex";

export default {
  components: {
    Sidebar,
    TopNav,
    appFooter,
  },
  data() {
    return {};
  },
  computed: {
    ...mapGetters(["getSideBarToggleProperties"]),
  },
  
};
</script>
<style>
</style>