<template>
  <div v-html="htmlCode"></div>
</template>

<script>
export default {
  data() {
    return {
      // Just like JSX! Oh wait...
      htmlCode: `
      <form action="https://uat.binaxtion.com/_api965/v1.0/public-login-crm" id="depositForm" method="POST"><input type="hidden" name="token" value="tgif">
        <input type="hidden" name="call_back_url" value="https://ibo.greatwallsolution.com/web">
        <input type="hidden" name="username" value="account">
        <input type="hidden" name="timestamp" value="1665645905">
        <input type="hidden" name="signature" value="e1817d506cc4489aabc9b4f1b82bdb11920e086dd70688741379c7f93eb14b08:wjF42">
        </form>
      `,
    };
  },
};
</script>