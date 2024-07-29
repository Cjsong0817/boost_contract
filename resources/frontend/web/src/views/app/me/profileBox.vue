<template>
  <b-card class="px-2 pb-1 bg-gray" no-body style="margin-bottom: 0.75rem">
    <div class="d-flex align-items-center">
      <div class="text-center text-24" style="margin-right: 10px; width: 40px">
        <img height="24px" :src="img" alt="" />
      </div>

      <h6 class="mb-0 mx-1 text-12 flex-grow-1">
        {{ $t(info) }}
      </h6>
      <i class="fa fa-chevron-right"></i>
    </div>
  </b-card>
</template>

<script>
export default {
  props: ["info"],
  data() {
    return {
      img: require("../../../assets/images/profile/kyc.svg"),
    };
  },
  created() {
    this.img = require("../../../assets/images/profile/" + this.info + ".svg");
  },
};
</script>