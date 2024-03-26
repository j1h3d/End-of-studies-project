<template>
    <b-card style="min-height: 570px">
        <div>
            <div class="mb-1 d-flex" style="right: 5rem;top: 15px; ;position: absolute;">
                <b-button @click="addB" style="margin-right: 1rem ;border-radius: 25px; height: 50px;width: 50px;">
                    <feather-icon icon="PlusIcon" size="20" style="margin-left: -6px;" />
                </b-button>
                <b-form>
                    <b-form-group id="searchInput" label="Search:" style="margin-top: 1rem;" label-cols="3">
                        <b-form-input v-model="searchTerm" size="sm" placeholder="Sales Pipeline" />
                    </b-form-group>
                </b-form>
            </div>
            <b-table :items="filteredPipelines" :per-page="7" :pagination="true" :current-page="currentPage"
                :fields="fields" style="margin-top: 4rem;">
                <template v-slot:cell(actions)="data">
                    <router-link :to="{ name: 'pipelinedetails', params: { id: data.item.id } }">
                        <b-button variant="primary">
                            <span class="iconify" data-icon="mdi-eye" size="18"></span>
                        </b-button>
                    </router-link>
                    <b-button variant="primary" @click="() => removePipeline(data.item.id)">
                        <span class="iconify" data-icon="mdi-trash" size="18"></span>
                    </b-button>
                </template>
                <template v-slot:cell(pipeline_name)="data">
                    {{ data.item.pipeline_name }}
                </template>
                <template v-slot:cell(steps_number)="data">
                    {{ data.item.steps_number }}
                </template>
            </b-table>
            <div class="mb-3 mt-1">
                <b-pagination v-model="currentPage" :total-rows="filteredPipelines.length" :per-page="7"
                    style="right: 4rem; bottom: 0 ;position: absolute" size="lg"></b-pagination>
            </div>
            <b-modal v-model="addP" hide-footer centered>
                <template #modal-title>
                    Add Sales Pipeline
                </template>
                <b-form @submit.prevent="onSubmit">
                    <b-form-group label="Pipeline Name:" label-for="pipeline_name">
                        <b-form-input id="pipeline_name" v-model="formData.pipeline_name" />
                    </b-form-group>
                    <b-form-group label="Steps Number:" label-for="steps_number">
                        <b-form-input type="number" id="steps_number" v-model="formData.steps_number"
                            @change="generateStepInputs" />
                    </b-form-group>
                    <div v-for="(step, index) in formData.steps" :key="index">
                        <b-form-group :label="`Step Name ${index + 1}:`" :label-for="`step_name_${index}`">
                            <b-form-input :id="`step_name_${index}`" v-model="step.step_name" />
                        </b-form-group>
                        <b-form-group :label="`Step Percentage ${index + 1}:`" :label-for="`step_percentage_${index}`">
                            <b-form-input type="number" :id="`step_percentage_${index}`" v-model="step.step_percentage" />
                        </b-form-group>
                    </div>
                    <div>
                        <b-button type="submit" variant="primary">Add</b-button>
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
    data() {
        return {
            rows: [],
            selectedClient: {},
            addP: false,
            pipelines: [],
            searchTerm: '',
            currentPage: 1,

            formData: {
                pipeline_name: '',
                steps_number: 1,
                steps: [{ step_name: '', step_order: 1, step_percentage: 0 }]
            },

            fields: [
                { key: 'pipeline_name', label: 'Pipeline Name' },
                { key: 'steps_number', label: 'Steps Number' },
                { key: 'actions', label: 'Actions' },
            ],
        }
    },

    mounted() {
        this.fetchSalesPipelines();
        const script = document.createElement('script');
        script.src = 'https://code.iconify.design/1/1.0.7/iconify.min.js';
        document.head.appendChild(script);
    },

    computed: {
        filteredPipelines() {
            if (!this.searchTerm) {
                return this.pipelines;
            }
            const searchTermLowerCase = this.searchTerm.toLowerCase();
            return this.pipelines.filter(pipeline => {
                return pipeline.pipeline_name.toLowerCase().includes(searchTermLowerCase);
            });
        }
    },

    methods: {
        fetchSalesPipelines() {
            axios.get('/api/pipelines')
                .then(response => {
                    this.pipelines = response.data.map(pipeline => {
                        pipeline.collapse = false;
                        return pipeline;
                    });
                })
                .catch(error => {
                    console.error(error);
                });
        },

        addB() {
            this.addP = true;
        },
        onSubmit() {
            axios.post('/api/pipelines', this.formData)
                .then(response => {
                    console.log(response.data.message)
                    this.addP = false
                })
                .catch(error => {
                    console.log(error)
                })
        },

        generateStepInputs() {
            const stepsNumber = parseInt(this.formData.steps_number)
            this.formData.steps = Array.from({ length: stepsNumber }, (_, index) => ({
                step_name: '',
                step_order: index + 1,
                step_percentage: 0,
            }))
        },

        goToPipeline(pipeline) {
            this.$router.push({ name: 'pipelinedetails', params: { id: pipeline.id } });
        },

        removePipeline(id) {
            axios.delete('/api/pipelines/' + id)
                .then(response => {
                    this.fetchSalesPipelines();
                })
                .catch(error => {
                    console.log(error);
                });
        },
    },

}
</script>

