<template>
  <div class="main-content d-flex flex-column" style="height: 100vh">
    <div class="appBar position-relative mb-4">
      <a @click="$router.go(-1)" class="text-20">
        <i class="fa fa-chevron-left"></i>
      </a>
      <span class="font-weight-bold text-20">{{ $t("details") }}</span>
    </div>

    <div
      class="pt-4 py-2 flex-grow-1"
      style="
        background: white;
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
        position: relative;
        overflow-y: scroll;
      "
    >
      <div class="px-3 py-2">
        <p class="font-weight-bolder mb-0 text-24">
          {{ parseFloat(item.amount).toFixed(2) }}
        </p>
        <div
          class="mx-0 my-2"
          style="height: 1px; background-color: gray"
        ></div>
        <b-row align-v="center">
          <b-col cols="5">
            <p class="mb-0 font-weight-bolder">
              {{ $t(type) }}
            </p>
          </b-col>
          <b-col cols="7" class="text-right font-weight-bold">
            <p
              class="mb-0"
              style="color: rgb(127, 127, 127); word-break: break-all"
            >
              {{ item.address }}
            </p>
          </b-col>
          <div
            class="mx-3 my-3 w-100"
            style="height: 1px; background-color: gray"
          ></div>
          <b-col cols="5">
            <p class="mb-0 font-weight-bolder">
              TXID
            </p>
          </b-col>
          <b-col cols="7" class="text-right font-weight-bold">
            <p
              class="mb-0"
              style="color: rgb(127, 127, 127); word-break: break-all"
            >
              {{ item.txid }}
            </p>
          </b-col><div
            class="mx-3 my-3 w-100"
            style="height: 1px; background-color: gray"
          ></div>
          <b-col cols="5">
            <p class="mb-0 font-weight-bolder">
              {{ $t("date") }}
            </p>
          </b-col>
          <b-col cols="7" class="text-right font-weight-bold">
            <p
              class="mb-0"
              style="color: rgb(127, 127, 127); word-break: break-all"
            >
              {{ item.updated_at }}
            </p>
          </b-col>
          <div
            class="mx-3 my-3 w-100"
            style="height: 1px; background-color: gray"
          ></div>
          <b-col cols="5">
            <p class="mb-0 font-weight-bolder">
              {{ $t("ref_no") }}
            </p>
          </b-col>
          <b-col cols="7" class="text-right font-weight-bold">
            <p
              class="mb-0"
              style="color: rgb(127, 127, 127); word-break: break-all"
            >
              {{ item.refNo }}
            </p>
          </b-col>
          <div
            class="mx-3 my-3 w-100"
            style="height: 1px; background-color: gray"
          ></div>
          <b-col cols="5">
            <p class="mb-0 font-weight-bolder">
              {{ $t("remark") }}
            </p>
          </b-col>
          <b-col cols="7" class="text-right font-weight-bold">
            <p
              class="mb-0"
              style="color: rgb(127, 127, 127); word-break: break-all"
            >
              {{ item.remark }}
            </p>
          </b-col>
          <div
            class="mx-3 my-3 w-100"
            style="height: 1px; background-color: gray"
          ></div>
          <b-col cols="5">
            <p class="mb-0 font-weight-bolder">
              {{ $t("status") }}
            </p>
          </b-col>
          <b-col cols="7" class="text-right font-weight-bold">
            <p
              class="mb-0"
              style="color: rgb(127, 127, 127); word-break: break-all"
            >
              {{ $t(site[item.status]) }}
            </p>
          </b-col>
        </b-row>
      </div>
      <div class="mx-3 my-1" style="height: 1px; background-color: gray"></div>
    </div>
    <Dialog ref="msg"></Dialog>
  </div>
</template>
  
  <script>
import Dialog from "../../../components/dialog.vue";
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters(["lang"]),
  },
  components: {
    Dialog,
  },
  data() {
    return {
      site: ["pending", "approved", "success", "rejected"],
    };
  },
  props: ["item", "type"],
  methods: {},
  created() {
    console.log(this.item);
  },
};
</script>