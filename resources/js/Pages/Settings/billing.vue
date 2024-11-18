<template>
    <div>
        <h2 class="text-h6 mb-2">Payment Method</h2>
        <p class="text-caption mb-4">Update your billing details and address.</p>

        <v-divider></v-divider>
        <br>
        <v-row>
            <v-col cols="12" sm="3">
                <h3 class="text-subtitle-1 mb-2">Card Details</h3>
                <p class="text-caption mb-4">Update your billing details and address.</p>

                <v-btn prepend-icon="mdi-plus-circle" variant="tonal">
                    Add another card
                </v-btn>
            </v-col>
            <v-col cols="12" sm="8">
                <v-row>
                    <v-col cols="12" sm="6">

                        <v-text-field density="compact" variant="outlined" label="Card Number" v-model="cardNumber"
                            outlined dense prepend-inner-icon="mdi-credit-card"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field density="compact" variant="outlined" label="CVV" v-model="cardCVV" outlined dense
                            type="password"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field density="compact" variant="outlined" label="Name on your Card" v-model="cardName"
                            outlined dense></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field density="compact" variant="outlined" label="Expiry" v-model="cardExpiry" outlined
                            dense></v-text-field>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>



        <v-divider></v-divider>
        <br>

        <v-row>
            <v-col cols="12" sm="3">
                <h3 class="text-subtitle-1 mb-2">Contact email</h3>
                <p class="text-caption mb-4">Where should invoices be sent?</p>
            </v-col>

            <v-col cols="12" sm="3">
                <v-radio-group v-model="contactEmailOption">
                    <v-radio label="Send to the existing email" value="existing">
                        <template v-slot:label>
                            <div>
                                Send to the existing email
                                <div class="text-caption text-grey">mayad.ahmed@infobase.co</div>
                            </div>
                        </template>
                    </v-radio>
                    <v-radio label="Add another email address" value="new"></v-radio>
                </v-radio-group>
            </v-col>
        </v-row>

        <h3 class="text-subtitle-1 mt-6 mb-2">Billing History</h3>
        <p class="text-caption mb-4">See the transactions you made</p>

        <v-data-table :headers="headers" :items="billingHistory" :items-per-page="5" class="elevation-1">
            <template v-slot:item.status="{ item }">
                <v-chip :color="getStatusColor(item.status)" text-color="white" small>
                    {{ item.status }}
                </v-chip>
            </template>
            <template v-slot:item.actions="{ item }">
                <v-tooltip location="bottom">
                    <template v-slot:activator="{ props }">
                        <v-btn icon v-bind="props">
                            <v-icon color="primary">
                                mdi-eye
                            </v-icon>
                        </v-btn>
                    </template>
                    <span>View</span>
                </v-tooltip>
                <v-tooltip location="bottom">
                    <template v-slot:activator="{ props }">
                        <v-btn icon v-bind="props">
                            <v-icon color="secondary">
                                mdi-file-pdf-box
                            </v-icon>
                        </v-btn>
                    </template>
                    <span>Download Invoice</span>
                </v-tooltip>
            </template>
        </v-data-table>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const tab = ref('billings');
const cardName = ref('Mayad Ahmed');
const cardExpiry = ref('02 / 2028');
const cardNumber = ref('8269 9620 9292 2538');
const cardCVV = ref('');
const contactEmailOption = ref('existing');

const headers = [
    { title: 'Invoice', align: 'start', key: 'invoice' },
    { title: 'Date', key: 'date' },
    { title: 'Amount', key: 'amount' },
    { title: 'Status', key: 'status' },
    { title: 'Tracking & Address', key: 'tracking' },
    { title: 'Actions', key: 'actions', sortable: false }
];

const billingHistory = [
    {
        invoice: 'Account Sale',
        date: 'Apr 14, 2004',
        amount: '$3,050',
        status: 'Pending',
        tracking: 'LM580405575CN 313 Kent Road, Sunderland'
    },
    {
        invoice: 'Account Sale',
        date: 'Jun 24, 2008',
        amount: '$1,050',
        status: 'Cancelled',
        tracking: 'AZ938540353US 99 Grange Road, Peterborough'
    },
    {
        invoice: 'Netflix Subscription',
        date: 'Feb 28, 2004',
        amount: '$800',
        status: 'Refund',
        tracking: '3S331605904US 2 New Street, Harrogate'
    }
];

const getStatusColor = (status) => {
    switch (status) {
        case 'Pending':
            return 'warning';
        case 'Cancelled':
            return 'error';
        case 'Refund':
            return 'success';
        default:
            return 'grey';
    }
};

const viewDetails = (item) => {
    console.log('View details for:', item);
    // Implement view details logic here
};
</script>

<style scoped>
.billing-settings {
    max-width: 1000px;
    margin: 0 auto;
}
</style>
