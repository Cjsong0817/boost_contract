<template>
  <div class="main-content mb-5">
    <div class="appBar mb-3">
      <a @click="$router.go(-1)">
        <i class="fa fa-chevron-left"></i>
      </a>
      <span>{{
        $route.query.type == "pwd"
          ? $t("password_reset")
          : $t("reset_sec_password")
      }}</span>
    </div>
    <Pwd v-if="$route.query.type == 'pwd'"></Pwd>
    <SecPwd v-else-if="$route.query.type == 'sec_pwd'"></SecPwd>
  </div>
</template>

<script>
import Pwd from "./password.vue";
import SecPwd from "./sec_password.vue";
export default {
  components: {
    Pwd,
    SecPwd,
  },
};
</script>