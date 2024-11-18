<template>
    <v-card class="mx-auto" variant="flat">
        <v-row>
            <v-col v-for="(item, index) in filterData" :key="index" cols="12" sm="2">
                <v-autocomplete clearable chips :label="item.label" v-if="item.type == 'select'" :items="item.items"
                    variant="outlined" item-title="label" item-value="value" v-model="item.value"
                    :multiple="item.multiple" return-object density="compact"></v-autocomplete>
                <v-text-field clearable :label="item.label" variant="outlined" v-model="item.value"
                    v-if="item.type == 'date'" type="date" density="compact"></v-text-field>
            </v-col>
            <v-col>
                <!-- <v-btn prepend-icon="mdi-magnify" variant="outlined" @click="filter">Filter</v-btn>


                <v-btn icon color="primary" variant="tonal" @click="downloadReport('excle')">
                    <v-icon>mdi-file-excel-outline</v-icon>
                </v-btn>
                <v-btn icon color="primary" variant="tonal" @click="downloadReport('pdf')">
                    <v-icon>mdi-file-pdf-box</v-icon>
                </v-btn> -->

                <v-btn-group divided>
                    <v-btn color="primary" icon="mdi-magnify" @click="filter"></v-btn>
                    <v-btn color="primary" icon="mdi-file-excel-outline" @click="downloadReport('excle')"
                        v-if="modelRoute === 'loans'"></v-btn>
                    <v-btn color="primary" icon="mdi-file-pdf-box" @click="downloadReport('pdf')"
                        v-if="modelRoute === 'loans'"></v-btn>
                </v-btn-group>


            </v-col>
        </v-row>

    </v-card>
</template>

<script>
export default {
    props: {
        filterRoute: String,
        modelRoute: String,
        filterData: Object,
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


        filter() {
            this.loading = true;
            let form = {}; // Change from [] to {}

            this.filterData.forEach(item => {
                form[item.model] = item.value; // Now you're working with an object
            });

            this.$emit('load', true);

            // Perform your axios.post with the transformed data
            axios.post(`/${this.filterRoute}`, form).then((res) => {
                console.log(res);
                this.loading = false;
                this.data = res.data;

                this.$emit('filter', res.data);
                this.$emit('load', false);

                // Handle the response
            }).catch((error) => {
                this.loading = false;
                this.$emit('load', false);
                // Handle the error
            });
        },

        refresh() {
            this.$emit('refresh');
        },

        async downloadReport(filetype) {
            this.loading = true;
            try {

                // Transform the form_data array into a single object
                const transformedData = this.filterData.reduce((acc, item) => {
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

                transformedData['filetype'] = filetype

                const response = await axios.post(`/download-export`, transformedData, {
                    responseType: 'blob'
                });

                // const filetype = 'excle'

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
    },

};
</script>

<style scoped>
.v-card {
    border-radius: 0 !important;
}
</style>
