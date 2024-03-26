<template>
    <b-card style="min-height: 570px">
        <div>
            <div class="d-flex" style="right: 5rem;top: 15px; position: absolute;">
                <b-button @click="addB" style="margin-right: 1rem ;border-radius: 25px; height: 50px;width: 50px;">
                    <feather-icon icon="PlusIcon" size="20" style="margin-left: -6px;" />
                </b-button>
                <b-form>
                    <b-form-group id="searchInput" label="Search:" style="margin-top: 1rem;" label-cols="3">
                        <b-form-input v-model="searchTerm" style="margin-left: 33px;" size="sm" placeholder="Partners" />
                    </b-form-group>
                </b-form>
            </div>
            <b-table :items="filteredPartners" :per-page="7" :pagination="true" :current-page="currentPage" :fields="fields"
                style="margin-top: 4rem;">
                <template v-slot:cell(actions)="data">
                    <b-button variant="primary" @click="edit(data.item)">
                        <feather-icon icon="Edit2Icon" size="18" />
                    </b-button>
                </template>
            </b-table>
            <div class="mb-3 mt-1">
                <b-pagination v-model="currentPage" :total-rows="filteredPartners.length" :per-page="7"
                    style="right: 4rem; bottom: 0; position: absolute;" size="lg"></b-pagination>
            </div>
            <b-modal v-model="showPartnerDetails" hide-footer centered>
                <template #modal-title>
                    Partner Details
                </template>
                <b-form>
                    <b-form-group id="NameInput" label="Full Name">
                        <b-form-input v-model="selectedPartner.name" />
                    </b-form-group>
                    <b-form-group id="phoneInput" label="Phone">
                        <b-form-input v-model="selectedPartner.phone" />
                    </b-form-group>
                    <b-form-group id="emailInput" label="Email">
                        <b-form-input v-model="selectedPartner.email" />
                    </b-form-group>
                    <b-form-group id="occupationInput" label="Occupation">
                        <b-form-input v-model="selectedPartner.occupation" />
                    </b-form-group>
                    <div class="d-flex justify-content-end" style="margin-top: 8rem; margin-bottom: 20px;">
                        <b-button variant="primary" class="mr-2" @click="editPartner">Confirm</b-button>
                        <b-button variant="danger" @click="() => removePartner(selectedPartner.id)">Remove</b-button>
                    </div>
                </b-form>
            </b-modal>
            <b-modal v-model="addP" hide-footer centered>
                <template #modal-title>
                    Add Partner
                </template>
                <b-form @submit.prevent="addPartner">
                    <b-form-group id="name" label="Full Name">
                        <b-form-input v-model="formData.name" required />
                    </b-form-group>
                    <b-form-group id="phone" label="Phone">
                        <b-form-input v-model="formData.phone" type="number" required />
                    </b-form-group>
                    <b-form-group id="email" label="Email">
                        <b-form-input v-model="formData.email" type="email" required />
                    </b-form-group>
                    <b-form-group id="occupation" label="Occupation">
                        <b-form-input v-model="formData.occupation" required />
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
        phone: '',
        email: '',
        occupation: '',
    },
    data() {
        return {
            rows: [],
            showPartnerDetails: false,
            selectedPartner: {},
            addP: false,
            partners: [],
            searchTerm: '',
            currentPage: 1,

            formData: {
                name: '',
                phone: '',
                email: '',
                occupation: ''
            },

            fields: [
                { key: 'name', label: 'Full Name' },
                { key: 'phone', label: 'Phone' },
                { key: 'email', label: 'Email' },
                { key: 'occupation', label: 'Occupation' },
                { key: 'actions', label: 'Actions' },
            ]
        }
    },

    mounted() {
        this.fetchPartners();
    },

    computed: {
        filteredPartners() {
            if (!this.searchTerm) {
                return this.partners;
            }
            const searchTermLowerCase = this.searchTerm.toLowerCase();
            return this.partners.filter(partner => {
                return partner.name.toLowerCase().includes(searchTermLowerCase);
            });
        }
    },

    methods: {
        fetchPartners() {
            axios.get('/api/partners')
                .then(response => {
                    this.partners = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },

        addPartner() {
            axios.post('/api/partners', this.formData)
                .then(response => {
                    this.formData = {
                        name: '',
                        phone: '',
                        email: '',
                        occupation: ''
                    };
                    this.fetchPartners();
                    this.addP = false;
                })
                .catch(error => {
                    console.log(error);
                });
        },

        editPartner() {
            axios.put(`/api/partners/${this.selectedPartner.id}`, this.selectedPartner)
                .then(response => {
                    const index = this.data.findIndex(partner => partner.id === response.data.id);
                    this.$set(this.data, index, response.data);
                    this.selectedPartner = {};
                })
                .catch(error => {
                    console.log(error);
                })
                .finally(() => {
                    this.showPartnerDetails = false;
                });
        },

        removePartner(id) {
            axios.delete('/api/partners/' + id)
                .then(response => {
                    this.fetchPartners();
                })
                .catch(error => {
                    console.log(error);
                });
            this.showPartnerDetails = false;
        },

        addB() {
            this.addP = true;
        },

        edit(partner) {
            this.selectedPartner = partner;
            this.showPartnerDetails = true;
        },
    },

}
</script>

