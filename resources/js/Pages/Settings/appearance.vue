<template>
    <div>
        <h2 class="mt-4">Appearance</h2>
        <p>Change how your public dashboard looks and feels.</p>
        <br>
        <v-row>
            <v-col cols="12" sm="3">
                <h3>Brand color</h3>
                <p>Select or customize your brand color.</p>
            </v-col>
            <v-col cols="12" sm="6">
                <b>Primary</b>
                <v-menu :close-on-content-click="false" location="end">
                    <template v-slot:activator="{ props }">
                        <v-row>
                            <v-col cols="1">
                                <v-btn :color="form.primary" v-bind="props" rounded></v-btn>
                            </v-col>
                            <v-col cols="2">
                                <v-text-field rounded v-model="form.primary" variant="outlined"
                                    density="compact"></v-text-field>
                            </v-col>
                        </v-row>
                    </template>
                    <v-card min-width="300">
                        <v-color-picker v-model="form.primary"></v-color-picker>
                    </v-card>
                </v-menu>

                <b>Success</b>
                <v-menu :close-on-content-click="false" location="end">
                    <template v-slot:activator="{ props }">
                        <v-row>
                            <v-col cols="1">
                                <v-btn :color="form.success" v-bind="props" rounded></v-btn>
                            </v-col>
                            <v-col cols="2">
                                <v-text-field rounded v-model="form.success" variant="outlined"
                                    density="compact"></v-text-field>
                            </v-col>
                        </v-row>
                    </template>
                    <v-card min-width="300">
                        <v-color-picker v-model="form.success"></v-color-picker>
                    </v-card>
                </v-menu>

                <b>Info</b>
                <v-menu :close-on-content-click="false" location="end">
                    <template v-slot:activator="{ props }">
                        <v-row>
                            <v-col cols="1">
                                <v-btn :color="form.info" v-bind="props" rounded></v-btn>
                            </v-col>
                            <v-col cols="2">
                                <v-text-field rounded v-model="form.info" variant="outlined"
                                    density="compact"></v-text-field>
                            </v-col>
                        </v-row>
                    </template>
                    <v-card min-width="300">
                        <v-color-picker v-model="form.primary"></v-color-picker>
                    </v-card>
                </v-menu>

                <b>Secondary</b>
                <v-menu :close-on-content-click="false" location="end">
                    <template v-slot:activator="{ props }">
                        <v-row>
                            <v-col cols="1">
                                <v-btn :color="form.secondary" v-bind="props" rounded></v-btn>
                            </v-col>
                            <v-col cols="2">
                                <v-text-field rounded v-model="form.secondary" variant="outlined"
                                    density="compact"></v-text-field>
                            </v-col>
                        </v-row>
                    </template>
                    <v-card min-width="300">
                        <v-color-picker v-model="form.secondary"></v-color-picker>
                    </v-card>
                </v-menu>

                <b>Error</b>
                <v-menu :close-on-content-click="false" location="end">
                    <template v-slot:activator="{ props }">
                        <v-row>
                            <v-col cols="1">
                                <v-btn :color="form.error" v-bind="props" rounded></v-btn>
                            </v-col>
                            <v-col cols="2">
                                <v-text-field rounded v-model="form.error" variant="outlined"
                                    density="compact"></v-text-field>
                            </v-col>
                        </v-row>
                    </template>
                    <v-card min-width="300">
                        <v-color-picker v-model="form.error"></v-color-picker>
                    </v-card>
                </v-menu>

                <b>Warning</b>
                <v-menu :close-on-content-click="false" location="end">
                    <template v-slot:activator="{ props }">
                        <v-row>
                            <v-col cols="1">
                                <v-btn :color="form.warning" v-bind="props" rounded></v-btn>
                            </v-col>
                            <v-col cols="2">
                                <v-text-field rounded v-model="form.warning" variant="outlined"
                                    density="compact"></v-text-field>
                            </v-col>
                        </v-row>
                    </template>
                    <v-card min-width="300">
                        <v-color-picker v-model="form.warning"></v-color-picker>
                    </v-card>
                </v-menu>
                <b>Accent</b>
                <v-menu :close-on-content-click="false" location="end">
                    <template v-slot:activator="{ props }">
                        <v-row>
                            <v-col cols="1">
                                <v-btn :color="form.accent" v-bind="props" rounded></v-btn>
                            </v-col>
                            <v-col cols="2">
                                <v-text-field rounded v-model="form.accent" variant="outlined"
                                    density="compact"></v-text-field>
                            </v-col>
                        </v-row>
                    </template>
                    <v-card min-width="300">
                        <v-color-picker v-model="form.accent"></v-color-picker>
                    </v-card>
                </v-menu>
            </v-col>
        </v-row>

        <v-row>
            <v-col cols="12" sm="3">
                <h3>Language</h3>
                <p>Default language for public dashboard.</p>
            </v-col>
            <v-col cols="12" sm="6">
                <v-select variant="outlined" density="compact" v-model="selectedLanguage" :items="languages"
                    item-title="name" item-value="code"></v-select>
            </v-col>
        </v-row>

        <v-row>
            <v-col cols="3">
                <h3>Layout</h3>
                <p>Display dashboard.</p>
            </v-col>
            <v-col cols="6">
                <v-btn variant="text">View examples</v-btn>
                <v-row>
                    <v-col v-for="banner in layoutBanners" :key="banner.title" cols="12" sm="4">
                        <v-card @click="selectBanner(banner)">
                            <v-img :src="banner.image"></v-img>
                            <v-card-title>{{ banner.title }}</v-card-title>
                            <v-card-subtitle>{{ banner.description }}</v-card-subtitle>
                        </v-card>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>

        <v-snackbar v-model="snackbar" :color="snackbarColor">
            {{ snackbarText }}
        </v-snackbar>
        <v-btn color="primary" @click="saveChanges" :loading="loading">Save</v-btn>
    </div>
