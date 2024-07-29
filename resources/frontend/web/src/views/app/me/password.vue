<template>
  <div>
    <div class="m-3 mx-4">
      <b-row align-h="center">
        <b-col md="10">
          <b-form @submit.prevent="submitForm">
            <div class="form-group row">
              <label for="old_password" class="col-sm-12 col-form-label">{{
                $t("old_password")
              }}</label>
              <div class="col-sm-12">
                <input
                  type="password"
                  class="form-control"
                  v-model="old_password"
                  required
                />
              </div>
            </div>

            <div class="form-group row">
              <label for="new_password" class="col-sm-12 col-form-label">{{
                $t("new_password")
              }}</label>
              <div class="col-sm-12">
                <input
                  type="password"
                  class="form-control"
                  v-model="password"
                  required
                />
              </div>
            </div>

            <div class="form-group row">
              <label
                for="confirm_new_password"
                class="col-sm-12 col-form-label"
                >{{ $t("confirm_new_password") }}</label
              >
              <div class="col-sm-12">
                <input
                  type="password"
                  class="form-control"
                  v-model="password_confirmation"
                  required
                />
              </div>
            </div>

            <div class=" float-right w-100" style="margin-top:10vh">
              <b-button type="submit" class="m-1 btn-curved" :disabled="isLoading" block>
                <span class="text-white font-weight-bold"
                  >{{ isLoading ? $t("loading...") : $t("submit") }}
                </span></b-button
              >
            </div>
          </b-form>
        </b-col>
      </b-row>
    </div>
  </div>
</template>

<script>
import { changePassword } from "../../../system/api/api";
import { handleError } from "../../../system/handleRes";
export default {
  data() {
    return {
      old_password: "",
      password: "",
      password_confirmation: "",
      sending: false,
      isLoading: false,
    };
  },

  methods: {
    submitForm() {
      let formData = new FormData();
      var self = this;
      formData.append("old_password", this.old_password);
      formData.append("password", this.password);
      formData.append("password_confirmation", this.password_confirmation);
      var result = changePassword(formData);
      self.isLoading = true;

      result
        .then(function (value) {
          if (value.data.code == 0) {
            self.$root.makeToast("success", self.$t(value.data.message));
            self.old_password = "";
            self.password = "";
            self.password_confirmation = "";
            self.$router.push("/web/me/mePage");
          } else {
            self.$root.makeToast("danger", self.$t(value.data.message));
          }
          self.sending = false;
          self.isLoading = false;
        })
        .catch(function (error) {
          console.log(error);
          self.$root.makeToast("warning", self.$t(handleError(error)));
          self.sending = false;
          self.isLoading = false;
        });
    },
  },
};
</script>