<template>
    <div class="navbar-container d-flex content align-items-center">
        <!-- Nav Menu Toggler -->
        <ul class="nav navbar-nav d-xl-none">
            <li class="nav-item">
                <b-link class="nav-link" @click="toggleVerticalMenuActive">
                    <feather-icon icon="MenuIcon" size="21" />
                </b-link>
            </li>
        </ul>

        <!-- Left Col -->
        <div
            class="bookmark-wrapper align-items-center flex-grow-1 d-none d-lg-flex"
        >
            <dark-Toggler class="d-none d-lg-block" />
        </div>

        <b-navbar-nav class="nav align-items-center ml-auto">
            <b-nav-item-dropdown
                right
                toggle-class="d-flex align-items-center dropdown-user-link"
                class="dropdown-user"
            >
                <template #button-content>
                    <div class="d-sm-flex d-none user-nav">
                        <p class="user-name font-weight-bolder mb-0">
                            {{ user.name }}
                        </p>
                        <span class="user-status"> {{ role  }} </span>
                    </div>
                    <b-avatar
                        size="40"
                        variant="light-primary"
                        badge
                        :src="require('@/assets/images/avatars/9-small.png')"
                        class="badge-minimal"
                        badge-variant="success"
                    />
                </template>

                <b-dropdown-item link-class="d-flex align-items-center" @click="profile">
                    <feather-icon size="16" icon="UserIcon" class="mr-50" />
                    <span>Profile</span>
                </b-dropdown-item>

                <b-dropdown-divider />

                <b-dropdown-item
                    link-class="d-flex align-items-center"
                    @click="logout"
                >
                    <feather-icon size="16" icon="LogOutIcon" class="mr-50" />
                    <span>Logout</span>
                </b-dropdown-item>
            </b-nav-item-dropdown>
        </b-navbar-nav>
    </div>
</template>

<script>
import axios from "axios";

import {
    BLink,
    BNavbarNav,
    BNavItemDropdown,
    BDropdownItem,
    BDropdownDivider,
    BAvatar
} from "bootstrap-vue";
import DarkToggler from "@core/layouts/components/app-navbar/components/DarkToggler.vue";

export default {
    components: {
        BLink,
        BNavbarNav,
        BNavItemDropdown,
        BDropdownItem,
        BDropdownDivider,
        BAvatar,

        // Navbar Components
        DarkToggler
    },
    data() {
        return {
            user: {
                name: "",
                id: "",
            },

            role:""
        };
    },
      created() {
    this.fetchUserData();
  },
    props: {
        toggleVerticalMenuActive: {
            type: Function,
            default: () => {}
        }
    },
    mounted() {
        // Fetch the user data from the backend API endpoint
        this.fetchUserData();
    },
     computed: {
    userRole() {
      return this.getUserRole(this.user.id);
    },
  },
    methods: {
        logout() {
            console.log("Logout method called");

            axios
                .post("/api/logout")
                .then(response => {
                    // Handle success, e.g., clear local data, redirect, etc.
                })
                .catch(error => {
                    // Handle error
                });
            this.$router.push("/login");
            localStorage.removeItem("accessToken");
        },
         profile() {
    // Redirect to the profile page
    window.location.href = "/profile";
  },
fetchUserData() {
      const accessToken = localStorage.getItem("accessToken");
      const headers = {
        Authorization: `Bearer ${accessToken}`,
        Accept: "application/json"
      };

      axios
        .get("http://127.0.0.1:8000/api/auth/user", { headers })
        .then(response => {
          console.log(response.data);
          this.user = response.data;

          // Retrieve the user ID
          const userId = response.data.id;

          // Search in the "entreprise" table
          axios.get(`/api/entreprise/${userId}`)
            .then(entrepriseUser => {
              if (entrepriseUser.data) {
                console.log("User is in the entreprise table");
                this.role = 'Entreprise';
              } else {
                // Search in the "commercial" table
                axios.get(`/api/commercial/${userId}`)
                  .then(commercialUser => {
                    if (commercialUser.data) {
                      console.log("User is in the commercial table");
                      this.role = 'Commercial';
                    } else {
                      console.log("User is not found in either table");
                      this.role = 'Admin';
                    }
                  })
                  .catch(error => {
                    console.log(error);
                  });
              }
            })
            .catch(error => {
              console.log(error);
            });
        })
        .catch(error => {
          console.log(error);
        });
    },

        }

};
</script>
