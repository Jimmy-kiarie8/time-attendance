<template>
    <v-container>
        <h1 class="text-h4 mb-6">Profile</h1>
        <v-card class="mb-6" variant="tonal">
            <v-card-text>
                <v-row align="center">
                    <v-col cols="auto">
                        <v-hover v-slot="{ isHovering, props }">
                            <v-avatar size="100" v-bind="props" class="position-relative overflow-hidden">
                                <v-img
                                    :src="user.profile_photo_url || 'https://play-lh.googleusercontent.com/Ieu-H2JARy4EVnrdxTse1jqfe3HWQOT16Eis6f8opR-Z_d_CfbxWXn1ea86aZEzygfiZ=w240-h480-rw'"
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
                        <h2 class="text-h5">{{ user.name }}</h2>
                        <p class="text-body-2">{{ user.email }}</p>
                    </v-col>
                    <v-col cols="auto" @click="updateEdit(true)" v-if="!editUser">
                        <v-btn color="primary">Edit</v-btn>
                    </v-col>
                </v-row>

                <v-row class="mt-6">
                    <v-col cols="12" sm="6">
                        <v-text-field clearable density="compact" label="Name" variant="outlined"
                            v-model="user.name" :disabled="!editUser"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field clearable density="compact" label="Phone" variant="outlined"
                            v-model="user.phone" :disabled="!editUser"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field clearable density="compact" label="Address" variant="outlined"
                            v-model="user.address" :disabled="!editUser"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field clearable density="compact" label="City" variant="outlined"
                            v-model="user.city" :disabled="!editUser"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field clearable density="compact" label="Country" variant="outlined" :disabled="!editUser"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field clearable density="compact" label="Timezone" variant="outlined" :disabled="!editUser"></v-text-field>
                    </v-col>

                </v-row>
            </v-card-text>
            <v-card-actions  v-if="editUser">
                <v-spacer></v-spacer>

                        <v-btn color="primary" variant="outlined">Update</v-btn>

                        <v-btn color="error" variant="outlined" @click="updateEdit(false)">Cancel</v-btn>
            </v-card-actions>
        </v-card>

        <v-card class="mb-6" variant="tonal">
            <v-card-text>
                <h2 class="text-h6 mb-2">My Email Addresses</h2>
                <p class="text-body-2 mb-4">You can use the following email addresses to sign in to your account and
                    also to
                    reset your password if you ever forget it.</p>

                <v-list>
                    <v-list-item>
                        <template v-slot:prepend>
                            <v-avatar color="primary" size="36">
                                <v-icon color="white">mdi-email</v-icon>
                            </v-avatar>
                        </template>
                        <v-list-item-title>{{ user.email }}</v-list-item-title>
                        <v-list-item-subtitle>21 days ago</v-list-item-subtitle>
                        <template v-slot:append>
                            <v-icon color="primary">mdi-crown</v-icon>
                        </template>
                    </v-list-item>
                </v-list>

                <v-btn color="primary" variant="text" prepend-icon="mdi-plus" class="mt-4">
                    Add Email Address
                </v-btn>
            </v-card-text>
        </v-card>

        <v-card class="mb-6" variant="tonal">
            <v-card-text>
                <h2 class="text-h6 mb-2">My Mobile Numbers</h2>
                <p class="text-body-2 mb-4">View and manage all of the mobile numbers associated with your account.</p>

                <v-img src="/path-to-your-placeholder-image.png" height="200" contain></v-img>

                <v-btn color="primary" prepend-icon="mdi-plus">
                    Add Mobile Number
                </v-btn>
            </v-card-text>
        </v-card>

        <v-snackbar v-model="snackbar" :color="snackbarColor">
            {{ snackbarText }}
        </v-snackbar>
    </v-container>
</template>

<script setup>
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';

// You can add any reactive variables or methods here if needed
const editUser = ref(false)



const page = usePage()
const user = page.props.auth.user


const snackbarText = ref('');
const snackbarColor = ref('success');
const snackbar = ref(false);
const fileInput = ref(null);

// fetchJson will now only be called when explicitly invoked
async function updateEdit(edit) {
   editUser.value = edit
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

    console.log(user);
    try {
        const response = await axios.post(`/profile/${user.id}`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });

        console.log(response);

        user.profile_photo_url = response.data.data.profile_photo_url;
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


// fetchJson will now only be called when explicitly invoked
async function updateUser() {
    const url = "/updateUser-data?file=reschedule.json";
    try {
        const response = await axios.post(`${url}`);

        formData.value = response.data

    } catch (error) {
        console.error("Failed to fetch data:", error);
    }
}


</script>

<style scoped>
/* Add any component-specific styles here */
</style>
