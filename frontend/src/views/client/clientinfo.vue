<template>
    <div>
        <b-card style="padding-bottom: 10rem;">
            <div class="mb-4 mt-4">
                <h1>{{ client.name }}</h1>
            </div>
            <h5>Client Details</h5>
            <b-form-group id="emailInput" label="email:" label-cols="2">
                <b-form-input v-model="client.email" size="sm" style="width: 15rem;" />
            </b-form-group>
            <b-form-group id="phoneInput" label="Phone Number:" label-cols="2">
                <b-form-input v-model="client.phone" size="sm" style="width: 15rem;" />
            </b-form-group>
            <b-form-group id="addressInput" label="Home Address:" label-cols="2">
                <b-form-input v-model="client.address" size="sm" style="width: 15rem;" />
            </b-form-group>

            <div
                style="position: absolute; right: 1rem;top: 2rem; background: rgba(234, 234, 234, 1); border-radius: 5px; width: 50%; height: 51%;">
                <div style="margin-top: 15px; margin-left: 35px;">
                    <h5 style="font-weight: bold;">Latest Transaction</h5>
                </div>
                <div style="margin-top: 10px;">
                    <div class="pec">Service:</div>
                    <div class="pec">Service:</div>
                    <div class="pec">Service:</div>
                </div>
            </div>
            <div class="d-flex" style="right: 10%;bottom: 10%; position: absolute;">
                <b-button style="padding: 12px 33px;" @click="editClient" variant="primary">OK</b-button>
                <b-button style="margin-left: 5px;" @click="removeClient" variant="danger">Remove</b-button>
            </div>
        </b-card>
    </div>
</template>
<script>
import axios from 'axios';

export default {
    data() {

    },
    props: {
        client: {
            type: Object,
            required: true
        },
    },
    mounted() {
        axios.get(`/api/clients/${id}`)
            .then(response => {
                this.client = response.data.client;
            })
            .catch(error => {
                console.error(error);
            });
    },
    methods: {
        removeClient() {
            axios.delete(`/api/clients/${this.client.id}`)
                .then(response => {
                    this.$router.push({ name: 'clients' });
                })
                .catch(error => {
                    console.error(error);
                });
        },
        editClient() {
            axios
                .put(`/api/clients/${this.client.id}`, this.client)
                .then((response) => {
                    this.$emit("clientUpdated", response.data);
                    this.$router.push({ name: 'clients' });
                    window.location.reload();
                })
                .catch((error) => {
                    console.error(error);
                });
        },
    },
};
</script>
<style>
.pec {
    position: relative;
    width: 90%;
    border-radius: 3px;
    background: white;
    margin-left: 35px;
    margin-top: 10px;
    padding: 10px 20px;
    color: rgb(158, 158, 158);
}
</style>