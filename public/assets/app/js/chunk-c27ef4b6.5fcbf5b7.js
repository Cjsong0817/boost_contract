(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-c27ef4b6"],{"25f0":function(t,a,e){"use strict";var s=e("6eeb"),o=e("825a"),i=e("d039"),l=e("ad6d"),r="toString",n=RegExp.prototype,c=n[r],d=i((function(){return"/a/b"!=c.call({source:"a",flags:"b"})})),g=c.name!=r;(d||g)&&s(RegExp.prototype,r,(function(){var t=o(this),a=String(t.source),e=t.flags,s=String(void 0===e&&t instanceof RegExp&&!("flags"in n)?l.call(t):e);return"/"+a+"/"+s}),{unsafe:!0})},9565:function(t,a,e){"use strict";var s=function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div")},o=[],i={methods:{makeToast:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null,a=arguments.length>1?arguments[1]:void 0;this.$bvToast.toast(a,{variant:t,solid:!0})}},watch:{testProp:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"success",a=arguments.length>1?arguments[1]:void 0;this.$bvToast.toast(a,{variant:t,solid:!0})}}},l=i,r=e("2877"),n=Object(r["a"])(l,s,o,!1,null,null,null);a["a"]=n.exports},ad6d:function(t,a,e){"use strict";var s=e("825a");t.exports=function(){var t=s(this),a="";return t.global&&(a+="g"),t.ignoreCase&&(a+="i"),t.multiline&&(a+="m"),t.dotAll&&(a+="s"),t.unicode&&(a+="u"),t.sticky&&(a+="y"),a}},b5d3:function(t,a,e){},c8ee:function(t,a,e){"use strict";e.r(a);var s=function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",{staticClass:"main-content"},[e("breadcumb",{attrs:{page:t.$t("system_config"),folder:t.$t("system_setting")}}),e("b-card",{attrs:{title:" "}},[e("b-form",{staticClass:"mx-5",on:{submit:function(a){return a.preventDefault(),t.saveConfig(a)}}},[t._l(t.rows,(function(a){return e("div",{key:a.id,staticClass:"form-group row justify-content-center"},[e("label",{staticClass:"col-sm-3 col-form-label",attrs:{for:a.global_key}},[t._v(" "+t._s(t.$t(a.global_key))+" ")]),"BONUS_SWITCH"==a.global_key?e("div",{staticClass:"col-sm-6"},[e("div",{staticClass:"col-sm-10 py-2"},[e("label",{staticClass:"switch switch-primary mr-3"},[e("input",{directives:[{name:"model",rawName:"v-model",value:t.dataset[a.global_key],expression:"dataset[item.global_key]"}],attrs:{type:"checkbox"},domProps:{checked:Array.isArray(t.dataset[a.global_key])?t._i(t.dataset[a.global_key],null)>-1:t.dataset[a.global_key]},on:{change:function(e){var s=t.dataset[a.global_key],o=e.target,i=!!o.checked;if(Array.isArray(s)){var l=null,r=t._i(s,l);o.checked?r<0&&t.$set(t.dataset,a.global_key,s.concat([l])):r>-1&&t.$set(t.dataset,a.global_key,s.slice(0,r).concat(s.slice(r+1)))}else t.$set(t.dataset,a.global_key,i)}}}),e("span",{staticClass:"slider"})])])]):"SITE_ON"==a.global_key?e("div",{staticClass:"col-sm-6"},[e("div",{staticClass:"col-sm-10 py-2"},[e("label",{staticClass:"switch switch-primary mr-3"},[e("input",{directives:[{name:"model",rawName:"v-model",value:t.dataset[a.global_key],expression:"dataset[item.global_key]"}],attrs:{type:"checkbox"},domProps:{checked:Array.isArray(t.dataset[a.global_key])?t._i(t.dataset[a.global_key],null)>-1:t.dataset[a.global_key]},on:{change:function(e){var s=t.dataset[a.global_key],o=e.target,i=!!o.checked;if(Array.isArray(s)){var l=null,r=t._i(s,l);o.checked?r<0&&t.$set(t.dataset,a.global_key,s.concat([l])):r>-1&&t.$set(t.dataset,a.global_key,s.slice(0,r).concat(s.slice(r+1)))}else t.$set(t.dataset,a.global_key,i)}}}),e("span",{staticClass:"slider"})])])]):"SUPPORT_QR_CN"==a.global_key?e("div",{staticClass:"col-sm-6"},[e("router-link",{directives:[{name:"show",rawName:"v-show",value:!t.displayCN,expression:"!displayCN"}],attrs:{to:"/upload"+t.dataset[a.global_key]+".jpg",target:"_blank"}},[e("img",{attrs:{src:t.origin+"/upload"+t.dataset[a.global_key]+".jpg",height:"50"},on:{error:t.imageLoadErrorCN}})]),e("b-form-file",{directives:[{name:"show",rawName:"v-show",value:t.displayCN,expression:"displayCN"}],staticClass:"form-control",attrs:{accept:"image/*",id:a.global_key},on:{change:t.setImageCN}})],1):"SUPPORT_QR_EN"==a.global_key?e("div",{staticClass:"col-sm-6"},[e("router-link",{directives:[{name:"show",rawName:"v-show",value:!t.displayEN,expression:"!displayEN"}],attrs:{to:"/upload"+t.dataset[a.global_key]+".jpg",target:"_blank"}},[e("img",{attrs:{src:t.origin+"/upload"+t.dataset[a.global_key]+".jpg",height:"50"},on:{error:t.imageLoadErrorEN}})]),e("b-form-file",{directives:[{name:"show",rawName:"v-show",value:t.displayEN,expression:"displayEN"}],staticClass:"form-control",attrs:{accept:"image/*",id:a.global_key},on:{change:t.setImageEN}})],1):e("div",{staticClass:"col-sm-6"},[e("b-form-input",{staticClass:"form-control",attrs:{type:"text",id:a.global_key,required:""},model:{value:t.dataset[a.global_key],callback:function(e){t.$set(t.dataset,a.global_key,e)},expression:"dataset[item.global_key]"}})],1)])})),e("div",{staticClass:"form-group row justify-content-center"},[e("div",{staticClass:"col-sm-9"},[e("div",{staticClass:"mt-4 float-right"},[e("b-button",{staticClass:"m-1",attrs:{type:"submit",variant:"primary"}},[t._v(t._s(t.$t("submit")))])],1)])])],2)],1),e("Dialog",{ref:"msg"})],1)},o=[],i=(e("a4d3"),e("e01a"),e("4160"),e("caad"),e("d3b7"),e("25f0"),e("2532"),e("159b"),e("06e0")),l=e("9565"),r=e("402a"),n={components:{Dialog:l["a"]},watch:{},data:function(){return{selectedId:null,title:"",dataset:{},isLoading:!1,canClear:!1,displayEN:!1,displayCN:!1,totalRecords:0,pageNumber:1,message:"",rows:[],origin:location.origin}},props:["success"],methods:{imageLoadErrorEN:function(){this.displayEN=!0},imageLoadErrorCN:function(){this.displayCN=!0},myClickEvent:function(){var t=this.$refs.key;t.click()},setImageEN:function(t){var a=t.target.files[0];console.log(a),this.dataset["SUPPORT_QR_EN"]=a,console.log(this.dataset["SUPPORT_QR_EN"]),a.type.includes("image/")||alert("Please select an image file")},setImageCN:function(t){var a=t.target.files[0];this.dataset["SUPPORT_QR_CN"]=a,a.type.includes("image/")||alert("Please select an image file")},processDate:function(t){var a=new Date(t),e=a.getMinutes(),s=a.getHours();1==e.toString().length&&(e="0"+e),1==s.toString().length&&(s="0"+s);var o=a.getFullYear()+"-"+(a.getMonth()+1)+"-"+a.getDate()+" "+s+":"+e;return o},onPageChange:function(t){this.pageNumber=t.currentPage,this.loadItems();var a=this.$el.querySelector("#table"),e=a.offsetTop;window.scrollTo(0,e)},onSearch:function(){this.pageNumber=1,this.loadItems()},onCancel:function(){this.canClear=!1,this.loadItems()},addFile:function(){console.log("hello")},saveConfig:function(){for(var t in this.dataset)("SITE_ON"==t||"BONUS_SWITCH"==t)&&(this.dataset[t]?this.dataset[t]=1:this.dataset[t]=0);var a=new FormData;for(var e in this.dataset)a.append(e,this.dataset[e]);var s=Object(i["qb"])(a),o=this;s.then((function(t){0==t.data.code&&o.$refs.msg.makeToast("success",o.$t("successSubmit")),o.dataset={},o.rows=[],o.loadItems()})).catch((function(t){o.$refs.msg.makeToast("warning",o.$t(Object(r["b"])(t)))}))},showModal:function(t){this.$bvModal.show("modal-1");var a=this,e=t;a.selectedId=e.id,a.title=e.title,a.body=e.body,a.rebody=e.rebody},clearData:function(){this.canEdit=!1;var t=this;t.selectedId=null,t.title="",t.description="",t.type="1",t.language="",t.is_display=0,t.imgSrc=""},loadItems:function(){var t=Object(i["wb"])(),a=this;this.isLoading=!0,t.then((function(t){var e=t.data.data.record;a.rows=e,a.isLoading=!1,e.forEach((function(t){"BONUS_SWITCH"==t.global_key||"SITE_ON"==t.global_key?1==t.key_value?a.dataset[t.global_key]=!0:a.dataset[t.global_key]=!1:a.dataset[t.global_key]=t.key_value}))})).catch((function(t){a.$refs.msg.makeToast("warning",a.$t(Object(r["b"])(t)))}))}},created:function(){this.loadItems()}},c=n,d=(e("ea16"),e("2877")),g=Object(d["a"])(c,s,o,!1,null,null,null);a["default"]=g.exports},e01a:function(t,a,e){"use strict";var s=e("23e7"),o=e("83ab"),i=e("da84"),l=e("5135"),r=e("861d"),n=e("9bf2").f,c=e("e893"),d=i.Symbol;if(o&&"function"==typeof d&&(!("description"in d.prototype)||void 0!==d().description)){var g={},u=function(){var t=arguments.length<1||void 0===arguments[0]?void 0:String(arguments[0]),a=this instanceof u?new d(t):void 0===t?d():d(t);return""===t&&(g[a]=!0),a};c(u,d);var m=u.prototype=d.prototype;m.constructor=u;var b=m.toString,f="Symbol(test)"==String(d("test")),y=/^Symbol\((.*)\)[^)]+$/;n(m,"description",{configurable:!0,get:function(){var t=r(this)?this.valueOf():this,a=b.call(t);if(l(g,t))return"";var e=f?a.slice(7,-1):a.replace(y,"$1");return""===e?void 0:e}}),s({global:!0,forced:!0},{Symbol:u})}},ea16:function(t,a,e){"use strict";var s=e("b5d3"),o=e.n(s);o.a}}]);
//# sourceMappingURL=chunk-c27ef4b6.5fcbf5b7.js.map