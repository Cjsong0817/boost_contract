(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-e1bdbeac"],{"3bf0":function(t,e,i){t.exports=i.p+"img/walletBg.71f5d6d9.jpg"},a4f5:function(t,e,i){},b78d:function(t,e,i){"use strict";i("a4f5")},ef79:function(t,e,i){},f1ac:function(t,e,i){"use strict";i("ef79")},f542:function(t,e,i){"use strict";i.r(e);var a=function(){var t=this,e=t._self._c;return e("div",{staticClass:"main-content flex-grow-1 d-flex flex-column",staticStyle:{height:"100%",width:"100%","max-height":"100%","min-height":"100%",position:"fixed","overflow-y":"scroll"}},[e("div",{staticClass:"appBar"},[e("a",{on:{click:function(e){return t.$router.go(-1)}}},[e("i",{staticClass:"fa fa-chevron-left"})])]),e("div",{staticClass:"mainpage mt-3 flex-grow-1 d-flex flex-column"},[e("h4",{staticClass:"font-weight-bold mb-3"},[t._v(t._s(t.$t("invite_link")))]),e("b-row",{attrs:{"align-h":"center"}},[e("b-col",{attrs:{md:"8 my-4"}},[e("div",{staticClass:"form-group row"},[e("div",{staticClass:"gradient-box p-4 sd-block mx-auto mb-0 rounded"},[e("qrcode",{attrs:{size:t.size,cls:t.qrCls,value:t.inv_link}})],1)])])],1),e("div",{staticClass:"d-flex flex-column justify-content-center"},[e("h6",{staticClass:"text-center font-weight-bold"},[t._v(" "+t._s(t.$t("refer_register"))+" ")]),e("p",{staticClass:"text-center"},[t._v(t._s(t.$t("scanDesc")))])]),e("div",{staticClass:"form-group row"},[e("label",{staticClass:"col-sm-12 col-form-label font-weight-bold",attrs:{for:"link"}},[t._v(t._s(t.$t("invite_link")))]),e("div",{staticClass:"col-sm-12"},[e("input",{directives:[{name:"model",rawName:"v-model",value:t.inv_link,expression:"inv_link"}],staticClass:"form-control text-white font-weight-bold",attrs:{type:"text",id:"link",readonly:""},domProps:{value:t.inv_link},on:{input:function(e){e.target.composing||(t.inv_link=e.target.value)}}})])]),e("b-row",{staticClass:"mb-5 pb-5",attrs:{"no-gutters":""}},[e("b-col",{attrs:{cols:"12"}},[e("b-button",{directives:[{name:"clipboard",rawName:"v-clipboard",value:function(){return t.inv_link},expression:"() => inv_link"},{name:"clipboard",rawName:"v-clipboard:success",value:t.clipboardSuccessHandler,expression:"clipboardSuccessHandler",arg:"success"},{name:"clipboard",rawName:"v-clipboard:error",value:t.clipboardErrorHandler,expression:"clipboardErrorHandler",arg:"error"}],staticClass:"my-1 w-100 btn-curved",attrs:{type:"button"}},[e("span",{staticClass:"text-white font-weight-bold"},[e("i",{staticClass:"fa fa-copy"}),t._v(" "+t._s(t.$t("copy"))+" ")])])],1),e("b-col",{attrs:{cols:"12"}},[e("b-button",{staticClass:"my-1 w-100 btn-curved",attrs:{type:"button"},on:{click:t.shareBtn}},[e("span",{staticClass:"text-white font-weight-bold"},[e("i",{staticClass:"fa fa-share"}),t._v(" "+t._s(t.$t("share"))+" ")])])],1)],1)],1),e("Dialog",{ref:"msg"})],1)},s=[],n=i("5530"),o=i("b5ae"),r=i("c4cd"),c=i("06e0"),l=i("402a"),d=i("9565"),u=i("2f62"),f={computed:Object(n["a"])({},Object(u["c"])(["lang"])),components:{Dialog:d["a"],Qrcode:r["a"]},validations:{newCoinType:{required:o["required"]},newAmount:{required:o["required"]},tx_id:{required:o["required"]},tx_id2:{required:o["required"]},sec_pwd:{required:o["required"]}},data:function(){return{bgImage:i("3bf0"),qrCls:"qrcode",size:240,inv_link:"",newAmount:"",newCoinAddress:"",newCoinType:"",coin:null,coinList:[],coinOptions:[],isLoading:!1,tx_id:"",tx_id2:"",address:"",sec_pwd:"",dfi_paid:"",option_paid:"",selected:"1",globalDfiAddress:"",globalDfiPrice:"",finalAmount:"",finalAmount2:"",depositName:"",is100:!1,ref_code:""}},props:["success"],methods:{clipboardSuccessHandler:function(){this.$refs.msg.makeToast("success",this.$t("copied"))},clipboardErrorHandler:function(){},shareBtn:function(){var t={title:"Winato Trade Network",text:"Let's join Winato Trade Network!",url:this.inv_link};navigator.share(t)},getCoin:function(){var t=Object(c["y"])(),e=this;e.isLoading=!0,t.then((function(t){0==t.data.code&&(e.newCoinAddress=t.data.data),e.isLoading=!1})).catch((function(t){e.$refs.msg.makeToast("warning",e.$t(Object(l["b"])(t))),e.isLoading=!1}))},loadItems:function(){var t=Object(c["p"])(),e=this;this.isLoading=!0,e.inv_link=location.origin+"/register?ref_id=",t.then((function(t){e.memberInfo=t.data.data,e.ref_code=t.data.data.ref_code,e.isLoading=!1,e.inv_link=e.inv_link+e.ref_code})).catch((function(t){e.$refs.msg.makeToast("warning",e.$t(Object(l["b"])(t)))}))}},created:function(){this.loadItems()}},b=f,p=(i("f1ac"),i("b78d"),i("2877")),m=Object(p["a"])(b,a,s,!1,null,"15f12adb",null);e["default"]=m.exports}}]);
//# sourceMappingURL=chunk-e1bdbeac.cefdb481.js.map