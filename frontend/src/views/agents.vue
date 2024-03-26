<template>
    <b-card style="min-height: 570px">
        <div>
            <div class="d-flex" style="right: 5rem;top: 15px; position: absolute;">
                <b-button @click="addB" style="margin-right: 1rem ;border-radius: 25px; height: 50px;width: 50px;">
                    <feather-icon icon="PlusIcon" size="20" style="margin-left: -6px;" />
                </b-button>
                <b-form>
                    <b-form-group id="searchInput" label="Search:" style="margin-top: 1rem;" label-cols="3">
                        <b-form-input v-model="searchTerm" style="margin-left: 33px;" size="sm" placeholder="Agents" />
                    </b-form-group>
                </b-form>
            </div>
            <b-table :items="filteredAgents" :per-page="7" :pagination="true" :current-page="currentPage" :fields="fields"
                style="margin-top: 4rem;">
                <template v-slot:cell(created_at)="row">
                    {{ new Date(row.item.created_at).toLocaleDateString() }}
                </template>
                <template v-slot:cell(actions)="data">
                    <b-button variant="primary" @click="edit(data.item)">
                        <feather-icon icon="Edit2Icon" size="18" />
                    </b-button>
                </template>
            </b-table>
            <div class="mb-3 mt-1">
                <b-pagination v-model="currentPage" :total-rows="filteredAgents.length" :per-page="7"
                    style="right: 4rem; bottom: 0; position: absolute;" size="lg"></b-pagination>
            </div>
            <b-modal v-model="showAgentDetails" hide-footer centered>
                <template #modal-title>
                    Agent Informations
                </template>
                <b-form>
                    <b-form-group id="NameInput" label="Full Name">
                        <b-form-input v-model="selectedAgent.name" />
                    </b-form-group>
                    <b-form-group id="emailInput" label="Email">
                        <b-form-input v-model="selectedAgent.email" />
                    </b-form-group>
                    <b-form-group id="phoneInput" label="Phone">
                        <b-form-input v-model="selectedAgent.phone" />
                    </b-form-group>
                    <div class="d-flex justify-content-end" style="margin-top: 8rem; margin-bottom: 20px;">
                        <b-button variant="primary" class="mr-2" @click="editAgent">Confirm</b-button>
                        <b-button variant="danger" @click="() => removeAgent(selectedAgent.id)">Remove</b-button>
                    </div>
                </b-form>
            </b-modal>
            <b-modal v-model="addA" hide-footer centered>
                <template #modal-title>
                    Create Agent
                </template>
                <b-form @submit.prevent="addAgent">
                    <b-form-group id="name" label="Agent's Name">
                        <b-form-input v-model="formData.name" required />
                    </b-form-group>
                    <b-form-group id="email" label="Agent's Email">
                        <b-form-input v-model="formData.email" type="email" required />
                    </b-form-group>
                    <b-form-group id="phone" label="Phone">
                        <b-form-input v-model="formData.phone" type="number" required />
                    </b-form-group>
                    <b-form-group id="password" label="Password">
                        <b-form-input v-model="formData.password" required />
                        <b-button @click="generatePassword" style="margin-top: 5px;">Generate</b-button>
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
    BTable, BAvatar, BIcon, BButton, BCard, BCardBody, BCardHeader, BForm, BFormGroup, BFormInput, BModal, BPagination, BFormSelect,
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
        BFormSelect,
    },
    data() {
        return {
            rows: [],
            showAgentDetails: false,
            selectedAgent: {},
            addA: false,
            agents: [],
            searchTerm: '',
            currentPage: 1,

            formData: {
                name: '',
                email: '',
                phone: '',
                password: '',
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
        this.fetchAgents();
    },

    computed: {
        filteredAgents() {
            if (!this.searchTerm) {
                return this.agents;
            }
            const searchTermLowerCase = this.searchTerm.toLowerCase();
            return this.agents.filter(agent => {
                return agent.name.toLowerCase().includes(searchTermLowerCase);
            });
        }
    },

    methods: {
        fetchAgents() {
            axios.get('/api/agents')
                .then(response => {
                    this.agents = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },

        generatePassword() {
            const length = 9;
            const charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            let password = '';
            for (let i = 0; i < length; i++) {
                password += charset.charAt(Math.floor(Math.random() * charset.length));
            }
            this.formData.password = password;
        },

        addAgent() {
            axios.post('/api/agents', this.formData)
                .then(response => {
                    this.formData = {
                        name: '',
                        email: '',
                        phone: '',
                        password: '',
                    };
                    this.fetchAgents();
                    this.addA = false;
                })
                .catch(error => {
                    console.log(error);
                });
        },

        editAgent() {
            axios.put(`/api/agents/${this.selectedAgent.id}`, this.selectedAgent)
                .then(response => {
                    const index = this.data.findIndex(agent => agent.id === response.data.id);
                    this.$set(this.data, index, response.data);
                    this.selectedAgent = {};
                })
                .catch(error => {
                    console.log(error);
                })
                .finally(() => {
                    this.showAgentDetails = false;
                });
        },

        removeAgent(id) {
            axios.delete('/api/agents/' + id)
                .then(response => {
                    this.fetchAgents();
                })
                .catch(error => {
                    console.log(error);
                });
            this.showAgentDetails = false;
        },

        addB() {
            this.addA = true;
        },

        edit(agent) {
            this.selectedAgent = agent;
            this.showAgentDetails = true;
        },
    },

}
</script>

