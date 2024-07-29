
import {
    getMemberInfo,getDownloadLink
} from "../system/api/api";
export default (to, from, next) => {

    if (
        localStorage.getItem("boostToken") != null &&
        localStorage.getItem("boostToken").length > 0
    ) {
        var result = getDownloadLink();

        result
            .then(function (value) {
                var siteOn = value.data.data.system.SITE_ON;
                localStorage.setItem('SUPPORT_URL_EN',value.data.data.system.SUPPORT_URL_EN);
                localStorage.setItem('SUPPORT_QR_CN',value.data.data.system.SUPPORT_QR_CN);
                if (siteOn == 0) {
                    next("/web/sessions/signIn");
                } else {
                    var result = getMemberInfo();

                    result
                        .then(function (value) {
                            var secPassword = value.data.data.password2;
                            var jy = value.data.data.jy;
                            if (secPassword == null) {
                                next("/web/settings/set-sec-password");
                            } else {
                                console.log('check');
                                if(jy==0){
                                    next("/web/sessions/signIn");
                                }else{
                                    next();
                                }
                            }


                        })
                        .catch(function () {
                            
                        });
                }
            })
            .catch(function () {
              
            });
        next();
    } else {
        localStorage.removeItem("boostToken");
        next("/web/sessions/signIn");
    }
};
