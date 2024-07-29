
import { getMemberInfo, } from "../../../system/api/api";
export default (to, from, next) => {
    if (localStorage.getItem("boostToken") != null && localStorage.getItem("boostToken").length > 0) {
        var result = getMemberInfo();
        result.then(function (value) {
            var secPassword = value.data.address;
            if (secPassword == null) {
                next("/web/withdraw/setCoin");
            } else {
                next();
            }
        }).catch(function (e) {
            console.log(e);

        });
    } else {
        localStorage.removeItem("boostToken");
        next("/web/sessions/signIn");
    }
};
