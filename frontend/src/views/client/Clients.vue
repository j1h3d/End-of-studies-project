<template>
    <b-card style="min-height: 570px">
        <div>
            <div class="mb-1 d-flex" style="right: 5rem;top: 15px; ;position: absolute;">
                <b-button @click="addB" style="margin-right: 1rem ;border-radius: 25px; height: 50px;width: 50px;">
                    <feather-icon icon="PlusIcon" size="20" style="margin-left: -6px;" />
                </b-button>
                <b-form>
                    <b-form-group id="searchInput" label="Search:" style="margin-top: 1rem;" label-cols="3">
                        <b-form-input v-model="searchTerm" size="sm" placeholder="Clients" />
                    </b-form-group>
                </b-form>
            </div>
            <b-table :items="filteredClients" :per-page="7" :pagination="true" :current-page="currentPage" :fields="fields"
                style="margin-top: 4rem;">
                <template v-slot:cell(created_at)="row">
                    {{ new Date(row.item.created_at).toLocaleDateString() }}
                </template>
                <template v-slot:cell(actions)="data">
                    <b-button variant="primary" @click="goToClient(data.item.id)">
                        <span class="iconify" data-icon="mdi-eye" size="18"></span>
                    </b-button>
                </template>
            </b-table>
            <div class="mb-3 mt-1">
                <b-pagination v-model="currentPage" :total-rows="filteredClients.length" :per-page="7"
                    style="right: 4rem; bottom: 0 ;position: absolute" size="lg"></b-pagination>
            </div>
            <b-modal v-model="addC" hide-footer centered>
                <template #modal-title>
                    Create Client
                </template>
                <b-form @submit.prevent="addClient">
                    <b-form-group id="name" label="Full Name">
                        <b-form-input v-model="formData.name" required />
                    </b-form-group>
                    <b-form-group id="phone" label="Phone">
                        <b-form-input v-model="formData.phone" type="number" required />
                    </b-form-group>
                    <b-form-group id="email" label="Email">
                        <b-form-input v-model="formData.email" type="email" required />
                    </b-form-group>
                    <b-form-group id="address" label="Address">
                        <b-form-input v-model="formData.address" required />
                    </b-form-group>
                    <div class="d-flex justify-content-end" style="margin-top: 8rem; margin-bottom: 20px;">
                        <b-button variant="primary" class="mr-2" type="submit">Add</b-button>
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
import editClient from '@/views/client/clientinfo.vue'

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
        email: '',
        joinedAt: '',
    },
    data() {
        return {
            rows: [],
            showClientDetails: false,
            selectedClient: {},
            addC: false,
            clients: [],
            searchTerm: '',
            currentPage: 1,
            client: [],

            formData: {
                name: '',
                email: '',
                created_at: '',
            },

            fields: [
                { key: 'name', label: 'Full Name' },
                { key: 'email', label: 'Email' },
                { key: 'created_at', label: 'Joined At' },
                { key: 'actions', label: 'Actions' },
            ]
        }
    },

    mounted() {
        this.fetchClients();
        const script = document.createElement('script');
        script.src = 'https://code.iconify.design/1/1.0.7/iconify.min.js';
        document.head.appendChild(script);
    },

    computed: {
        filteredClients() {
            if (!this.searchTerm) {
                return this.clients;
            }
            const searchTermLowerCase = this.searchTerm.toLowerCase();
            return this.clients.filter(client => {
                return client.name.toLowerCase().includes(searchTermLowerCase);
            });
        }
    },

    methods: {
        fetchClients() {
            axios.get('/api/clients')
                .then(response => {
                    this.clients = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },

        updateClient(updatedClient) {
            const index = this.filteredClients.findIndex(c => c.id === updatedClient.id);
            if (index !== -1) {
                this.filteredClients.splice(index, 1, updatedClient);
            }
        },

        addClient() {
            axios.post('/api/clients', this.formData)
                .then(response => {
                    this.formData = {
                        name: '',
                        phone: '',
                        email: '',
                        address: '',
                    };
                    this.fetchClients();
                    this.addC = false;
                })
                .catch(error => {
                    console.log(error);
                });
        },

        goToClient(id) {
            axios.get(`/api/clients/${id}`)
                .then(response => {
                    this.$router.push({ name: 'clientinfo', params: { client: response.data } });
                })
                .catch(error => {
                    console.error(error);
                });
        },

        removeClient(id) {
            axios.delete('/api/clients/' + id)
                .then(response => {
                    this.fetchClients();
                })
                .catch(error => {
                    console.log(error);
                });
            this.showClientDetails = false;
        },

        addB() {
            this.addC = true;
        },
    },

}
</script>

