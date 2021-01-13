<template>
    <v-content class="position-absolute w-100">
        <v-overlay :value="overlay">
            <v-progress-circular indeterminate size="64"></v-progress-circular>
        </v-overlay>

        <v-container>
            <v-layout row class="text-xs-center" justify-center>
                <v-col xl="6" lg="6" md="12" xs="12">
                    <v-container
                        style="position: relative;"
                        class="text-xs-center"
                        fluid
                    >
                        <v-alert
                            :value="alert"
                            color="pink"
                            dark
                            border="top"
                            transition="scale-transition"
                        >
                            {{ error_msg }}
                        </v-alert>
                        <v-card elevation="1">
                            <v-card-title primary-title class="justify-center ">
                                <h4 class="pt-3">Web Admin Login</h4>
                            </v-card-title>
                            <v-card-text>
                                <v-form ref="form">
                                    <v-text-field
                                        prepend-icon="mdi-account"
                                        name="Username"
                                        label="Username"
                                        v-model="username"
                                    ></v-text-field>
                                    <v-text-field
                                        prepend-icon="mdi-lock"
                                        name="Password"
                                        label="Password"
                                        type="password"
                                        v-model="password"
                                    ></v-text-field>
                                    <v-layout
                                        row
                                        class="text-xs-center"
                                        justify-center
                                    >
                                        <v-card-actions
                                            class="mt-3 col-12 justify-center"
                                        >
                                            <v-btn @click="submit">Login</v-btn>
                                            <v-btn @click="clear" class="ml-5"
                                                >Clear</v-btn
                                            >
                                        </v-card-actions>
                                    </v-layout>
                                </v-form>
                            </v-card-text>
                        </v-card>
                    </v-container>
                </v-col>
            </v-layout>
        </v-container>
    </v-content>
</template>

<script>
export default {
    data: () => ({
        alert: false,
        username: "",
        password: "",
        overlay: false,
        error_msg: ""
    }),
    created() {
        // let $vm = this;
        // axios.post("/api/adminUser").then(function(response) {
        //     if (response.data.code == "200") {
        //         $vm.$emit("status", 1);
        //         $vm.$emit("send", "home");
        //         $vm.$router.push("home");
        //     }
        // });
    },
    mounted() {},
    methods: {
        clear() {
            this.$refs.form.reset();
        },
        submit() {
            let $vm = this;
            $vm.overlay = true;
            axios
                .post("/api/adminLogin", {
                    username: $vm.username,
                    password: $vm.password
                })
                .then(function(response) {
                    console.log(response);
                    if (response.data.code == "200") {
                        $vm.overlay = false;
                        // alert("submitted");

                        $vm.$emit("status", 1);
                        $vm.$emit("username", $vm.username);

                        $vm.$emit("send", "home");
                        $vm.$router.push("home");
                    } else {
                        $vm.alert = true;
                        $vm.error_msg = response.data.msg;
                        $vm.overlay = false;
                    }
                });
        }
    }
};
</script>

<style></style>
