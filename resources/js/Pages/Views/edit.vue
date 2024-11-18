<template>
    <v-row justify="center" v-if="dialog">
        <v-dialog persistent v-model="dialog" :width="modalWidth">
            <v-divider></v-divider>
            <v-card>
                <v-card-title class="text-h5">
                    Edit {{ title }}
                </v-card-title>
                <v-card-text>
                    <my-form :formData="formData" v-model:form="form" />
                </v-card-text>
                <v-card-actions>
                    <v-btn variant="outlined" color="red" @click="close">
                        <v-icon>mdi-close</v-icon> Close
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-btn variant="outlined" color="primary" @click="submit" :loading="loading">
                        <v-icon>mdi-content-save</v-icon>
                        Save Changes
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
import MyForm from '@/Components/FormComponent.vue';
import axios from 'axios';

const props = defineProps({
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

const dialog = ref(false);
const snackbar = ref(false);
const text = ref('Updated');
const color = ref('black');
const loading = ref(false);
const id = ref(null);

const form = reactive({});
const formData = ref([]);

// onMounted(async () => {
// });
const emit = defineEmits(['refresh'])


async function fetchFormData(id) {
    try {
        const response = await axios.get(`/${props.modelRoute}/${id}/edit`);

        formData.value = response.data;
        console.log('formData',formData.value);

        formData.value.forEach(item => {
            if (item.type === 'file') {
                form[item.model] = item.multiple ? [] : null;
            } else {
                form[item.model] = item.value;
            }
        });
    } catch (error) {
        console.error("Failed to fetch data:", error);
        snackbar.value = true;
        color.value = 'error';
        text.value = 'Failed to load data';
    }
}

// Set up watchers for dependent fields and calculations
// watch(formData, (newFormData) => {
//     newFormData.forEach(item => {
//         if (item.fetch) {
//             watch(() => form[item.model], async (newVal) => {
//                 if (newVal) {
//                     await fetchDependentData(item.fetch.url, newVal, item.fetch.target_fields);
//                 }
//             });
//         }
//         if (item.calculation) {
//             const { depends_on, formula, target_field } = item.calculation;
//             watch(depends_on.map(dep => () => form[dep]), () => {
//                 const calculatedValue = eval(formula.replace(/\b(amount|installments)\b/g, (match) => form[match]));
//                 form[target_field] = calculatedValue;
//             });
//         }
//     });
// }, { deep: true });

async function fetchDependentData(url, value, targetFields) {
    try {
        const response = await axios.get(`${url}/${value}`);
        const data = response.data;
        targetFields.forEach(field => {
            form[field] = data[field];
        });
    } catch (error) {
        console.error("Failed to fetch dependent data:", error);
    }
}

function submit() {

    loading.value = true;


    /*
    const submissionData = new FormData();
    formData.value.forEach(item => {
        if (item.type === 'file') {
            if (item.multiple && Array.isArray(form[item.model])) {
                form[item.model].forEach(file => submissionData.append(`${item.model}[]`, file));
            } else if (form[item.model]) {
                submissionData.append(item.model, form[item.model]);
            }
        } else {
            submissionData.append(item.model, form[item.model]);
        }
    });

    axios.patch(`/${props.modelRoute}/${id.value}`, submissionData, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    }) */

    axios.patch(`/${props.modelRoute}/${id.value}`, form).then((res) => {
        snackbar.value = true;
        color.value = 'success';
        text.value = 'Updated successfully';
        dialog.value = false;


        emit('refresh', false);
        dialog.value = false;
    }).catch((error) => {
        console.error(error);
        snackbar.value = true;
        color.value = 'error';
        text.value = 'Something went wrong!';
    }).finally(() => {
        loading.value = false;
    });
}

function show(data) {
    console.log(data.id);
    dialog.value = true;
    id.value = data.id;
    fetchFormData(data.id);

}

function close() {
    dialog.value = false;
}

defineExpose({ show });
</script>