</template>

<script setup>
import { onMounted, ref, watch } from 'vue';
import { useTheme } from 'vuetify'

const form = ref({
    primary: '#2196f3',
    secondary: '#48a9a6',
    accent: '#FF4081',
    error: '#b00020',
    success: '#4caf50',
    warning: '#fb8c00',
    accent: '#82B1FF',
});

// Language settings
const selectedLanguage = ref('en-GB');
const languages = ref([
    { name: 'English (UK)', code: 'en-GB' },
    // Add more languages as needed
]);

// Snackbar settings
const snackbarText = ref('');
const snackbarColor = ref('success');
const snackbar = ref(false);
const loading = ref(false);

const theme = useTheme()

// Layout banners
const layoutBanners = ref([
    { title: 'Default', description: 'controls for visitors.', image: "https://cdn.vuetifyjs.com/docs/images/wireframes/baseline.svg" },
    { title: 'Simplified', description: 'Show a simplified banner.', image: 'https://cdn.vuetifyjs.com/docs/images/wireframes/inbox.svg' },
    { title: 'Rail', description: "Collapsed.", image: "https://cdn.vuetifyjs.com/docs/images/wireframes/side-navigation.svg" },
]);

// Watch for changes in the form to dynamically update the theme
watch(form, (newValue) => {
    // Update the Vuetify theme colors
    const vuetifyTheme = {
        primary: newValue.primary,
        secondary: newValue.secondary,
        warning: newValue.warning,
        error: newValue.error,
        success: newValue.success,
        primary: newValue.success,
    };

    // Assuming you have access to the Vuetify instance
    // This can vary based on how your app is structured
    // You may need to emit an event or call a function that applies the new theme
    // Example: $vuetify.theme.themes.light = vuetifyTheme;
}, { deep: true });

// Snackbar display function
function showSnackbar(text, color) {
    snackbarText.value = text;
    snackbarColor.value = color;
    snackbar.value = true;
}

// Save changes function
const getTheme = async () => {
    console.log(theme.themes.value.light.colors)
    form.value = theme.themes.value.light.colors
};
// Save changes function
const saveChanges = async () => {
    loading.value = true;
    try {
        // Send form data to your API
        await axios.post('/appearance', form.value);
        showSnackbar('Settings updated. Refresh to apply changes!', 'success');
    } catch (error) {
        console.error("Failed to update settings:", error);
        showSnackbar('Failed to update settings. Please try again.', 'error');
    } finally {
        loading.value = false;
    }
};

// onMounted
onMounted(() => {
    getTheme()
})

</script>
