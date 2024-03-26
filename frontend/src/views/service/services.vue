<template>
    <b-card style="min-height: 570px">
        <div>
            <div class="mb-1 d-flex" style="right: 5rem;top: 15px; ;position: absolute;">
                <router-link to="/service">
                    <b-button style="margin-right: 1rem ;border-radius: 25px; height: 50px;width: 50px;">
                        <feather-icon icon="PlusIcon" size="20" style="margin-left: -6px;" />
                    </b-button>
                </router-link>
                <b-form>
                    <b-form-group id="searchInput" label="Search:" style="margin-top: 1rem;" label-cols="3">
                        <b-form-input v-model="searchTerm" size="sm" placeholder="Service" />
                    </b-form-group>
                </b-form>
            </div>
            <b-table :items="filteredServices" :per-page="7" :pagination="true" :current-page="currentPage" :fields="fields"
                style="margin-top: 4rem;">
                <template v-slot:cell(created_at)="row">
                    {{ new Date(row.item.created_at).toLocaleDateString() }}
                </template>
                <template v-slot:cell(actions)="data">
                    <b-button variant="primary" @click="edit(data.item)">
                        <span class="iconify" data-icon="mdi-pencil" size="18"></span>
                    </b-button>
                    <b-button variant="primary" @click="() => removeService(data.item.id)">
                        <span class="iconify" data-icon="mdi-trash" size="18"></span>
                    </b-button>
                </template>
            </b-table>
            <div class="mb-3 mt-1">
                <b-pagination v-model="currentPage" :total-rows="filteredServices.length" :per-page="7"
                    style="right: 4rem; bottom: 0 ;position: absolute" size="lg"></b-pagination>
            </div>
            <b-modal v-model="showServiceDetails" hide-footer centered>
                <template #modal-title>
                    Edit Service
                </template>
                <b-form>
                    <b-form-group id="nameInput" label="Full Name">
                        <b-form-input v-model="selectedService.name" />
                    </b-form-group>
                    <b-form-group id="priceInput" label="Price">
                        <b-form-input v-model="selectedService.price" />
                    </b-form-group>
                    <b-form-group id="categoryInput" label="Category">
                        <b-form-input v-model="selectedService.category" />
                    </b-form-group>
                    <b-form-group id="descInput" label="Description">
                        <b-form-input v-model="selectedService.description" />
                    </b-form-group>
                    <div class="d-flex justify-content-end" style="margin-top: 8rem; margin-bottom: 20px;">
                        <b-button variant="primary" class="mr-2" @click="editService">Confirm</b-button>
                    </div>
                </b-form>
            </b-modal>
        </div>

    </b-card>
</template>

<script>
import {
    BTable, BAvatar, BIcon, BButton, BCard, BCardBody, BCardHeader, BForm, BFormGroup, BFormInput, BModal, BPagination
} from 'bootstrap-vue';
import axios from 'axios';

export default {
    components: {
        BTable,
        BAvatar,
        BIcon,
        BButton,
        BCard,
        BCardBody,
        BCardHeader,
        BForm,
        BFormGroup,
        BFormInput,
        BModal,
        BPagination,
    },
    props: {
        name: '',
        created_at: '',
        category: '',
    },
    data() {
        return {
            rows: [],
            showServiceDetails: false,
            selectedService: {},
            addS: false,
            services: [],
            searchTerm: '',
            currentPage: 1,

            formData: {
                name: '',
                created_at: '',
                category: '',
            },

            fields: [
                { key: 'name', label: 'Service' },
                { key: 'created_at', label: 'Added At' },
                { key: 'price', label: 'Price' },
                { key: 'category', label: 'Category' },
                { key: 'actions', label: 'Actions' },
            ]
        }
    },

    mounted() {
        this.fetchServices();
        const script = document.createElement('script');
        script.src = 'https://code.iconify.design/1/1.0.7/iconify.min.js';
        document.head.appendChild(script);
    },

    computed: {
        filteredServices() {
            if (!this.searchTerm) {
                return this.services;
            }
            const searchTermLowerCase = this.searchTerm.toLowerCase();
            return this.services.filter(service => {
                return service.name.toLowerCase().includes(searchTermLowerCase);
            });
        }
    },

    methods: {
        fetchServices() {
            axios.get('/api/services')
                .then(response => {
                    this.services = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },

        addService() {
            axios.post('/api/services', this.formData)
                .then(response => {
                    this.formData = {
                        name: '',
                        phone: '',
                        email: '',
                        address: '',
                    };
                    this.fetchServices();
                    this.addS = false;
                })
                .catch(error => {
                    console.log(error);
                });
        },

        editService() {
            axios.put(`/api/services/${this.selectedService.id}`, this.selectedService)
                .then(response => {
                    const index = this.data.findIndex(service => service.id === response.data.id);
                    this.$set(this.data, index, response.data);
                    this.selectedService = {};
                })
                .catch(error => {
                    console.log(error);
                })
                .finally(() => {
                    this.showServiceDetails = false;
                });
        },

        removeService(id) {
            axios.delete('/api/services/' + id)
                .then(response => {
                    this.fetchServices();
                })
                .catch(error => {
                    console.log(error);
                });
            this.showServiceDetails = false;
        },
        edit(service) {
            this.selectedService = service;
            this.showServiceDetails = true;
        },
    },

}
</script>

