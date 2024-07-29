<template>
  <div class="main-content" style="padding-bottom: 10vh !important">
    <h2 class="m-3 mx-4">Wallets</h2>
    <b-card class="m-3 mx-4 dashboard-bg">
      <b-row no-gutters>
        <b-col cols="9">
          <div class="d-flex flex-column align-items-start">
            <h6 class="mt-2">Total Income / Total Cap</h6>
            <h4 class="text-primary font-weight-bold mb-0">{{ getIncome }} / {{ getTotal }}</h4>
          </div>
        </b-col>
        <b-col cols="3" class="">
        </b-col>
      </b-row>
    </b-card>
    
    <b-card class="m-3 mx-4">
      <div class="d-flex flex-column align-items-center">
        <i class="text-40 i-Wallet"></i>
        <h4 class="font-weight-bold mt-2">DSP</h4>
        <div class="bg-info px-3 py-2 w-100 mb-2" style="border-radius: 10px">
          <h3 class="text-white mb-0 text-center">{{ getPoint2 }}</h3>
        </div>
        <b-row no-gutters class="w-100">
          <b-col cols="6" class="pr-1"
            ><b-button @click="$router.push('/web/transfer')" block>
              {{ $t("transfer") }}
            </b-button></b-col
          >
          <b-col cols="6" class="pl-1"
            ><b-button
              @click="$router.push('/web/wallet/record?type=point2')"
              block
            >
              {{ $t("record") }}
            </b-button></b-col
          >
          <b-col cols="12" class="pt-2"
            ><b-button @click="$router.push('/web/deposit')" block>
              {{ $t("deposit") }}
            </b-button></b-col
          >
        </b-row>
      </div>
    </b-card>

    <b-card class="m-3 mx-4">
      <div class="d-flex flex-column align-items-center">
        <i class="text-40 i-Wallet"></i>
        <h4 class="font-weight-bold mt-2">DBP</h4>
        <div class="bg-info px-3 py-2 w-100 mb-2" style="border-radius: 10px">
          <h3 class="text-white mb-0 text-center">{{ getPoint1 }}</h3>
        </div>
        <b-row no-gutters class="w-100">
          <b-col cols="6" class="pr-1"
            ><b-button @click="$router.push('/web/withdraw')" class="w-100">
              {{ $t("withdraw") }}
            </b-button></b-col
          >
          <b-col cols="6" class="pl-1"
            ><b-button
              @click="$router.push('/web/wallet/record?type=point1')"
              block
            >
              {{ $t("record") }}
            </b-button></b-col
          >
        </b-row>
      </div>
    </b-card>

    <b-card class="m-3 mx-4">
      <div class="d-flex flex-column align-items-center">
        <i class="text-40 i-Wallet"></i>
        <h4 class="font-weight-bold mt-2">DRP</h4>
        <div class="bg-info px-3 py-2 w-100 mb-2" style="border-radius: 10px">
          <h3 class="text-white mb-0 text-center">{{ getPoint3 }}</h3>
        </div>

        <b-row no-gutters class="w-100">
          <b-col cols="6" class="pr-1"
            ><b-button @click="$router.push('/web/transfer')" block>
              {{ $t("transfer") }}
            </b-button></b-col
          >
          <b-col cols="6" class="pl-1"
            ><b-button
              @click="$router.push('/web/wallet/record?type=point3')"
              block
            >
              {{ $t("record") }}
            </b-button></b-col
          >
        </b-row>
      </div>
    </b-card>

    <b-card class="m-3 mx-4">
      <div class="d-flex flex-column align-items-center">
        <i class="text-40 i-Wallet"></i>
        <h4 class="font-weight-bold mt-2">DMP</h4>
        <div class="bg-info px-3 py-2 w-100 mb-2" style="border-radius: 10px">
          <h3 class="text-white mb-0 text-center">{{ getPoint4 }}</h3>
        </div>

        <b-button @click="$router.push('/web/wallet/record?type=point4')" block>
          {{ $t("record") }}
        </b-button>
      </div>
    </b-card>
  </div>
</template>
<script>
import { getMemberInfo } from "../../../system/api/api";
import { mapGetters, mapActions } from "vuex";
export default {
  computed: {
    ...mapGetters([
      "getPoint1",
      "getPoint2",
      "getPoint3",
      "getPoint4",
      "getIncome",
      "getTotal",
    ]),
  },
  data() {
    return {
      member: {
        point2: 0,
        point3: 0,
      },
    };
  },
  methods: {
    ...mapActions([
      "updateP1",
      "updateP2",
      "updateP3",
      "updateP4",
      "updateIncome",
      "updateTotal",
    ]),
    memberInfo() {
      var result = getMemberInfo();
      var self = this;
      result
        .then(function (value) {
          self.member = value.data;
          self.updateP1(self.member.point1);
          self.updateP2(self.member.point2);
          self.updateP3(self.member.point3);
          self.updateP4(self.member.point4);
          self.updateIncome(self.member.total_income);
          self.updateTotal(self.member.total_cap);
        })
        .catch(function () {});
    },
  },
  created() {
    this.memberInfo();
  },
};
</script>