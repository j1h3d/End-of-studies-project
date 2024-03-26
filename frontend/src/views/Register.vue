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
                <h2 class="fonttitle">Company's Information</h2>
                <p>Enter your account details</p>
                <!-- form -->
                <validation-observer ref="loginValidation">
                    <b-form class="auth-login-form " @submit.prevent>
                        <!-- first line -->

                        <b-form-group
                            class=""
                            label="Name"
                            label-for="register-name"
                        >
                            <validation-provider
                                class="textcase "
                                #default="{ errors }"
                                name="name"
                                rules="required|name"
                            >
                                <b-form-input
                                    id="register-name"
                                    v-model="name"
                                    :state="errors.length > 0 ? false : null"
                                    name="register-name"
                                    placeholder="Name"
                                />
                                <small class="text-danger">{{
                                    errors[0]
                                }}</small>
                            </validation-provider>
                        </b-form-group>
                        <b-form-group
                            class="paddingright"
                            label="Email"
                            label-for="register-email"
                        >
                            <validation-provider
                                class="textcase "
                                #default="{ errors }"
                                name="Email"
                                rules="required|email"
                            >
                                <b-form-input
                                    id="register-email"
                                    v-model="email"
                                    :state="errors.length > 0 ? false : null"
                                    name="register-email"
                                    placeholder="Email"
                                />
                                <small class="text-danger">{{
                                    errors[0]
                                }}</small>
                            </validation-provider>
                        </b-form-group>

                        <!-- second line -->

                        <!-- <b-form-group
                            class=""
                            label="Password"
                            label-for="register-password"
                        >
                            <validation-provider
                                class="textcase "
                                #default="{ errors }"
                                name="Password"
                                rules="required|password"
                            >
                                <b-form-input
                                    id="register-password"
                                    v-model="password"
                                    :state="errors.length > 0 ? false : null"
                                    name="register-password"
                                    placeholder="Password"
                                />
                                 <b-input-group-append is-text>
                                        <feather-icon
                                            class="cursor-pointer"
                                            :icon="passwordToggleIcon"
                                            @click="togglePasswordVisibility"
                                        />
                                    </b-input-group-append>
                                <small class="text-danger">{{
                                    errors[0]
                                }}</small>
                            </validation-provider>
                        </b-form-group> -->
                        <b-form-group>
                            <div class="d-flex justify-content-between">
                                <label for="login-password">Password</label>
                            </div>
                            <validation-provider
                                #default="{ errors }"
                                name="Password"
                                rules="required"
                            >
                                <b-input-group
                                    class="input-group-merge"
                                    :class="
                                        errors.length > 0 ? 'is-invalid' : null
                                    "
                                >
                                    <b-form-input
                                        id="register-password"
                                        v-model="password"
                                        :state="
                                            errors.length > 0 ? false : null
                                        "
                                        class="form-control-merge"
                                        :type="passwordFieldType"
                                        name="register-password"
                                        placeholder="············"
                                    />
                                    <b-input-group-append is-text>
                                        <feather-icon
                                            class="cursor-pointer"
                                            :icon="passwordToggleIcon"
                                            @click="togglePasswordVisibility"
                                        />
                                    </b-input-group-append>
                                </b-input-group>
                                <small class="text-danger">{{
                                    errors[0]
                                }}</small>
                            </validation-provider>
                        </b-form-group>
                        <!-- third line -->

                        <!-- phone -->
                        <b-form-group
                            class=""
                            label="Phone"
                            label-for="register-phone"
                        >
                            <validation-provider
                                class="textcase "
                                #default="{ errors }"
                                name="Phone"
                                rules="required|phone"
                            >
                                <b-form-input
                                    id="register-phone"
                                    v-model="phone"
                                    :state="isPhoneValid ? null : false"
                                    name="register-phone"
                                    placeholder="Phone"
                                    @input="validatePhone"
                                />
                                <small class="text-danger" v-if="!isPhoneValid"
                                    >Please enter a valid phone number</small
                                >
                            </validation-provider>
                        </b-form-group>
                        <!-- cp registration -->
                        <b-form-group
                            class=""
                            label="Tax Registration Number"
                            label-for="register-cp_registration"
                        >
                            <validation-provider
                                class="textcaselong "
                                #default="{ errors }"
                                name="cp_registration"
                                rules="required|cp-registration"
                            >
                                <b-form-input
                                    id="register-cp-registration"
                                    v-model="cp_registration"
                                    :state="errors.length > 0 ? false : null"
                                    name="register-cp-registration"
                                    placeholder="Tax Registration Number"
                                />
                                <small class="text-danger">{{
                                    errors[0]
                                }}</small>
                            </validation-provider>
                            <!-- Adress -->
                        </b-form-group>
                        <b-form-group
                            class=""
                            label="Adress"
                            label-for="register-adress"
                        >
                            <validation-provider
                                class="textcaselong "
                                #default="{ errors }"
                                name="Adress"
                                rules="required|adress"
                            >
                                <b-form-input
                                    id="register-adress"
                                    v-model="adress"
                                    :state="errors.length > 0 ? false : null"
                                    name="register-adress"
                                    placeholder="Adress"
                                />
                                <small class="text-danger">{{
                                    errors[0]
                                }}</small>
                            </validation-provider>
                        </b-form-group>
                        <!-- City -->
                        <b-form-group
                            class=""
                            label="City"
                            label-for="register-city"
                        >
                            <validation-provider
                                class="textcaselong "
                                #default="{ errors }"
                                name="City"
                                rules="required|city"
                            >
                                <b-form-input
                                    id="register-social-reason"
                                    v-model="city"
                                    :state="errors.length > 0 ? false : null"
                                    name="register-city"
                                    placeholder="City"
                                />
                                <small class="text-danger">{{
                                    errors[0]
                                }}</small>
                            </validation-provider>
                        </b-form-group>
                        <!-- Social Reason -->
                        <b-form-group
                            class=""
                            label="Social Reason"
                            label-for="register-social_reason"
                        >
                            <validation-provider
                                class="textcaselong "
                                #default="{ errors }"
                                name="social_reason"
                                rules="required|social_reason"
                            >
                                <b-form-input
                                    id="register-social_reason"
                                    v-model="social_reason"
                                    :state="errors.length > 0 ? false : null"
                                    name="register-social_reason"
                                    placeholder="Social Reason"
                                />
                                <small class="text-danger">{{
                                    errors[0]
                                }}</small>
                            </validation-provider>
                        </b-form-group>
                        <!-- Country -->
                        <b-form-group
                            class="paddingright"
                            label="Country"
                            label-for="country"
                        >
                            <validation-provider
                                class="textcase "
                                #default="{ errors }"
                                name="Country"
                                rules="required|country"
                            >
                                <b-form-select
                                    v-model="selected"
                                    :options="options"
                                ></b-form-select>

                                <br />
                                <small class="text-danger">{{
                                    errors[0]
                                }}</small>
                            </validation-provider>
                        </b-form-group>

                        <!-- fourth line -->

                        <b-form-group>
                            <b-form-checkbox
                                id="register-privacy-policy"
                                v-model="status"
                                name="checkbox-1"
                            >
                                I agree to
                                <b-link>privacy policy & terms</b-link>
                            </b-form-checkbox>
                        </b-form-group>

                        <!-- submit buttons -->
                        <b-button
                            class="signup"
                            type="submit"
                            variant="primary"
                            block
                            @click="register()"
                        >
                            Sign up
                        </b-button>
                        <br />
                        <br />
                        <p class="text">
                            <span class="center">Already have an account?</span>
                            <b-link :to="{ name: 'login' }">
                                <span>&nbsp;Sign in instead</span>
                            </b-link>
                        </p>
                    </b-form>
                </validation-observer>
            </div>
        </b-card>
    </b-col>
