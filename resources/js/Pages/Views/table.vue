<template>
    <div>

        <v-skeleton-loader type="table" v-if="loading"></v-skeleton-loader>

        <v-data-table :headers="headers" :items="tableData.data" :sort-by="[{ key: 'punch_time', order: 'desc' }]"
            class="elevation-2 sticky-table" :search="search" :loading="loading"
            :show-select="modelRoute === 'employees'" v-model="selected" v-else>
            <template v-slot:top>
                <v-text-field v-model="search" append-icon="mdi-magnify" label="Search" single-line hide-details
                    variant="outlined" density="compact"></v-text-field>

                <div v-if="selected.length > 0">


                    <v-tooltip location="top">
                        <template v-slot:activator="{ props }">
                            <v-btn @click="syncEmployees" icon v-bind="props">
                                <v-icon color="error">
                                    mdi-cancel
                                </v-icon>
                            </v-btn>
                        </template>
                        <span>Deactivate</span>
                    </v-tooltip>
                </div>

            </template>

            <template v-slot:item.actions="{ item }">
                <div class="actions">
                    <!-- <v-tooltip v-for="(button, index) in actions" :key="index" location="bottom">
                        <template v-slot:activator="{ props }">
                            <v-btn icon v-bind="props" @click="runAction(item, button)" variant="text"
                                :color="button.color">
                                <v-icon>{{ button.icon }}</v-icon>
                            </v-btn>
                        </template>
                        <span>{{ button.action_name }}</span>
                    </v-tooltip> -->
                    <v-tooltip location="bottom">
                        <template v-slot:activator="{ props }">
                            <v-btn icon v-bind="props" variant="text"
                                color="primary" @click="openEdit(item)">
                                <v-icon>mdi-pen</v-icon>
                            </v-btn>
                        </template>
                        <span>Edit</span>
                    </v-tooltip>
                </div>
            </template>

            <template v-slot:item.checkin_status="{ value }">
                <v-chip :color="getColor(value)" :prepend-icon="getIcon(value)">{{ value }}</v-chip>
            </template>

            <template v-slot:item.checkout_status="{ value }">
                <v-chip :color="getColor(value)" :prepend-icon="getIcon(value)">{{ value }}</v-chip>
            </template>


            <template v-slot:item.photo="{ value }">
                <v-avatar icon="mdi-account-circle" v-if="!value"></v-avatar>
                <v-avatar :image="'http://192.168.1.2:91'+value" v-else></v-avatar>
            </template>

            <template v-slot:item.status="{ value }">
                <v-chip :color="getColor(value)" :prepend-icon="getIcon(value)">{{ value }}</v-chip>
            </template>
            <template v-slot:item.active="{ value }">
                <v-icon color="success" size="x-small" v-if="value">mdi-circle</v-icon>
                <v-icon color="red" size="x-small" v-else>mdi-circle</v-icon>
            </template>
        </v-data-table>



        <componentEdit ref="editModal" :modalWidth="modalWidth" :modelRoute="modelRoute" :title="title"
            @refresh="refresh" />

        <v-snackbar v-model="snackbar" :color="color">
            {{ text }}
        </v-snackbar>


        <v-dialog v-model="dialogConfirm" max-width="400px">
            <v-card>
                <v-card-title class="text-h5">Warning!</v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    {{ warning_text }}?
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-btn color="red-darken-1" variant="tonal" @click="dialogConfirm = false">
                        <v-icon>mdi-close-box</v-icon>Cancel
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" variant="tonal" @click="actionConfirm(current_data, current_route)">
                        <v-icon>mdi-checkbox-marked</v-icon>OK
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>

import componentEdit from './edit.vue';
import axios from 'axios';

