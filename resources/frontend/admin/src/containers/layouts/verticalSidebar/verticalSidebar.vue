<template>
  <vue-perfect-scrollbar class="sidebar-panel rtl-ps-none ps scroll" @mouseleave.native="
  sidebarCompact();
returnSelectedParentMenu();
  " @mouseenter.native="removeSidebarCompact" :class="{
    'vertical-sidebar-compact': getVerticalCompact.isSidebarCompact,
    'sidebar-full-collapse': getVerticalSidebar.isMobileCompact,
  }" :settings="{ suppressScrollX: true, wheelPropagation: false }">
    <div>
      <div class="
          gull-brand
          text-center
          d-flex
          align-items-center
          pl-2
          mb-2
          justify-content-between
        ">
        <!-- <div><img class="" src="../../../assets/images/logo.png" /></div> -->
        <!-- <div class="toggle-sidebar-compact">
          <label class="switch ul-switch switch-primary ml-auto">
            <input @click="switchSidebar" type="checkbox" />
            <span class="ul-slider o-hidden"></span>
          </label>
        </div> -->
      </div>

      <div class="close-mobile-menu" @click="mobileSidebar">
        <i class="text-16 text-primary i-Close-Window font-weight-bold"></i>
      </div>

      <div class="mt-4 main-menu">
        <ul class="ul-vertical-sidebar pl-4" id="menu">
          <li class="Ul_li--hover">
            <a class="has-arrow" href="/manage/dashboard/dashboard"
              :class="{ active: selectedParentMenu == 'dashboard' }">
              <i class="i-Home1 text-20 mr-2"></i>
              <span class="text-15" :class="{
                'vertical-item-name': getVerticalCompact.isItemName,
              }">{{ $t("dashboard") }}</span>
            </a>
          </li>

          <li class="Ul_li--hover">
            <div v-b-toggle.accordion-1>
              <a class="has-arrow" href="#" :class="{ active: selectedParentMenu == 'users' }">
                <i class="i-Business-Mens text-20 mr-2"></i>
                <span class="text-15" :class="{
                  'vertical-item-name': getVerticalCompact.isItemName,
                }">{{ $t("userManage") }}</span>
                <arrowIcon />
              </a>
            </div>
            <b-collapse accordion="my-accordion" id="accordion-1">
              <ul class="Ul_collapse" :class="{ 'vertical-item-name': getVerticalCompact.isItemName }">
                <li>
                  <router-link tag="a" class to="/manage/users/user">
                    <i class="i-Circular-Point mr-2"></i>
                    <span>{{ $t("userList") }}</span>
                  </router-link>
                </li>
                <li>
                  <router-link tag="a" class to="/manage/users/userKyc">
                    <i class="i-Circular-Point mr-2"></i>
                    <span>{{ $t("user_kyc") }}</span>
                  </router-link>
                </li>
                <li>
                  <router-link tag="a" class to="/manage/users/userKycHis">
                    <i class="i-Circular-Point mr-2"></i>
                    <span>{{ $t("user_kyc_history") }}</span>
                  </router-link>
                </li>
                <li>
                  <router-link tag="a" class to="/manage/users/registerMember">
                    <i class="i-Circular-Point mr-2"></i>
                    <span>{{ $t("registerMember") }}</span>
                  </router-link>
                </li>
                <!-- <li>
                  <router-link tag="a" class to="/manage/users/contactOtp">
                    <i class="i-Circular-Point mr-2"></i>
                    <span>{{ $t("send_otp") }}</span>
                  </router-link>
                </li> -->
              </ul>
            </b-collapse>
          </li>

          <li class="Ul_li--hover">
            <div v-b-toggle.accordion-12>
              <a class="has-arrow" href="#" :class="{ active: selectedParentMenu == 'transaction' }">
                <i class="i-Security-Check text-20 mr-2"></i>
                <span class="text-15" :class="{
                  'vertical-item-name': getVerticalCompact.isItemName,
                }">{{ $t("transaction") }}</span>
                <arrowIcon />
              </a>
            </div>
            <b-collapse accordion="my-accordion" id="accordion-12">
              <ul class="Ul_collapse" :class="{ 'vertical-item-name': getVerticalCompact.isItemName }">
                <li>
                  <router-link tag="a" class to="/manage/transaction/record">
                    <i class="i-Circular-Point mr-2"></i>
                    <span>{{ $t("transaction_record") }}</span>
                  </router-link>
                </li>
              </ul>
            </b-collapse>
          </li>

          <li class="Ul_li--hover">
            <div v-b-toggle.accordion-20>
              <a class="has-arrow" href="#" :class="{ active: selectedParentMenu == 'follower' }">
                <i class="i-Security-Check text-20 mr-2"></i>
                <span class="text-15" :class="{
                  'vertical-item-name': getVerticalCompact.isItemName,
                }">{{ $t("follower") }}</span>
                <arrowIcon />
              </a>
            </div>
            <b-collapse accordion="my-accordion" id="accordion-20">
              <ul class="Ul_collapse" :class="{ 'vertical-item-name': getVerticalCompact.isItemName }">
                <li>
                  <router-link tag="a" class to="/manage/follower/followList">
                    <i class="i-Circular-Point mr-2"></i>
                    <span>{{ $t("followList") }}</span>
                  </router-link>
                </li>

                <li>
                  <router-link tag="a" class to="/manage/follower/unFollowList">
                    <i class="i-Circular-Point mr-2"></i>
                    <span>{{ $t("unFollowList") }}</span>
                  </router-link>
                </li>
                <li>
                  <router-link tag="a" class to="/manage/follower/followerUserList">
                    <i class="i-Circular-Point mr-2"></i>
                    <span>{{ $t("followerUserList") }}</span>
                  </router-link>
                </li>
                <li>
                  <router-link tag="a" class to="/manage/follower/followClaimList">
                    <i class="i-Circular-Point mr-2"></i>
                    <span>{{ $t("followClaimList") }}</span>
                  </router-link>
                </li>

              </ul>
            </b-collapse>
          </li>

          <li class="Ul_li--hover">
            <div v-b-toggle.accordion-11>
              <a class="has-arrow" href="#" :class="{ active: selectedParentMenu == 'insurance' }">
                <i class="i-Security-Check text-20 mr-2"></i>
                <span class="text-15" :class="{
                  'vertical-item-name': getVerticalCompact.isItemName,
                }">{{ $t("insurance") }}</span>
                <arrowIcon />
              </a>
            </div>
            <b-collapse accordion="my-accordion" id="accordion-11">
              <ul class="Ul_collapse" :class="{ 'vertical-item-name': getVerticalCompact.isItemName }">
                <li>
                  <router-link tag="a" class to="/manage/insurance/insuranceList">
                    <i class="i-Circular-Point mr-2"></i>
                    <span>{{ $t("claim_list") }}</span>
                  </router-link>
                </li>
                <li>
                  <router-link tag="a" class to="/manage/insurance/claimHis">
                    <i class="i-Circular-Point mr-2"></i>
                    <span>{{ $t("claim_his") }}</span>
                  </router-link>
                </li>
                <li>
                  <router-link tag="a" class to="/manage/insurance/revertInsurance">
                    <i class="i-Circular-Point mr-2"></i>
                    <span>{{ $t("revert_claim") }}</span>
                  </router-link>
                </li>
                <li>
                  <router-link tag="a" class to="/manage/insurance/surrenderList">
                    <i class="i-Circular-Point mr-2"></i>
                    <span>{{ $t("surrenderList") }}</span>
                  </router-link>
                </li>
                <li>
                  <router-link tag="a" class to="/manage/insurance/surrenderHis">
                    <i class="i-Circular-Point mr-2"></i>
                    <span>{{ $t("surrenderHis") }}</span>
                  </router-link>
                </li>

                <!-- <li>
                  <router-link tag="a" class to="/manage/insurance/followList">
                    <i class="i-Circular-Point mr-2"></i>
                    <span>{{ $t("followList") }}</span>
                  </router-link>
                </li>

                <li>
                  <router-link tag="a" class to="/manage/insurance/unFollowList">
                    <i class="i-Circular-Point mr-2"></i>
                    <span>{{ $t("unFollowList") }}</span>
                  </router-link>
                </li> -->

              </ul>
            </b-collapse>
          </li>

          <li class="Ul_li--hover">
            <div v-b-toggle.accordion-10>
              <a class="has-arrow" href="#" :class="{ active: selectedParentMenu == 'package' }">
                <i class="i-Box-Full text-20 mr-2"></i>
                <span class="text-15" :class="{
                  'vertical-item-name': getVerticalCompact.isItemName,
                }">{{ $t("package") }}</span>
                <arrowIcon />
              </a>
            </div>
            <b-collapse accordion="my-accordion" id="accordion-10">
              <ul class="Ul_collapse" :class="{ 'vertical-item-name': getVerticalCompact.isItemName }">
                <li>
                  <router-link tag="a" class to="/manage/package/packageManage">
                    <i class="i-Circular-Point mr-2"></i>
                    <span>{{ $t("packageManage") }}</span>
                  </router-link>
                </li>
                <li>
                  <router-link tag="a" class to="/manage/package/packageHis">
                    <i class="i-Circular-Point mr-2"></i>
                    <span>{{ $t("packageHis") }}</span>
                  </router-link>
                </li>
              </ul>
            </b-collapse>
          </li>

          <li class="Ul_li--hover">
            <div v-b-toggle.accordion-4>
              <a class="has-arrow" href="#" :class="{ active: selectedParentMenu == 'country' }">
                <i class="i-Flag-2 text-20 mr-2"></i>
                <span class="text-15" :class="{
                  'vertical-item-name': getVerticalCompact.isItemName,
                }">{{ $t("country") }}</span>
                <arrowIcon />
              </a>
            </div>
            <b-collapse accordion="my-accordion" id="accordion-4">
              <ul class="Ul_collapse" :class="{ 'vertical-item-name': getVerticalCompact.isItemName }">
                <li>
                  <router-link tag="a" class to="/manage/country/countryManage">
                    <i class="i-Circular-Point mr-2"></i>
                    <span>{{ $t("country") }}</span>
                  </router-link>
                </li>
                <!-- <li>
                  <router-link tag="a" to="/manage/country/bankManage">
                    <i class="i-Circular-Point mr-2"></i>
                    <span class="">{{ $t("bank_list") }}</span>
                  </router-link>
                </li> -->
              </ul>
            </b-collapse>
          </li>

          <li class="Ul_li--hover">
            <div v-b-toggle.accordion-16>
              <a class="has-arrow" href="#" :class="{ active: selectedParentMenu == 'team' }">
                <i class="i-Business-Mens text-20 mr-2"></i>
                <span class="text-15" :class="{
                  'vertical-item-name': getVerticalCompact.isItemName,
                }">{{ $t("team") }}</span>
                <arrowIcon />
              </a>
            </div>
            <b-collapse accordion="my-accordion" id="accordion-16">
              <ul class="Ul_collapse" :class="{ 'vertical-item-name': getVerticalCompact.isItemName }">
                <li>
                  <router-link tag="a" class to="/manage/team/memberTree">
                    <i class="i-Circular-Point mr-2"></i>
                    <span>{{ $t("memberTree") }}</span>
                  </router-link>
                </li>
                <li>
                  <router-link tag="a" class to="/manage/team/teamReport">
                    <i class="i-Circular-Point mr-2"></i>
                    <span>{{ $t("teamReport") }}</span>
                  </router-link>
                </li>
              </ul>
            </b-collapse>
          </li>

          <li class="Ul_li--hover">
            <div v-b-toggle.accordion-2>
              <a class="has-arrow" href="#" :class="{ active: selectedParentMenu == 'wallet' }">
                <i class="i-Wallet text-20 mr-2"></i>
                <span class="text-15" :class="{
                  'vertical-item-name': getVerticalCompact.isItemName,
                }">{{ $t("walletManage") }}</span>
                <arrowIcon />
              </a>
            </div>
            <b-collapse accordion="my-accordion" id="accordion-2">
              <ul class="Ul_collapse" :class="{ 'vertical-item-name': getVerticalCompact.isItemName }">
                <li>
                  <router-link tag="a" to="/manage/wallet/walletChangeRec">
                    <i class="i-Circular-Point mr-2"></i>
                    <span class="">{{ $t("changeRecord") }}</span>
                  </router-link>
                </li>
              </ul>
            </b-collapse>
          </li>
          <li class="Ul_li--hover">
            <div v-b-toggle.accordion-15>
              <a class="has-arrow" href="#" :class="{ active: selectedParentMenu == 'deposit' }">
                <i class="i-Financial text-20 mr-2"></i>
                <span class="text-15" :class="{
                  'vertical-item-name': getVerticalCompact.isItemName,
                }">{{ $t("depositManage") }}</span>
                <arrowIcon />
              </a>
            </div>
            <b-collapse accordion="my-accordion" id="accordion-15">
              <ul class="Ul_collapse" :class="{ 'vertical-item-name': getVerticalCompact.isItemName }">
                <li>
                  <router-link tag="a" to="/manage/deposit/reloadDeposit">
                    <i class="i-Circular-Point mr-2"></i>
                    <span class="">{{ $t("reloadRecord") }}</span>
                  </router-link>
                </li>
              </ul>
            </b-collapse>
          </li>
          <li class="Ul_li--hover">
            <div v-b-toggle.accordion-14>
              <a class="has-arrow" href="#" :class="{ active: selectedParentMenu == 'withdraw' }">
                <i class="i-Inbox-Out text-20 mr-2"></i>
                <span class="text-15" :class="{
                  'vertical-item-name': getVerticalCompact.isItemName,
                }">{{ $t("withdrawManage") }}</span>
                <arrowIcon />
              </a>
            </div>
            <b-collapse accordion="my-accordion" id="accordion-14">
              <ul class="Ul_collapse" :class="{ 'vertical-item-name': getVerticalCompact.isItemName }">
                <li>
                  <router-link tag="a" to="/manage/withdraw/withdrawList">
                    <i class="i-Circular-Point mr-2"></i>
                    <span class="">{{ $t("withdrawList") }}</span>
                  </router-link>
                </li>
                <li>
                  <router-link tag="a" to="/manage/withdraw/withdrawHistory">
                    <i class="i-Circular-Point mr-2"></i>
                    <span class="">{{ $t("withdrawHistory") }}</span>
                  </router-link>
                </li>
                <!-- <li>
                  <router-link tag="a" to="/manage/withdraw/withdrawCash">
                    <i class="i-Circular-Point mr-2"></i>
                    <span class="">{{ $t("withdrawCash") }}</span>
                  </router-link>
                </li>
                <li>
                  <router-link tag="a" to="/manage/withdraw/withdrawCashHistory">
                    <i class="i-Circular-Point mr-2"></i>
                    <span class="">{{ $t("withdrawCashHistory") }}</span>
                  </router-link>
                </li> -->
              </ul>
            </b-collapse>
          </li>
          <li class="Ul_li--hover">
            <div v-b-toggle.accordion-13>
              <a class="has-arrow" href="#" :class="{ active: selectedParentMenu == 'record' }">
                <i class="nav-icon i-Money-Bag text-20 mr-2"></i>
                <span class="text-15" :class="{
                  'vertical-item-name': getVerticalCompact.isItemName,
                }">{{ $t("bonusRecord") }}</span>
                <arrowIcon />
              </a>
            </div>
            <b-collapse accordion="my-accordion" id="accordion-13">
              <ul class="Ul_collapse" :class="{ 'vertical-item-name': getVerticalCompact.isItemName }">
                <li>
                  <router-link tag="a" to="/manage/record/sponsor" class href="#">
                    <i class="i-Circular-Point mr-2"></i>
                    <span class="">{{ $t("sponsor_bonus") }}</span>
                  </router-link>
                </li>
                <li>
                  <router-link tag="a" to="/manage/record/level" class href="#">
                    <i class="i-Circular-Point mr-2"></i>
                    <span class="">{{ $t("level_bonus") }}</span>
                  </router-link>
                </li>
                <li>
                  <router-link tag="a" to="/manage/record/dynamic" class href="#">
                    <i class="i-Circular-Point mr-2"></i>
                    <span class="">{{ $t("dynamic_bonus") }}</span>
                  </router-link>
                </li>
                <li>
                  <router-link tag="a" to="/manage/record/special" class href="#">
                    <i class="i-Circular-Point mr-2"></i>
                    <span class="">{{ $t("special_bonus") }}</span>
                  </router-link>
                </li>
              </ul>
            </b-collapse>
          </li>

          <li class="Ul_li--hover">
            <div v-b-toggle.accordion-7>
              <a class="has-arrow" href="#" :class="{ active: selectedParentMenu == 'internal' }">
                <i class="nav-icon i-Management text-20 mr-2"></i>
                <span class="text-15" :class="{
                  'vertical-item-name': getVerticalCompact.isItemName,
                }">{{ $t("newsManage") }}</span>

                <arrowIcon />
              </a>
            </div>
            <b-collapse accordion="my-accordion" id="accordion-7">
              <ul class="Ul_collapse" :class="{ 'vertical-item-name': getVerticalCompact.isItemName }">
                <li class="item-name">
                  <router-link tag="a" to="/manage/internal/article" class>
                    <i class="i-Circular-Point mr-2"></i>
                    <span class="">{{ $t("newsList") }}</span>
                  </router-link>
                </li>
                <!-- <li class="item-name">
                <router-link
                  tag="a"
                  to="/manage/internal/classification"
                  class
                  href="#"
                >
                  <i class="i-Circular-Point mr-2 "></i>
                  <span class="">分类管理</span>
                </router-link>
              </li>
              <li class="item-name">
                <router-link
                  tag="a"
                  to="/manage/internal/internal-page"
                  class
                  href="#"
                >
                  <i class="i-Circular-Point mr-2 "></i>
                  <span class="">内页管理</span>
                </router-link>
              </li>
              <li class="item-name">
                <router-link
                  tag="a"
                  to="/manage/internal/pages"
                  class
                  href="#"
                >
                  <i class="i-Circular-Point mr-2 "></i>
                  <span class="">页面管理</span>
                </router-link>
              </li>
              <li class="item-name">
                <router-link
                  tag="a"
                  to="/manage/internal/article-tag"
                  class
                  href="#"
                >
                  <i class="i-Circular-Point mr-2 "></i>
                  <span class="">文章标签</span>
                </router-link>
              </li> -->
              </ul>
            </b-collapse>
          </li>
          <!-- <li class="Ul_li--hover">
          <div v-b-toggle.accordion-8>
            <a class="has-arrow " href="#" :class="{ active: selectedParentMenu == 'plug-in' }">
              <i class="nav-icon i-File-Horizontal-Text text-20 mr-2 "></i>
              <span
                class="text-15 "
                :class="{ 'vertical-item-name': getVerticalCompact.isItemName }"
                >插件中心</span
              >
              <arrowIcon />
            </a>
          </div>
          <b-collapse accordion="my-accordion" id="accordion-8">
            <ul
              class="Ul_collapse"
              :class="{ 'vertical-item-name': getVerticalCompact.isItemName }"
            >
              <li class="item-name">
                <router-link tag="a" to="/manage/plug-in/hook" class href="#">
                  <i class="i-Circular-Point mr-2 "></i>
                  <span class="">钩子管理</span>
                </router-link>
              </li>
            </ul>
          </b-collapse>
        </li>
        <li class="Ul_li--hover">
          <div v-b-toggle.accordion-9>
            <a class="has-arrow " href="#" :class="{ active: selectedParentMenu == 'system-log' }">
              <i class="nav-icon i-Administrator text-20 mr-2 "></i>
              <span
                class="text-15 "
                :class="{ 'vertical-item-name': getVerticalCompact.isItemName }"
                >系统日志</span
              >
              <arrowIcon />
            </a>
          </div>
          <b-collapse accordion="my-accordion" id="accordion-9">
            <ul
              class="Ul_collapse"
              :class="{ 'vertical-item-name': getVerticalCompact.isItemName }"
            >
              <li class="item-name">
                <router-link tag="a" to="/manage/system-log/mission-log" class href="#">
                  <i class="i-Circular-Point mr-2 "></i>
                  <span class="">任务日志</span>
                </router-link>
              </li>
            </ul>
          </b-collapse>
        </li> -->
          <li class="Ul_li--hover">
            <div v-b-toggle.accordion-12>
              <a class="has-arrow" href="#" :class="{ active: selectedParentMenu == 'ticket' }">
                <i class="nav-icon i-Speach-Bubble-Asking text-20 mr-2"></i>
                <span class="text-15" :class="{
                  'vertical-item-name': getVerticalCompact.isItemName,
                }">{{ $t("ticketCenter") }}</span>
                <span v-if="unread > 0" class="badge badge-danger ml-2">{{
                  unread
                }}</span>
                <arrowIcon />
              </a>
            </div>
            <b-collapse accordion="my-accordion" id="accordion-12">
              <ul class="Ul_collapse" :class="{ 'vertical-item-name': getVerticalCompact.isItemName }">
                <li class="item-name">
                  <router-link tag="a" to="/manage/ticket/ticketList" class href="#">
                    <i class="i-Circular-Point mr-2"></i>
                    <span class="">{{ $t("ticketList") }}</span>
                  </router-link>
                </li>
              </ul>
            </b-collapse>
          </li>

          <li class="Ul_li--hover">
            <div v-b-toggle.accordion-99>
              <a class="has-arrow" href="#" :class="{ active: selectedParentMenu == 'system-manage' }">
                <i class="nav-icon i-Gears text-20 mr-2"></i>
                <span class="text-15" :class="{
                  'vertical-item-name': getVerticalCompact.isItemName,
                }">{{ $t("system_setting") }}</span>
                <arrowIcon />
              </a>
            </div>
            <b-collapse accordion="my-accordion" id="accordion-99">
              <ul class="Ul_collapse" :class="{ 'vertical-item-name': getVerticalCompact.isItemName }">
                <!-- <li class="item-name">
                <router-link tag="a" to="/manage/system-manage/website-info" class href="#">
                  <i class="i-Circular-Point mr-2 "></i>
                  <span class="">网站信息</span>
                </router-link>
              </li>
              <li class="item-name">
                <router-link tag="a" to="/manage/system-manage/email" class href="#">
                  <i class="i-Circular-Point mr-2 "></i>
                  <span class="">邮箱配件</span>
                </router-link>
              </li>
              <li class="item-name">
                <router-link tag="a" to="/manage/system-manage/banner" class href="#">
                  <i class="i-Circular-Point mr-2 "></i>
                  <span class="">banner图管理</span>
                </router-link>
              </li>
              <li class="item-name">
                <router-link tag="a" to="/manage/system-manage/message" class href="#">
                  <i class="i-Circular-Point mr-2 "></i>
                  <span class="">短信其他</span>
                </router-link>
              </li>
              <li class="item-name">
                <router-link tag="a" to="/manage/system-manage/doc-store" class href="#">
                  <i class="i-Circular-Point mr-2 "></i>
                  <span class="">文件存储</span>
                </router-link>
              </li>
              <li class="item-name">
                <router-link tag="a" to="/manage/system-manage/operate-config" class href="#">
                  <i class="i-Circular-Point mr-2 "></i>
                  <span class="">运营配置</span>
                </router-link>
              </li> -->
                <li class="item-name">
                  <router-link tag="a" to="/manage/system-manage/system-config" class href="#">
                    <i class="i-Circular-Point mr-2"></i>
                    <span class="">{{ $t("system_config") }}</span>
                  </router-link>
                </li>
                <!-- <li class="item-name">
                <router-link tag="a" to="/manage/system-manage/package-config" class href="#">
                  <i class="i-Circular-Point mr-2 "></i>
                  <span class="">配套配置</span>
                </router-link>
              </li> -->
              </ul>
            </b-collapse>
          </li>
        </ul>
      </div>
    </div>
  </vue-perfect-scrollbar>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import arrowIcon from "../../../components/arrow/arrowIcon";
export default {
  components: {
    arrowIcon,
  },
  computed: {
    ...mapGetters(["getVerticalCompact", "getVerticalSidebar", "unread"]),
  },
  data() {
    return {
      selectedParentMenu: "",
    };
  },
  mounted() {
    this.toggleSelectedParentMenu();
    document.addEventListener("click", this.returnSelectedParentMenu);

    if (this.$i18n.locale == "vi") {
      this.$i18n.locale = "zh";
    }
  },
  beforeDestroy() {
    document.removeEventListener("click", this.returnSelectedParentMenu);
  },
  methods: {
    ...mapActions([
      "switchSidebar",
      "sidebarCompact",
      "removeSidebarCompact",
      "mobileSidebar",
    ]),

    toggleSelectedParentMenu() {
      const currentParentUrl = this.$route.path
        .split("/")
        .filter((x) => x !== "")[1];

      if (currentParentUrl !== undefined || currentParentUrl !== null) {
        this.selectedParentMenu = currentParentUrl.toLowerCase();
        console.log(currentParentUrl);
      } else {
        this.selectedParentMenu = "users";
      }
    },
    returnSelectedParentMenu() {
      this.toggleSelectedParentMenu();
    },
  },
};
</script>
<style>

</style>