<template>
  <div
    class="node d-flex flex-column align-items-center mx-auto px-3"
    style="min-width: 100px"
  >
    <img
      class="cursor-pointer"
      :data-username="item.username"
      src="@/assets/images/boost/profile.png"
      style="max-width: 70px"
      @click="check_user(item.parrent)"
    />
    <!--:src="item.image"-->

    <p v-if="item.username.length > 0">{{ item.username }}</p>
    <p v-else style="color: transparent">{{ "unknown" }}</p>
    <div class="ptitle">Total CV</div>
    <div class="ptext">{{ item.total_lv }}|{{ item.total_rv }}</div>

    <p text-align="center"></p>
    <div class="ptitle">Balance CV</div>
    <div class="ptext">{{ item.left_point }}|{{ item.right_point }}</div>

    <p></p>

    <b-button
      v-if="item.username.length > 0"
      @click="show_detail(item.parrent)"
      variant="info"
      class="btn btn-info btn-circle added"
      ><i class="fa fa-book"></i
    ></b-button>
    <b-button
      v-else
      @click="show_detail(item.parrent)"
      variant="success"
      class="btn btn-success btn-circle added"
      ><i class="fa fa-plus"></i
    ></b-button>
    <b-modal
      :id="'modal-unit' + item.parrent"
      size="md"
      centered
      :title="$t('details')"
      :hide-footer="true"
      style="background-color: #5f646e !important"
    >
      <div class="d-flex flex-column justify-content-center">
        <h3 class="mx-auto">{{ item.username }}</h3>
        <b-row class="text-16">
          <b-col cols="6">Left CV : {{ item.left_point }}</b-col>
          <b-col cols="6"> Right CV : {{ item.right_point }} </b-col>
          <b-col cols="6"> Total CV : {{ item.total_lv }} </b-col>
          <b-col cols="6"> Total CV : {{ item.total_rv }} </b-col>
        </b-row>
      </div>
    </b-modal>
  </div>
</template>

<script>
import { mapActions } from "vuex";
export default {
  props: ["item", "group", "previous"],
  methods: {
    ...mapActions(["changeSelectedP"]),
    check_user(userID) {
      console.log(userID);
      if (userID > 0) {
        this.$parent.loadItems(userID);
        this.changeSelectedP(this.previous.parrent);
      } else {
        this.$router.push(
          "/web/registration?jid=" +
            this.item.username +
            "&group_type=" +
            this.group
        );
      }
    },
    show_detail(userID) {
      if (userID > 0) {
        this.$bvModal.show("modal-unit" + this.item.parrent);
        // this.$parent.loadItems(userID);
      } else {
        this.$router.push(
          "/web/registration?jid=" +
            this.previous.username +
            "&group_type=" +
            this.group
        );
      }
    },
  },
};
</script>

<style scoped>
.ptitle {
  font-size: 12px;
}
.ptext {
  font-size: 14px;
}

p {
  margin-bottom: 5px;
}
</style>