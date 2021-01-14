<template>
    <div>
        <v-app-bar app color="indigo" dark>
            <v-app-bar-nav-icon @click.stop="drawer = !drawer" />
            <v-toolbar-title>DJS ORDER SYSTEM</v-toolbar-title>
        </v-app-bar>
        <v-navigation-drawer v-model="drawer" app>
            <v-list dense nav>
                <v-list-item
                    v-for="item in items"
                    :key="item.title"
                    link
                    @click="clicked(item.slug)"
                >
                    <v-list-item-icon>
                        <v-icon>{{ item.icon }}</v-icon>
                    </v-list-item-icon>

                    <v-list-item-content>
                        <v-list-item-title> {{ item.title }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>
    </div>
</template>

<script>
export default {
    // props: {
    //     items: Array
    // },
    data: () => ({
        drawer: false,
        name: "Zubaer Haque",
        right: null,
        items: [
            { title: "Login", slug: "order-login", icon: "mdi-login" },

            {
                title: "Order Form Entry",
                slug: "order-form-entry",
                icon: "mdi-border-color"
            },
            {
                title: "Order List",
                slug: "order-list",
                icon: "mdi-format-list-bulleted-square"
            }
            // { title: "About", icon: "mdi-help-box" }
        ]
    }),
    methods: {
        clicked(slug) {
            // console.log(slug);
            this.drawer = false;
            this.$emit("send", slug);
            this.$router.push(slug);
        }
    }
};
</script>

<style></style>
