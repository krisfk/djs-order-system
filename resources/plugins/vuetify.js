// src/plugins/vuetify.js

import Vue from "vue";
import Vuetify from "vuetify";

Vue.use(Vuetify);
// console.log(6);
const opts = {
    theme: {
        themes: {
            light: {
                primary: "#d5418d",
                secondary: "#b0bec5",
                accent: "#8c9eff",
                error: "#b71c1c"
            }
        }
    }
};

export default new Vuetify(opts);