<template>
  <div>

    <!-- Alert: No item found -->
    <b-alert
      variant="danger"
      :show="userData === undefined"
    >
      <h4 class="alert-heading">
        Error fetching user data
      </h4>
      <div class="alert-body">
        No user found with this user id. Check
        <b-link
          class="alert-link"
          :to="{ name: 'apps-users-list'}"
        >
          User List
        </b-link>
        for other users.
      </div>
    </b-alert>

    <template v-if="userData">
      <!-- First Row -->
      <b-row>
        <b-col
          cols="12"
          xl="9"
          lg="8"
          md="7"
        >
          <user-view-user-info-card :user-data="userData" />
        </b-col>
        <b-col
          cols="12"
          md="5"
          xl="3"
          lg="4"
        >
          <!-- <user-view-user-plan-card /> -->
        </b-col>
      </b-row>

      <b-row>
        <b-col
          cols="12"
          lg="6"
        >
          <!-- <user-view-user-timeline-card /> -->
        </b-col>
        <b-col
          cols="12"
          lg="6"
        >
          <!-- <user-view-user-permissions-card /> -->
        </b-col>
      </b-row>

      <!-- <invoice-list /> -->
    </template>

  </div>
</template>

<script>
import store from '@/store'
import {
  BRow, BCol, BAlert, BLink,
} from 'bootstrap-vue'
import InvoiceList from '@/views/apps/invoice/invoice-list/InvoiceList.vue'
import UserViewUserInfoCard from './UserViewUserInfoCard.vue'
import UserViewUserPlanCard from './UserViewUserPlanCard.vue'
import UserViewUserTimelineCard from './UserViewUserTimelineCard.vue'
import UserViewUserPermissionsCard from './UserViewUserPermissionsCard.vue'
export default {
  components: {
    BRow,
    BCol,
    BAlert,
    BLink,

    // Local Components
    UserViewUserInfoCard,
    UserViewUserPlanCard,
    UserViewUserTimelineCard,
    UserViewUserPermissionsCard,

    InvoiceList,
  },
  //   computed:{
  //   userData(){
  //     return this.$store.state.users.userData;
  //   }
  // },
   data() {
    return {
      userData: {}
    }
  },
    mounted() {
      console.log("userData", this.$route.params.id);
  this.$http.get('/api/auth/user/'+ this.$route.params.id).then(response => {
        this.userData = response.data
     

      })}}

</script>

<style>

</style>
