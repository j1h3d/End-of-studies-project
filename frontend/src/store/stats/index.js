// In your Vuex store file (e.g., store/statistics.js)
import axios from "axios";

const state = {
    transactions: 0,
    clients: 0,
    services: 0,
    agents: 0,
    partners: 0
};

const actions = {
    getAllTransactions({ commit }) {
        axios
            .get("/api/transactions/count")
            .then(response => {
                commit("SET_TRANSACTIONS", response.data.count);
            })
            .catch(error => {
                console.error(error);
            });
    },
    getNumberClients({ commit }) {
        axios
            .get("/api/clients/count")
            .then(response => {
                commit("SET_CLIENTS", response.data.count);
            })
            .catch(error => {
                console.error(error);
            });
    },
    getNumberServices({ commit }) {
        axios
            .get("/api/services/count")
            .then(response => {
                commit("SET_SERVICES", response.data.count);
            })
            .catch(error => {
                console.error(error);
            });
    },

    getNumberAgents({ commit }) {
        axios
            .get("/api/agents/count")
            .then(response => {
                commit("SET_AGENTS", response.data.count);
            })
            .catch(error => {
                console.error(error);
            });
    },
    getNumberPartners({ commit }) {
        axios
            .get("/api/partners/count")
            .then(response => {
                commit("SET_PARTNERS", response.data.count);
            })
            .catch(error => {
                console.error(error);
            });
    }
};

const mutations = {
    SET_TRANSACTIONS(state, count) {
        state.transactions = count;
    },
    SET_CLIENTS(state, count) {
        state.clients = count;
    },
    SET_SERVICES(state, count) {
        state.services = count;
    },
    SET_PROFIT(state, profit) {
        state.profit = profit;
    },
    SET_AGENTS(state, count) {
        state.agents = count;
    },
    SET_PARTNERS(state, count) {
        state.partners = count;
    }
};

export default {
    state,
    actions,
    mutations
};
