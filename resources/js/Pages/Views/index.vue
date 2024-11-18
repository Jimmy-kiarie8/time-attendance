<template>
    <MainLayout :title="title" :rail="false" :modelRoute="modelRoute" ref="snackBarModal">
        <v-toolbar color="transparent">

            <v-toolbar-title>
                <h2 color="primary">{{ title }} Management <v-icon icon="mdi-shimmer" size="30"></v-icon></h2>


            </v-toolbar-title>

            <v-spacer></v-spacer>
            <v-btn prepend-icon="mdi-plus" elevated variant="outlined" @click="openCreate" color="info"
                v-if="canCreate">
                Create {{ title }}
            </v-btn>

            <v-tooltip location="bottom">
                    <template v-slot:activator="{ props }">
                        <v-btn icon v-bind="props" @click="refresh()" variant="text" color="primary">
                            <v-icon>
                                mdi-refresh
                            </v-icon>
                        </v-btn>
                    </template>
                    <span>Refresh</span>
                </v-tooltip>
            <div style="width: 10px;"></div>
            <v-btn prepend-icon="mdi-upload" variant="outlined" @click="uploadItem" color="info" v-if="upload">
                Upload
            </v-btn>
        </v-toolbar>

        <v-divider></v-divider>
        <br>

        <div class="overflow-hidden shadow-xl sm:rounded-lg">
            <div v-if="canFilter">
                <componentFilter ref="filterRef" :filterData="filterData" :filterRoute="filterRoute"
                    :modelRoute="modelRoute" @filter="handleFilter" @load="handleLoading" @refresh="refresh" />

                <!-- <v-sheet color="primary" elevation="3" rounded="lg" v-if="canFilterTab">
                    <v-tabs v-model="tab" :items="tabs" align-tabs="center" color="white" height="60"
                        slider-color="#f78166" @update:modelValue="filterLoans()">
                        <template v-slot:tab="{ item }">
                            <v-tab :prepend-icon="item.icon" :text="item.text" :value="item.value"
                                class="text-none"></v-tab>
                        </template>

                    </v-tabs>
                </v-sheet> -->
                <v-divider></v-divider>
            </div>

            <v-card>


                <!-- <v-skeleton-loader type="table" v-if="loading"></v-skeleton-loader> -->

                <!-- Table -->


                <componentTable :canCreate="canCreate" :formData="formData" :headers="headers" :modelRoute="modelRoute"
                    :title="title" :upload="upload" :actions="actions" :modalWidth="modalWidth" :tableData="tableData"
                    @refresh="refresh" :loading="loading" />
            </v-card>

        </div>
        <!-- <myShow ref="showModal" :modelRoute="modelRoute" /> -->


        <v-dialog v-model="dialogDelete" max-width="400px">
            <v-card>
                <v-card-title class="text-h5">Warning!</v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    Are you sure you want to delete this item?
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-btn color="red-darken-1" variant="tonal" @click="close">
                        <v-icon>mdi-close-box</v-icon>Cancel
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" variant="tonal" @click="deleteItemConfirm">
                        <v-icon>mdi-checkbox-marked</v-icon>OK
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <myUpload ref="uploadModal" :modelRoute="modelRoute" :title="title" @refresh="refresh" />
        <myCreate :modalWidth="modalWidth" ref="createModal" :formData="formData" :modelRoute="modelRoute"
            :title="title" @refresh="refresh" />
        <v-snackbar v-model="snackbar" :color="color">
            {{ text }}
        </v-snackbar>
    </MainLayout>
</template>

<script>
import MainLayout from '@/Layouts/MainLayout.vue';
import { router } from '@inertiajs/vue3'

import componentTable from './table.vue'
import myCreate from './create.vue'
import myUpload from './upload.vue';

