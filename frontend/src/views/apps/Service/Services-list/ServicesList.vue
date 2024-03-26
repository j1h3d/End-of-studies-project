<template lang="">
  <div>
   <b-card>Hello
<!-- Table start -->
      <b-table
        ref="refUserListTable"
        class="position-relative"
        :items="services"
        responsive
        :fields="tableColumns"
        primary-key="id"
        :sort-by.sync="sortBy"
        show-empty
        empty-text="No matching records found"
        :sort-desc.sync="isSortDirDesc"
      >


      <!-- Column: User -->
        <template #cell(user)="data">
           <b-media vertical-align="center">
            <template #aside>
              <!-- <b-avatar
                size="32"
                :src="data.image"
              
              /> -->
  <b-img :src="require('@/assets/images/avatars/1.png')" fluid alt="Fluid image"></b-img>

            </template>
          
          </b-media>
        </template>
   


        <!-- Column: Actions
        <template #cell(actions)="data">
          <b-dropdown
            variant="link"
            no-caret
            :right="$store.state.appConfig.isRTL"
          >

            <template #button-content>
              <feather-icon
                icon="MoreVerticalIcon"
                size="16"
                class="align-middle text-body"
              />
            </template>
            <b-dropdown-item :to="{ name: 'apps-users-view', params: { id: data.item.id } }">
              <feather-icon icon="FileTextIcon" />
              <span class="align-middle ml-50">Details</span>
            </b-dropdown-item>

            <b-dropdown-item :to="{ name: 'apps-users-edit', params: { id: data.item.id } }">
              <feather-icon icon="EditIcon" />
              <span class="align-middle ml-50">Edit</span>
            </b-dropdown-item>

            <b-dropdown-item>
              <feather-icon icon="TrashIcon" />
              <span class="align-middle ml-50">Delete</span>
            </b-dropdown-item>
          </b-dropdown>
        </template> -->

      </b-table>
<!-- Table end -->
   </b-card>
  </div>
</template>
<script>
import {  BCard, BRow, BCol, BFormInput, BButton, BTable, BMedia, BAvatar, BLink,
  BBadge, BDropdown, BDropdownItem, BPagination,BImg} from 'bootstrap-vue'
export default {
  components:{
     BCard, BRow, BCol, BFormInput, BButton, BTable, BMedia, BAvatar, BLink,
  BBadge, BDropdown, BDropdownItem, BPagination, BImg
  },
  data() {
    return {
      services:{}
    }
  },
  created() {
       this.$http.get('/api/services').then(response => {
        this.services = response.data
        console.log(this.services);
  })
},
setup(props) {
  const tableColumns= [
     { key: 'user', sortable: true },
          {
            key: 'titre',
            sortable: true
          },
          {
            key: 'nature',
            sortable: true
          },
          {
            key: 'prix',
            sortable: false
          },
          {
            key: 'description',
            sortable: false
          },
          {
            key: 'image',
            sortable: false
          },
      
          {
            key: 'categorie',
            label: 'Category',
            sortable: true,
            // Variant applies to the whole column, including the header and footer
            variant: 'danger'
          },
         
        ]
        return{
          tableColumns
        }
  
}}
</script>
<style lang="">
  
</style>