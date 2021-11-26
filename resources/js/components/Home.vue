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
                                :search="search"
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
                                                class="col-lg-7 col-md-7 col-sm-12 col-12 "
                                            >
                                                <h5 class="d-inline-block">
                                                    {{ page_title }}
                                                </h5>
                                                <v-divider
                                                    class="mx-2"
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
                                                <v-text-field
                                                    class="d-inline-block search-text-field"
                                                    v-model="search"
                                                    append-icon="mdi-magnify"
                                                    label="Search Order"
                                                    single-line
                                                    hide-details
                                                ></v-text-field>
                                            </div>
                                            <!-- <v-spacer></v-spacer> -->

                                            <!-- <template
                                            v-slot:activator="{ on, attrs }"
                                        > -->

                                            <div
                                                class="col-lg-5 col-md-5 col-sm-12 col-12 text-right"
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
                                                            label="Order App"
                                                            outlined
                                                        ></v-select>

                                                        <div
                                                            class="datepicker-label"
                                                        >
                                                            Order Date
                                                        </div>
                                                        <Datepicker
                                                            type="date"
                                                            class="datepicker mb-5"
                                                            format="yyyy-MM-dd"
                                                            v-model="
                                                                editedItem.order_date
                                                            "
                                                            placeholder="Order Date(yyyy-MM-dd)"
                                                        ></Datepicker>

                                                        <v-text-field
                                                            v-model="
                                                                editedItem.order_code
                                                            "
                                                            label="Order Code"
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
                                                            label="Order Type"
                                                            outlined
                                                        ></v-select>

                                                        <v-textarea
                                                            :rules="[
                                                                rules.required
                                                            ]"
                                                            v-model="
                                                                editedItem.order_detail
                                                            "
                                                            label="Order Detail"
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
                                                'Order Code' +
                                                    '\n' +
                                                    item.order_code +
                                                    '\n\n' +
                                                    'Tel' +
                                                    '\n' +
                                                    item.tel +
                                                    '\n\n' +
                                                    'Order Detail' +
                                                    '\n' +
                                                    item.order_detail +
                                                    '\n\n' +
                                                    'Order Date' +
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
        isloading: true,
        dialog: false,
        dialogDelete: false,
        headers: [
            { text: "ID", value: "id" },
            { text: "Order App", value: "order_app" },
            { text: "Order Date", value: "order_date" },
            { text: "Order Code", value: "order_code" },
            { text: "Order Type", value: "order_type" },
            { text: "Order Detail", value: "order_detail" },
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
