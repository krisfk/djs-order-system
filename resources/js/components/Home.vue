<template>
    <v-content class="position-absolute w-100">
        <v-container>
            <v-layout row class="text-xs-center" justify-center>
                <v-col xl="6" lg="6" md="12" xs="12">
                    <v-container
                        style="position: relative;top: 13%;"
                        class="text-xs-center"
                        fluid
                    >
                        <div class="text-center">
                            <h4>Hello {{ username }}! Welcome Back</h4>
                        </div>
                    </v-container>
                </v-col>
            </v-layout>
        </v-container>

        <v-container>
            <v-layout row class="text-xs-center" justify-center>
                <v-col xl="12" lg="12" md="12" xs="12">
                    <v-container
                        style="position: relative;"
                        class="text-xs-center"
                        fluid
                    >
                        <v-card elevation="0">
                            <v-data-table
                                :headers="headers"
                                :items="orders"
                                :search="searchResult"
                                sort-by="calories"
                                class="elevation-1 mt-5"
                                :loading="isloading"
                            >
                                <!-- <template v-slot:body="{ items }">
                                    <tbody>
                                        <tr
                                            v-for="item in items"
                                            :key="item.id"
                                        >
                                            <td>{{ item.id }}</td>
                                            <td>{{ item.order_code }}</td>
                                            <td>{{ item.order_type }}</td>
                                            <td>{{ item.tel }}</td>
                                            <td>{{ item.order_app }}</td>
                                            <td style="white-space: pre-line">
                                                {{ item.order_detail }}
                                            </td>
                                            <td>{{ item.order_date }}</td>
                                            <td>
                                                <v-icon
                                                    small
                                                    class="mr-2"
                                                    @click="editItem(item)"
                                                >
                                                    mdi-pencil
                                                </v-icon>
                                                <v-icon
                                                    small
                                                    @click="deleteItem(item)"
                                                >
                                                    mdi-delete
                                                </v-icon>
                                            </td>
                                        </tr>
                                    </tbody>
                                </template> -->

                                <template v-slot:top>
                                    <v-toolbar flat>
                                        <div class="row">
                                            <div
                                                class="col-lg-8 col-md-8 col-sm-12 col-12 "
                                            >
                                                <h5 class="">
                                                    {{ page_title }}
                                                </h5>
                                                <v-divider
                                                    class="mx-2 divider"
                                                    style="width: 100px;
                                                            height: 32px;
                                                            padding: 0;
                                                            margin: 0;
                                                            position: relative;
                                                            top: 6px;"
                                                    inset
                                                    vertical
                                                ></v-divider>

                                                <!-- <v-spacer></v-spacer> -->
                                                <div class="field-div">
                                                    <v-text-field
                                                        class="d-inline-block search-text-field me-1"
                                                        v-model="search"
                                                        append-icon="mdi-magnify"
                                                        label="Search Text 1"
                                                        @keyup="
                                                            updateSearchidx(1)
                                                        "
                                                        single-line
                                                        hide-details
                                                    ></v-text-field>

                                                    <v-text-field
                                                        class="d-inline-block search-text-field search-text-field-2"
                                                        v-model="search2"
                                                        append-icon="mdi-magnify"
                                                        label="Search Text 2"
                                                        @keyup="
                                                            updateSearchidx(2)
                                                        "
                                                        single-line
                                                        hide-details
                                                    ></v-text-field>
                                                </div>
                                            </div>
                                            <!-- <v-spacer></v-spacer> -->

                                            <!-- <template
                                            v-slot:activator="{ on, attrs }"
                                        > -->

                                            <div
                                                class="col-lg-4 col-md-4 col-sm-12 col-12 text-center"
                                            >
                                                <VueJsonToCsv
                                                    :csv-title="page_title"
                                                    :json-data="orders"
                                                >
                                                    <v-btn
                                                        color="accent"
                                                        class="mb-2 ml-2"
                                                        >Export</v-btn
                                                    >
                                                </VueJsonToCsv>
                                                <v-btn
                                                    color="primary"
                                                    dark
                                                    @click="newOrder"
                                                    class="mb-2"
                                                >
                                                    New Order
                                                </v-btn>
                                            </div>
                                        </div>

                                        <!-- </template> -->
                                        <!-- new item/edit item dialog -->
                                        <v-dialog
                                            v-model="dialog"
                                            max-width="500px"
                                            v-if="!overlay"
                                        >
                                            <v-card>
                                                <v-form ref="form">
                                                    <v-card-title>
                                                        <span
                                                            class="headline"
                                                            >{{
                                                                formTitle
                                                            }}</span
                                                        >
                                                    </v-card-title>

                                                    <v-card-text>
                                                        <v-select
                                                            v-model="
                                                                editedItem.order_app
                                                            "
                                                            :items="
                                                                orderAppList
                                                            "
                                                            label="Bill App"
                                                            outlined
                                                        ></v-select>

                                                        <div
                                                            class="datepicker-label"
                                                        >
                                                            Bill Date
                                                        </div>
                                                        <Datepicker
                                                            type="date"
                                                            class="datepicker mb-5"
                                                            format="yyyy-MM-dd"
                                                            v-model="
                                                                editedItem.order_date
                                                            "
                                                            placeholder="Bill Date(yyyy-MM-dd)"
                                                        ></Datepicker>

                                                        <v-text-field
                                                            v-model="
                                                                editedItem.order_code
                                                            "
                                                            label="Bill Code"
                                                            :rules="[
                                                                rules.required
                                                            ]"
                                                            outlined
                                                        ></v-text-field>

                                                        <v-select
                                                            v-model="
                                                                editedItem.order_type
                                                            "
                                                            :items="
                                                                orderTypeList
                                                            "
                                                            label="Bill Type"
                                                            outlined
                                                        ></v-select>

                                                        <v-textarea
                                                            :rules="[
                                                                rules.required
                                                            ]"
                                                            v-model="
                                                                editedItem.order_detail
                                                            "
                                                            label="Bill Detail"
                                                            hint=""
                                                            outlined
                                                            class="mt-0"
                                                        ></v-textarea>
                                                        <v-text-field
                                                            outlined
                                                            v-model="
                                                                editedItem.tel
                                                            "
                                                            label="Tel"
                                                            :rules="[
                                                                rules.required
                                                            ]"
                                                        ></v-text-field>

                                                        <v-btn
                                                            elevation="2"
                                                            class="mr-3"
                                                            @click="close"
                                                            color="secondary"
                                                        >
                                                            Cancel
                                                        </v-btn>
                                                        <v-btn
                                                            elevation="2"
                                                            class="mr-4"
                                                            color="primary"
                                                            @click="save"
                                                        >
                                                            Ok
                                                        </v-btn>
                                                    </v-card-text>
                                                </v-form>
                                            </v-card>
                                        </v-dialog>

                                        <!-- delete item dialog -->
                                        <v-dialog
                                            v-if="!overlay"
                                            v-model="dialogDelete"
                                            max-width="500px"
                                        >
                                            <v-card>
                                                <v-card-title class="headline"
                                                    >Are you sure you want to
                                                    delete this
                                                    Order?</v-card-title
                                                >
                                                <v-card-actions>
                                                    <v-spacer></v-spacer>
                                                    <v-btn
                                                        color="secondary"
                                                        @click="closeDelete"
                                                        >Cancel</v-btn
                                                    >
                                                    <v-btn
                                                        color="primary"
                                                        @click="
                                                            deleteItemConfirm
                                                        "
                                                        >OK</v-btn
                                                    >
                                                    <v-spacer></v-spacer>
                                                </v-card-actions>
                                            </v-card>
                                        </v-dialog>
                                    </v-toolbar>
                                </template>
                                <template v-slot:[`item.actions`]="{ item }">
                                    <div class="btn-set">
                                        <v-icon
                                            small
                                            class=""
                                            @click="editItem(item)"
                                        >
                                            mdi-pencil
                                        </v-icon>
                                        <v-icon
                                            small
                                            @click="deleteItem(item)"
                                            class=""
                                        >
                                            mdi-delete
                                        </v-icon>

                                        <a
                                            target="_blank"
                                            class="action-btn"
                                            :href="
                                                'https://wa.me/852' + item.tel
                                            "
                                            >852wts</a
                                        >
                                        <a
                                            target="_blank"
                                            class="action-btn"
                                            :href="
                                                'https://wa.me/853' + item.tel
                                            "
                                            >853wts</a
                                        >

                                        <a
                                            href="javascript:void(0);"
                                            class="copy-tel-btn action-btn"
                                            :data-id="item.id"
                                            @click="copyTel(item, $event)"
                                            >copy tel</a
                                        >
                                        <a
                                            href="javascript:void(0);"
                                            class="copy-order-msg action-btn"
                                            :data-id="item.id"
                                            @click="copyOrderList(item, $event)"
                                            >copy order list</a
                                        >

                                        <input
                                            type="text"
                                            :class="
                                                'copy-tel-text copy-tel-' +
                                                    item.id
                                            "
                                            :value="item.tel"
                                        />

                                        <textarea
                                            type="text"
                                            :class="
                                                'copy-orderlist-text copy-orderlist-' +
                                                    item.id
                                            "
                                            :value="
                                                '*Bill Code*' +
                                                    '\n' +
                                                    item.order_code +
                                                    '\n\n' +
                                                    '*Bill Type*' +
                                                    '\n' +
                                                    item.order_type +
                                                    '\n\n' +
                                                    '*Tel*' +
                                                    '\n' +
                                                    item.tel +
                                                    '\n\n' +
                                                    '*Bill Detail*' +
                                                    '\n' +
                                                    item.order_detail +
                                                    '\n\n' +
                                                    '*Bill Date*' +
                                                    '\n' +
                                                    item.order_date
                                            "
                                        />
                                    </div>
                                </template>
                                <template v-slot:no-data>
                                    <v-btn color="primary" @click="initialize">
                                        Reset
                                    </v-btn>
                                </template>
                            </v-data-table>
                        </v-card>
                    </v-container>
                </v-col>
            </v-layout>
        </v-container>
        <v-bottom-sheet v-model="sheet">
            <v-sheet class="text-center sheet">
                <v-btn class="mt-6" text color="red" @click="sheet = !sheet">
                    close
                </v-btn>
                <div class="py-3 font-weight-bold">
                    Number {{ copy_tel }} is copied
                </div>
            </v-sheet>
        </v-bottom-sheet>

        <v-bottom-sheet v-model="sheet2">
            <v-sheet class="text-center sheet">
                <v-btn class="mt-6" text color="red" @click="sheet = !sheet">
                    close
                </v-btn>
                <div class="py-3 font-weight-bold">
                    Order list from {{ copy_tel }} is copied
                </div>
            </v-sheet>
        </v-bottom-sheet>
    </v-content>
