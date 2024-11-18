<template>
    <div>
        <br>
        <v-row v-for="section in settings" :key="section.title">
            <!-- Section Title and Description -->
            <v-col cols="12" sm="3">
                <h3>{{ section.title }}</h3>
                <p>{{ section.description }}</p>
            </v-col>

            <!-- Fields for this Section -->
            <v-col cols="12" sm="9">
                <v-row>
                    <!-- Loop through fields in the section -->
                    <v-col v-for="field in section.fields" :key="field.label" cols="12" sm="4">
                        <!-- Render input based on field type -->
                        <component :is="getComponentType(field.type)" v-model="formData[field.model]"
                            :label="field.label" :items="field.options || []" variant="outlined"
                            v-if="field.type !== 'switch'" density="compact" item-value="value"></component>
                        <v-switch v-model="formData[field.model]" :label="field.label" v-if="field.type === 'switch'"
                            color="success" inset></v-switch>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>

        <v-btn color="primary" @click="updateSettings" variant="tonal" :loading="loading">Update</v-btn>

        <v-snackbar v-model="snackbar" :color="snackbarColor">
            {{ snackbarText }}
        </v-snackbar>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';


const props = defineProps({
    formData: Object
});


const snackbarText = ref('');
const snackbarColor = ref('success');
const snackbar = ref(false);
const loading = ref(false);

// Form data, where keys are the model fields
// const formData = ref({
//     currency: 'KES',
//     dateFormat: 'MM/DD/YYYY',
//     timeZone: 'EAT',
//     language: 'English',
//     defaultInterestRate: 0,
//     loanDuration: '12 months',
//     repaymentFrequency: 'Monthly',
//     latePaymentPenalties: 0,
//     automaticRepaymentProcessing: false,
//     partialPaymentAllowance: false
// });

// Loaded settings from JSON file
const settings = ref([]);

// Function to get the appropriate component type
const getComponentType = (type) => {
    switch (type) {
        case 'text':
        case 'number':
        case 'date':
            return 'v-text-field';
        case 'select':
            return 'v-select';
        case 'switch':
            return 'v-switch';
        default:
            return 'v-text-field';
    }
};

const updateSettings = async () => {

    loading.value = true
    try {
        const response = await axios.post(`/settings`, props.formData);

        console.log(response);
        loading.value = false

        showSnackbar(response.data.message, 'success');
    } catch (error) {
        loading.value = false
        console.error('Error uploading file:', error);
        showSnackbar('Failed to update avatar. Please try again.', 'error');
    }
}


function showSnackbar(text, color) {
    snackbarText.value = text;
    snackbarColor.value = color;
    snackbar.value = true;
}

// Load settings from a JSON file
onMounted(async () => {
    const response = await axios.get('/data/settings.json');
    settings.value = response.data;
});
</script>

<style scoped>
/* Optional styling */
</style>
