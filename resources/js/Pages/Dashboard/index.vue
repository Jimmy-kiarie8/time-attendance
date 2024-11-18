<template>
    <MainLayout title="Dashboard">
        <v-row>
            <template v-for="(item, index) in data" :key="index">
                <v-col cols="12" sm="3" style="padding: 3px;" v-if="index < 4">
                    <v-card class="mx-auto">
                        <v-card-item :title="item.label">
                            <template v-slot:subtitle>
                                <v-icon :icon="item.icon" size="18" :color="item.iconColor" class="me-1 pb-1"></v-icon>
                                {{ item.label }}
                            </template>
                        </v-card-item>

                        <v-card-text class="py-0">
                            <v-row align="center">
                                <v-col class="value-text" cols="6">
                                    {{ item.value }}
                                </v-col>

                                <v-col cols="6" class="text-right">
                                    <v-icon :color="item.iconColor" :icon="item.icon" size="88"></v-icon>
                                </v-col>
                            </v-row>
                        </v-card-text>

                    </v-card>
                </v-col>

            </template>
            </v-row>
        <v-row>
            <v-col cols="12" sm="6" style="padding: 3px;">
                <v-card class="mx-auto">
                    <barChart :chartData="dailyAttendance" />
                </v-card>
            </v-col>
            <v-col cols="12" sm="6" style="padding: 3px;">
                <v-card class="mx-auto">
                    <lineChart :chartData="departmentDistribution" />
                </v-card>
            </v-col>
            <v-col cols="12" sm="12" style="padding: 3px;">
                <v-card class="mx-auto">
                    <barChart :chartData="hourlyPattern" />
                </v-card>
            </v-col>

        </v-row>

    </MainLayout>
</template>

<script>
import MainLayout from '@/Layouts/MainLayout.vue';
import barChart from './bar-chart.vue'
import lineChart from './line-chart.vue'
import doughnutChart from './doughnut-chart.vue'
import { Link } from '@inertiajs/vue3';
export default {
    props: {
        dailyAttendance: Object,
        departmentDistribution: Object,
        deviceComparison: Object,
        hourlyPattern: Object,
        data: Object
    },

    components: {
        MainLayout, doughnutChart, lineChart, barChart, Link
    },
    data() {
        return {
            search: '',
            page: 1,
            itemsPerPage: 5
        }
    },
    methods: {
    },
}
</script>
<style scoped>
.v-col-sm-3 {
    padding: 10px;

}

.value-text {
    font-size: 30px !important;
}
</style>
