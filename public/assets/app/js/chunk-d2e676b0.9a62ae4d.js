(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-d2e676b0"],{"25f0":function(t,e,a){"use strict";var s=a("6eeb"),l=a("825a"),r=a("d039"),o=a("ad6d"),n="toString",i=RegExp.prototype,c=i[n],u=r((function(){return"/a/b"!=c.call({source:"a",flags:"b"})})),d=c.name!=n;(u||d)&&s(RegExp.prototype,n,(function(){var t=l(this),e=String(t.source),a=t.flags,s=String(void 0===a&&t instanceof RegExp&&!("flags"in i)?o.call(t):a);return"/"+e+"/"+s}),{unsafe:!0})},"4b78":function(t,e,a){"use strict";var s=a("9318"),l=a.n(s);l.a},8953:function(t,e,a){"use strict";a.r(e);var s=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"main-content"},[a("breadcumb",{attrs:{page:t.$t("followerUserList"),folder:t.$t("insuranceManage")}}),a("b-row",[a("b-col",{attrs:{md:"12"}},[a("b-card",{staticClass:"mb-30"},[a("b-row",{attrs:{"align-v":"center"}},[a("b-col",{attrs:{md:"2"}},[a("b-form-group",{attrs:{id:"input-group-1",label:t.$t("username"),"label-for":"input-1"}},[a("b-form-input",{attrs:{id:"input-1",type:"text",required:"",placeholder:t.$t("Enter")+t.$t("username")},model:{value:t.searchUsername,callback:function(e){t.searchUsername=e},expression:"searchUsername"}})],1)],1),a("b-col",{staticClass:"mt-3 mt-md-0",attrs:{md:"3"}},[a("b-form-group",{attrs:{id:"input-group-2",label:t.$t("from"),"label-for":"input-2"}},[a("b-form-input",{attrs:{id:"input-2",type:"date"},model:{value:t.from,callback:function(e){t.from=e},expression:"from"}})],1)],1),a("b-col",{staticClass:"mt-3 mt-md-0",attrs:{md:"3"}},[a("b-form-group",{attrs:{id:"input-group-2",label:t.$t("to"),"label-for":"input-2"}},[a("b-form-input",{attrs:{id:"input-2",type:"date"},model:{value:t.to,callback:function(e){t.to=e},expression:"to"}})],1)],1),a("b-col",{staticClass:"mt-3 mt-md-0",attrs:{md:"1"}},[a("b-button",{attrs:{disabled:t.isLoading,variant:"primary"},on:{click:t.onSearch}},[t._v(t._s(t.$t("search")))])],1),t.canClear?a("b-col",{staticClass:"mt-3 mt-md-0",attrs:{md:"1"}},[a("b-button",{attrs:{disabled:t.isLoading,variant:"danger"},on:{click:t.onCancel}},[t._v(t._s(t.$t("clear")))])],1):t._e()],1)],1)],1)],1),a("b-card",{attrs:{title:t.$t("followerUserList")}},[a("vue-good-table",{attrs:{id:"table",mode:"remote",totalRows:t.totalRecords,isLoading:t.isLoading,columns:t.columns,"search-options":{enabled:!1,placeholder:"Search this table"},"pagination-options":{enabled:!1,perPageDropdownEnabled:!1,perPageDropdown:[10],dropdownAllowAll:!1,rowsPerPageLabel:t.$t("rowPerPage"),nextLabel:t.$t("next"),prevLabel:t.$t("previous"),mode:"pages",pageLabel:t.$t("page"),setCurrentPage:t.pageNumber},styleClass:"tableOne vgt-table table-striped",selectOptions:{enabled:!1,selectionInfoClass:"table-alert__box"},rows:t.rows},on:{"on-page-change":t.onPageChange,"on-search":t.onSearch},scopedSlots:t._u([{key:"table-row",fn:function(e){return["status"==e.column.field?a("span",[0==e.row.status?a("span",[a("b-badge",{attrs:{href:"#",variant:"warning m-2"}},[t._v(t._s(t.$t("pending")))])],1):1==e.row.status?a("span",[a("b-badge",{attrs:{href:"#",variant:"primary m-2"}},[t._v(t._s(t.$t("approve")))])],1):a("span",[a("b-badge",{attrs:{href:"#",variant:"danger m-2"}},[t._v(t._s(t.$t("reject")))])],1)]):"created_at"==e.column.field?a("span",[t._v(" "+t._s(e.row.created_at)+" ")]):"user_group_id"==e.column.field?a("span",["en"==t.$i18n.locale?a("span",[t._v(" "+t._s(e.row.package.package_name_en)+" ")]):a("span",[t._v(t._s(e.row.package.package_name))])]):"user_rank_id"==e.column.field?a("span",[t._v(" "+t._s(t.checkRank(e.row))+" ")]):"set_rank"==e.column.field?a("span",[t._v(" "+t._s(t.checkLowestRank(e.row.set_rank))+" ")]):t._e()]}}])}),a("div",{staticClass:"align-items-center mobile-adjust"},[t.totalRecords>0?a("div",{staticClass:"d-flex flex-wrap align-items-center justify-content-start mt-3"},[a("p",{staticClass:"text-light text-16 mr-2"},[t._v(t._s(t.$t("total")))]),a("p",{staticClass:"text-muted text-16",staticStyle:{"font-weight":"bold"}},[t._v(" "+t._s(t.totalRecords)+" ")])]):a("div"),a("div",{staticClass:"d-flex flex-wrap align-items-center justify-content-end"},[a("b-pagination",{staticClass:"pagi-margin pt-3",attrs:{"total-rows":t.totalRecords,"per-page":10,"first-text":t.$t("first"),"prev-text":t.$t("prev"),"next-text":t.$t("next"),"last-text":t.$t("last")},on:{input:function(e){return t.loadItems()}},model:{value:t.pageNumber,callback:function(e){t.pageNumber=e},expression:"pageNumber"}}),a("b-input-group",{staticClass:"ml-3",staticStyle:{width:"160px"}},[a("b-form-input",{attrs:{placeholder:t.$t("PageNo")},model:{value:t.pageNumber,callback:function(e){t.pageNumber=e},expression:"pageNumber"}}),a("b-input-group-append",[a("b-button",{attrs:{variant:"primary",disabled:t.isLoading},on:{keypress:function(e){return t.loadItems()},click:function(e){return t.loadItems()}}},[t._v(t._s(t.$t("go")))])],1)],1)],1)])],1),a("Dialog",{ref:"msg"}),a("b-modal",{attrs:{id:"modal-1",size:"lg",centered:"",title:t.$t("provideRemark"),"hide-footer":""}},[a("b-form",{staticClass:"mx-5",on:{submit:function(e){return e.preventDefault(),t.rejectW(e)}}},[a("b-row",{attrs:{"align-h":"center"}},[a("b-col",{attrs:{md:"10 mb-30"}},[a("div",{staticClass:"form-group row"},[a("label",{staticClass:"col-sm-2 col-form-label",attrs:{for:"remark"}},[t._v(t._s(t.$t("remark")))]),a("div",{staticClass:"col-sm-10"},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.remark,expression:"remark"}],staticClass:"form-control",attrs:{type:"text",id:"remark",required:""},domProps:{value:t.remark},on:{input:function(e){e.target.composing||(t.remark=e.target.value)}}})])]),a("div",{staticClass:"form-group row justify-content-end"},[a("div",{staticClass:"col-sm-12"},[a("div",{staticClass:"mt-4 float-right"},[a("b-button",{staticClass:"m-1",attrs:{disabled:t.isLoading,type:"submit",variant:"primary"}},[t._v(t._s(t.$t("submit")))])],1)])])])],1)],1)],1)],1)},l=[],r=(a("d3b7"),a("25f0"),a("5530")),o=a("06e0"),n=a("402a"),i=a("9565"),c=a("2f62"),u={computed:Object(r["a"])({},Object(c["c"])(["lang"]),{walletLabel:function(){return[{label:this.$t("id"),text:"id",field:"id",thClass:"gull-th-class",value:"id",sortable:!1},{label:this.$t("username"),text:"username",field:"username",thClass:"gull-th-class",value:"username",sortable:!1},{label:this.$t("amount"),text:"amount",field:"amount",thClass:"gull-th-class",value:"amount",sortable:!1},{label:this.$t("opened_rate"),text:"opened_rate",field:"opened_rate",thClass:"gull-th-class",value:"opened_rate",sortable:!1},{label:this.$t("closed_rate"),text:"closed_rate",field:"closed_rate",thClass:"gull-th-class",value:"closed_rate",sortable:!1},{label:this.$t("pl"),text:"pl",field:"pl",thClass:"gull-th-class",value:"pl",sortable:!1},{label:this.$t("trade_type"),text:"trade_type",field:"trade_type",thClass:"gull-th-class",value:"trade_type",sortable:!1},{label:this.$t("opened_date"),text:"opened_date",field:"opened_date",thClass:"gull-th-class",value:"opened_date",sortable:!1},{label:this.$t("closed_date"),text:"closed_date",field:"closed_date",thClass:"gull-th-class",value:"closed_date",sortable:!1},{label:this.$t("asset"),text:"asset",field:"asset",thClass:"gull-th-class",value:"asset",sortable:!1},{label:this.$t("created_at"),text:"created_at",field:"created_at",thClass:"gull-th-class",value:"created_at",sortable:!1}]},columns:function(){return[{label:this.$t("user_id"),text:"id",field:"id",thClass:"gull-th-class",value:"id",sortable:!1},{label:this.$t("username"),text:"username",field:"username",thClass:"gull-th-class",value:"username",sortable:!1},{label:this.$t("fullname"),text:"fullname",field:"fullname",thClass:"gull-th-class",value:"fullname",sortable:!1},{label:this.$t("email"),text:"email",field:"email",thClass:"gull-th-class",value:"email",sortable:!1},{label:this.$t("master_trader"),text:"follow_trader",field:"follow_trader",thClass:"gull-th-class",value:"follow_trader",sortable:!1},{label:this.$t("package"),text:"user_group_id",field:"user_group_id",thClass:"gull-th-class",value:"user_group_id",sortable:!1},{label:this.$t("point1"),text:"point1",field:"point1",thClass:"gull-th-class",value:"point1",sortable:!1},{label:this.$t("point2"),text:"point2",field:"point2",thClass:"gull-th-class",value:"point2",sortable:!1},{label:this.$t("point3"),text:"point3",field:"point3",thClass:"gull-th-class",value:"point3",sortable:!1},{label:this.$t("user_rank"),text:"user_rank_id",field:"user_rank_id",thClass:"gull-th-class",value:"user_rank_id",sortable:!1},{label:this.$t("registerDate"),text:"created_at",field:"created_at",thClass:"gull-th-class",value:"created_at",tdClass:"dateWidth",sortable:!1}]}}),components:{Dialog:i["a"]},data:function(){return{selectedId:null,isLoading:!1,canClear:!1,totalRecords:0,pageNumber:1,message:"",rows:[],username:"",remark:"",searchUsername:"",searchUsernameWallet:"",walletPageNumber:1,totalWalletRecords:0,from:"",to:"",canShow:!1,tabIndex:0,walletRows:[]}},props:["success"],methods:{processDate:function(t){var e=new Date(t),a=e.getMinutes(),s=e.getHours();1==a.toString().length&&(a="0"+a),1==s.toString().length&&(s="0"+s);var l=e.getFullYear()+"-"+(e.getMonth()+1)+"-"+e.getDate()+" "+s+":"+a;return l},checkRank:function(t){return 1==t.user_group_id?this.$t("nonMember"):"en"==this.$i18n.locale?t.rank.rank_name_en:t.rank.rank_name},checkLowestRank:function(t){for(var e=0;e<this.user_rank_idOptions.length;e++)if(this.user_rank_idOptions[e].value==t)return this.user_rank_idOptions[e].text},onPageChange:function(t){this.pageNumber=t.currentPage,this.loadItems();var e=this.$el.querySelector("#table"),a=e.offsetTop;window.scrollTo(0,a)},onSearch:function(){this.pageNumber=1,""==this.searchUsername&&""==this.from&&""==this.to||(this.canClear=!0),this.loadItems()},onCancel:function(){this.searchUsername="",this.from="",this.to="",this.canClear=!1,this.loadItems()},showModal:function(t,e){this.selectedId=t.id,this.selectedAction=e},showModalApprove:function(t){var e=this;this.$swal({title:this.$t("are_you_sure_to_approve"),text:this.$t("double_confirm"),type:"warning",showCancelButton:!0,cancelButtonText:this.$t("cancel"),confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:this.$t("approve")}).then((function(a){a.value&&(console.log(a.value),e.approved(t))}))},clearData:function(){this.canEdit=!1;var t=this;t.selectedId=null,t.username="",t.remark=""},loadItems:function(){var t=Object(o["z"])(this.pageNumber,this.from,this.to,this.searchUsername,"BOT"),e=this;this.isLoading=!0,t.then((function(t){console.log(t);var a=t.data.data.user.data;e.rows=a,e.totalRecords=t.data.data.user.total,e.isLoading=!1})).catch((function(t){e.$refs.msg.makeToast("warning",e.$t(Object(n["b"])(t)))}))}},created:function(){this.loadItems()}},d=u,p=(a("4b78"),a("2877")),m=Object(p["a"])(d,s,l,!1,null,null,null);e["default"]=m.exports},9318:function(t,e,a){},9565:function(t,e,a){"use strict";var s=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div")},l=[],r={methods:{makeToast:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null,e=arguments.length>1?arguments[1]:void 0;this.$bvToast.toast(e,{variant:t,solid:!0})}},watch:{testProp:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"success",e=arguments.length>1?arguments[1]:void 0;this.$bvToast.toast(e,{variant:t,solid:!0})}}},o=r,n=a("2877"),i=Object(n["a"])(o,s,l,!1,null,null,null);e["a"]=i.exports},ad6d:function(t,e,a){"use strict";var s=a("825a");t.exports=function(){var t=s(this),e="";return t.global&&(e+="g"),t.ignoreCase&&(e+="i"),t.multiline&&(e+="m"),t.dotAll&&(e+="s"),t.unicode&&(e+="u"),t.sticky&&(e+="y"),e}}}]);
//# sourceMappingURL=chunk-d2e676b0.9a62ae4d.js.map