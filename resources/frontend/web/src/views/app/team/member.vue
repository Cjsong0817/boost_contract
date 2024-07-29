<template>
  <div>
    <div
      class="gradient-banner position-relative"
      style="padding: 6vh 0px;"
    >
      <h5 class="text-center">{{ $t("member") }}</h5>
    </div>
    <SponsorTree></SponsorTree>
  </div>
</template>

<script>
import SponsorTree from "./memberTree.vue";
// import PlacementTree from "./placementTree.vue";
export default {
  components: {
    SponsorTree,
    // PlacementTree,
  },
};
</script>