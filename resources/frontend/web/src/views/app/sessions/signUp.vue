<template>
  <div class="main-content auth-layout-wrap h-100 w-100 mx-auto">
    <div class="row justify-content-center rowAdjust">
      <div class="col-12">
        <div class="d-flex justify-content-between align-items-center w-100">
          <div class="appBar">
            <a @click="$router.go(-1)" class="ml-2">
              <i class="fa fa-chevron-left"></i>
            </a>
          </div>
          <b-dropdown
            id="dropdown-1"
            :text="$t('language')"
            class="m-md-2 mb-3 text-right"
            variant="primary"
          >
            <b-dropdown-item @click="changeLang('en')">
              <i class="header-icon"><flag iso="US" /></i> English
            </b-dropdown-item>
            <b-dropdown-item @click="changeLang('zh')">
              <i class="header-icon"><flag iso="CN" /></i> 中文
            </b-dropdown-item>
          </b-dropdown>
        </div>
      </div>
      <div class="col-md-10">
        <div class="auth-logo text-center">
          <img :src="logo" />
        </div>
        <div class="p-4" style="margin-top: auto; margin-bottom: auto">
          <b-form @submit.prevent="submit" style="margin-bottom: 100px">
            <div class="form-group row mb-3">
              <label for="ref_id" class="col-12 col-form-label">{{
                $t("ref_id")
              }}</label>
              <div class="col-12">
                <input
                  class="form-control form-custom"
                  v-model="refID"
                  type="text"
                  required
                />
              </div>
            </div>

            <div class="form-group row mb-3">
              <label for="username" class="col-12 col-form-label">{{
                $t("username")
              }}</label>
              <div class="col-12">
                <input
                  class="form-control form-custom"
                  v-model="username"
                  @keydown="checkKeyDownAlphaNumeric($event)"
                  type="text"
                  required
                />
                <b-alert
                  show
                  variant="danger"
                  class="error col mt-1"
                  v-if="!name2Valid"
                  >{{ $t("not_valid") }}</b-alert
                >
              </div>
            </div>

            <div class="form-group row mb-3">
              <label for="full_name" class="col-12 col-form-label">{{
                $t("full_name")
              }}</label>
              <div class="col-12">
                <input
                  class="form-control form-custom"
                  v-model="full_name"
                  type="text"
                  required
                />
              </div>
            </div>

            <div class="form-group row mb-3">
              <label for="identity_no" class="col-12 col-form-label">{{
                $t("identity_no")
              }}</label>
              <div class="col-12">
                <input
                  class="form-control form-custom"
                  v-model="ic"
                  type="text"
                  required
                />
              </div>
            </div>

            <div class="form-group row mb-3">
              <label
                for="identity_no"
                class="col-12 col-form-label"
                >{{
              }}</label>
              <div class="col-12">
                <h6 style="color: red">
                  {{ $t("ICwarn1") }} <br />
                  {{ $t("ICwarn2") }}
                </h6>
              </div>
            </div>
            <!-- <b-form-input
                  class="form-control form-custom mb-3 form-custom"
                  v-model="email"
                  :placeholder="$t('email')"
                  required
                >
                </b-form-input> -->
            <!-- <b-form-select
                  v-model="country"
                  class="form-control form-custom mb-3"
                  :value="country"
                  :options="countryOptions"
                  @change="updateCode"
                  id="country"
                  required
                  style="
                    border-radius: 0.75rem !important;
                    height: calc(2.5rem + 2px);
                    background-color: transparent !important;
                    border: 3px grey solid;
                    color: #000;
                  "
                >
                </b-form-select> -->

            <div class="form-group row mb-3">
              <label for="country" class="col-12 col-form-label">{{
                $t("country")
              }}</label>
              <div class="col-12">
                <div
                  class="form-control form-custom mb-1"
                  @click="openOtp()"
                  id="demo"
                >
                  {{ $t("country") }}
                </div>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label for="phone" class="col-12 col-form-label">{{
                $t("phone")
              }}</label>
              <div class="col-12">
                <b-input-group>
                  <b-input-group-prepend class="mb-3">
                    <span class="input-group-text">{{ countryCode }}</span>
                  </b-input-group-prepend>
                  <b-form-input
                    style="
                      border-top-left-radius: 0px !important;
                      border-bottom-left-radius: 0px !important;
                    "
                    class="form-control form-custom"
                    v-model="mobile"
                    type="number"
                    required
                  >
                  </b-form-input>
                </b-input-group>
                <!-- <input
                  class="form-control form-custom"
                  v-model="mobile"
                  type="number"
                  required
                />-->
              </div>
            </div>

            <div class="form-group row mb-3">
              <label for="email" class="col-12 col-form-label">{{
                $t("email")
              }}</label>
              <div class="col-12">
                <input
                  class="form-control form-custom"
                  v-model="email"
                  type="email"
                  required
                />
              </div>
            </div>

            <!-- <div class="form-group row mb-3">
                  <label for="email" class="col-12 col-form-label">{{
                    $t("email")
                  }}</label>
                  <div class="col-12">
                    <b-input-group>
                      <b-input-group-prepend class="mb-3 form-custom-prepend">
                      </b-input-group-prepend>
                      <b-form-input
                        class="form-control form-custom mb-3 form-custom-none"
                        v-model="email"
                        type="text"
                        :placeholder="$t('email')"
                        style="background-color: transparent !important;border-radius: 0.2rem !important;height: auto;font-size: inherit;color:white"
                        required
                      >
                      </b-form-input>
                      <b-input-group-append
                        class="form-custom-append"
                        style="position: relative"
                      >
                        <b-button
                          style="
                            height: 100%;
                          "
                          :disabled="startCount || sending"
                          @click="getOTP"
                        >
                          <span v-if="!sending">{{ $t("getCode") }}</span
                          ><span v-else class="">{{ $t("loading...") }}</span>
                        </b-button>
                        <div
                          v-if="startCount"
                          class="text-center py-2 overlay-text"
                        >
                          {{ timecount }} s
                        </div>
                      </b-input-group-append>
                    </b-input-group>
                  </div>
                </div> -->

            <!-- <div class="form-group row mb-3">
                  <label for="otp" class="col-12 col-form-label">{{
                    $t("otp")
                  }}</label>
                  <div class="col-12">
                    <input
                      class="form-control form-custom"
                      v-model="otp"
                      type="text"
                      required
                    />
                  </div>
                </div> -->

            <div class="form-group row mb-3">
              <label for="password" class="col-12 col-form-label">{{
                $t("password")
              }}</label>
              <div class="col-12">
                <input
                  class="form-control form-custom"
                  v-model="otp"
                  type="password"
                  v-model.trim="password"
                  required
                />
                <b-alert
                  show
                  variant="danger"
                  class="error col mt-1"
                  v-if="!$v.password.minLength"
                  >{{ $t("min") }} {{ $v.password.$params.minLength.min }}
                  {{ $t("character") }}</b-alert
                >
              </div>
            </div>

            <div class="form-group row mb-3">
              <label for="confirm_password" class="col-12 col-form-label">{{
                $t("confirm_password")
              }}</label>
              <div class="col-12">
                <input
                  class="form-control form-custom"
                  type="password"
                  v-model.trim="$v.repeatPassword.$model"
                  required
                />
                <b-alert
                  show
                  variant="danger"
                  class="error col mt-1"
                  v-if="!$v.repeatPassword.sameAsPassword"
                  >{{ $t("passwordNotMatch") }}</b-alert
                >
              </div>
            </div>

            <!-- <div
                  class="container d-block mx-auto w-15"
                  style="margin-bottom: 25px"
                >
                  <div class="row">
                      <label for="vehicle1" style="vertical-align: middle">
                        Already has an account ?</label
                      >
                      <span
                        @click="$router.push('/web/sessions/signIn')"
                        style="
                          color: white;
                          font-weight: 900;
                          margin-left: 5px;
                          vertical-align: super;
                        "
                        ><u>Login</u></span
                      >
                  </div>
                </div> -->

            <b-button
              type="submit"
              block
              class="mt-4 btn-square"
              variant="primary"
              style=""
              :disabled="
                submitStatus === 'PENDING' ||
                $v.$invalid ||
                !name2Valid ||
                !name3Valid
              "
              >{{
                submitStatus === "PENDING" ? "Submitting..." : $t("sign_up")
              }}</b-button
            >

            <p v-once class="typo__p" v-if="submitStatus === 'OK'">
              {{ makeToastTwo("success") }}
              {{ this.$router.push("/") }}
            </p>
            <p v-once class="typo__p" v-if="submitStatus === 'ERROR'">
              {{ makeToast("danger") }}
            </p>
            <div v-once class="typo__p" v-if="submitStatus === 'PENDING'">
              <div class="spinner sm spinner-primary mt-3"></div>
            </div>
          </b-form>
        </div>
        <center
          class="text-white"
          style="
            margin-left: auto;
            margin-right: auto;
            left: 0px;
            right: 0px;
            text-align: center;
          "
        >
          <p>© 2022 Winato Trade</p>
        </center>
      </div>
    </div>

    <b-modal
      id="modal-tnc"
      size="md"
      centered
      :title="$t('our_terms_of_use')"
      :hide-footer="true"
      style="background-color: #5f646e !important"
    >
      <b-row align-h="center">
        <b-col md="12 mb-30">
          <h6>
            {{ $t("our_terms_of_use2") }}
          </h6>
          <p>{{ $t("our_terms_of_use3") }}</p>
          <p>{{ $t("our_terms_of_use4") }}</p>
          <p>{{ $t("our_terms_of_use5") }}</p>
          <p>{{ $t("our_terms_of_use6") }}</p>
          <p>{{ $t("our_terms_of_use7") }}</p>
          <p>{{ $t("our_terms_of_use8") }}</p>
          <p>{{ $t("our_terms_of_use9") }}</p>
          <p>{{ $t("our_terms_of_use10") }}</p>
          <p>{{ $t("our_terms_of_use11") }}</p>
          <p>{{ $t("our_terms_of_use12") }}</p>
          <p>{{ $t("our_terms_of_use13") }}</p>
          <p>{{ $t("our_terms_of_use14") }}</p>
          <p>{{ $t("our_terms_of_use15") }}</p>
          <p>{{ $t("our_terms_of_use16") }}</p>
          <p>{{ $t("our_terms_of_use17") }}</p>
          <p>{{ $t("our_terms_of_use18") }}</p>
          <p>{{ $t("our_terms_of_use19") }}</p>
          <p>{{ $t("our_terms_of_use20") }}</p>
          <p>{{ $t("our_terms_of_use21") }}</p>
          <p>{{ $t("our_terms_of_use22") }}</p>
          <p>{{ $t("our_terms_of_use23") }}</p>
          <p>{{ $t("our_terms_of_use24") }}</p>
          <p>{{ $t("our_terms_of_use25") }}</p>
          <p>{{ $t("our_terms_of_use26") }}</p>
          <p>{{ $t("our_terms_of_use27") }}</p>
          <p>{{ $t("our_terms_of_use28") }}</p>
          <p>{{ $t("our_terms_of_use29") }}</p>
          <p>{{ $t("our_terms_of_use30") }}</p>
          <p>{{ $t("our_terms_of_use31") }}</p>
          <p>{{ $t("our_terms_of_use32") }}</p>
          <p>{{ $t("our_terms_of_use33") }}</p>
          <p>{{ $t("our_terms_of_use34") }}</p>
          <p>{{ $t("our_terms_of_use35") }}</p>
          <p>{{ $t("our_terms_of_use36") }}</p>
          <p>{{ $t("our_terms_of_use37") }}</p>
          <p>{{ $t("our_terms_of_use38") }}</p>
          <p>{{ $t("our_terms_of_use39") }}</p>
          <p>{{ $t("our_terms_of_use40") }}</p>
          <p>{{ $t("our_terms_of_use41") }}</p>
          <p>{{ $t("our_terms_of_use42") }}</p>
          <p>{{ $t("our_terms_of_use43") }}</p>
          <p>{{ $t("our_terms_of_use44") }}</p>
          <p>{{ $t("our_terms_of_use45") }}</p>
          <p>{{ $t("our_terms_of_use46") }}</p>
          <p>{{ $t("our_terms_of_use47") }}</p>
          <p>{{ $t("our_terms_of_use48") }}</p>
          <p>{{ $t("our_terms_of_use49") }}</p>
          <p>{{ $t("our_terms_of_use50") }}</p>
          <p>{{ $t("our_terms_of_use51") }}</p>
          <p>{{ $t("our_terms_of_use52") }}</p>
          <p>{{ $t("our_terms_of_use53") }}</p>
          <p>{{ $t("our_terms_of_use54") }}</p>
          <p>{{ $t("our_terms_of_use55") }}</p>
          <p>{{ $t("our_terms_of_use56") }}</p>
          <p>{{ $t("our_terms_of_use57") }}</p>
          <p>{{ $t("our_terms_of_use58") }}</p>
        </b-col>
        <b-button
          @click="closeTnc()"
          type="submit"
          block
          style="
            background: linear-gradient(
              rgb(254, 190, 193),
              rgb(211, 41, 230)
            ) !important;
            border-radius: 10px;
            color: black;
            border: 1px solid #febec1;
            margin: auto;
            width: 50%;
          "
          >{{ $t("confirm") }}</b-button
        >
      </b-row>
    </b-modal>
    <b-modal
      id="modal-otp"
      size="md"
      centered
      :title="$t('country')"
      :hide-footer="true"
      style="background-color: white !important"
    >
      <b-container class="bv-example-row">
        <b-row @click="selectCountry(1, $t('india'))">
          <b-col cols="1"
            ><i class="header-icon-country"><flag iso="IN" /></i
          ></b-col>
          <b-col cols="7" class="middle">{{ $t("india") }}</b-col>
          <b-col cols="2" class="middle">+91</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(12, $t('aus'))">
          <b-col cols="1"
            ><i class="header-icon-country"><flag iso="AU" /></i
          ></b-col>
          <b-col cols="7" class="middle">{{ $t("aus") }}</b-col>
          <b-col cols="2" class="middle">+61</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(195, $t('uk'))">
          <b-col cols="1"
            ><i class="header-icon-country"><flag iso="GB" /></i
          ></b-col>
          <b-col cols="7" class="middle">{{ $t("uk") }}</b-col>
          <b-col cols="2" class="middle">+44</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(2, $t('malaysia'))">
          <b-col cols="1"
            ><i class="header-icon-country"><flag iso="MY" /></i
          ></b-col>
          <b-col cols="7" class="middle">{{ $t("malaysia") }}</b-col>
          <b-col cols="2" class="middle">+60</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(28, $t('brunei'))">
          <b-col cols="1"
            ><i class="header-icon-country"><flag iso="BN" /></i
          ></b-col>
          <b-col cols="7" class="middle">{{ $t("brunei") }}</b-col>
          <b-col cols="2" class="middle">+673</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(3, $t('china'))">
          <b-col cols="1"
            ><i class="header-icon-country"><flag iso="CN" /></i
          ></b-col>
          <b-col cols="7" class="middle">{{ $t("china") }}</b-col>
          <b-col cols="2" class="middle">+86</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(83, $t('indonesia'))">
          <b-col cols="1"
            ><i class="header-icon-country"><flag iso="ID" /></i
          ></b-col>
          <b-col cols="7" class="middle">{{ $t("indonesia") }}</b-col>
          <b-col cols="2" class="middle">+62</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(90, $t('japan'))">
          <b-col cols="1"
            ><i class="header-icon-country"><flag iso="JP" /></i
          ></b-col>
          <b-col cols="7" class="middle">{{ $t("japan") }}</b-col>
          <b-col cols="2" class="middle">+81</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(96, $t('korea_south'))">
          <b-col cols="1"
            ><i class="header-icon-country"><flag iso="KR" /></i
          ></b-col>
          <b-col cols="7" class="middle">{{ $t("korea_south") }}</b-col>
          <b-col cols="2" class="middle">+82</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(145, $t('philippines'))">
          <b-col cols="1"
            ><i class="header-icon-country"><flag iso="PH" /></i
          ></b-col>
          <b-col cols="7" class="middle">{{ $t("philippines") }}</b-col>
          <b-col cols="2" class="middle">+63</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(4, $t('singapore'))">
          <b-col cols="1"
            ><i class="header-icon-country"><flag iso="SG" /></i
          ></b-col>
          <b-col cols="7" class="middle">{{ $t("singapore") }}</b-col>
          <b-col cols="2" class="middle">+65</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(169, $t('south_africa'))">
          <b-col cols="1"
            ><i class="header-icon-country"><flag iso="ZA" /></i
          ></b-col>
          <b-col cols="7" class="middle">{{ $t("south_africa") }}</b-col>
          <b-col cols="2" class="middle">+27</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(180, $t('taiwan'))">
          <b-col cols="1"
            ><i class="header-icon-country"><flag iso="TW" /></i
          ></b-col>
          <b-col cols="7" class="middle">{{ $t("taiwan") }}</b-col>
          <b-col cols="2" class="middle">+886</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(193, $t('ukraine'))">
          <b-col cols="1"
            ><i class="header-icon-country"><flag iso="UA" /></i
          ></b-col>
          <b-col cols="7" class="middle">{{ $t("ukraine") }}</b-col>
          <b-col cols="2" class="middle">+380</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(69, $t('germany'))">
          <b-col cols="1"
            ><i class="header-icon-country"><flag iso="DE" /></i
          ></b-col>
          <b-col cols="7" class="middle">{{ $t("germany") }}</b-col>
          <b-col cols="2" class="middle">+49</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(65, $t('france'))">
          <b-col cols="1"
            ><i class="header-icon-country"><flag iso="FR" /></i
          ></b-col>
          <b-col cols="7" class="middle">{{ $t("france") }}</b-col>
          <b-col cols="2" class="middle">+33</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(86, $t('ireland'))">
          <b-col cols="1"
            ><i class="header-icon-country"><flag iso="IE" /></i
          ></b-col>
          <b-col cols="7" class="middle">{{ $t("ireland") }}</b-col>
          <b-col cols="2" class="middle">+353</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(150, $t('russia'))">
          <b-col cols="1"
            ><i class="header-icon-country"><flag iso="RU" /></i
          ></b-col>
          <b-col cols="7" class="middle">{{ $t("russia") }}</b-col>
          <b-col cols="2" class="middle">+7</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(35, $t('canada'))">
          <b-col cols="1"
            ><i class="header-icon-country"><flag iso="CA" /></i
          ></b-col>
          <b-col cols="7" class="middle">{{ $t("canada") }}</b-col>
          <b-col cols="2" class="middle">+1</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(207, $t('us'))">
          <b-col cols="1"
            ><i class="header-icon-country"><flag iso="US" /></i
          ></b-col>
          <b-col cols="7" class="middle">{{ $t("us") }}</b-col>
          <b-col cols="2" class="middle">+1</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(13, $t('austria'))">
          <b-col cols="1"
            ><i class="header-icon-country"><flag iso="AT" /></i
          ></b-col>
          <b-col cols="7" class="middle">{{ $t("austria") }}</b-col>
          <b-col cols="2" class="middle">+43</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(81, $t('hungary'))">
          <b-col cols="1"
            ><i class="header-icon-country"><flag iso="HU" /></i
          ></b-col>
          <b-col cols="7" class="middle">{{ $t("hungary") }}</b-col>
          <b-col cols="2" class="middle">+36</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(178, $t('switzerland'))">
          <b-col cols="1"
            ><i class="header-icon-country"><flag iso="CH" /></i
          ></b-col>
          <b-col cols="7" class="middle">{{ $t("switzerland") }}</b-col>
          <b-col cols="2" class="middle">+41</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(20, $t('belgium'))">
          <b-col cols="1"
            ><i class="header-icon-country"><flag iso="BE" /></i
          ></b-col>
          <b-col cols="7" class="middle">{{ $t("belgium") }}</b-col>
          <b-col cols="2" class="middle">+32</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(101, $t('latvia'))">
          <b-col cols="1"
            ><i class="header-icon-country"><flag iso="LV" /></i
          ></b-col>
          <b-col cols="7" class="middle">{{ $t("latvia") }}</b-col>
          <b-col cols="2" class="middle">+371</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(61, $t('estonia'))">
          <b-col cols="1"
            ><i class="header-icon-country"><flag iso="EE" /></i
          ></b-col>
          <b-col cols="7" class="middle">{{ $t("estonia") }}</b-col>
          <b-col cols="2" class="middle">+372</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(51, $t('denmark'))">
          <b-col cols="1"
            ><i class="header-icon-country"><flag iso="DK" /></i
          ></b-col>
          <b-col cols="7" class="middle">{{ $t("denmark") }}</b-col>
          <b-col cols="2" class="middle">+45</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(130, $t('netherlands'))">
          <b-col cols="1"
            ><i class="header-icon-country"><flag iso="NL" /></i
          ></b-col>
          <b-col cols="7" class="middle">{{ $t("netherlands") }}</b-col>
          <b-col cols="2" class="middle">+31</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(172, $t('spain'))">
          <b-col cols="1"
            ><i class="header-icon-country"><flag iso="ES" /></i
          ></b-col>
          <b-col cols="7" class="middle">{{ $t("spain") }}</b-col>
          <b-col cols="2" class="middle">+34</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(27, $t('brazil'))">
          <b-col cols="1"
            ><i class="header-icon-country"><flag iso="BR" /></i
          ></b-col>
          <b-col cols="7" class="middle">{{ $t("brazil") }}</b-col>
          <b-col cols="2" class="middle">+55</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(149, $t('romania'))">
          <b-col cols="1"
            ><i class="header-icon-country"><flag iso="RO" /></i
          ></b-col>
          <b-col cols="7" class="middle">{{ $t("romania") }}</b-col>
          <b-col cols="2" class="middle">+40</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(88, $t('italy'))">
          <b-col cols="1"
            ><i class="header-icon-country"><flag iso="IT" /></i
          ></b-col>
          <b-col cols="7" class="middle">{{ $t("italy") }}</b-col>
          <b-col cols="2" class="middle">+39</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(122, $t('monaco'))">
          <b-col cols="1"
            ><i class="header-icon-country"><flag iso="MC" /></i
          ></b-col>
          <b-col cols="7" class="middle">{{ $t("monaco") }}</b-col>
          <b-col cols="2" class="middle">+377</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(29, $t('bulgaria'))">
          <b-col cols="1"
            ><i class="header-icon-country"><flag iso="BG" /></i
          ></b-col>
          <b-col cols="7" class="middle">{{ $t("bulgaria") }}</b-col>
          <b-col cols="2" class="middle">+359</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(163, $t('albania'))">
          <b-col cols="1"
            ><i class="header-icon-country"><flag iso="AL" /></i
          ></b-col>
          <b-col cols="7" class="middle">{{ $t("albania") }}</b-col>
          <b-col cols="2" class="middle">+355</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(146, $t('poland'))">
          <b-col cols="1"
            ><i class="header-icon-country"><flag iso="PL" /></i
          ></b-col>
          <b-col cols="7" class="middle">{{ $t("poland") }}</b-col>
          <b-col cols="2" class="middle">+48</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(19, $t('belarus'))">
          <b-col cols="1"
            ><i class="header-icon-country"><flag iso="BY" /></i
          ></b-col>
          <b-col cols="7" class="middle">{{ $t("belarus") }}</b-col>
          <b-col cols="2" class="middle">+375</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(64, $t('finland'))">
          <b-col cols="1"
            ><i class="header-icon-country"><flag iso="FI" /></i
          ></b-col>
          <b-col cols="7" class="middle">{{ $t("finland") }}</b-col>
          <b-col cols="2" class="middle">+358</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(136, $t('norway'))">
          <b-col cols="1"
            ><i class="header-icon-country"><flag iso="NO" /></i
          ></b-col>
          <b-col cols="7" class="middle">{{ $t("norway") }}</b-col>
          <b-col cols="2" class="middle">+47</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(177, $t('sweden'))">
          <b-col cols="1"
            ><i class="header-icon-country"><flag iso="SE" /></i
          ></b-col>
          <b-col cols="7" class="middle">{{ $t("sweden") }}</b-col>
          <b-col cols="2" class="middle">+46</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(189, $t('turkey'))">
          <b-col cols="1"
            ><i class="header-icon-country"><flag iso="TR" /></i
          ></b-col>
          <b-col cols="7" class="middle">{{ $t("turkey") }}</b-col>
          <b-col cols="2" class="middle">+90</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(9, $t('argentina'))">
          <b-col cols="1"
            ><i class="header-icon-country"><flag iso="AR" /></i
          ></b-col>
          <b-col cols="7" class="middle">{{ $t("argentina") }}</b-col>
          <b-col cols="2" class="middle">+54</b-col>
        </b-row>
      </b-container>
    </b-modal>
    <Dialog ref="msg"></Dialog>
  </div>
