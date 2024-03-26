<template>
    <b-card class="card-big" style="min-height: 570px; display: flex; flex: 1; flex-direction: column">
        <div style="margin-top: 3rem;">
            <b-card no-body style="background-color: rgb(241, 241, 241);">
                <b-card-header>
                    <h2 style="color: rgb(71, 71, 71);">{{ pipeline.pipeline_name }}</h2>
                    <div style="margin-left: 76%;">
                        <b-badge variant="primary">{{ pipeline.steps ? pipeline.steps.length : 0 }} Steps</b-badge>
                    </div>
                </b-card-header>
                <b-card-body>
                    <div style="max-width: 100%; overflow-x: auto;">
                        <draggable ghost-class="ghost" style="padding: 20px 20px;display: flex;overflow-y: auto;"
                            v-model="pipeline.steps" group="steps" animation="150" @start="dragging = true"
                            @end="saveStepOrder">
                            <div v-for="(step, index) in pipeline.steps" :key="step.id" style="flex-shrink: 0;">
                                <b-card class="card-int mr-1" style="width: 230px;">
                                    <b-card-header style="top: -20px;">
                                        <p style="font-size: 18px;margin-left: -17px; color: #2F9297;">Step {{ index + 1 }}
                                        </p>
                                        <b-button variant="danger" size="sm"
                                            style="position: absolute;margin-top: -8px; margin-left: 8rem;"
                                            @click="removeStep(step.id, index)">X</b-button>
                                    </b-card-header>
                                    <div class="step-content">
                                        <div class="card-header-i">
                                            Name <p>{{ step.step_name }}</p>
                                            Percentage <p>({{ step.step_percentage }}%)</p>
                                        </div>
                                    </div>
                                </b-card>
                            </div>
                        </draggable>
                    </div>
                </b-card-body>
                <a class="pl-2 pb-2 text-black" href="#" @click="showAddStepModal = true">+ Add Step</a>
            </b-card>
        </div>
        <b-modal v-model="showAddStepModal" title="Add Step" hide-footer>
            <b-form @submit.prevent="addStep">
                <b-form-group label="Step Name" label-for="step-name-input">
                    <b-form-input id="step-name-input" v-model="newStepName" required></b-form-input>
                </b-form-group>

                <b-form-group label="Step Percentage" label-for="step-percentage-input">
                    <b-form-input type="number" id="step-percentage-input" v-model="newStepPercentage" min="0" max="100"
                        required></b-form-input>
                </b-form-group>

                <b-button variant="primary" type="submit">Add Step</b-button>
                <b-button variant="secondary" @click="showAddStepModal = false">Cancel</b-button>
            </b-form>
        </b-modal>
    </b-card>
</template>
  
  
  

