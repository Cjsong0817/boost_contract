import Vue from "vue";
import store from "./store";
// import {isMobile} from "mobile-device-detect";
import Router from "vue-router";
import NProgress from "nprogress";
// import checkStatus from "./auth/checkStatus";
// import checkInfo from "./views/app/withdraw/checkInfo";
// import checkRequestDeposit from "./auth/checkRequestDeposit";
import checkSecPassword from "./auth/checkSecPassword";
// import checkInfo from "./views/app/withdraw/checkInfo";
// import authenticate from "./auth/authenticate";
Vue.use(Router);

// create new router

const routes = [
  {
    path: "/web/",
    component: () => import("./views/app"), //webpackChunkName app
    beforeEnter: checkSecPassword,
    redirect: "/web/wallet",

    children: [

      {
        path: "/web/test",
        component: () => import("./views/app/transfer/test"),
      },

      {
        path: "/web/wallet",
        component: () => import("./views/app/transfer/wallet"),
      },
      {
        path: "/web/upgradePackage",
        component: () => import("./views/app/package/upgradePackage"),
      },
      {
        path: "/web/member",
        component: () => import("./views/app/team/member"),
      },

      {
        path: "/web/bonus/bonusRecord",
        component: () => import("./views/app/bonus/bonusRecord"),
      },
      
      {
        path: "/web/me/mePage",
        component: () => import("./views/app/me/profile"),
      },
      
      {
        path: "/web/me/invitation_link",
        component: () => import("./views/app/me/invitation_link"),
      },
      
      {
        path: "/web/me/news",
        component: () => import("./views/app/me/newsList"),
      },
      
      {
        path: "/web/me/basic_info",
        name: "basic_info",
        props: true,
        component: () => import("./views/app/me/basic_info"),
      },
      
      {
        path: "/web/me/newsDetails",
        name: "newDetails",
        props: true,
        component: () => import("./views/app/me/newsDetails"),
      },
      
      {
        path: "/web/me/KYC",
        component: () => import("./views/app/me/KYC"),
      },
      {
        path: "/web/me/password",
        component: () => import("./views/app/me/passwordSetting"),
      },

      

      // {
      //   path: "/web/chat",
      //   component: () => import("./views/app/chat"), //dashboard,
      //   children: [
      //     {
      //       path: "chatBox",
      //       component: () => import("./views/app/chat/chatBox"),
      //     },
      //   ]
      // },
      // {
      //   path: "/web/dashboard",
      //   beforeEnter: checkSecPassword,
      //   component: () => import("./views/app/dashboard"), //dashboard,
      //   children: [
      //     {
      //       path: "dashboard",
      //       component: () => import("./views/app/dashboard/dashboard"),
      //     },
      //   ]
      // },
      // {
      //   path: "/web/boost",
      //   beforeEnter: checkSecPassword,
      //   component: () => import("./views/app/boost"),
      //   children: [
      //     {
      //       path: "boostPage",
      //       component: () => import("./views/app/boost/boostPage"),

      //     },
      //   ]
      // },
      // {
      //   path: "/web/ticket",
      //   beforeEnter: checkSecPassword,
      //   component: () => import("./views/app/ticket/"),
      //   children: [
      //     {
      //       path: "createTicket",
      //       component: () => import("./views/app/ticket/createTicket"),

      //     },
      //   ]
      // },
      
      // {
      //   path: "/web/quantitative",
      //   component: () => import("./views/app/quantitative"), //dashboard,
      //   meta: { permission: '1' },
      //   children: [
      //     {
      //       path: "marketList",
      //       component: () => import("./views/app/quantitative/marketList"),

      //     },
      //     {
      //       path: "robotInfo",
      //       component: () => import("./views/app/quantitative/robotinfo"),

      //       props: true
      //     },
      //     {
      //       path: "robotSetting",
      //       component: () => import("./views/app/quantitative/robotSetting"),

      //       props: true
      //     },
      //   ]
      // },
      // {
      //   path: "/web/apiBinding",
      //   component: () => import("./views/app/apiBinding"),
      //   children: [
      //     {
      //       path: "apiBinding",
      //       component: () => import("./views/app/apiBinding/apiBinding"),

      //     },
      //   ]
      // },
      // {
      //   path: "/web/revenueManage",
      //   component: () => import("./views/app/revenueManage"),
      //   children: [
      //     {
      //       path: "revenue",
      //       component: () => import("./views/app/revenueManage/revenue"),

      //     },
      //     {
      //       path: "revenueDetails",
      //       component: () => import("./views/app/revenueManage/revenueDetails"),

      //     },
      //   ]
      // },
      // {
      //   path: "/web/myWallet",
      //   component: () => import("./views/app/myWallet"),
      //   children: [
      //     {
      //       path: "walletRecord",
      //       component: () => import("./views/app/myWallet/walletRecord"),

      //     },
      //     {
      //       path: "deposit",
      //       component: () => import("./views/app/myWallet/deposit"),

      //     },
      //     {
      //       path: "depositRecord",
      //       component: () => import("./views/app/myWallet/depositRecord"),

      //       props: true
      //     },
      //     {
      //       path: "withdraw",
      //       component: () => import("./views/app/myWallet/withdraw"),

      //       props: true
      //     },
      //     {
      //       path: "withdrawRecord",
      //       component: () => import("./views/app/myWallet/withdrawRecord"),

      //       props: true
      //     },
      //     {
      //       path: "transfer",
      //       component: () => import("./views/app/myWallet/transfer"),

      //       props: true
      //     },
      //     {
      //       path: "transferRecord",
      //       component: () => import("./views/app/myWallet/transferRecord"),

      //       props: true
      //     },
      //   ]
      // },
      // // settings
      // {
      //   path: "/web/settings",
      //   beforeEnter: checkSecPassword,
      //   component: () => import("./views/app/settings"),
      //   children: [
      // {
      //   path: "settingCenter",
      //   component: () => import("./views/app/settings/settingCenter")
      // },
      // {
      //   path: "change-password",
      //   meta: { permission: '111' },
      //   component: () => import("./views/app/settings/change-password")
      // },
      // {
      //   path: "change-sec-password",
      //   component: () => import("./views/app/settings/change-sec-password"),

      //   props: true
      // },
      // {
      //   path: "forget-sec-password",
      //   component: () => import("./views/app/settings/forget-sec-password"),

      //   props: true
      // },
      //   ]
      // },
    ]
  },
  {
    path: "/web/registration",
    beforeEnter: checkSecPassword,
    component: () => import("./views/app/registration/memberRegister"), //dashboard,
  },
  {
    path: "/web/package",
    beforeEnter: checkSecPassword,
    component: () => import("./views/app/package"),
    redirect: "/web/package/packageHistory",
    children: [
      // {
      //   path: "upgradePackage",
      //   component: () => import("./views/app/package/upgradePackage"),
      // },
      {

        path: "packageHistory",
        component: () => import("./views/app/package/packageHistory"),
      },
    ]
  },
  {
    path: "/web/wallet/record",
    beforeEnter: checkSecPassword,
    component: () => import("./views/app/transfer/walletRecord"),
  },
  {
    path: "/web/wallet/recordDetails",
    name: "recordDetails",
    props: true,
    beforeEnter: checkSecPassword,
    component: () => import("./views/app/transfer/recordDetails"),
  },
  {
    path: "/web/transfer",
    beforeEnter: checkSecPassword,
    component: () => import("./views/app/transfer"),
    redirect: "/web/transfer/transfer",
    children: [
      {
        path: "transfer",
        component: () => import("./views/app/transfer/transfer"),
      },
      {
        path: "transferRecord",
        component: () => import("./views/app/transfer/transferRecord"),
      },
      {
        path: "changeWallet",
        component: () => import("./views/app/transfer/changeWallet"),
      },
    ]
  },
  {
    path: "/web/insurance",
    beforeEnter: checkSecPassword,
    component: () => import("./views/app/insurance"),
    redirect: "/web/insurance/purchaseInsurance",
    children: [
      {
        path: "purchaseInsurance",
        component: () => import("./views/app/insurance/purchaseInsurance"),
      },
      {
        path: "insuranceRecord",
        component: () => import("./views/app/insurance/insuranceRecord"),
      },
      {
        path: "claimInsuranceHis",
        component: () => import("./views/app/insurance/claimInsuranceHis"),
      },
    ]
  },
  {
    path: "/web/bonus",
    beforeEnter: checkSecPassword,
    component: () => import("./views/app/bonus"),
    redirect: "/web/bonus/bonusCenter",
    children: [
      {
        path: "bonusCenter",
        component: () => import("./views/app/bonus/bonusCenter"),
      },
      {
        path: "/web/bonus/bonusRecord",
        beforeEnter: checkSecPassword,
        component: () => import("./views/app/bonus/bonusRecord"),
      },
    ]
  },
  {
    path: "/web/withdraw",
    beforeEnter: checkSecPassword,
    component: () => import("./views/app/withdraw"),
    redirect: "/web/withdraw/withdraw",
    children: [
      {
        path: "withdraw",
        component: () => import("./views/app/withdraw/withdraw"),
      },
      {
        path: "withdrawHistory",
        component: () => import("./views/app/withdraw/withdrawHistory"),
      },
    ]
  },
  // {
  //   path: "/web/myTeam",
  //   beforeEnter: checkSecPassword,
  //   component: () => import("./views/app/team/memberTree"),
  // },
  // {
  //   path: "/web/requestDeposit",
  //   beforeEnter: checkRequestDeposit,
  //   component: () => import("./views/app/deposit/requestDeposit"),
  // },
  {
    path: "/web/deposit",
    beforeEnter: checkSecPassword,
    component: () => import("./views/app/deposit"),
    redirect: "/web/deposit/deposit",
    children: [
      {
        path: "deposit",
        component: () => import("./views/app/deposit/deposit"),
      },
      {

        path: "depositHistory",
        component: () => import("./views/app/deposit/depositHistory"),
      },
    ]
  },
  // {
  //   path: "/web/withdraw",
  //   component: () => import("./views/app/withdraw"),
  //   beforeEnter: checkSecPassword,
  //   redirect: "/web/withdraw/withdraw",
  //   children: [
  //     {
  //       path: "withdraw",
  //       beforeEnter: checkInfo,
  //       component: () => import("./views/app/withdraw/withdraw"),
  //     },
  //     {
  //       path: "setBank",
  //       component: () => import("./views/app/withdraw/setBank"),
  //     },
  //     {

  //       path: "withdrawHistory",
  //       component: () => import("./views/app/withdraw/withdrawHistory"),
  //     },
  //   ]
  // },

  // {
  //   path: "/web/boost/boostPage",
  //   beforeEnter: checkSecPassword,
  //   component: () => import("./views/app/boost/boostPage"),
  // },
  // {
  //   path: "/web/settings/settingCenter",
  //   beforeEnter: checkSecPassword,
  //   component: () => import("./views/app/settings/settingCenter"),
  // },
  // {
  //   path: "/web/settings/change-password",
  //   beforeEnter: checkSecPassword,
  //   component: () => import("./views/app/settings/change-password"),
  // },
  {
    path: "/web/settings/forget-password",
    component: () => import("./views/app/settings/forget-password"),
  },
  // {
  //   path: "/web/settings/change-sec-password",
  //   beforeEnter: checkSecPassword,
  //   component: () => import("./views/app/settings/change-sec-password"),
  // },
  // {
  //   path: "/web/settings/forget-sec-password",
  //   beforeEnter: checkSecPassword,
  //   component: () => import("./views/app/settings/forget-sec-password"),
  // },
  {
    path: "/web/settings/set-sec-password",
    component: () => import("./views/app/settings/set-sec-password"),
  },
  // {
  //   path: "/web/bonus/bonusCenter",
  //   beforeEnter: checkSecPassword,
  //   component: () => import("./views/app/bonus/bonusCenter"),
  // },
  // {
  //   path: "/web/bonus/bonusRecord",
  //   beforeEnter: checkSecPassword,
  //   component: () => import("./views/app/bonus/bonusRecord"),
  // },
  // {
  //   path: "/web/bonus/dynamicBonusRecord",
  //   beforeEnter: checkSecPassword,
  //   component: () => import("./views/app/bonus/dynamicBonusRecord"),
  // },



  // sessions
  {
    path: "/web/sessions",
    component: () => import("./views/app/sessions"),
    redirect: "/web/sessions/signIn",
    children: [
      {
        path: "signIn",
        component: () => import("./views/app/sessions/signIn")
      },
      // {
      //   path: "signUp",
      //   component: () => import("./views/app/sessions/signUp")
      // },
      // {
      //   path: "forgot",
      //   component: () => import("./views/app/sessions/forgot")
      // }
    ]
  },

  {
    path: "/register",
    component: () => import("./views/app/sessions/signUp"),
  },

  // {
  //   path: "/vertical-sidebar",
  //   component: () => import("./containers/layouts/verticalSidebar")
  // },
  {
    path: "*",
    component: () => import("./views/app/pages/notFound")
  }
];

