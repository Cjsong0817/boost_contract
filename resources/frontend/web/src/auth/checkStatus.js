
import {
    checkAllowDeposit,
} from "../system/api/api";
export default (to, from, next) => {
    if (
        localStorage.getItem("boostToken") != null &&
        localStorage.getItem("boostToken").length > 0
    ) {
        var result = checkAllowDeposit();
        // var self = this;
        // self.isLoading = true;

        result
            .then(function (value) {
                console.log(value);
                var approval = value.data.data.approval;
                //   self.statusAction();
                //   self.isLoading = true;
                if (approval == 0) {
                    next("/web");
                } else if (approval == 2 || approval == 3) {
                    next("/web/requestDeposit");
                } else {
                    next();
                }


            })
            .catch(function () {
                //   console.log(error);
                //   self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
                //   self.isLoading = false;
            });
    } else {
        localStorage.removeItem("boostToken");
        next("/web/sessions/signIn");
    }
};
