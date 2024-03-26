<template>
<div>
    <nav class="navbar container" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
      <a class="navbar-item" href="/">
        <strong class="is-size-4">Add New Service</strong>
      </a>
      <navbar 
      
     />
    </div>
  </nav>
  <!-- BODY -->
      <validation-observer
        #default="{ handleSubmit }"
        ref="refFormObserver"
      >
        <!-- Form -->
        <b-form
          class="p-2"
       
        >

          <!-- Service Name -->
          <validation-provider
            #default="validationContext"
            name="Service Name"
            rules="required"
          >
            <b-form-group
              label="Service Name"
              label-for="Service-Name"
            >
              <b-form-input
                id="Service-Name"
                v-model="userData.fullName"
                autofocus
                 trim
                placeholder="Electricity"
              />

              <b-form-invalid-feedback>
                {{ }}
              </b-form-invalid-feedback>
            </b-form-group>
          </validation-provider>

          <!-- Username -->
          <validation-provider
            #default="validationContext"
            name="Username"
            rules="required|alpha-num"
          >
            <b-form-group
              label="Username"
              label-for="username"
            >
              <b-form-input
                id="username"
                v-model="userData.username"
                 trim
              />

              <b-form-invalid-feedback>
               </b-form-invalid-feedback>
            </b-form-group>
          </validation-provider>

          <!-- Email -->
          <validation-provider
            #default="validationContext"
            name="Email"
            rules="required|email"
          >
            <b-form-group
              label="Email"
              label-for="email"
            >
              <b-form-input
                id="email"
                v-model="userData.email"
                 trim
              />

              <b-form-invalid-feedback>
                {{   }}
              </b-form-invalid-feedback>
            </b-form-group>
          </validation-provider>

          <!-- Company -->
          <validation-provider
            #default="validationContext"
            name="Contact"
            rules="required"
          >
            <b-form-group
              label="Contact"
              label-for="contact"
            >
              <b-form-input
                id="contact"
                v-model="userData.contact"
                 trim
              />

              <b-form-invalid-feedback>
                {{   }}
              </b-form-invalid-feedback>
            </b-form-group>
          </validation-provider>

          <!-- Company -->
          <validation-provider
            #default="validationContext"
            name="Company"
            rules="required"
          >
            <b-form-group
              label="Company"
              label-for="company"
            >
              <b-form-input
                id="company"
                v-model="userData.company"
                 trim
              />

              <b-form-invalid-feedback>
                {{ }}
              </b-form-invalid-feedback>
            </b-form-group>
          </validation-provider>

          <!-- Country -->
          <validation-provider
            #default="validationContext"
            name="Country"
            rules="required"
          >
            <b-form-group
              label="Country"
              label-for="country"
             >
              <v-select
                v-model="userData.country"
                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                :options="countries"
                :clearable="false"
                input-id="country"
              />
              <b-form-invalid-feedback  >
                {{  }}
              </b-form-invalid-feedback>
            </b-form-group>
          </validation-provider>

          <!-- User Role -->
          <validation-provider
            #default="validationContext"
            name="User Role"
            rules="required"
          >
            <b-form-group
              label="User Role"
              label-for="user-role"
             >
              <v-select
                v-model="userData.role"
                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                :options="roleOptions"
                :reduce="val => val.value"
                :clearable="false"
                input-id="user-role"
              />
              <b-form-invalid-feedback   >
                {{   }}
              </b-form-invalid-feedback>
            </b-form-group>
          </validation-provider>

          <!-- Plan -->
          <validation-provider
            #default="validationContext"
            name="Plan"
            rules="required"
          >
            <b-form-group
              label="Plan"
              label-for="plan"
             >
              <!-- <v-select
                v-model="userData.currentPlan"
                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                :options="planOptions"
                :reduce="val => val.value"
                :clearable="false"
                input-id="plan"
              /> -->
              <b-form-invalid-feedback>
                {{ }}
              </b-form-invalid-feedback>
            </b-form-group>
          </validation-provider>

          <!-- Form Actions -->
          <div class="d-flex mt-2">
            <b-button
              v-ripple.400="'rgba(255, 255, 255, 0.15)'"
              variant="primary"
              class="mr-2"
              type="submit"
            >
              Add
            </b-button>
            <b-button
              v-ripple.400="'rgba(186, 191, 199, 0.15)'"
              type="button"
              variant="outline-secondary"
            
            >
              Cancel
            </b-button>
          </div>

        </b-form>
      </validation-observer>
</div>
    </template>

<script>
import {
  BSidebar, BForm, BFormGroup, BFormInput, BFormInvalidFeedback, BButton,
} from 'bootstrap-vue'
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import { ref } from '@vue/composition-api'
import { required, alphaNum, email } from '@validations'
import formValidation from '@core/comp-functions/forms/form-validation'
import Ripple from 'vue-ripple-directive'
import vSelect from 'vue-select'
import countries from '@/@fake-db/data/other/countries'
import store from '@/store'

export default {
  components: {
    BSidebar,
    BForm,
    BFormGroup,
    BFormInput,
    BFormInvalidFeedback,
    BButton,
    vSelect,

    // Form Validation
    ValidationProvider,
    ValidationObserver,
  },
  directives: {
    Ripple,
  },
  model: {
    prop: 'isAddNewUserSidebarActive',
    event: 'update:is-add-new-user-sidebar-active',
  },
  props: {
    isAddNewUserSidebarActive: {
      type: Boolean,
      required: true,
    },
    roleOptions: {
      type: Array,
      required: true,
    },
    planOptions: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {
      required,
      alphaNum,
      email,
      countries,
    }
  },
  setup(props, { emit }) {
    const blankUserData = {
      fullName: '',
      username: '',
      email: '',
      role: null,
      currentPlan: null,
      company: '',
      country: '',
      contact: '',
    }

    const userData = ref(JSON.parse(JSON.stringify(blankUserData)))
    const resetuserData = () => {
      userData.value = JSON.parse(JSON.stringify(blankUserData))
    }

    const onSubmit = () => {
      store.dispatch('app-user/addUser', userData.value)
        .then(() => {
          emit('refetch-data')
          emit('update:is-add-new-user-sidebar-active', false)
        })
    }

    const {
      refFormObserver,
      getValidationState,
      resetForm,
    } = formValidation(resetuserData)

    return {
      userData,
      onSubmit,

      refFormObserver,
      getValidationState,
      resetForm,
    }
  },
}
</script>

<style lang="scss">
@import '@core/scss/vue/libs/vue-select.scss';

#add-new-user-sidebar {
  .vs__dropdown-menu {
    max-height: 200px !important;
  }
}
</style>