import componentFilter from './filter.vue';
import axios from 'axios';
export default {
    props: {
        data: Object,
        formData: Object,
        headers: Object,
        modelRoute: String,
        title: String,
        upload: Boolean,
        filterData: Object,
        filterRoute: String,
        canFilter: Boolean,
        canCreate: Boolean,
        canFilterTab: Boolean,
        actions: Object,
        modalWidth: Number
    },
    components: {
        MainLayout, componentFilter, componentTable, myCreate, myUpload
    },
    data() {
        return {
            tableData: {},
            search: '',
            page: 1,
            loading: false,
            dialogDelete: false,
            itemsPerPage: 5,
            editedIndex: -1,
            editedItem: {},
            tab: "all",
            tabs: [
                {
                    icon: 'mdi-alpha-l-circle',
                    text: 'All',
                    value: 'all',
                },
                {
                    icon: 'mdi-book-open-page-variant',
                    text: 'Pending',
                    value: 'Pending',
                },
                {
                    icon: 'mdi-handshake-outline',
                    text: 'Approved',
                    value: 'Approved',
                },
                {
                    icon: 'mdi-checkbox-marked',
                    text: 'Active',
                    value: 'Active',
                },
                {
                    icon: 'mdi-close-circle',
                    text: 'Arrears',
                    value: 'Arrears',
                },
                {
                    icon: 'mdi-checkbox-multiple-outline',
                    text: 'Fully Paid',
                    value: 'Paid',
                },
                {
                    icon: 'mdi-format-overline',
                    text: 'Over Paid',
                    value: 'Over paid',
                },
                {
                    icon: 'mdi-cancel',
                    text: 'Rejected',
                    value: 'Rejected',
                },
                {
                    icon: 'mdi-pen-lock',
                    text: 'Write-offs',
                    value: 'Written Off',
                },
                {
                    icon: 'mdi-alarm',
                    text: 'Restructured',
                    value: 'Restructured',
                }
            ],
            snackbar: false,
            text: 'Updated',
            color: 'black',

        }
    },
    methods: {

        goTo(route) {
            router.visit(route)
        },
        close() {
            this.dialogDelete = false
        },

        openCreate() {
            this.$refs.createModal.show()
        },
        async refresh() {
            if (this.modelRoute === "loans") {
                this.filterLoans()
            } else {
                this.loading = true;

                try {
                    const response = await axios.get(`/${this.modelRoute}?axios=true`);
                    this.tableData = response.data
                } catch (error) {
                    this.loading = false;
                } finally {
                    this.loading = false;
                }

            }
        },
        uploadItem() {
            this.$refs.uploadModal.show()
        },
        async filterLoans() {
            this.loading = true;
            const data = {
                status: this.tab
            }

            try {
                const response = await axios.post(`/loan-filter`, data);
                console.log("🚀 ~ dispatch ~ response:", response)
                this.tableData = response.data

            } catch (error) {
                console.log("🚀 ~ axios.get ~ error:", error);
            } finally {
                this.loading = false;
            }
        },


        handleFilter(data) {
            this.tableData = data;
        },

        handleLoading(data) {
            this.loading = data;
        }
    },

    computed: {
        pageCount() {
            return Math.ceil(this.data.data.length / this.itemsPerPage)
        },

        // canEdit() {
        //     const permission = 'Edit ' + this.title;
        //     if (this.$page.props.auth && this.$page.props.auth.user) {
        //         const permissions = this.$page.props.auth.user.can;
        //         // return permissions
        //         return permissions[`${permission}`];
        //     }
        //     return false;
        // }
    },
    mounted() {
        this.tableData = this.data
    }
}
</script>

<style>
.v-btn--icon .v-icon {
    font-size: 18px !important;
}

.sticky-table {
    overflow-x: auto;
}

.actions {
    width: 180px;
    /* position: sticky; */
    /* left: 0; */
    /* z-index: 2; */
    /* Make sure it stays above other columns */
}

/* .v-theme--dark thead th:last-child,
.v-theme--dark tbody td:last-child {
    background: #272525;
    position: sticky;
    right: 0;
    z-index: 3;
}

.v-theme--light thead th:last-child,
.v-theme--light tbody td:last-child {
    background: #f0f0f0;
    position: sticky;
    right: 0;
    z-index: 3;
} */
</style>
