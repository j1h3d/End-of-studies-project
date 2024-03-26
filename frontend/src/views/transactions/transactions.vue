<template>
    <b-card style="min-height: 570px">
        <div>
            <div class="d-flex" style="right: 5rem;top: 15px; position: absolute;">
                <b-button @click="addB" style="margin-right: 1rem ;border-radius: 25px; height: 50px;width: 50px;">
                    <feather-icon icon="PlusIcon" size="20" style="margin-left: -6px;" />
                </b-button>
                <b-form>
                    <b-form-group label="Pipeline used:" label-for="pipeline" label-cols="4" style="margin-top: 10px;">
                        <b-form-select v-model="selectedPipeline" :options="pipelines" id="pipeline"
                            text-field="pipeline_name" value-field="id" @change="updateColumns">
                            <template #first>
                                <option disabled selected>Please select a Sales pipeline</option>
                            </template>
                        </b-form-select>
                    </b-form-group>
                </b-form>
            </div>
            <div v-if="selectedPipeline">
                <div class="table-container">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th v-for="(column, index) in columns" :key="index">{{ column }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(column, index) in columns" :key="index">
                                <td>
                                    <b-card>
                                        <draggable v-model="transactions[column]" :group="column" class="card-list">
                                            <div v-for="(transaction, tIndex) in transactions[index]" :key="tIndex">
                                                <div class="card">
                                                    salem
                                                </div>
                                            </div>
                                        </draggable>
                                    </b-card>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <b-modal v-model="addT" hide-footer centered>
                <template #modal-title>
                    Create transaction
                </template>
                <b-form @submit.prevent="createTransaction">
                    <b-form-group label="Service:" label-for="service">
                        <b-form-select v-model="selectedService" :options="services" id="service" required text-field="name"
                            value-field="id">
                            <template #first>
                                <option selected disabled>Please select a Service</option>
                            </template>
                        </b-form-select>
                    </b-form-group>
                    <b-form-group label="Partner:" label-for="partner">
                        <b-form-select v-model="selectedPartner" :options="partners" id="partner" required text-field="name"
                            value-field="id">
                            <template #first>
                                <option disabled selected>Please select a Partner</option>
                            </template>
                        </b-form-select>
                    </b-form-group>
                    <b-form-group label="Client:" label-for="client">
                        <b-form-select v-model="selectedClient" :options="clients" id="client" required text-field="name"
                            value-field="id">
                            <template #first>
                                <option disabled>Please select a Client</option>
                            </template>
                        </b-form-select>
                    </b-form-group>
                    <b-form-group label="Agent affected:" label-for="agent">
                        <b-form-select v-model="selectedCommercial" :options="commercials" id="agent" required
                            text-field="name" value-field="id">
                            <template #first>
                                <option disabled selected>Please select an Agent</option>
                            </template>
                        </b-form-select>
                    </b-form-group>
                    <b-form-group label="Pipeline used:" label-for="pipeline">
                        <b-form-select v-model="selectedPipeline" :options="pipelines" id="pipeline" required
                            text-field="pipeline_name" value-field="id">
                            <template #first>
                                <option disabled selected>Please select a Sales pipeline</option>
                            </template>
                        </b-form-select>
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
import draggable from 'vuedraggable'
import axios from 'axios';
export default {
    components: {
        draggable,
    },
    data() {
        return {
            selectedClient: null,
            selectedPartner: null,
            selectedService: null,
            selectedCommercial: null,
            selectedPipeline: null,
            draggedItem: null,
            draggedItemIndex: null,
            draggedItemPipelineId: null,
            unassignedTransactions: [],
            transactions: [],
            clients: [],
            services: [],
            steps: [],
            partners: [],
            commercials: [],
            pipelines: [],
            columns: [],
            columnsData: [],
            addT: false,
            formData: {
                client_id: '',
                service_id: '',
                partner_id: '',
                commercial_id: '',
                pipeline_id: '',
            }
        };
    },
    mounted() {
        this.fetchServices();
        this.fetchPartners();
        this.fetchClients();
        this.fetchCommercials();
        this.fetchPipelines();
        console.log('yoo ', this.transactions.__ob__.value);
    },
    watch: {
        selectedPipeline(newVal) {
            if (newVal) {
                this.fetchTransactions();
            }
        },
    },
    methods: {
        updateColumns() {
            const pipeline = this.pipelines.find(p => p.id === this.selectedPipeline);
            if (pipeline) {
                this.columns = Array.from({ length: pipeline.steps_number }, (_, i) => `Step ${i + 1}`);
            } else {
                this.columns = [];
            }
        },

        fetchServices() {
            axios.get('/api/services')
                .then(response => {
                    this.services = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        fetchPartners() {
            axios.get('/api/partners')
                .then(response => {
                    this.partners = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        fetchClients() {
            axios.get('/api/clients')
                .then(response => {
                    this.clients = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        fetchCommercials() {
            axios.get('/api/agents')
                .then(response => {
                    this.commercials = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        fetchPipelines() {
            axios.get('/api/pipelines')
                .then(response => {
                    this.pipelines = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },


        onDragStart(evt, pipelineId) {
            this.draggedItem = evt.item;
            this.draggedItemIndex = evt.oldIndex;
            this.draggedItemPipelineId = pipelineId;
        },
        onDragEnd() {
            this.draggedItem = null;
            this.draggedItemIndex = null;
            this.draggedItemPipelineId = null;
        },
        onDrop(pipelineId) {
            if (this.draggedItem && this.draggedItemPipelineId !== pipelineId) {
                const draggedItemCopy = { ...this.draggedItem };
                if (this.draggedItemPipelineId === null) {
                    this.unassignedTransactions.splice(this.draggedItemIndex, 1);
                } else {
                    this.transactions.pipelines[this.draggedItemPipelineId].steps.splice(
                        this.draggedItemIndex,
                        1
                    );
                }
                this.transactions.pipelines[pipelineId].steps.push(draggedItemCopy);
            }
        },


        removeTransactionFromPipelines(transactionId) {
            for (const pipeline of this.transactions.pipelines) {
                const index = pipeline.transactions.findIndex(t => t.id === transactionId);

                if (index !== -1) {
                    pipeline.transactions.splice(index, 1);
                    break;
                }
            }
        },



        createTransaction() {
            axios.post('/api/transactions', {
                service_id: this.selectedService,
                partner_id: this.selectedPartner,
                client_id: this.selectedClient,
                commercial_id: this.selectedCommercial,
                pipeline_id: this.selectedPipeline,
            })
                .then(response => {
                    console.log(response.data);
                    this.fetchTransactions();
                    this.addT = false;
                })
                .catch(error => {
                    console.log(error);
                });
        },



        fetchTransactions() {
            axios
                .get('/api/transactions')
                .then(response => {
                    this.transactions = response.data;
                })
                .catch(error => {
                    console.error(error);
                });
        },

        addB() {
            this.addT = true;
        },
    },
};
</script>
<style scoped>
.table-container {
    overflow-x: auto;
}

.custom-table {
    margin-top: 4rem;
    width: 100%;
    border-collapse: collapse;
}

.custom-table th,
.custom-table td {
    padding: 8px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.card {
    margin-bottom: 15px;
}

.card-body {
    padding: 15px;
}

.card-title {
    margin-bottom: 10px;
}

.card-text {
    margin-bottom: 5px;
}

.card-list {
    min-height: 50px;
    list-style-type: none;
    padding: 0;
    margin: 0;
}

.card-list .draggable-dragging {
    opacity: 0.5;
}
</style>