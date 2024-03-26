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
                <h2 class="fonttitle">Forgot your password?</h2>
                <p>No worries. we’ll send you reset instructions</p>
                <br />
                <!-- form -->
                <validation-observer ref="loginValidation">
                    <b-form class="auth-login-form " @submit.prevent>
                        <!-- first line -->

                        <b-form-group
                            class="paddingright"
                            label="Email"
                            label-for="forgotpassword"
                        >
                            <validation-provider
                                class="textcase "
                                #default="{ errors }"
                                name="Email"
                                rules="required|email"
                            >
                                <b-form-input
                                    id="forgotpassword"
                                    v-model="email"
                                    :state="errors.length > 0 ? false : null"
                                    name="forgotpassword"
                                    placeholder="Enter your email"
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
                        @click="forgotpassword"
                    >
                        Send
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
            message: "",

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
        forgotpassword() {
            store
                .dispatch("auth/forgotpassword", {
                    email: this.email,
                })
                .then(response => {
                    // userData.value = response.data;
                })
                .catch(error => { });

        }
}
}

</script>

<style lang="scss">
@import "@core/scss/vue/pages/page-auth.scss";
@import "@/assets/scss/style.scss";
</style>
