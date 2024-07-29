 <template>
  <div class="footer_wrap mt-auto" ref="footer">
    <!-- Footer Start -->
    <div class="app-footer">
      <b-row align-h="around" no-gutters>
        <!--<b-col cols="2" >
          <router-link
            tag="a"
            to="/web/dashboard/dashboard"
            class="nav-item-hold"
          >
            <i class="nav-icon i-Dashboard"></i>
            <span class="nav-text">{{ $t("dashboard") }}</span>
          </router-link>
        </b-col>-->
        <b-col cols="3" class="position-relative">
          <div class="borderTop" :class="{ active: path == 'wallet' }"></div>
          <router-link tag="a" to="/web/wallet" class="nav-item-hold">
            <i
              class="nav-icon i-Wallet"
              :class="{ active: path == 'wallet' }"
            ></i>
            <span class="nav-text" :class="{ active: path == 'wallet' }">{{
              $t("dashboard")
            }}</span>
          </router-link>
        </b-col>
        <!-- <b-col cols="auto">
          <router-link tag="a" to="/web/upgradePackage" class="nav-item-hold">
            <i class="nav-icon i-File-Block"></i>
            <span class="nav-text">{{ $t("package") }}</span>
          </router-link>
        </b-col> -->
        <b-col cols="3">
          <div class="borderTop" :class="{ active: path == 'bonus' }"></div>
          <router-link
            tag="a"
            to="/web/bonus/bonusRecord"
            class="nav-item-hold"
          >
            <i class="nav-icon i-Book"
              :class="{ active: path == 'bonus' }"></i>
            <span class="nav-text" :class="{ active: path == 'bonus' }">{{
              $t("record")
            }}</span>
          </router-link>
        </b-col>

        <!--<b-col cols="auto">
          <router-link tag="a" to="/web/registration" class="nav-item-hold">
            <i class="nav-icon i-Add-User"></i>
            <span class="nav-text">{{ $t("register") }}</span>
          </router-link>
        </b-col>-->
        <b-col cols="3">
          <div class="borderTop" :class="{ active: path == 'member' }"></div>
          <router-link tag="a" to="/web/member" class="nav-item-hold">
            <i class="nav-icon i-Business-Mens"
              :class="{ active: path == 'member' }"></i>
            <span class="nav-text" :class="{ active: path == 'member' }">{{
              $t("member")
            }}</span>
          </router-link>
        </b-col>
        <b-col cols="3">
          <div class="borderTop" :class="{ active: path == 'me' }"></div>
          <router-link tag="a" to="/web/me/mePage" class="nav-item-hold">
            <i class="nav-icon i-Administrator"
              :class="{ active: path == 'me' }"></i>
            <span class="nav-text" :class="{ active: path == 'me' }">{{
              $t("profile")
            }}</span>
          </router-link>
        </b-col>
      </b-row>
      <!-- fotter end -->
    </div>
  </div>
</template> 
<script>
import { mapActions } from "vuex";
export default {
  watch: {
    $route() {
      this.changePath();
    },
  },
  data() {
    return {
      path: "",
    };
  },
  methods: {
    ...mapActions(["storeHeight"]),
    handlesize() {
      let height = this.$refs.footer.clientHeight;
      this.storeHeight(height);
    },
    changePath() {
      this.path = this.$route.path.split("/")[2];
      console.log(this.path);
    },
  },
  mounted() {
    this.changePath();
    this.handlesize();
  },
};
</script>


<style lang="scss" scoped>
</style> 