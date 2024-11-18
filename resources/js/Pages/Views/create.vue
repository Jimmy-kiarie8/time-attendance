<template>
    <v-row justify="center">
        <v-dialog persistent v-model="dialog" :width="modalWidth">

            <v-divider></v-divider>
            <v-card>
                <v-card-title class="text-h5">
                    Create A {{ title }}
                </v-card-title>
                <v-card-text>
                    <v-card color="error" variant="tonal" v-if="errors">
                        <v-list density="compact">

                            <v-list-item v-for="(errors, field) in errors" :key="field" :value="field" color="error">


                                <v-list-item-title>
                                    <ul>
                                        <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
                                    </ul>

                                </v-list-item-title>
                            </v-list-item>
                        </v-list>
                    </v-card>
                    <v-divider></v-divider>
                    <my-form :formData="formData" v-model:form="form" :guarantors="guarantors" />
                </v-card-text>
                <v-card-actions>
                    <v-btn variant="outlined" color="red" @click="close">
                        <v-icon>mdi-checkbox-marked</v-icon> Close
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-btn variant="outlined" color="primary" @click="submit" :loading="loading">
                        <v-icon>mdi-plus-circle</v-icon>
                        Submit
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>


        <v-snackbar v-model="snackbar" :color="color">
            {{ text }}
        </v-snackbar>
    </v-row>
</template>

<script setup>
import { ref, reactive, watch, defineEmits } from 'vue';
import { useForm } from '@inertiajs/vue3';
import MyForm from '@/Components/FormComponent.vue';
import axios from 'axios';

const props = defineProps({
    formData: {
        type: Array,
        required: true
    },
    modelRoute: {
        type: String,
        required: true
    },
    title: {
        type: String,
        required: true
    },
    modalWidth: {
        type: Number,
        required: true
    }

});

const emit = defineEmits(['refresh'])

const dialog = ref(false);
const snackbar = ref(false);
const text = ref('Updated');
const color = ref('black');
const loading = ref(false);


const defaultFormState = props.formData.reduce((acc, item) => {
    if (item.type === 'file') {
        acc[item.model] = item.multiple ? [] : null;
    } else {
        acc[item.model] = item.value || '';
    }
    return acc;
}, {});


const form = reactive({ ...defaultFormState });
const errors = ref(null);
const guarantors = ref(null);

const fileRefs = reactive({});

const documentModal = ref(null);


// Initialize form with formData
props.formData.forEach(item => {
    if (item.type === 'file') {
        form[item.model] = item.multiple ? [] : null;
        fileRefs[item.model] = ref(null);
    } else {
        form[item.model] = item.value;
    }
});

function showDocumentModal(data) {
    documentModal.value?.show(data);
}


// resetForm updated to clear and set the form back to its initial state
function resetForm() {
    Object.keys(defaultFormState).forEach(key => {
        form[key] = Array.isArray(defaultFormState[key]) ? [] : defaultFormState[key];
    });
}


// Watch for changes in dependent fields and trigger fetch
props.formData.forEach(item => {
    if (item.fetch) {
        watch(() => form[item.model], async (newVal) => {
            if (newVal) {
                await fetchData(item.fetch.url, newVal, item.fetch.target_fields);
            }
        });
    }

    if (item.calculation) {
        const { depends_on, formula, target_field } = item.calculation;

        watch(depends_on.map(dep => () => form[dep]), () => {
            const calculatedValue = eval(formula.replace(/\b(amount|installments|interest_rate|total_payment)\b/g, (match) => form[match]));
            form[target_field] = calculatedValue;
        });
    }
    if (item.interest) {
        const { depends_on, target_field } = item.interest;

        // Watch the fields the calculation depends on
        watch(depends_on.map(dep => () => form[dep]), () => {
            // Get form values for amount, installments, and interest_rate
            const amount = parseFloat(form.amount);
            const installments = parseInt(form.installments);
            const interestRate = parseFloat(form.interest_rate) / 100; // Convert to decimal

            if (installments === 1) {
                // Simple case with 1 installment
                const interest = amount * interestRate;
                const totalPayment = amount + interest;
                form[target_field] = totalPayment;
            } else {
                // Reducing balance calculation for multiple installments
                let totalPayment = 0;
                let remainingBalance = amount;

                for (let i = 1; i <= installments; i++) {
                    const principalPayment = amount / installments;
                    const interest = remainingBalance * interestRate; // Interest on remaining balance

                    const installmentPayment = principalPayment + interest;
                    totalPayment += installmentPayment;

                    remainingBalance -= principalPayment; // Update remaining balance
                }

                form[target_field] = totalPayment;
            }
        });
    }

});

async function fetchData(url, value, targetFields) {
    try {
        const response = await axios.get(`${url}/${value}`);
        const data = response.data;
        targetFields.forEach(field => {
            form[field] = data[field];
        });

        if (data.guarantors) {
            guarantors.value = data.guarantors
        }
    } catch (error) {
        console.error("Failed to fetch data:", error);
    }
}


function submit() {
    errors.value = null
    loading.value = true;
    // const submissionData = new FormData();

    // Object.keys(form).forEach(key => {
    //     const field = props.formData.find(item => item.model === key);
    //     if (field && field.type === 'file') {
    //         if (field.multiple && Array.isArray(form[key])) {
    //             form[key].forEach(file => submissionData.append(`${key}[]`, file));
    //         } else if (form[key]) {
    //             submissionData.append(key, form[key]);
    //         }
    //     } else if (key.startsWith('guarantors')) {
    //         if (Array.isArray(form[key])) {
    //             form[key].forEach((guarantor, index) => {
    //                 submissionData.append(`${key}[]`, JSON.stringify(guarantor));
    //             });
    //         } else {
    //             submissionData.append(key, JSON.stringify(form[key]));
    //         }
    //     } else {
    //         submissionData.append(key, form[key]);
    //     }
    // });

    axios.post(`/${props.modelRoute}`, form).then((res) => {
        snackbar.value = true;
        color.value = 'success';
        text.value = 'Created';
        if (props.modelRoute === 'loans') {
            console.log(res.data);

            showDocumentModal(res.data)
        } else {
            emit('refresh', false);
            resetForm(); // Now properly resetting form
            dialog.value = false;
        }

    }).catch((error) => {
        console.log(error);

        if (error.response.status === 422) {
            text.value = error.response.data.message;
        } else {
            text.value = "Something went wrong";
        }

        errors.value = error.response.data.errors
        snackbar.value = true;
        color.value = 'error';
    }).finally(() => {
        loading.value = false; // Loading stops regardless of success or error
    });
}

function show() {
    dialog.value = true;
}

function close() {
    dialog.value = false;
}

defineExpose({ show });
</script>
