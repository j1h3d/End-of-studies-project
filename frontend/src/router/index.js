import Vue from 'vue'
import VueRouter from 'vue-router'
import apps from './routes/apps'

Vue.use(VueRouter)

const router = new VueRouter({
    mode: "history",
    base: process.env.BASE_URL,
    scrollBehavior() {
        return { x: 0, y: 0 };
    },
    routes: [
        ...apps,
        {
            path: "/",
            name: "Dashboard",
            component: () => import("@/views/Dashboard.vue"),
            meta: {
                pageTitle: "Dashbord",
                requiresAuth: true,
                breadcrumb: [
                    {
                        text: "Dashboard",
                        active: false
                    }
                ],
                redirectIfLoggedIn: true
            },
            beforeEnter(to, from, next) {
                if (localStorage.getItem("accessToken")) {
                    next();
                } else {
                    next("/login");
                }

                // next();
            }
        },
        {
            path: "/dashboard",
            name: "Dashboard",
            component: () => import("@/views/Dashboard.vue"),
            meta: {
                pageTitle: "Dashbord",
                requiresAuth: true,
                breadcrumb: [
                    {
                        text: "Dashboard",
                        active: false
                    }
                ],
                redirectIfLoggedIn: true
            },
            beforeEnter(to, from, next) {
                if (localStorage.getItem("accessToken")) {
                    next();
                } else {
                    next("/login");
                }

                // next();
            }
        },
        // {
        //   path: '/utilisateurs',
        //   name: 'Users',
        //   component: () => import('@/views/SecondPage.vue'),
        //   meta: {
        //     pageTitle: 'Utilisateurs',
        //     breadcrumb: [
        //       {
        //         text: 'Utilisateurs',
        //         active: false,
        //       },
        //     ],
        //   },
        // },
        {
            path: "/login",
            name: "login",
            component: () => import("@/views/Login.vue"),
            meta: {
                layout: "full"
            }
        },
        {
            path: "/register",
            name: "register",
            component: () => import("@/views/Register.vue"),
            meta: {
                layout: "full"
            }
        },
        {
            path: "/forgotpassword",
            name: "forgotpassword",
            component: () => import("@/views/Forgotpassword.vue"),
            meta: {
                layout: "full"
            }
        },
        {
            path: "/resetpassword",
            name: "resetpassword",
            component: () => import("@/views/resetpassword.vue"),
            meta: {
                layout: "full"
            }
        },
        {
            path: "/users",
            name: "users",
            component: () => import("@/views/pages/users/Index.vue"),
            meta: {
                pageTitle: "Services",
                breadcrumb: [
                    {
                        text: "Services",
                        active: false
                    }
                ],
                redirectIfLoggedIn: true
            },
            beforeEnter(to, from, next) {
                if (localStorage.getItem("accessToken")) {
                    next();
                } else {
                    next("/login");
                }

                // next();
            }
        },
        {
            path: "/partners",
            name: "partners",
            component: () => import("@/views/Partners.vue"),
            meta: {
                pageTitle: "Partners",
                breadcrumb: [
                    {
                        text: "Partners",
                        active: false
                    }
                ],
                redirectIfLoggedIn: true
            },
            beforeEnter(to, from, next) {
                if (localStorage.getItem("accessToken")) {
                    next();
                } else {
                    next("/login");
                }

                // next();
            }
        },
        {
            path: "/Profile",
            name: "Profile",
            component: () => import("@/views/Profile.vue"),
            meta: {
                pageTitle: "Profile",
                breadcrumb: [
                    {
                        text: "Profile",
                        active: false
                    }
                ],
                redirectIfLoggedIn: true
            },
            beforeEnter(to, from, next) {
                if (localStorage.getItem("accessToken")) {
                    next();
                } else {
                    next("/login");
                }

                // next();
            }
        },
        {
            path: "/clients",
            name: "clients",
            component: () => import("@/views/client/Clients.vue"),
            meta: {
                pageTitle: "Clients",
                breadcrumb: [
                    {
                        text: "Clients",
                        active: false
                    }
                ],
                redirectIfLoggedIn: true
            },
            beforeEnter(to, from, next) {
                if (localStorage.getItem("accessToken")) {
                    next();
                } else {
                    next("/login");
                }

                // next();
            }
        },
        {
            path: "/clients/:id",
            name: "clientinfo",
            component: () => import("@/views/client/clientinfo.vue"),
            props: true,
            meta: {
                pageTitle: "Clients",
                breadcrumb: [
                    {
                        text: "Clients",
                        active: false
                    }
                ],
                redirectIfLoggedIn: true
            },
            beforeEnter(to, from, next) {
                if (localStorage.getItem("accessToken")) {
                    next();
                } else {
                    next("/login");
                }

                // next();
            }
        },
        {
            path: "/services",
            name: "services",
            component: () => import("@/views/service/services.vue"),
            meta: {
                pageTitle: "Services",
                breadcrumb: [
                    {
                        text: "Services",
                        active: false
                    }
                ],
                redirectIfLoggedIn: true
            },
            beforeEnter(to, from, next) {
                if (localStorage.getItem("accessToken")) {
                    next();
                } else {
                    next("/login");
                }

                // next();
            }
        },
        {
            path: "/service",
            name: "service",
            component: () => import("@/views/service/service.vue"),
            meta: {
                pageTitle: "Create Service",
                breadcrumb: [
                    {
                        text: "Create Service",
                        active: false
                    }
                ],
                redirectIfLoggedIn: true
            },
            beforeEnter(to, from, next) {
                if (localStorage.getItem("accessToken")) {
                    next();
                } else {
                    next("/login");
                }

                // next();
            }
        },
        {
            path: "/agents",
            name: "agents",
            component: () => import("@/views/agents.vue"),
            meta: {
                pageTitle: "Agents",
                breadcrumb: [
                    {
                        text: "Agents",
                        active: false
                    }
                ],
                redirectIfLoggedIn: true
            },
            beforeEnter(to, from, next) {
                if (localStorage.getItem("accessToken")) {
                    next();
                } else {
                    next("/login");
                }

                // next();
            }
        },
        {
            path: "/pipelines",
            name: "pipelines",
            component: () => import("@/views/pipelines/sales-pipeline.vue"),
            meta: {
                pageTitle: "Sales Pipeline",
                breadcrumb: [
                    {
                        text: "Sales Pipeline",
                        active: false
                    }
                ],
                redirectIfLoggedIn: true
            },
            beforeEnter(to, from, next) {
                if (localStorage.getItem("accessToken")) {
                    next();
                } else {
                    next("/login");
                }

                // next();
            }
        },
        {
            path: "/pipelines/:id",
            name: "pipelinedetails",
            component: () => import("@/views/pipelines/pipelineDetails.vue"),
            props: true,
            meta: {
                pageTitle: "Pipeline Details",
                breadcrumb: [
                    {
                        text: "Pipeline Details",
                        active: false
                    }
                ],
                redirectIfLoggedIn: true
            },
            beforeEnter(to, from, next) {
                if (localStorage.getItem("accessToken")) {
                    next();
                } else {
                    next("/login");
                }

                // next();
            }
        },
        {
            path: "/transactions",
            name: "transactions",
            component: () => import("@/views/transactions/transactions.vue"),
            meta: {
                pageTitle: "Transactions",
                breadcrumb: [
                    {
                        text: "Transactions",
                        active: false
                    }
                ],
                redirectIfLoggedIn: true
            },
            beforeEnter(to, from, next) {
                if (localStorage.getItem("accessToken")) {
                    next();
                } else {
                    next("/login");
                }

                // next();
            }
        },
        {
            path: "/add-user",
            name: "add-user",
            component: () => import("@/views/pages/users/Add.vue"),
            meta: {
                pageTitle: "Add User",
                breadcrumb: [
                    {
                        text: "Add User",
                        active: false
                    }
                ],
                redirectIfLoggedIn: true
            },
            beforeEnter(to, from, next) {
                if (localStorage.getItem("accessToken")) {
                    next();
                } else {
                    next("/login");
                }

                // next();
            }
        },
        {
            path: "/error-404",
            name: "error-404",
            component: () => import("@/views/error/Error404.vue")
        },
        {
            path: "*",
            redirect: "error-404"
        }
    ]
});

// ? For splash screen
// Remove afterEach hook if you are not using splash screen
router.afterEach(() => {
    // Remove initial loading
    const appLoading = document.getElementById('loading-bg')
    if (appLoading) {
        appLoading.style.display = 'none'
    }
})

export default router
