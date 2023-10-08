<template>
    <div>
        <v-overlay :value="overlay">
            <v-progress-circular indeterminate size="64"></v-progress-circular>
        </v-overlay>
        <v-app-bar app color="indigo" dark>
            <v-app-bar-nav-icon @click.stop="drawer = !drawer" />
            <v-toolbar-title>DJS ORDER SYSTEM</v-toolbar-title>
        </v-app-bar>
        <v-navigation-drawer v-model="drawer" app>
            <v-list dense nav v-if="login_status">
                <v-list-item>
                    <v-list-item>
                        <h5>Hello {{ username }}!</h5>
                    </v-list-item>
                </v-list-item>
            </v-list>

            <v-list dense nav>
                <v-list-item v-if="!login_status">
                    <v-list-item @click="clicked('login')" link>
                        <v-list-item-icon>
                            <v-icon>mdi-login</v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title v-html="'Login'">
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list-item>

                <v-list-item v-if="this.login_status">
                    <v-list-item @click="logout" link>
                        <v-list-item-icon>
                            <v-icon>mdi-logout</v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title v-html="'Logout'">
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list-item>

                <v-list-item v-for="item in items" :key="item.id">
                    <v-list-item
                        v-if="!item.sep"
                        @click="clicked(item.slug)"
                        link
                    >
                        <v-list-item-icon>
                            <v-icon>{{ item.icon }}</v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title v-html="item.title">
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                    <v-divider v-if="item.sep"></v-divider>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>
    </div>
</template>

<script>
export default {
    props: {
        login_status: Number,
        username: String,
    },
    data: () => ({
        overlay: false,
        drawer: false,
        right: null,
        items: [
            // { title: "Login", slug: "login", icon: "mdi-login" },
            // { title: "", slug: "", icon: "", sep: true },
            // {
            //     title: "Admin User Management",
            //     slug: "admin-user-list",
            //     icon: "mdi-account-star"
            // },
            // {
            //     title: "Parent User Management",
            //     slug: "parent-user-list",
            //     icon: "mdi-account"
            // },
            // { title: "", slug: "", icon: "", sep: true },
            // {
            //     title: "Activity Information",
            //     slug: "activity",
            //     icon: "mdi-calendar"
            // },
            // {
            //     title: "Activity Registration Records",
            //     slug: "activity-registration-records",
            //     icon: "mdi-account-check"
            // },
            // { title: "", slug: "", icon: "", sep: true },
            // {
            //     title: "Brand Information",
            //     slug: "brand-list",
            //     icon: "mdi-domain"
            // },
            // {
            //     title: "Brand Member<br>Registration Records",
            //     slug: "brand-registration-records",
            //     icon: "mdi-account-check"
            // },
            // { title: "", slug: "", icon: "", sep: true },
            // {
            //     title: "Doctor Information",
            //     slug: "doctor-list",
            //     icon: "mdi-doctor"
            // },
            // { title: "", slug: "", icon: "", sep: true },
            // {
            //     title: "Contact info",
            //     slug: "contact",
            //     icon: "mdi-phone"
            // },
            // {
            //     title: "Privacy policy",
            //     slug: "privacy",
            //     icon: "mdi-format-list-text"
            // },
            // {
            //     title: "Disclaimer",
            //     slug: "disclaimer",
            //     icon: "mdi-format-list-text"
            // },
            // {
            //     title: "Terms of service",
            //     slug: "term",
            //     icon: "mdi-format-list-text"
            // }
            // {
            //     title: "Order Form Entry",
            //     slug: "order-form-entry",
            //     icon: "mdi-border-color"
            // },
            // {
            //     title: "Order List",
            //     slug: "order-list",
            //     icon: "mdi-format-list-bulleted-square"
            // }
            // { title: "About", icon: "mdi-help-box" }
        ],
    }),
    methods: {
        clicked(slug) {
            this.drawer = false;
            this.$emit("send", slug);
            this.$router.push(slug);
        },
        logout() {
            let $vm = this;
            $vm.overlay = true;
            this.drawer = false;

            axios.post("/api/adminLogout").then(function (response) {
                if (response.data.code == "200") {
                    $vm.overlay = false;
                    $vm.$router.push("login");
                    $vm.$emit("send", "login");

                    // alert("submitted");
                    $vm.$emit("status", 0);
                    // $vm.$emit("username", $vm.username);
                    // $vm.$emit("send", "home");
                    // $vm.$router.push("home");
                }
            });
        },
    },
};
</script>

<style></style>
