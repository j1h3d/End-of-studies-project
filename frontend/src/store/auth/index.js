import axios from "axios";
export default {
    namespaced: true,
    state: {},
    getters: {},
    mutations: {
        UPDATE_WINDOW_WIDTH(state, val) {
            state.windowWidth = val;
        }
    },
    actions: {
        register({ commit }, formdata) {
            axios
                .post(
                    "http://127.0.0.1:8000/api/entreprises/register",
                    formdata
                )
                .then(function(response) {
                    console.log(response);
                })
                .catch(function(error) {
                    console.error(error);
                });
        },
        login({ commit }, formdata) {
            axios
                .post("http://127.0.0.1:8000/api/auth/login", formdata)
                .then(function(response) {
                    console.log(response);
                    localStorage.setItem(
                        "accessToken",
                        response.data.accessToken
                    );
                })
                .catch(function(error) {
                    console.error(error);
                });
        },
        forgotpassword({ commit }, formdata) {
            axios
                .post("http://127.0.0.1:8000/api/auth/forgotpassword", formdata)
                .then(response => {
                    if (response.ok) {
                        this.message =
                            "We have emailed your password reset link!";
                    } else if (response.status === 404) {
                        this.message =
                            "We could not find a user with that email address.";
                    } else {
                        this.message =
                            "Unable to send reset link. Please try again later.";
                    }
                })
                .catch(error => {
                    console.error(error);
                    this.message =
                        "Unable to send reset link. Please try again later.";
                });
        }
    },
    resetpassword({ commit }, formdata) {
        axios
            .post("http://127.0.0.1:8000/api/auth/resetpassword", formdata)
            .then(response => {
                if (response.ok) {
                    this.message = "we reset your password";
                } else if (response.status === 404) {
                                                        this.message =
                                                            "Try again";
                                                    }
            })
            .catch(error => {
                console.error(error);
                this.message = "Unable to reset password";
            });
    }
};
