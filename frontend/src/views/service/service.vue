<template>
    <b-card style="min-height: 570px; display: flex; flex-direction: column;">
        <b-form @submit.prevent="addService">
            <div class="ml-2 mt-2 d-flex" style="flex-direction: row;">
                <div style="width: 50%;">
                    <h3>Description</h3>
                    <div
                        style="border-radius: 5px; border: 2px solid #DBDBDB;padding-left: 15px; padding-top: 13px;padding-right: 15px;">
                        <b-form-group label="Service Name">
                            <b-form-input id="name" v-model="name" required />
                        </b-form-group>
                        <b-form-group label="Service Description">
                            <textarea type="text" style="height: 25vh; width: 100%;" id="description" v-model="description"
                                required placeholder="Description"></textarea>
                        </b-form-group>
                    </div>
                </div>
                <div style="flex-direction: column;width: 50%;">
                    <div style=" margin-left: 2rem;">
                        <h3>Category</h3>
                        <div
                            style="border-radius: 5px; border: 2px solid #DBDBDB;padding-left: 15px; padding-top: 13px;padding-right: 15px;">
                            <b-form-group label="Product Category">
                                <b-form-select id="category" v-model="category" required
                                    :options="categories"></b-form-select>
                            </b-form-group>
                        </div>
                    </div>
                    <div style="margin-left: 2rem; margin-top: 20px;">
                        <h3>Pricing</h3>
                        <div
                            style="border-radius: 5px; border: 2px solid #DBDBDB;padding-left: 15px; padding-top: 13px;padding-right: 15px;">
                            <b-form-group label="Price">
                                <b-form-input id="price" v-model="price" required />
                            </b-form-group>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex" style="right: 10%;bottom: 10%; position: absolute;">
                <router-link to="/services" style="display: inline-block;align-self: flex-start; margin-right: auto;">
                    <b-button style="padding: 12px 33px;">Discard</b-button>
                </router-link>
                <b-button style="margin-left: 5px;" variant="primary" type="sumbit">Add Service</b-button>
            </div>
        </b-form>
    </b-card>
</template>

<script>
import {
    BButton, BCard, BCardBody, BCardHeader, BForm, BFormGroup, BFormInput,
} from 'bootstrap-vue';
import axios from 'axios';

export default {
    components: {
        BButton,
        BCard,
        BCardBody,
        BCardHeader,
        BForm,
        BFormGroup,
        BFormInput,
    },
    data() {
        return {
            categories: [
                { value: 'Electricity', text: 'Electricity' },
                { value: 'Plumbing', text: 'Plumbing' },
                { value: 'Heating', text: 'Heating' },
                { value: 'air-conditioning', text: 'air-conditioning' },
            ],
            name: '',
            description: '',
            price: '',
            category: '',
        };
    },
    methods: {
        addService() {
            axios.post('/api/services', {
                name: this.name,
                description: this.description,
                category: this.category,
                price: this.price
            }).then(() => {
                this.$router.push('/services');
            })
                .catch(error => {
                    console.log(error.response.data);
                });
        },
    },
}
</script>