</template>
<script>
import {
  country_list,
  signUp,
  sendOtp,
  checkotp,
} from "../../../system/api/api";
import Dialog from "../../../components/dialog.vue";
import { handleError } from "../../../system/handleRes";
import { required, sameAs, minLength } from "vuelidate/lib/validators";
import { mapGetters, mapActions } from "vuex";
export default {
  metaInfo: {
    // if no subcomponents specify a metaInfo.title, this title will be used
    title: "SignUp",
  },
  components: {
    Dialog,
  },

  data() {
    return {
      username: "",
      email: "",
      bgImage: require("../../../assets/images/boost/bottom_banner.png"),
      logo: require("../../../assets/images/logo.png"),
      signInImage: require("../../../assets/images/photo-long-3.jpg"),
      password: "",
      repeatPassword: "",
      submitStatus: null,
      mobile: "",
      full_name: "",
      ic: "",
      country: null,
      countryCode: "",
      countryOptions: [],
      country_id: "",
      rows: [],
      refID: "",
      otp: "",
      timecount: 60,
      startCount: false,
      myVar: null,
      sending: false,
      wrongEmail: false,
      /* eslint-disable no-useless-escape */
      reg: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/,
    };
  },

  validations: {
    password: {
      required,
      minLength: minLength(5),
    },
    repeatPassword: {
      sameAsPassword: sameAs("password"),
    },

    // add input
    // peopleAdd: {
    //   required,
    //   minLength: minLength(3),
    //   $each: {
    //     multipleName: {
    //       required,
    //       minLength: minLength(5)
    //     }
    //   }
    // },
    // validationsGroup:['peopleAdd.multipleName']
  },

  computed: {
    name2Valid() {
      if (this.username == null) {
        return true;
      } else {
        return /^[ A-Za-z0-9]+$/.test(this.username);
      }
    },
    name3Valid() {
      if (this.email == null) {
        return true;
      } else {
        return /^[ A-Za-z0-9@.]+$/.test(this.email);
      }
    },
    ...mapGetters(["loggedInUser", "loading", "error", "lang"]),
  },

  methods: {
    isEmailValid: function () {
      return this.email == ""
        ? ""
        : this.reg.test(this.email)
        ? (this.wrongEmail = false)
        : (this.wrongEmail = true);
    },
    checkKeyDownAlphaNumeric(event) {
      if (!/^[A-Za-z0-9]+$/.test(event.key)) {
        this.username = "";
        event.preventDefault();
      }
    },
    // checkKeyDownAlphaNumeric2(event) {
    //   if (!/^[A-Za-z0-9@.]+$/.test(event.key)) {
    //     this.email = "";
    //     event.preventDefault();
    //   }
    // },
    selectCountry(id, country_name) {
      this.country_id = id;
      document.getElementById("demo").innerHTML = country_name;
      this.$bvModal.hide("modal-otp");
      this.updateCode(id);
    },
    openOtp() {
      this.$bvModal.show("modal-otp");
    },
    backpage() {
      this.$router.go(-1);
    },
    ...mapActions(["changeLan"]),
    //   validate form
    changeLang(lang) {
      this.$i18n.locale = lang;
      this.changeLan(lang);
    },
    closeTnc() {
      this.$bvModal.hide("modal-tnc");
    },
    openTnc() {
      this.$bvModal.show("modal-tnc");
    },
    otpModal() {
      this.$bvModal.show("modal-1");
    },

    cancelOtp() {
      this.$bvModal.hide("modal-1");
      this.startCount = false;
      this.timecount = 60;
      this.otp = "";
      clearInterval(this.myVar);
    },

    checkOTP() {
      var result = checkotp(this.email, this.otp);
      var self = this;

      result
        .then(function (value) {
          console.log(value.data);
          if (value.data.code == 0) {
            self.submit();
          } else {
            self.$refs.msg.makeToast("danger", self.$t(value.data.message));
          }
          self.sending = false;
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          self.sending = false;
        });
    },

    getOTP() {
      if (this.email == "") {
        this.$refs.msg.makeToast("danger", this.$t("enter_email"));
      } else {
        this.sending = true;
        let formData = new FormData();
        formData.append("email", this.email);
        formData.append("country_id", this.country_id);
        formData.append("lang", this.$i18n.locale == "en" ? "en" : "cn");
        var result = sendOtp(formData);
        var self = this;

        result
          .then(function (value) {
            console.log(value.data);
            if (value.data.code == 0) {
              self.$refs.msg.makeToast("success", self.$t("otp_sent"));
              self.startCount = true;
              self.myVar = setInterval(() => {
                self.timecount -= 1;
                if (self.timecount == 0) {
                  self.timecount = 60;
                  clearInterval(self.myVar);
                  self.startCount = false;
                }
              }, 1000);
            } else {
              self.$refs.msg.makeToast("danger", value.data.message);
            }
            self.sending = false;
          })
          .catch(function (error) {
            self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
            self.sending = false;
          });
      }
    },
    submit() {
      this.submitStatus = "PENDING";
      if (this.country_id == "") {
        this.$refs.msg.makeToast("danger", this.$t("fill_in_country"));
      } else {
        let formData = new FormData();
        formData.append("username", this.username);
        formData.append("email", this.email);
        formData.append("country_id", this.country_id);
        formData.append("contact_number", this.mobile);
        formData.append("password", this.password);
        formData.append("password_confirmation", this.repeatPassword);
        formData.append("ref_id", this.refID);
        formData.append("user_group", "1");
        formData.append("ic", this.ic);
        formData.append("fullname", this.full_name);
        formData.append(
          "bio",
          this.$i18n.locale == "en" ? this.$i18n.locale : "cn"
        );

        var result = signUp(formData);
        var self = this;
        result
          .then(function (value) {
            self.submitStatus = null;
            console.log(value.data);
            if (value.data.code == 0) {
              self.$root.makeToast("success", self.$t("register_success"));
              self.$bvModal.hide("modal-1");
              self.$router.push("/web");
              // setTimeout(() => {
              //   var current = location.origin + "/";
              //   window.location.href = current + "web";
              // }, 2000);
            } else {
              self.$refs.msg.makeToast("danger", self.$t(value.data.message));
            }
          })
          .catch(function (error) {
            self.submitStatus = null;
            self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          });
      }
    },

    updateCode(id) {
      this.rows.forEach((item) => {
        if (id == item.id) {
          this.countryCode = item.country_code;
        }
      });
    },

    getCountryList() {
      this.username = null;
      this.email = null;
      var result = country_list();
      var self = this;
      self.countryOptions = [];
      this.isLoading = true;
      result
        .then(function (value) {
          console.log(value.data);
          self.country = value.data.data[0].id;
          self.country_id = value.data.data[0].id;
          self.countryCode = value.data.data[0].country_code;
          document.getElementById("demo").innerHTML =
            self.$i18n.locale == "en"
              ? value.data.data[0].name_en
              : value.data.data[0].name;
          for (let i = 0; i < value.data.data.length; i++) {
            var jsonObject = {};
            jsonObject["value"] = value.data.data[i].id;
            jsonObject["text"] =
              self.$i18n.locale == "en"
                ? value.data.data[i].name_en
                : value.data.data[i].name;
            self.countryOptions.push(jsonObject);
            self.rows = value.data.data;
          }
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
    makeToast(variant = null) {
      this.$bvToast.toast("Please fill the form correctly.", {
        title: `Variant ${variant || "default"}`,
        variant: variant,
        solid: true,
      });
    },
    makeToastTwo(variant = null) {
      this.$bvToast.toast("Successfully Created Account", {
        title: `Variant ${variant || "default"}`,
        variant: variant,
        solid: true,
      });
    },

    inputSubmit() {
      console.log("submitted");
    },
  },

  created() {
    var url_string = window.location.href;
    var url = new URL(url_string);
    this.refID = url.searchParams.get("ref_id");
    this.getCountryList();
  },

  watch: {
    lang(val) {
      console.log(val);
      var self = this;
      self.countryOptions = [];
      for (let i = 0; i < self.rows.length; i++) {
        var jsonPackageEn = {};
        jsonPackageEn["value"] = self.rows[i].id;
        jsonPackageEn["text"] =
          val == "en" ? self.rows[i].name_en : self.rows[i].name;
        self.countryOptions.push(jsonPackageEn);
      }
    },
  },
};
</script>
<style>
.modal-body{
  height: auto;
}
/* select,
input[type="text"]:focus,
input[type="email"]:focus,
input[type="password"]:focus {
  border-color: #fff;
  color: #fff;
} */
.spinner.sm {
  height: 2em;
  width: 2em;
}

.overlay-text {
  position: absolute;
  z-index: 2;
  height: 100%;
  width: 100%;
  color: black;
  font-weight: 700;
  line-height: 1.5;
}

@media screen and (max-width: 600px) {
  .colAdjust {
    padding: 0px;
  }

  .rowAdjust {
    margin: 0px;
  }

  .cardHeight {
    min-height: 100vh;
  }

  .auth-content {
    width: 100%;
    padding: 0px !important;
  }
}
i.header-icon-country {
  font-size: 20px;
}
.middle.col-7 {
  margin: auto;
}
.middle.col-2 {
  margin: auto;
  text-align: right;
}
hr.line {
  margin-top: 5px;
  margin-bottom: 5px;
}
</style>


