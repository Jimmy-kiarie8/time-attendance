<template>
    <v-container>
        <h1 class="text-h4 mb-6">Organization</h1>
        <v-card class="mb-6" variant="tonal">
            <v-card-text>
                <v-row align="center">
                    <v-col cols="auto">
                        <v-hover v-slot="{ isHovering, props }">
                            <v-avatar size="100" v-bind="props" class="position-relative overflow-hidden">
                                <v-img
                                    :src="company.logo || 'https://play-lh.googleusercontent.com/Ieu-H2JARy4EVnrdxTse1jqfe3HWQOT16Eis6f8opR-Z_d_CfbxWXn1ea86aZEzygfiZ=w240-h480-rw'"
                                    alt="Avatar" cover>
                                    <v-expand-transition>
                                        <div v-if="isHovering"
                                            class="d-flex transition-fast-in-fast-out v-card--reveal text-h6 align-center justify-center"
                                            style="height: 100%;">
                                            <v-btn icon @click="triggerFileInput">
                                                <v-icon>mdi-camera-outline</v-icon>
                                            </v-btn>
                                        </div>
                                    </v-expand-transition>
                                </v-img>
                            </v-avatar>
                        </v-hover>

                        <input type="file" ref="fileInput" style="display: none"
                        @change="handleFileChange" accept="image/*">
                    </v-col>
                    <v-col>
                        <h2 class="text-h5">{{ company.name }}</h2>
                        <p class="text-body-2">{{ company.email }}</p>
                    </v-col>
                    <v-col cols="auto" @click="updateEdit(true)" v-if="!editUser">
                        <v-btn color="primary">Edit</v-btn>
                    </v-col>
                </v-row>

                <v-row class="mt-6">
                    <v-col cols="12" sm="4">
                        <v-text-field clearable density="compact" label="Name" variant="outlined" v-model="company.name"
                            :disabled="!editUser"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <v-text-field clearable density="compact" label="Phone" variant="outlined"
                            v-model="company.phone" :disabled="!editUser"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <v-text-field clearable density="compact" label="Address" variant="outlined"
                            v-model="company.address" :disabled="!editUser"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <v-text-field clearable density="compact" label="Pin" variant="outlined"
                            v-model="company.pin" :disabled="!editUser"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <v-text-field clearable density="compact" label="P.O.Box" variant="outlined"
                            v-model="company.po_box" :disabled="!editUser"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <v-text-field clearable density="compact" label="Website" variant="outlined"
                            v-model="company.website" :disabled="!editUser"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <v-text-field clearable density="compact" label="Registration No" variant="outlined"
                            v-model="company.registration_no" :disabled="!editUser"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <v-text-field clearable density="compact" label="City" variant="outlined" v-model="company.city"
                            :disabled="!editUser"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <v-text-field clearable density="compact" label="Country" variant="outlined"
                            v-model="company.country" :disabled="!editUser"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <v-text-field clearable density="compact" label="Timezone" variant="outlined"
                            v-model="company.timezone" :disabled="!editUser"></v-text-field>
                    </v-col>
                </v-row>
            </v-card-text>
            <v-card-actions v-if="editUser">
                <v-spacer></v-spacer>
                <v-btn color="primary" variant="outlined" @click="updateCompany" :loading="loading">Update</v-btn>
                <v-btn color="error" variant="outlined" @click="updateEdit(false)">Cancel</v-btn>
            </v-card-actions>
        </v-card>

        <v-snackbar v-model="snackbar" :color="snackbarColor">
            {{ snackbarText }}
        </v-snackbar>
    </v-container>
</template>

<script setup>
import axios from 'axios';
import { onMounted, ref } from 'vue';

const editUser = ref(false);
const loading = ref(false);
const company = ref({
    name: '',
    email: '',
    phone: '',
    address: '',
    city: '',
    country: '',
    timezone: '',
    logo: ''
});
const snackbarText = ref('');
const snackbarColor = ref('success');
const snackbar = ref(false);
const fileInput = ref(null);

function updateEdit(edit) {
    editUser.value = edit;
}

function triggerFileInput() {
    if (fileInput.value) {
        fileInput.value.click();
    }
}

async function handleFileChange(event) {
    const file = event.target.files[0];
    if (!file) return;

    const formData = new FormData();
    formData.append('file', file);

    try {
        const response = await axios.post(`/logo/${company.value.id}`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });

        console.log(response);

        company.value.logo = response.data.data.logo;
        showSnackbar(response.data.message, 'success');
    } catch (error) {
        console.error('Error uploading file:', error);
        showSnackbar('Failed to update avatar. Please try again.', 'error');
    }
}

function showSnackbar(text, color) {
    snackbarText.value = text;
    snackbarColor.value = color;
    snackbar.value = true;
}

async function updateCompany() {
    loading.value = true;
    try {
        const response = await axios.post('/company', company.value);
        company.value = response.data;
        showSnackbar('Company information updated successfully!', 'success');
        updateEdit(false);
    } catch (error) {
        console.error("Failed to update company:", error);
        showSnackbar('Failed to update company information. Please try again.', 'error');
    } finally {
        loading.value = false;
    }
}

async function getCompany() {
    try {
        const response = await axios.get('/company');
        company.value = response.data;
    } catch (error) {
        console.error("Failed to fetch company data:", error);
        showSnackbar('Failed to fetch company information. Please try again.', 'error');
    }
}

onMounted(() => {
    getCompany();
});
</script>

<style scoped>
.v-card--reveal {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
