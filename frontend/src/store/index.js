import Vue from "vue";
import Vuex from "vuex";

// Modules
import app from "./app";
import appConfig from "./app-config";
import verticalMenu from "./vertical-menu";
import statistics from "./statistics";
import users from "./users";
import piechart from "./piechart";
import donut from "./donut";
import auth from "./auth";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        app,
        appConfig,
        verticalMenu,
        statistics,
        users,
        piechart,
        donut,
        auth
    },
    strict: process.env.DEV
});
