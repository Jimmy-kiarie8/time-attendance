<template>
    <MainLayout title="Reports">
        <v-card class="mx-auto" :loading="loading">
            <v-card-text>
                <v-row>
                    <v-col v-for="(item, index) in form_data" :key="index" cols="12" sm="4">
                        <v-autocomplete clearable chips :label="item.label" v-if="item.type == 'select'" :items="item.items"
                            variant="outlined" item-title="label" item-value="value" v-model="item.value"
                            :multiple="item.multiple" return-object density="compact"></v-autocomplete>
                        <v-text-field clearable :label="item.label" variant="outlined" v-model="item.value"
                            density="compact" v-if="item.type == 'date'" type="date"></v-text-field>
                    </v-col>
                    <v-col>
                    </v-col>
                </v-row>
                <div style="text-align: center;">

                    <v-btn prepend-icon="mdi-magnify" variant="tonal" @click="generate()">
                        Search
                    </v-btn>
                    <v-btn prepend-icon="mdi-file-excel" variant="tonal" @click="downloadReport('excel')"
                        style="margin-left: 6px;">
                        Excel
                    </v-btn>
                    <v-btn prepend-icon="mdi-file-pdf-box" variant="tonal" @click="downloadReport('pdf')"
                        style="margin-left: 6px;">
                        Pdf
                    </v-btn>
                </div>

            </v-card-text>
        </v-card>
        <br>
        <div class="overflow-hidden shadow-xl sm:rounded-lg" v-if="report_data">
            <v-skeleton-loader type="table" v-if="loading"></v-skeleton-loader>

            <v-data-table :headers="headers" :items="report_data.data"
                :sort-by="[{ key: 'product_name', order: 'asc' }]" class="elevation-2" :search="search" v-else>
                <template v-slot:item.description="{ value }">
                    <p id="tooltip">
                        {{ value }}
                        <v-tooltip activator="parent" location="top">{{ value }}</v-tooltip>
                    </p>
                </template>
                <template v-slot:item.short_description="{ value }">
                    <p id="tooltip">
                        {{ value }}
                        <v-tooltip activator="parent" location="top">{{ value }}</v-tooltip>
                    </p>
                </template>

                <template v-slot:item.paid="{ value }">
                    <v-icon color="success" size="x-small" v-if="value">mdi-circle</v-icon>
                    <v-icon color="red" size="x-small" v-else>mdi-circle</v-icon>
                </template>
                <template v-slot:item.notes="{ value }">
                    <p id="tooltip">
                        {{ value }}
                        <v-tooltip activator="parent" location="top">{{ value }}</v-tooltip>
                    </p>
                </template>
                <template v-slot:item.customer_notes="{ value }">
                    <p id="tooltip">
                        {{ value }}
                        <v-tooltip activator="parent" location="top">{{ value }}</v-tooltip>
                    </p>
                </template>
                <template v-slot:item.client_address="{ value }">
                    <p id="tooltip">
                        {{ value }}
                        <v-tooltip activator="parent" location="top">{{ value }}</v-tooltip>
                    </p>
                </template>
            </v-data-table>
        </div>
    </MainLayout>
</template>

