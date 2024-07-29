<template>
    <div class="main-content">
        <breadcumb :page="$t('packageManage')" :folder="$t('package')" />
        <b-card v-if="userInfo != null" title=" ">
            <b-form class="mx-5" v-on:submit.prevent="submitPackage">
                <div v-for="(value, propertyName) in userInfo" :key="value"
                    class="form-group row justify-content-center">
                    <label :for="propertyName" class="col-sm-3 col-form-label">
                        {{ $t(propertyName) }}
                    </label>
                    <div class="col-sm-6">
                        <b-form-input type="text" class="form-control" :id="value" :value="value" readonly />
                    </div>
                </div>
                <div class="form-group row justify-content-center">
                    <label for="package" class="col-sm-3 col-form-label">
                        {{ $t('package') }}
                    </label>
                    <div class="col-sm-6">
                        <b-form-select v-model="packageID" :options="selectOptions" id="type2">
                        </b-form-select>
                    </div>
                </div>
                <div class="form-group row justify-content-center">
                    <div class="col-sm-9">
                        <div class="mt-4 float-right">
                            <b-button type="submit" class="m-1" variant="primary" :disabled="isLoading">{{
                                $t("submit")
                            }}</b-button>
                        </div>
                    </div>
                </div>
            </b-form>
        </b-card>
        <b-card v-else :title="$t('search') + ' ' + $t('username')">
            <b-form class="mx-5" v-on:submit.prevent="searchUsername">
                <div class="row justify-content-center">
                    <div class="col-6">
                        <div class="form-group row justify-content-center">
                            <label :for="username" class="col-sm-12 col-form-label">
                                {{ $t('username') }}
                            </label>
                            <div class="col-sm-12">
                                <b-form-input type="text" class="form-control" id="username" v-model="username"
                                    required />
                            </div>
                        </div>
                        <div class="form-group row justify-content-center">
                            <div class="col-sm-12">
                                <div class="mt-4 float-right">
                                    <b-button type="submit" class="m-1" variant="primary" :disabled="isLoading">{{
                                        $t("search")
                                    }}</b-button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </b-form>
        </b-card>
        <Dialog ref="msg"></Dialog>
    </div>
</template>

<script>
import { getUserInfo, getPackage, addPackage } from "../../../system/api/api";
import Dialog from "../../../components/dialog.vue";
import { handleError } from "../../../system/handleRes";
export default {
    components: {
        Dialog,
    },
    watch: {},
    data() {
        return {
            selectedId: null,
            title: "",
            dataset: {},
            isLoading: false,
            canClear: false,
            displayEN: false,
            displayCN: false,
            totalRecords: 0,
            pageNumber: 1,
            message: "",
            rows: [],
            origin: location.origin,
            username: null,
            userInfo: null,
            selectOptions: [
            ],
            userID: null,
            packageID: null,
        };
    },
    props: ["success"],
    methods: {
        processDate(rawDate) {
            var d = new Date(rawDate);
            var dMinute = d.getMinutes();
            var dHour = d.getHours();
            if (dMinute.toString().length == 1) {
                dMinute = "0" + dMinute;
            }

            if (dHour.toString().length == 1) {
                dHour = "0" + dHour;
            }
            var date =
                d.getFullYear() +
                "-" +
                (d.getMonth() + 1) +
                "-" +
                d.getDate() +
                " " +
                dHour +
                ":" +
                dMinute;
            return date;
        },
        onPageChange(params) {
            this.pageNumber = params.currentPage;
            this.loadItems();
            var container = this.$el.querySelector("#table");
            var top = container.offsetTop;

            window.scrollTo(0, top);
        },
        onSearch() {
            this.pageNumber = 1;
            this.loadItems();
        },
        onCancel() {
            this.canClear = false;
            this.loadItems();
        },
        searchUsername() {
            var result = getUserInfo(this.username);
            var self = this;
            self.isLoading = true;
            result
                .then(function (value) {
                    if (value.data.data.record == null) {
                        // self.username = null;
                        self.$refs.msg.makeToast("danger", self.$t('memberNotFound'));

                    } else {
                        var user = value.data.data.record;
                        self.userID = user['id'];
                        self.userInfo = {};
                        self.userInfo['username'] = user['username'];
                        // self.userInfo['email'] = user['email'];
                        // self.userInfo['mobile'] = '+' + user['country']['phone_code'] + user['contact_number'];
                        // console.log(user);

                    }
                    self.isLoading = false;
                })
                .catch(function (error) {
                    self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
                    // localStorage.removeItem("userToken");
                    // self.$router.push("/admin/sessions/signIn");
                });

        },
        submitPackage() {
            let formData = new FormData();
            formData.append('user_id', this.userID);
            formData.append('package_id', this.packageID);

            var result = addPackage(formData);
            var self = this;
            self.isLoading = true;
            result
                .then(function (value) {
                    if (value.data.code == 0) {
                        self.$refs.msg.makeToast("success", self.$t("successSubmit"));
                        self.userInfo = null;
                        self.userID = null;
                        self.username = null;
                        self.packageID = [];
                        self.loadItems();
                    } else {
                        self.$refs.msg.makeToast("danger", self.$t(value.data.message));

                    }
                    self.isLoading = false;
                })
                .catch(function (error) {
                    self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
                    // localStorage.removeItem("userToken");
                    // self.$router.push("/admin/sessions/signIn");
                });

        },
        showModal(row) {
            this.$bvModal.show("modal-1");

            var self = this;
            var contentData = row;
            self.selectedId = contentData.id;
            self.title = contentData.title;
            self.body = contentData.body;
            self.rebody = contentData.rebody;
        },
        clearData() {
            this.canEdit = false;
            var self = this;
            self.selectedId = null;
            self.title = "";
            self.description = "";
            self.type = "1";
            self.language = "";
            self.is_display = 0;
            self.imgSrc = "";
        },
        loadItems() {
            var result = getPackage();
            var self = this;
            self.selectOptions = [];
            this.isLoading = true;
            result
                .then(function (value) {
                    for (let i = 0; i < value.data.data.package.length; i++) {
                        var tmp = {};
                        tmp['value'] = value.data.data.package[i].id;
                        tmp['text'] = value.data.data.package[i].package_name + '(' + value.data.data.package[i].remark + ')';
                        self.selectOptions.push(tmp);

                    }
                    self.isLoading = false;


                })
                .catch(function (error) {
                    self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
                });
        },
    },
    created() {
        this.loadItems();
    },
};
</script>

<style>
.upload-hint {
    position: absolute;
    width: 100%;
    height: 100%;
    border-style: dotted;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
}

.hiddenClass {
    pointer-events: none;
    display: none;
}

.bodyWidth {
    min-width: 250px;
}

.overflow {
    white-space: nowrap;
    overflow: hidden;
    display: inline-block;
    width: 100%;
    text-overflow: ellipsis;
}
</style>