<script>
import draggable from 'vuedraggable'
import axios from 'axios';
import { BCard, BCardBody, BCardHeader, BCollapse, BBadge, BIcon } from 'bootstrap-vue';
export default {
    name: 'pipelinedetails',
    components: {
        draggable,
        BCard,
        BCardBody,
        BCardHeader,
        BCollapse,
        BBadge,
        BIcon
    },
    data() {
        return {
            dragging: false,
            loading: false,
            showAddStepModal: false,
            error: null,
            allSteps: [],
            pipeline: {},
            pipelines: [{
                collapse: false,
            }],
            cardVisible: false,
            dragging: false,
            draggedIndex: null,
            newStepName: '',
            newStepPercentage: '',
            formData: {
                pipeline_name: '',
                steps_number: 1,
                steps: [{ step_name: '', step_order: 1, step_percentage: 0 }]
            },
        }
    },
    created() {
        axios.get(`/api/pipelines/${this.$route.params.id}`)
            .then(response => {
                this.pipeline = response.data;
                console.log('Fetched pipeline:', this.pipeline);
            })
            .catch(error => {
                console.log(error);
            });
    },
    methods: {
        addStep() {
            axios.post(`/api/steps`, {
                sales_pipeline_id: this.pipeline.id,
                step_name: this.newStepName,
                step_percentage: this.newStepPercentage,
            })
                .then(response => {
                    const newStep = response.data;
                    const lastStep = this.pipeline.steps[this.pipeline.steps.length - 1];
                    const newStepOrder = lastStep ? lastStep.step_order + 1 : 1;

                    newStep.step_order = newStepOrder;
                    this.pipeline.steps.push(newStep);
                    this.showAddStepModal = false;
                    this.newStepName = '';
                    this.newStepPercentage = '';
                    window.location.reload();
                })
                .catch(error => {
                    console.error(error);
                });
        },



        removeStep(stepId, index) {
            const dialog = document.createElement('div');
            dialog.className = 'confirmation-dialog';
            dialog.innerHTML = `<div class="dialog-box">
                                  <h4>Are you sure you want to delete this step?</h4>
                                  <div class="buttons">
                                    <button class="confirm-btn">Delete</button>
                                    <button class="cancel-btn">Cancel</button>
                                  </div>
                                </div>
                              `;
            const confirmBtn = dialog.querySelector('.confirm-btn');
            const cancelBtn = dialog.querySelector('.cancel-btn');
            confirmBtn.addEventListener('click', () => {
                axios.delete(`/api/steps/${stepId}`)
                    .then(response => {
                        this.pipeline.steps.splice(index, 1);
                    })
                    .catch(error => {
                        console.error(error);
                    });
                document.body.removeChild(dialog);
            });
            cancelBtn.addEventListener('click', () => {
                document.body.removeChild(dialog);
            });

            document.body.appendChild(dialog);
        },
        saveStepOrder() {
            const stepOrders = this.pipeline.steps.map((step, index) => {
                return {
                    id: step.id,
                    step_order: index + 1,
                };
            });

            axios.put(`/api/pipelines/${this.pipeline.id}/steps`, {
                steps: stepOrders,
            }).then(response => {
                console.log('Step order saved successfully');
            }).catch(error => {
                console.error('Error saving step order:', error);
            });
        },
    }
}
</script>




<style>
.ghost {
    opacity: 0.5;
    background: #c8ebfb;
}

.step-content {
    width: 9rem;
}

.card-big {
    border: solid 1px rgb(238, 238, 238);
    padding: 8px;
    border-radius: 5px;
    background-color: rgb(255, 255, 255);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.card-int {
    border: solid 1px rgb(245, 245, 245);
    padding: 8px;
    border-radius: 5px;
    background-color: rgb(255, 255, 255);
    color: rgb(53, 53, 53);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.card-header-i {
    background-color: rgb(255, 255, 255);
    color: #8a8a8a;
    font-weight: bold;
    font-size: 15px;
    margin-top: -15px;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
}

.card-header-i p {
    color: #a0a0a0;
    font-size: 13px;
    margin: 8px 0;
}

.card-header-i p:first-child {
    margin-top: 0;
}

::-webkit-scrollbar {
    width: 8px;
    height: 8px;
    background-color: #f5f5f5;
}

/* handle */
::-webkit-scrollbar-thumb {
    background-color: #c1c1c1;
    border-radius: 4px;
}

/* handle on hover */
::-webkit-scrollbar-thumb:hover {
    background-color: #a6a6a6;
}

.confirmation-dialog {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 9999;
}

.dialog-box {
    background-color: white;
    border-radius: 5px;
    padding: 20px;
    box-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.5);
    display: flex;
    flex-direction: column;
    align-items: center;
}

h4 {
    margin-bottom: 20px;
}

.buttons {
    display: flex;
}

button {
    margin: 10px;
    padding: 10px 20px;
    border-radius: 5px;
    border: none;
    cursor: pointer;
}

.confirm-btn {
    background-color: #f44336;
    color: white;
}

.cancel-btn {
    background-color: #ddd;
    color: black;
}
</style>