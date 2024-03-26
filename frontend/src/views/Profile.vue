<template>
  <b-card style="min-height: 570px">
    <div>
      <h2>User Informations</h2>
      <br />

      <!-- Display user information -->
      <div class="form-group">
        <label class="form-label">Name:</label>
        <span class="form-text" v-if="!editMode">{{ user.name }}</span>
        <input v-model="user.name" v-else type="text" required />
      </div>
      <div class="form-group">
        <label class="form-label">Email:</label>
        <span class="form-text" v-if="!editMode">{{ user.email }}</span>
        <input v-model="user.email" v-else type="text" required />
      </div>
      <!-- Add more fields as needed -->

      <div class="form-group">
        <label class="form-label">Phone:</label>
        <span class="form-text" v-if="!editMode">{{ user.phone }}</span>
        <input v-model="user.phone" v-else type="text" required />
      </div>
      <!-- Display enterprise information -->
      <div class="form-group">
        <label class="form-label">Tax Registration Number:</label>
        <span class="form-text" v-if="!editMode">{{ enterprise.cp_registration }}</span>
        <input
          v-model="enterprise.cp_registration"
          v-else
          type="text"
          required
        />
      </div>
      <div class="form-group">
        <div>
          <label class="form-label">Adress:</label>
          <span class="form-text" v-if="!editMode">{{ enterprise.adress }}</span>
          <input
            v-model="enterprise.adress"
            v-else
            type="text"
            required
          />
        </div>
        <label class="form-label">City:</label>
        <span class="form-text" v-if="!editMode">{{ enterprise.city }}</span>
        <input v-model="enterprise.city" v-else type="text" required />
      </div>
      <div class="form-group">
        <label class="form-label">Social Reason:</label>
        <span class="form-text" v-if="!editMode">{{ enterprise.social_reason }}</span>
        <input
          v-model="enterprise.social_reason"
          v-else
          type="text"
          required
        />
      </div>

      <!-- Add more fields as needed -->

      <!-- Edit button -->
      <b-button variant="primary" @click="toggleEditMode" v-if="!editMode">Edit</b-button>

      <!-- Save and Cancel buttons -->
      <div v-if="editMode">
        <br>
        <b-button variant="primary" @click="saveChanges">Save</b-button>
        <b-button variant="primary" @click="cancelEditing">Cancel</b-button>
      </div>
    </div>
  </b-card>
</template>
<style>
  .form-group {
    margin-bottom: 10px;
  }

  .form-label {
    display: block;
    font-size: 16px;
  }

  .form-text {
    display: inline-block;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    background-color: #f9f9f9;
    color: #555;
    font-size: 16px;
    width: 250px; /* Set a desired width */
  }

  input[type="text"] {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    width: 250px; /* Set a desired width */
  }

  .btn-group {
    margin-top: 15px;
  }
</style>



<script>
import axios from 'axios';

export default {
    data() {
        return {
            user: {
                id:"",
                name: "",
                email: "",
                password: "",
                phone:""
                // Add more user fields as needed
            },
            enterprise: {
                cp_registration: "",
                adress: "",
                city: "",
                social_reason:""
                // Add more enterprise fields as needed
            },
            editMode: false
        };
    },
    created() {
  this.fetchUserData();
  this.fetchEnterpriseData();
},
    methods: {
  fetchUserData() {
      const accessToken = localStorage.getItem("accessToken");
      const headers = {
        Authorization: `Bearer ${accessToken}`,
        Accept: "application/json"
      };

      axios
        .get("http://127.0.0.1:8000/api/auth/user", { headers })
        .then(response => {
          this.user = response.data;

          // Retrieve enterprise data for the user
          const userId = response.data.id;
          axios
            .get(`http://127.0.0.1:8000/api/entreprise/${userId}`, { headers })
            .then(response => {
              this.enterprise = response.data;
            })
            .catch(error => {
              console.log(error);
            });
        })
        .catch(error => {
          console.log(error);
        });
    },




        toggleEditMode() {
            this.editMode = !this.editMode;
        },
        saveChanges() {
            // Perform the save operation, e.g., send data to the server
            // In this example, the changes are saved automatically in the component's data
            this.editMode = false;
        },
        cancelEditing() {
            this.editMode = false;
            // Reset the fields to their original values
            this.user = {
                  name: "",
                email: "",
                password: "",
                phone:""
            };
            this.enterprise = {
                cp_registration: "",
                adress: "",
                city: "",
                social_reason:""
            };
        }
    }
};
</script>