export default {
    components: {
        componentEdit
    },
    props: {
        tableData: Object,
        formData: Object,
        headers: Object,
        modelRoute: String,
        title: String,
        loading: Boolean,
        upload: Boolean,
        canCreate: Boolean,
        actions: Object,
        modalWidth: Number
    },
    data() {
        return {
            search: '',
            page: 1,
            sortBy: [{ key: 'reference', order: 'desc' }],
            // loading: false,
            dialogDelete: false,
            selected: [],
            itemsPerPage: 5,
            editedIndex: -1,
            editedItem: {},
            dialogConfirm: false,
            snackbar: false,
            text: 'Updated',
            color: 'black',
            current_data: null,
            current_route: null,
            warning_text: "Are you sure you want to delete this item"
        }
    },
    methods: {
        reverse(data) {
            this.dialogConfirm = true
            this.current_data = data
            this.current_route = `reverse/${data.id}`
            this.warning_text = `Are you sure you want to reverse`
            action_run(data, route)
        },

        shouldShowButton(item, button) {
            if (!button.show) return true;
            if (Array.isArray(button.show.value)) {
                return button.show.value.includes(item[button.show.label]);
            }
            return button.show.value === item[button.show.label];
        },
        getIcon(status) {
            switch (status) {
                case "On time":
                    return "mdi-check-circle";
                case "Late":
                case "Early":
                    return "mdi-cancel";
                default:
                    return "mdi-information";
            }
        },
        getColor(status) {
            switch (status) {
                case "Late":
                case "Early":

                    return "red";
                case "On time":
                    return "success";
                case "In":
                    return "Info";

                case "Out":
                    return "secondary";
                default:
                    return "";
            }
        },

        valueInArray(data, item) {
            item.some(function (value) {
                console.log(data, value);
                console.log(value === data);
                return value === data
            });

        },
        async refresh() {
            this.$emit('refresh', false);

        },
        runAction(data, action) {

            if (action.action_name == 'Edit') {
                this.openEdit(data)
            } else if (action.action_name == 'Delete') {
                this.deleteItem(data)
            } else if (action.action_name == 'View Loan') {
                this.openShow(data)
            } else if (action.action_name == 'Documents') {
                this.upenDocument(data)
            } else if (action.action_name == 'Logo') {
                this.uploadImage(data)
            } else if (action.action_name == 'Password') {
                this.passwordReset(data, action.route)
            } else if (action.action_name == 'Repay Loan') {
                this.openPayment(data, action.route)
            } else if (action.action_name == 'Reschedule') {
                this.rescheduleLoan(data, action.route)
            } else if (action.action_name == 'View Loan') {
                this.openLoan(data, action.route)
            } else if (action.action_name == 'Approve' || action.action_name == 'Reject' || action.action_name == 'Disburse') {
                this.dialogConfirm = true
                this.current_data = data
                this.current_route = action.route
                this.warning_text = `Are you sure you want to ${action.action_name}`
            } else if (action.action_name == 'Open File') {
                window.open(data.path, '_blank');
            } else {
                this.action_run(data, action.route)
            }

        },
        async action_run(data, route) {
            this.$props.loading = true;
            this.dialogConfirm = false

            try {
                const response = await axios.post(`/${route}`, data);
                console.log("🚀 ~ dispatch ~ response:", response)
                this.refresh()

                this.snackbar = true
                this.color = 'success'
                this.text = (response.data.message) ?? 'Updated';
            } catch (error) {
                console.log("🚀 ~ axios.get ~ error:", error);
                this.snackbar = true
                this.color = 'error'
                this.text = 'Something went wrong!'
            } finally {
                this.$props.loading = false;
            }
        },
        goTo(route) {
            router.visit(route)
        },
        openEdit(data) {
            this.$refs.editModal.show(data)
        },
        openShow(data) {
            this.$refs.showModal.show(data)
        },
        upenDocument(data) {
            this.$refs.documentModal.show(data)
        },
        openPayment(data, route) {
            this.$refs.paymentModal.show(data, route)
        },
        openLoan(data, route) {
            this.$refs.showModal.show(data, route)
        },
        rescheduleLoan(data, route) {
            this.$refs.rescheduleModal.show(data, route)
        },
        deleteItem(item) {

            this.editedIndex = this.data.data.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true

        },
        deleteItemConfirm() {
            axios.delete(`${this.modelRoute}/${this.editedItem.id}`).then((res) => {
                console.log("🚀 ~ axios.delete ~ res:", res)
                this.dialogDelete = true
                this.data.data.splice(this.editedIndex, 1)
                this.close()
            }).catch((error) => {
                console.log("🚀 ~ axios.delete ~ error:", error)

            })


        },
        actionConfirm(data, route) {
            this.action_run(data, route)

        },
        close() {
            this.dialogDelete = false
        },

        uploadItem() {
            this.$refs.uploadModal.show()
        },


        editLoan(loan, type) {
            this.$refs.editLoanModal.show(loan, type)
        },
        syncEmployees() {
            // this.$props.loading = true;
            axios.post('delete-bio', this.selected).then((res) => {
                console.log(res);
                // this.$props.loading = true;

            }).catch((error) => {
                console.log(error);
                // this.$props.loading = true;

            })
        }
    },



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
}
</style>
