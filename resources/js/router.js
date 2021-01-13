import Vue from "vue";
import VueRouter from "vue-router";
import Dashboard from "./components/Dashboard";
import Vuetify from "../plugins/vuetify";

Vue.use(VueRouter);
Vue.use(Vuetify);
// console.log(66);
export default new VueRouter({
    routes: [{
            path: "/",
            component: Dashboard
        },
        {
            path: "/login",
            component: Dashboard
        },

        {
            path: "/home",
            component: Dashboard
        },
        {
            path: "/order-login",
            component: Dashboard
        },
        {
            path: "/order-form-entry",
            component: Dashboard
        },
        {
            path: "/order-list",
            component: Dashboard
        }
    ],
    mode: "history",
    base: "/cms"
});