<script>
import MainLayout from "@/Layouts/MainLayout.vue";
export default {
    props: {
        reports: Object,
        locations: Object,
        form_data: Object,
    },
    components: {
        MainLayout,
    },
    data() {
        return {
            report_data: [],
            headers: [],
            search: "",
            page: 1,
            loading: false,
            itemsPerPage: 5,
            statuses: [
                "Scheduled",
                "Cancelled",
                "Delivered",
                "Returned",
                "Dispatched",
            ],
        };
    },
    methods: {
        statusUpdate(data) {
            this.$refs.statusModal.show(data);
        },
        updateLocation(data) {
            this.$refs.locationModal.show(data);
        },

        getIcon(deliveryStatus) {
            switch (deliveryStatus) {
                case "delivered":
                    return "mdi-check-circle";
                case "cancelled":
                    return "mdi-cancel";
                case "returned":
                    return "mdi-undo";
                case "Scheduled":
                    return "mdi-clock";
                case "Dispatched":
                    return "mdi-send";
                default:
                    return "mdi-information";
            }
        },
        getColor(deliveryStatus) {
            switch (deliveryStatus) {
                case "delivered":
                    return "success";
                case "cancelled":
                    return "error";
                case "returned":
                    return "error";
                case "Scheduled":
                    return "primary";
                case "Dispatched":
                    return "warning";
                default:
                    return "";
            }
        },
        async downloadReport1(filetype) {
            this.loading = true
            try {
                const transformedData = this.form_data.reduce((acc, item) => {
                    // Use the model as the key and assign the value
                    acc[item.model] = {
                        label: item.label,
                        value: item.value
                    };
                    return acc;
                }, {});

                // Make a POST request to your Laravel backend to initiate file download
                const response = await axios.post(`/admin/reports/download?filetype=${filetype}`, transformedData, {
                    responseType: 'blob'  // Set responseType to blob for downloading files
                });

                // return response;

                // Create a Blob from the file stream
                const blob = new Blob([response.data], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });

                // Create a link element to trigger the download
                const url = window.URL.createObjectURL(blob);
                const link = document.createElement('a');
                link.href = url;

                if (filetype === 'pdf') {
                    link.setAttribute('download', `Report_${new Date().toISOString()}.pdf`);
                } else {
                    link.setAttribute('download', `Report_${new Date().toISOString()}.xlsx`);
                }
                document.body.appendChild(link);
                link.click();

                // Clean up
                document.body.removeChild(link);
                window.URL.revokeObjectURL(url);
                this.loading = false
            } catch (error) {
                this.loading = false
                console.error('Error downloading report:', error);
                // Handle error if needed
            }
        },

        async downloadReport(filetype) {
            this.loading = true;
            try {

            // Transform the form_data array into a single object
            const transformedData = this.form_data.reduce((acc, item) => {
                // Handle cases where value is an object, array, or null
                if (Array.isArray(item.value)) {
                    // If it's an array, map it to extract the value of each object in the array
                    acc[item.model] = item.value.map(val => val.value);
                } else if (item.value && typeof item.value === 'object') {
                    // If it's an object, take its 'value' property
                    acc[item.model] = item.value.value;
                } else {
                    // Otherwise, just take the value directly (for null or primitive values)
                    acc[item.model] = item.value;
                }

                return acc;
            }, {});

                const response = await axios.post(`/report-download?filetype=${filetype}`, transformedData, {
                    responseType: 'blob'
                });
                // return response;

                const blob = new Blob([response.data], { type: filetype === 'pdf' ? 'application/pdf' : 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
                const url = window.URL.createObjectURL(blob);

                if (filetype === 'pdf') {
                    // Open PDF in a new window for preview
                    window.open(url, '_blank');
                } else {
                    // Handle Excel download
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', `Report_${new Date().toISOString()}.xlsx`);
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                }

                window.URL.revokeObjectURL(url);
                this.loading = false;
            } catch (error) {
                this.loading = false;
                console.error('Error downloading report:', error);
            }
        },

        generate() {
            this.loading = true;

            // Transform the form_data array into a single object
            const transformedData = this.form_data.reduce((acc, item) => {
                // Handle cases where value is an object, array, or null
                if (Array.isArray(item.value)) {
                    // If it's an array, map it to extract the value of each object in the array
                    acc[item.model] = item.value.map(val => val.value);
                } else if (item.value && typeof item.value === 'object') {
                    // If it's an object, take its 'value' property
                    acc[item.model] = item.value.value;
                } else {
                    // Otherwise, just take the value directly (for null or primitive values)
                    acc[item.model] = item.value;
                }

                return acc;
            }, {});

            // Now you have the transformed data in the desired format
            console.log(transformedData);

            // Perform your axios.post with the transformed data
            axios.post('/report', transformedData)
                .then((res) => {
                    this.loading = false;
                    this.headers = res.data.headers;
                    this.report_data = res.data;
                    // Handle the response
                })
                .catch((error) => {
                    this.loading = false;
                    // Handle the error
                });
        }


    },

    computed: {
        pageCount() {
            return Math.ceil(this.reports.data.length / this.itemsPerPage);
        },
    },
};
</script>

<style>
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

.v-col {
    margin-left: 10px !important;
}
</style>