</template>

<script>
// import VueJsonToCsv from "vue-json-to-csv";
import VueJsonToCsv from "vue-json-to-csv";
import Datepicker from "vuejs-datepicker";
import moment from "moment";

export default {
    components: { VueJsonToCsv, Datepicker },
    data: () => ({
        update_search_idx: "",
        copy_tel: "",
        copy_orderlist: "",
        test: "",
        sheet: false,
        sheet2: false,

        test2: "",
        username: "",
        orderTypeList: [
            "",
            "JP",
            "TW",
            "KANAHEI",
            "KAO KANAHEI",
            "JS CLOTHING",
            "STOCK",
            "STORE",
            "Syk hand made",
            "Djs venina",
            "CUSTOM"
        ],
        orderAppList: ["", "WhatsApp", "Signal"],
        current_doc: "",
        overlay: false,
        page_title: "Order Management",
        rules: {
            required: value => !!value || "Required.",
            password_edit: value =>
                !value || (value && value.length >= 8) || "Min 8 characters",
            password_new: value =>
                (value && value.length >= 8) || "Min 8 characters",

            email: value => {
                const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return pattern.test(value) || "Invalid e-mail.";
            }
        },

        search: "",
        search2: "",
        isloading: true,
        dialog: false,
        dialogDelete: false,
        headers: [
            { text: "ID", value: "id" },
            { text: "Bill App", value: "order_app" },
            { text: "Bill Date", value: "order_date" },
            { text: "Bill Code", value: "order_code" },
            { text: "Bill Type", value: "order_type" },
            { text: "Bill Detail", value: "order_detail" },
            { text: "Tel", value: "tel" },
            { text: "Actions", value: "actions", sortable: false }
        ],
        orders: [],
        editedIndex: -1,
        editedItem: {
            upload_doc: []
        },
        defaultItem: {
            upload_doc: []
        }
    }),

    computed: {
        formTitle() {
            return this.editedIndex === -1 ? "New Order" : "Edit Order";
        },
        searchResult() {
            // console.log(this.update_search_idx);
            if (this.search && !this.search2) {
                // console.log(1);
                return this.search;
            } else if (!this.search && this.search2) {
                // console.log(2);

                return this.search2;
            } else {
                if (this.update_search_idx == 1) {
                    return this.search;
                    // this.search2 && this.search;
                }
                if (this.update_search_idx == 2) {
                    return this.search2;
                    // this.search && this.search2;
                }
            }

            // {
            //     return this.search;
            // } else {
            //     return this.search && this.search2;
            // }
            // return !this.search ? this.search2 : this.search && this.search2;
        }
    },

    watch: {
        dialog(val) {
            val || this.close();
            this.$refs.form && this.$refs.form.resetValidation();
            // alert(this.editedIndex);
            if (this.editedIndex == -1) {
                var todaydate = new Date();
                todaydate = moment(todaydate).format("YYYY-MM-DD");

                this.editedItem.order_date = todaydate;
            }
        },
        dialogDelete(val) {
            val || this.closeDelete();
        }
    },

    mounted: function() {
        this.fetchAllOrders();
    },

    methods: {
        updateSearchidx(idx) {
            this.update_search_idx = idx;
            // alert(idx);
        },
        copyTel(item, event) {
            var idx = event.currentTarget.getAttribute("data-id");
            var copyTextarea = document.querySelector(".copy-tel-" + idx);
            this.copy_tel = item.tel;

            copyTextarea.focus();
            copyTextarea.select();

            try {
                var successful = document.execCommand("copy");

                var msg = successful ? "successful" : "unsuccessful";
                console.log("Copying text command was " + msg);
                this.sheet = true;
            } catch (err) {
                console.log("Oops, unable to copy");
            }
        },
        copyOrderList(item, event) {
            var idx = event.currentTarget.getAttribute("data-id");
            var copyTextarea = document.querySelector(".copy-orderlist-" + idx);
            this.copy_tel = item.tel;

            // this.copy_orderlist = item.tel;

            copyTextarea.focus();
            copyTextarea.select();

            try {
                var successful = document.execCommand("copy");

                var msg = successful ? "successful" : "unsuccessful";
                console.log("Copying text command was " + msg);
                this.sheet2 = true;
            } catch (err) {
                console.log("Oops, unable to copy");
            }
        },
        fetchAllOrders() {
            let $vm = this;

            axios.post("/api/allOrders").then(function(response) {
                if (response.data.code == "401") {
                    $vm.$emit("send", "login");
                    $vm.$router.push("login");
                } else {
                    $vm.orders = response.data;
                    $vm.isloading = false;
                }
            });
        },
        newOrder() {
            this.editedIndex = -1;

            // if (this.editedIndex == -1) {
            var todaydate = new Date();
            todaydate = moment(todaydate).format("YYYY-MM-DD");

            this.editedItem.order_date = todaydate;
            this.dialog = true;
            // }
        },
        editItem(item) {
            this.editedIndex = this.orders.indexOf(item);
            this.editedItem = Object.assign({}, item);
            // console.log(this.editedItem);
            // console.log(this.editedItem.upload_doc);

            // this.editedItem.upload_doc_obj = "";

            // if (typeof this.editedItem.upload_doc != "object") {
            // this.current_doc = this.editedItem.upload_doc;
            // }
            this.dialog = true;
        },

        deleteItem(item) {
            this.editedIndex = this.orders.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.dialogDelete = true;
        },

        deleteItemConfirm() {
            let order_id = this.orders[this.editedIndex].id;
            let $vm = this;
            $vm.overlay = true;

            axios
                .post("/api/deleteOrder", { order_id })
                .then(function(response) {
                    console.log(response);
                    $vm.orders.splice($vm.editedIndex, 1);
                    $vm.overlay = false;
                    $vm.closeDelete();
                });
        },

        close() {
            this.dialog = false;
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem);
                this.editedIndex = -1;
            });
        },

        closeDelete() {
            this.dialogDelete = false;
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem);
                this.editedIndex = -1;
            });
        },

        save() {
            let order_code = this.editedItem.order_code;
            let order_type = this.editedItem.order_type;
            let order_app = this.editedItem.order_app;

            let tel = this.editedItem.tel;
            // alert(this.editedItem.order_date);
            this.editedItem.order_date = moment(
                this.editedItem.order_date
            ).format("yyyy-MM-DD");

            let order_date = this.editedItem.order_date;
            // alert(order_date);

            // this.editedItem.order_date;
            let order_detail = this.editedItem.order_detail;
            let order_id = this.editedItem.id;

            let $vm = this;
            let api_str = "";

            if (this.editedIndex > -1) {
                Object.assign(this.orders[this.editedIndex], this.editedItem);
                api_str = "editOrder";
                // order_id = this.editedItem.id;
            } else {
                api_str = "createOrder";
            }
            // alert(this.$refs.form.validate());
            if (this.$refs.form.validate()) {
                $vm.overlay = true;

                axios
                    .post("/api/" + api_str, {
                        order_id,
                        order_code,
                        order_type,
                        order_app,
                        tel,
                        order_date,
                        order_detail
                    })
                    .then(function(response) {
                        console.log(response);
                        $vm.overlay = false;

                        if ($vm.editedIndex == -1) {
                            $vm.editedItem.id = response.data.last_insert_id;
                            $vm.orders.push($vm.editedItem);

                            $vm.fetchAllOrders();
                        }

                        $vm.close();
                    });
                // }
            }
        }
    },
    created() {
        let $vm = this;
        axios.post("/api/adminUser").then(function(response) {
            if (response.data.code == "200") {
                // $vm.$emit("send", "home");
                // $vm.$router.push("home");
                $vm.username = response.data.username;
            }
        });
    }
};
</script>

<style></style>
