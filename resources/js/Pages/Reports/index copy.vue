<template>
    <MainLayout title="Order Management">
        <v-card>

            <v-row>
                <v-col cols="12" sm="2">
                    <v-select clearable chips label="Report" :items="reports" variant="outlined"  item-title="label" item-value="value" v-model="form.report" density="compact"></v-select>
                </v-col>
                <v-col cols="12" sm="2">
                    <v-select clearable chips label="Borrowers" :items="clients" variant="outlined" item-title="name" item-value="id" v-model="form.client_id" density="compact"></v-select>
                </v-col>
                <v-col cols="12" sm="2">
                    <v-select clearable chips label="Branches" :items="branches" variant="outlined" item-title="name" item-value="id" v-model="form.client_id" density="compact"></v-select>
                </v-col>
                <v-col cols="12" sm="2">
                    <v-select clearable chips label="Loan Officer" :items="officers" variant="outlined" item-title="name" item-value="id" v-model="form.client_id" density="compact"></v-select>
                </v-col>
                <v-col cols="12" sm="2">
                    <v-select clearable chips label="Loan Type" :items="loan_type" variant="outlined" item-title="name" item-value="id" v-model="form.client_id" density="compact"></v-select>
                </v-col>
                <v-col cols="12" sm="2">
                    <v-select clearable chips label="Report Type Type" :items="report_type" variant="outlined" item-title="name" item-value="id" v-model="form.client_id" density="compact"></v-select>
                </v-col>
                <v-col cols="12" sm="2">
                    <v-text-field clearable v-model="form.start_date" label="Start Date" variant="outlined" type="date" density="compact"></v-text-field>
                </v-col>
                <v-col cols="12" sm="2">
                    <v-text-field clearable v-model="form.end_date" label="End Date" variant="outlined" type="date" density="compact"></v-text-field>
                </v-col>
                <v-col cols="12" sm="1">
                    <v-btn color="primary" @click="getReport">Filer</v-btn>
                </v-col>
            </v-row>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <v-data-table :headers="headers" :items="data.data" :sort-by="[{ key: 'product_name', order: 'asc' }]" class="elevation-2" :search="search">
                    <template v-slot:top>
                    <v-toolbar flat>
                        <v-toolbar-title>Reports</v-toolbar-title>
                        <v-divider class="mx-4" inset vertical></v-divider>
                        <v-spacer></v-spacer>

                    </v-toolbar>
                        <v-text-field v-model="search" append-icon="mdi-magnify" label="Search" single-line hide-details></v-text-field>
                    </template>
                </v-data-table>
            </div>
        </v-card>
    </MainLayout>

</template>

<script>
import MainLayout from '@/Layouts/MainLayout.vue';
import axios from 'axios';
export default {
        props: {
            clients: Object,
            branches: Object,
            loan_type: Object,
            officers: Object,
        },
    components: {
        MainLayout
    },
    data () {
      return {
        form: {
            start_date: null,
            end_date: null,
            agent_id: null,
            report: null
        },
        search: '',
        page: 1,
        itemsPerPage: 5,
        data: [],
        headers: [],
        report_type: ["Summary", "Detailed"],
        reports: [
            {
                label: 'Loan Book',
                value: 'LoanBook'
            },
            {
                label: 'Loans Listing',
                value: 'LoanListing'
            },
            {
                label: 'Loans Analysis',
                value: 'LoanAnalysis'
            },
            {
                label: 'Repayments',
                value: 'Repayments'
            },
            {
                label: 'Installments Failing Due',
                value: 'InstallmentsFailingDue'
            },
            {
                label: 'Installments In Arrears',
                value: 'InstallmentsInArrears'
            },
            {
                label: 'Days Collections',
                value: 'DaysCollections'
            },
            {
                label: 'Disbursements',
                value: 'Disbursements'
            },
            {
                label: 'Processing Fees',
                value: 'Fees'
            },
            {
                label: 'Missed Collections',
                value: 'MissedCollections'
            },
            {
                label: 'Portfolio At Risk',
                value: 'PortfolioAtRisk'
            },
            {
                label: 'Collateral Register',
                value: 'CollateralRegister'
            },
            {
                label: 'Collection Sheets',
                value: 'CollectionSheets'
            },
        ]
      }
    },
    methods: {
        getReport() {
            if (!this.form.report) {
                return;
            }
            axios.post(this.form.report, this.form).then((res) => {
                console.log("🚀 ~ file: index.vue:58 ~ axios.get ~ res:", res.data.headers)
                this.data = res.data.data
                this.headers = res.data.headers

            })
        }
    },

    computed: {
      pageCount () {
        return Math.ceil(this.data.data.length / this.itemsPerPage)
      },
    },
  }
</script>


<style scoped>
#tooltip {
    font-style: inherit;
    font-weight: inherit;
    white-space: nowrap;
    text-overflow: ellipsis;
    max-width: 180px;
    overflow: hidden;
    display: block;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
}

.v-card--variant-elevated {
    padding: 30px
}
</style>