</template>
<!-- <style scoped>
.fonttitle {


/* Light/Basic Typography/H3 Heading */

font-family: 'Public Sans';
font-style: normal;
font-weight: 600;
font-size: 170%;
line-height: 225%;
}
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

/* Auto layout */

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
}

</style> -->
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
            status: "",
            password: "",
            email: "",
            name: "",
            password: "",
            phone: "",
            isPhoneValid: true,

            cp_registration: "",
            adress: "",
            city: "",
            social_reason: "",
            sideImg: require("@/assets/images/pages/login-v2.svg"),
            // validation rulesimport store from '@/store/index'
            required,
            selected: null,
            options: [
                { value: null, text: "Country" },
                { value: "Tunisie", text: "Tunisie" }
            ]
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
        validationForm() {
            this.$refs.loginValidation.validate().then(success => {
                if (success) {
                    this.$toast({
                        component: ToastificationContent,
                        props: {
                            title: "Form Submitted",
                            icon: "EditIcon",
                            variant: "success"
                        }
                    });
                }
            });
        },
         validatePhone() {
      const numericRegex = /^\d+$/;
      this.isPhoneValid = numericRegex.test(this.phone);
    },
        register() {
            store
                .dispatch("auth/register", {
                    email: this.email,
                    name: this.name,
                    password: this.password,
                    phone: this.phone,
                    cp_registration: this.cp_registration,
                    adress: this.adress,
                    city: this.city,
                    social_reason: this.social_reason,
                    selected: this.selected
                })

                .then(response => {
                    // userData.value = response.data;
                })
                .catch(error => {});
            this.login();
            this.$router.push("/dashboard");
            const accessToken = localStorage.getItem("accessToken");

            if (accessToken) {
                axios.defaults.headers.common[
                    "Authorization"
                ] = `Bearer ${accessToken}`;
            }
        },
        login() {
            store
                .dispatch("auth/login", {
                    email: this.email,
                    password: this.password
                })
                .then(response => {
                    // userData.value = response.data;
                })
                .catch(error => {});
            this.$router.push("/dashboard");
        }
    }
};
</script>

<style lang="scss">
@import "@core/scss/vue/pages/page-auth.scss";
@import "@/assets/scss/style.scss";
</style>
