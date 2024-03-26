<template>
    <b-row>
        <b-col lg="6" xl="7" class="d-none d-lg-flex align-items-center p-5">
            <div
                class="w-100 d-lg-flex align-items-center justify-content-center px-4"
            >
                <b-img
                    :src="require('@/assets/images/logo/darydar_login.png')"
                    width="570px"
                    height="596px"
                    left
                ></b-img>
            </div>
        </b-col>

        <b-col md="12" lg="6" xl="5" class="d-lg-flex align-items-center p-3">
            <b-card bg-variant="light" class="w-100 p-4">
                <b-card-text class="mb-1">
                    <div>
                        <br />

                        <b-img
                            :src="
                                require('@/assets/images/logo/logo_darydar.png')
                            "
                            width="279px"
                            height="76px"
                            center
                        ></b-img>
                        <br />
                        <br />
                    </div>
                </b-card-text>
                <!-- form -->
                <validation-observer ref="loginValidation">
                    <b-form class="auth-login-form mt-2" @submit.prevent>
                        <!-- email -->
                        <b-form-group label="Email" label-for="login-email">
                            <validation-provider
                                #default="{ errors }"
                                name="Email"
                                rules="required|email"
                            >
                                <b-form-input
                                    id="login-email"
                                    v-model="email"
                                    :state="errors.length > 0 ? false : null"
                                    name="login-email"
                                    placeholder="john@example.com"
                                />
                                <small class="text-danger">{{
                                    errors[0]
                                }}</small>
                            </validation-provider>
                        </b-form-group>

                        <!-- forgot password -->
                        <b-form-group>
                            <div class="d-flex justify-content-between">
                                <label for="login-password">Password</label>
                                <b-link to="/forgotpassword">

                                    <small>Forgot Password?</small>
                                </b-link>

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
                                        id="login-password"
                                        v-model="password"
                                        :state="
                                            errors.length > 0 ? false : null
                                        "
                                        class="form-control-merge"
                                        :type="passwordFieldType"
                                        name="login-password"
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

                        <!-- checkbox -->
                        <b-form-group>
                            <b-form-checkbox
                                id="remember-me"
                                v-model="status"
                                name="checkbox-1"
                            >
                                Remember Me
                            </b-form-checkbox>
                        </b-form-group>

                        <!-- submit buttons -->
                        <b-button
                            type="submit"
                            variant="primary"
                            block
                            @click="login"
                        >
                            Sign in
                        </b-button>
                    </b-form>
                </validation-observer>

                <b-card-text class="text-center mt-2">
                    <span>New on our platform? </span>
                    <b-link :to="{ name: 'register' }">
                        <span>&nbsp;Create an account</span>
                    </b-link>
                </b-card-text>
                <br />
                <br />
                <br />
            </b-card>
        </b-col>
    </b-row>
</template>

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
