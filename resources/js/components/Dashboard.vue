<template>
    <v-app>
        <Header
            @send="recV"
            :login_status="this.login_status"
            :username="this.username"
            @status="setStatus"
        ></Header>

        <!-- <v-content> {{ this.page }}</v-content> -->

        <!-- <v-if></v-if> -->
        <div class="position-relative w-100">
            <transition name="change">
                <!-- <Login @send="recV" v-if="this.page == 'login'"></Login>
                <Home @send="recV" v-if="this.page == 'home'"></Home> -->

                <Login
                    @send="recV"
                    @status="setStatus"
                    @username="setUsername"
                    v-if="this.page == 'login'"
                ></Login>
                <Home @send="recV" v-if="this.page == 'home'"></Home>

                <OrderFormEntry
                    @send="recV"
                    v-if="this.page == 'order-form-entry'"
                ></OrderFormEntry>
            </transition>
        </div>
        <!-- <v-content>
            <v-container class="fill-height" fluid>
                <v-row align="center" justify="center">
                    <v-col class="text-center">
                        <v-card class="mx-auto" max-width="344" outlined>
                            <v-list-item three-line>
                                <v-list-item-content>
                                    <div class="overline mb-4">OVERLINE</div>
                                    <v-list-item-title class="headline mb-1">{{
                                        writer
                                    }}</v-list-item-title>
                                    <v-list-item-subtitle
                                        >Greyhound divisely hello coldly
                                        fonwderfully</v-list-item-subtitle
                                    >
                                </v-list-item-content>

                                <v-list-item-avatar
                                    tile
                                    size="80"
                                    color="grey"
                                ></v-list-item-avatar>
                            </v-list-item>

                            <v-card-actions>
                                <v-btn text>Button</v-btn>
                                <v-btn text>Button</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-content> -->
    </v-app>
</template>

<script>
import Header from "../components/Header";
import Login from "../components/Login";
import OrderFormEntry from "../components/OrderFormEntry";
import Home from "../components/Home";

// import Login from './Login.vue';
// import Login from './Login.vue';

export default {
    name: "App",
    components: {
        Header,
        Login,
        OrderFormEntry,
        Home
    },
    data: () => ({
        drawer: false,
        page: "", //first page
        right: null,
        overlay: true,
        login_status: 0,
        username: ""
        //
    }),
    created() {
        let $vm = this;
        axios.post("/api/adminUser").then(function(response) {
            console.log(response);
            $vm.overlay = false;
            let current_route = $vm.$router.currentRoute.path;

            if (response.data.code == "200") {
                $vm.login_status = 1;
                $vm.username = response.data.username;

                if (current_route == "/login" || current_route == "/") {
                    $vm.page = "home";
                    $vm.$router.push("home");
                }
            } else {
                if (current_route != "/login") {
                    $vm.page = "login";
                    $vm.$router.push("login");
                }
            }
        });
    },
    methods: {
        recV(data) {
            this.page = data;
        },
        setStatus(data) {
            this.login_status = data;
        },
        setUsername(data) {
            this.username = data;
        }
    },
    mounted() {
        var path = this.$router.currentRoute.fullPath.replace(/\\|\//g, "");
        if (!path) {
            path = "order-login";
        }
        this.page = path;
    }
};
</script>
