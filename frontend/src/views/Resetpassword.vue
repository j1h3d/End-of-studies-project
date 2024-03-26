<template>
    <b-col md="12" class=" d-md-flex justify-content-center p-3">
        <b-card bg-variant="light" class="p-4 ">
            <b-card-text class="">
                <div>
                    <b-img
                        :src="require('@/assets/images/logo/logo_darydar.png')"
                        width="279px"
                        height="76px"
                        center
                    ></b-img>
                </div>
            </b-card-text>
            <div class="paddingleft">
                <br />
                <h2 class="fonttitle">Reset your password</h2>
                <br />
                <!-- form -->
                <validation-observer ref="loginValidation">
                    <b-form class="auth-login-form " @submit.prevent>
                        <!-- first line -->

                        <b-form-group
                            class="paddingright"
                            label="Email"
                            label-for="resetpassword"
                        >
                            <validation-provider
                                class="textcase "
                                #default="{ errors }"
                                name="Email"
                                rules="required|email"
                            >
                                <b-form-input
                                    id="resetpassword"
                                    v-model="email"
                                    :state="errors.length > 0 ? false : null"
                                    name="resetpassword"
                                    placeholder="Enter your email"
                                />
                                <small class="text-danger">{{
                                    errors[0]
                                }}</small>
                            </validation-provider>
                        </b-form-group>
                          <b-form-group
                            class="paddingright"
                            label="New Password"
                            label-for="resetpassword"
                        >
                            <validation-provider
                                class="textcase "
                                #default="{ errors }"
                                name="password"
                                rules="required|password"
                            >
                                <b-form-input
                                    id="resetpassword"
                                    v-model="password"
                                    :state="errors.length > 0 ? false : null"
                                    name="resetpassword"
                                    placeholder="Enter your password"
                                />
                                <small class="text-danger">{{
                                    errors[0]
                                }}</small>
                            </validation-provider>
                        </b-form-group>

                          <b-form-group
                            class="paddingright"
                            label="Confirm Password"
                            label-for="resetpassword"
                        >
                            <validation-provider
                                class="textcase "
                                #default="{ errors }"
                                name="password_confirmation"
                                rules="required|password_confirmation"
                            >
                                <b-form-input
                                    id="resetpassword"
                                    v-model="password_confirmation"
                                    :state="errors.length > 0 ? false : null"
                                    name="resetpassword"
                                    placeholder="Confirm your password"
                                />
                                <small class="text-danger">{{
                                    errors[0]
                                }}</small>
                            </validation-provider>
                        </b-form-group>


                        <!-- second line -->
                    </b-form>
                    <!-- submit buttons -->
                    <b-button
                        type="submit"
                        variant="primary"
                        block
                        @click="resetpassword"
                    >
                        Reset Password
                    </b-button>
                    <br />
                    <p class="text">
                        <b-link to="/login">
                            <span>&nbsp;← Back to Login</span>
                        </b-link>
                    </p>
                </validation-observer>
            </div>
        </b-card>
    </b-col>
</template>
<style scoped>
.fonttitle {
    text-align: center;
    font-family: "Public Sans";
    font-style: normal;
    font-weight: 700;
    font-size: 20px;
    line-height: 24px;
    /* or 120% */

    display: flex;
    align-items: center;
    text-align: center;

    color: #4b465c;
}
/*
.cardregister {

width: 50%;
height: auto;
left: 25%;
}
.textcase {

display: flex;
flex-direction: row;
align-items: center;
padding: 0px;

width: 130%;
}
.paddingright {

padding-left: 15%;
}
.paddingleft {

padding-left: 80px;
}
.textcaseright {

display: flex;
flex-direction: row;
align-items: center;
padding: 20px;

width: 282px;
height: 38px;
}
.textcaselong {

display: flex;
flex-direction: row;
align-items: center;
padding: 0%;

width: 90%;

}
.signup {



display: flex;
flex-direction: row;
justify-content: center;
align-items: center;
padding: 0px;

position: absolute;
width: 25%;
height: 5%;
left: 40%;
}
.text {

text-align: center;
}*/
</style>
<script>
/* eslint-disable global-require */
import { ValidationProvider, ValidationObserver } from "vee-validate";
import VuexyLogo from "@core/layouts/components/Logo.vue";
import {
    BRow,
    BCol,
    BLink,
    BFormGroup,
    BFormInput,
    BInputGroupAppend,
    BInputGroup,
    BFormCheckbox,
    BCardText,
    BCardTitle,
    BImg,
    BForm,
    BButton,
    BCard
} from "bootstrap-vue";
import { required, email } from "@validations";
import { togglePasswordVisibility } from "@core/mixins/ui/forms";
import store from "@/store";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";
import axios from "axios";
export default {
    components: {
        BRow,
        BCol,
        BLink,
        BFormGroup,
        BFormInput,
        BInputGroupAppend,
        BInputGroup,
        BFormCheckbox,
        BCardText,
        BCardTitle,
        BImg,
        BForm,
        BButton,
        VuexyLogo,
        ValidationProvider,
        ValidationObserver,
        BCard
    },
    mixins: [togglePasswordVisibility],
    data() {
        return {
            email: "",
            password: "",
            password_confirmation: "",
            token: "{{ $token }}",

            sideImg: require("@/assets/images/pages/login-v2.svg"),
            // validation rulesimport store from '@/store/index'
            required
        };
    },
    computed: {
        passwordToggleIcon() {
            return this.passwordFieldType === "password"
                ? "EyeIcon"
                : "EyeOffIcon";
        },
        imgUrl() {
            if (store.state.appConfig.layout.skin === "dark") {
                // eslint-disable-next-line vue/no-side-effects-in-computed-properties
                this.sideImg = require("@/assets/images/pages/login-v2-dark.svg");
                return this.sideImg;
            }
            return this.sideImg;
        }
    },
    methods: {
        // // resetpassword() {

        // //     store
        // //         .dispatch("auth/resetpassword", {
        // //             email: this.email,
        // //             password: this.password,
        // //             password_confirmation: this.password_confirmation,
        // //             token: this.token
        // //         })
        // //         // .then(response => {
        //         console.log(response);
        // //         // })
        // //         // .catch(error => {
        //                     console.log(error);

        // });
        // }
        resetpassword() {
            axios.post('/api/auth/resetpassword', {
                email: this.email,
                password: this.password,
                password_confirmation: this.password_confirmation,
                token: this.token
            }).then(response => {
                 //   userData.value = response.data;
            }).catch(error => {
                console.log(error);
            });
        }
    }
}
</script>

<style lang="scss">
@import "@core/scss/vue/pages/page-auth.scss";
@import "@/assets/scss/style.scss";
</style>