const router = new Router({
  mode: "history",
  linkActiveClass: "open",
  routes,
  // to, from, savedPosition
  scrollBehavior() {
    return { x: 0, y: 0 };
  }
});

router.beforeEach((to, from, next) => {
  // If this isn't an initial page load.
  if (to.path) {
    // Start the route progress bar.

    NProgress.start();
    NProgress.set(0.1);
  }
  // if (localStorage.getItem('path') != null) {
  //   var permissionList = localStorage.getItem('path');
  //   console.log((permissionList.includes(to.meta.permission)))
  //   try {
  //     // if (to.path == '/') {
  //     //   next('/');
  //     // }

  //     if (to.meta.permission != undefined && to.path != '/*') {
  //       if(permissionList.includes(to.meta.permission)){
  //         next();

  //       }else{
  //         next('*');
  //       }
  //     } else {
  //       next();
  //     }

  //   } catch (error) {
  //     console.log(error)
  //   }

  // } else {
  //   localStorage.removeItem("boostToken");

  // }
  next();
});

router.afterEach(() => {
  // Remove initial loading
  const gullPreLoading = document.getElementById("loading_wrap");
  if (gullPreLoading) {
    gullPreLoading.style.display = "none";
  }
  // Complete the animation of the route progress bar.
  setTimeout(() => NProgress.done(), 100);
  // NProgress.done();
  // if (isMobile) {
  if (window.innerWidth <= 1200) {
    // console.log("mobile");
    store.dispatch("changeSidebarProperties");
    if (store.getters.getSideBarToggleProperties.isSecondarySideNavOpen) {
      store.dispatch("changeSecondarySidebarProperties");
    }
  } else {
    if (store.getters.getSideBarToggleProperties.isSecondarySideNavOpen) {
      store.dispatch("changeSecondarySidebarProperties");
    }

    // store.state.sidebarToggleProperties.isSecondarySideNavOpen = false;
  }
});

export default router;
