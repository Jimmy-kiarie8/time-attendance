<template>
    <v-row justify="center" v-if="dialog">
        <v-dialog v-model="dialog" transition="dialog-bottom-transition" fullscreen>
            <v-card>
                <v-toolbar>
                    <v-btn icon="mdi-close" @click="dialog = false"></v-btn>
                    <v-tabs v-model="tab">
                        <v-tab value="loan">Loan</v-tab>
                        <v-tab value="history">Comment&History</v-tab>
                    </v-tabs>
                </v-toolbar>

                <v-card-text>
                    <v-window v-model="tab">
                        <v-window-item value="loan">
                            <v-container v-if="formData">
                                <!-- Header Section -->
                                <v-row>
                                    <v-col cols="12">
                                        <v-card class="mb-4">
                                            <v-card-item>
                                                <div class="d-flex justify-space-between align-center">
                                                    <div>
                                                        <v-card-title class="text-h5">
                                                            Loan Reference: {{ formData.reference }}
                                                        </v-card-title>
                                                        <v-chip :color="getStatusColor(formData.status)" class="mt-2">
                                                            {{ formData.status }}
                                                        </v-chip>
                                                    </div>
                                                    <div class="text-right">
                                                        <div class="text-h6">Amount: Ksh {{ formData.amount }}</div>
                                                        <div class="text-subtitle-1">Balance: Ksh {{ formData.balance }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </v-card-item>
                                        </v-card>
                                    </v-col>
                                </v-row>

                                <!-- Main Content -->
                                <v-row>
                                    <!-- Client Information -->
                                    <v-col cols="12" md="6">
                                        <v-card>
                                            <v-card-title>Client Information</v-card-title>
                                            <v-card-text>
                                                <v-list>
                                                    <v-list-item color="primary" rounded="xl">
                                                        <template v-slot:prepend>
                                                            <v-icon>mdi-account-multiple</v-icon>
                                                        </template>

                                                        <v-list-item-title>Client Name</v-list-item-title>
                                                        <v-list-item-subtitle>{{ formData.client?.name
                                                            }}</v-list-item-subtitle>
                                                    </v-list-item>
                                                    <v-list-item color="primary" rounded="xl">
                                                        <template v-slot:prepend>
                                                            <v-icon>mdi-card-account-details</v-icon>
                                                        </template>

                                                        <v-list-item-title>ID Number</v-list-item-title>
                                                        <v-list-item-subtitle>{{ formData.id_no
                                                            }}</v-list-item-subtitle>
                                                    </v-list-item>
                                                    <v-list-item color="primary" rounded="xl">
                                                        <template v-slot:prepend>
                                                            <v-icon>mdi-source-branch-check</v-icon>
                                                        </template>

                                                        <v-list-item-title>Branch</v-list-item-title>
                                                        <v-list-item-subtitle>{{ formData.branch?.name
                                                            }}</v-list-item-subtitle>
                                                    </v-list-item>
                                                </v-list>

                                            </v-card-text>
                                        </v-card>

                                        <v-list>
                                            <v-list-subheader>Client Information</v-list-subheader>

                                            <v-list-item color="primary" rounded="xl">
                                                <template v-slot:prepend>
                                                    <v-icon>mdi-account-multiple</v-icon>
                                                </template>

                                                <v-list-item-title>Client Name</v-list-item-title>
                                                <v-list-item-subtitle>{{ formData.client?.name
                                                    }}</v-list-item-subtitle>
                                            </v-list-item>
                                        </v-list>
                                    </v-col>

                                    <!-- Loan Details -->
                                    <v-col cols="12" md="6">
                                        <v-card>
                                            <v-card-title>Loan Details</v-card-title>
                                            <v-card-text>
                                                <v-list>
                                                    <v-list-item>
                                                        <v-list-item-title>Loan Type</v-list-item-title>
                                                        <v-list-item-subtitle>{{ formData.loantype?.name
                                                            }}</v-list-item-subtitle>
                                                    </v-list-item>
                                                    <v-list-item>
                                                        <v-list-item-title>Interest Rate</v-list-item-title>
                                                        <v-list-item-subtitle>{{ formData.interest_rate
                                                            }}%</v-list-item-subtitle>
                                                    </v-list-item>
                                                    <v-list-item>
                                                        <v-list-item-title>Interest Type</v-list-item-title>
                                                        <v-list-item-subtitle>{{ formData.interest_type
                                                            }}</v-list-item-subtitle>
                                                    </v-list-item>
                                                    <v-list-item>
                                                        <v-list-item-title>Frequency</v-list-item-title>
                                                        <v-list-item-subtitle>{{ formData.frequency
                                                            }}</v-list-item-subtitle>
                                                    </v-list-item>
                                                </v-list>
                                            </v-card-text>
                                        </v-card>
                                    </v-col>

                                    <!-- Payment Information -->
                                    <v-col cols="12" md="6">
                                        <v-card>
                                            <v-card-title>Payment Information</v-card-title>
                                            <v-card-text>
                                                <v-list>
                                                    <v-list-item>
                                                        <v-list-item-title>Payment Per Month</v-list-item-title>
                                                        <v-list-item-subtitle>${{ formData.payment_per_installment
                                                            }}</v-list-item-subtitle>
                                                    </v-list-item>
                                                    <v-list-item>
                                                        <v-list-item-title>Installments</v-list-item-title>
                                                        <v-list-item-subtitle>{{ formData.installments
                                                            }}</v-list-item-subtitle>
                                                    </v-list-item>
                                                    <v-list-item>
                                                        <v-list-item-title>Processing Fee</v-list-item-title>
                                                        <v-list-item-subtitle>${{ formData.processing_fee
                                                            }}</v-list-item-subtitle>
                                                    </v-list-item>
                                                    <v-list-item>
                                                        <v-list-item-title>Due Date</v-list-item-title>
                                                        <v-list-item-subtitle>{{ formatDate(formData.due_date)
                                                            }}</v-list-item-subtitle>
                                                    </v-list-item>
                                                </v-list>
                                            </v-card-text>
                                        </v-card>
                                    </v-col>

                                    <!-- Dates and Status -->
                                    <v-col cols="12" md="6">
                                        <v-card>
                                            <v-card-title>Important Dates</v-card-title>
                                            <v-card-text>
                                                <v-list>
                                                    <v-list-item>
                                                        <v-list-item-title>Application Date</v-list-item-title>
                                                        <v-list-item-subtitle>{{ formatDate(formData.application_date)
                                                            }}</v-list-item-subtitle>
                                                    </v-list-item>
                                                    <v-list-item>
                                                        <v-list-item-title>Disbursed At</v-list-item-title>
                                                        <v-list-item-subtitle>{{ formatDate(formData.disbursed_at)
                                                            }}</v-list-item-subtitle>
                                                    </v-list-item>
                                                    <v-list-item>
                                                        <v-list-item-title>Last Payment</v-list-item-title>
                                                        <v-list-item-subtitle>{{ formatDate(formData.last_payment)
                                                            }}</v-list-item-subtitle>
                                                    </v-list-item>
                                                </v-list>
                                            </v-card-text>
                                        </v-card>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-window-item>

                        <v-window-item value="history">
                            <!-- History tab content here -->
                        </v-window-item>
                    </v-window>
                </v-card-text>
            </v-card>
        </v-dialog>

        <v-snackbar v-model="snackbar" :color="color">
            {{ text }}
        </v-snackbar>
    </v-row>
</template>

<script setup>
import { ref, reactive, watch, onMounted } from 'vue';
import axios from 'axios';

const props = defineProps({
    modelRoute: {
        type: String,
        required: true
    },
});

const dialog = ref(false);
const snackbar = ref(false);
const text = ref('Updated');
const color = ref('black');
const loading = ref(false);
const form = reactive({});
const formData = ref([]);
const tab = ref('loan');

function getStatusColor(status) {
    const statusColors = {
        'Rejected': 'error',
        'Approved': 'success',
        'Pending': 'warning',
        'Active': 'primary'
    };
    return statusColors[status] || 'grey';
}

function formatDate(date) {
    if (!date) return 'N/A';
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

async function fetchFormData(id) {
    try {
        const response = await axios.get(`/${props.modelRoute}/${id}`);
        formData.value = response.data;
        console.log('formData', formData.value);
    } catch (error) {
        console.error("Failed to fetch data:", error);
        snackbar.value = true;
        color.value = 'error';
        text.value = 'Failed to load data';
    }
}

function show(data) {
    console.log(data);
    dialog.value = true;
    fetchFormData(data.id);
}

function close() {
    dialog.value = false;
}

defineExpose({ show });
</script>
