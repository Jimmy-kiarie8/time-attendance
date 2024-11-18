<template>
    <MainLayout :title="title" :modelRoute="modelRoute" :company="company" :rail="false" ref="snackBarModal">


        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <v-data-table :headers="headers" :items="table_data.data" :sort-by="[{ key: 'name', order: 'asc' }]"
                class="elevation-2" :search="search" :loading="loading">
                <template v-slot:top>
                    <v-toolbar flat>
                        <v-toolbar-title>{{ title }} Management</v-toolbar-title>
                        <v-divider class="mx-4" inset vertical></v-divider>
                        <v-spacer></v-spacer>
                        <v-tooltip location="bottom">
                            <template v-slot:activator="{ props }">
                                <v-btn icon v-bind="props" @click="refresh()">
                                    <v-icon color="info">
                                        mdi-refresh
                                    </v-icon>
                                </v-btn>
                            </template>
                            <span>View geofences</span>
                        </v-tooltip>

                        <v-btn prepend-icon="mdi-plus-circle" variant="outlined" @click="openCreate('geocoder')"
                            color="info" v-if="modelRoute !== 'geofences'">
                            Add {{ title }}
                        </v-btn>


                        <v-btn prepend-icon="mdi-plus-circle" variant="tonal" @click="goTo('geocoder')" color="info"
                            rounded v-else>
                            Add {{ title }}
                        </v-btn>

                        <v-btn prepend-icon="mdi-upload" variant="outlined" @click="uploadItem" color="info"
                            v-if="upload">
                            Upload
                        </v-btn>
                    </v-toolbar>
                    <v-text-field v-model="search" append-icon="mdi-magnify" label="Search" single-line
                        hide-details></v-text-field>
                </template>
                <template v-slot:item.actions="{ item }">
                    <div class="actions">
                        <v-tooltip location="bottom" v-for="(button, index) in actions" :key="index">
                            <template v-slot:activator="{ props }">
                                <v-btn icon v-bind="props" @click="runAction(item, button)" variant="text"
                                    :color="button.color">
                                    <v-icon>
                                        {{ button.icon }}
                                    </v-icon>
                                </v-btn>
                            </template>
                            <span>{{ button.action_name }}</span>
                        </v-tooltip>
                    </div>
                </template>

                <template v-slot:item.availability_status="{ value }">
                    <v-icon color="success" size="x-small" v-if="value">mdi-circle</v-icon>
                    <v-icon color="red" size="x-small" v-else>mdi-circle</v-icon>
                </template>
                <template v-slot:item.active="{ value }">
                    <v-icon color="success" size="x-small" v-if="value">mdi-circle</v-icon>
                    <v-icon color="red" size="x-small" v-else>mdi-circle</v-icon>
                </template>
            </v-data-table>
        </div>
        <myEdit ref="editModal" :modelRoute="modelRoute" :title="title" />
        <myCreate ref="createModal" :title="title" :modelRoute="modelRoute" :permissions="permissions" />

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
                    <v-btn color="info" variant="tonal" @click="deleteItemConfirm">
                        <v-icon>mdi-checkbox-marked</v-icon>OK
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </MainLayout>
</template>

<script>
import MainLayout from '@/Layouts/MainLayout.vue';
import { router } from '@inertiajs/vue3'

import myCreate from './create.vue'
import myEdit from './edit.vue'
import axios from 'axios';
export default {
    props: {
        data: Object,
        permissions: Object,
        company: Object,
        headers: Object,
        actions: Object,
        modelRoute: String,
        title: String,
        upload: Boolean
    },
    components: {
        MainLayout, myCreate, myEdit
    },
    data() {
        return {
            search: '',
            page: 1,
            itemsPerPage: 5,
            table_data: {},
            loading: false,
            dialogDelete: false
        }
    },
    methods: {
        goTo(route) {
            router.visit(route)
        },
        refresh() {
            this.loading = true
            axios.get(`${this.modelRoute}?axios=${true}`).then((res) => {
                this.loading = false
                this.table_data = res.data

                console.log("🚀 ~ axios.get ~ res:", res)
            }).catch((error) => {
                this.loading = false
                console.log("🚀 ~ axios.get ~ error:", error)

            })
        },
        runAction(data, action) {
            console.log("🚀 ~ runAction ~ action:", action.action_name)
            if (action.action_name == 'Edit') {
                this.openEdit(data)
            } else if (action.action_name == 'Delete') {
                this.deleteItem(data)
            } else if (action.action_name == 'Logo') {
                this.uploadImage(data)
            } else {
                this.action_run(data, action.route)
            }
        },

        async action_run(data, route) {
            this.loading = true;

            try {
                const response = await axios.post(`/${route}`, data);
                console.log("🚀 ~ dispatch ~ response:", response)
            } catch (error) {
                console.log("🚀 ~ axios.get ~ error:", error);
            } finally {
                this.loading = false;
            }
        },


        uploadImage(data) {
            this.$refs.imageModal.show(data)
        },
        openEdit(data) {
            console.log("🚀 ~ openEdit ~ data:", data)
            this.$refs.editModal.show(data.id)
            // this.$emit('CallEvent', data)
        },
        openCreate() {
            this.$refs.createModal.show()
            // this.$emit('CallEvent', data)
        },
        geoFence(route) {
            router.visit(`/geofences/${route}`)
        },
        uploadItem() {
            this.$refs.uploadModal.show()
        },
        close() {
            this.dialogDelete = false
        },
        deleteItem(item) {
            console.log("🚀 ~ deleteItem ~ item:", item)
            this.editedIndex = this.data.data.indexOf(item)
            this.deleteId = item.id
            this.dialogDelete = true

        },
        deleteItemConfirm() {
            axios.delete(`${this.modelRoute}/${this.deleteId}`).then((res) => {
                console.log("🚀 ~ axios.delete ~ res:", res)
                this.dialogDelete = true
                this.data.data.splice(this.editedIndex, 1)
                this.close()
            }).catch((error) => {
                console.log("🚀 ~ axios.delete ~ error:", error)

            })


        },
    },

    computed: {
        pageCount() {
            return Math.ceil(this.data.data.length / this.itemsPerPage)
        },
    },

    mounted() {
        this.table_data = this.data
    }
}
</script>

<style>
.v-btn--icon .v-icon {
    font-size: 18px !important;
}

.actions {
    width: 200px;
}
</style>
