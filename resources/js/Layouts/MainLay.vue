<template>
    <v-app id="inspire">

        <v-navigation-drawer v-model="drawer" :expand-on-hover="rail" :rail="rail" color="primary">
            <img :src="company.logo" alt="" srcset="" />

            <v-divider></v-divider>

            <v-list v-for="(item, i) in links" :key="i" :value="item" id="main-layout">
                <template v-if="item.hasSub">
                    <v-list-subheader>{{ item.text }}</v-list-subheader>
                    <Link :key="i" :href="sub.link" v-for="sub in item.subMenu">
                    <v-list-item color="primary" variant="plain" :class="{ 'isActive': isActive(sub.link) }"
                        density="compact">
                        <template v-slot:prepend>
                            <v-icon :icon="sub.icon" size="small"></v-icon>
                        </template>
                        <v-list-item-title v-text="sub.text"></v-list-item-title>
                    </v-list-item>
                    </Link>
                </template>

                <template v-else>
                    <Link :key="i" :href="item.link">
                    <v-list-item variant="plain" :class="{ 'isActive': isActive(item.link) }">
                        <template v-slot:prepend>
                            <v-icon :icon="item.icon" size="small"></v-icon>
                        </template>
                        <v-list-item-title v-text="item.text"></v-list-item-title>
                    </v-list-item>
                    </Link>
                </template>
            </v-list>
        </v-navigation-drawer>
        <v-main>
            <v-toolbar color="transparent">

                <v-toolbar-title>

                    <h2>{{ title }} <v-icon icon="mdi-shimmer" size="30"></v-icon></h2>
                </v-toolbar-title>


                <v-spacer></v-spacer>

                <v-btn icon @click="logout">
                    <v-icon>mdi-logout</v-icon>
                </v-btn>


            <v-btn class="ma-2" variant="text"
                :icon="theme.global.current.value.dark ? 'mdi-white-balance-sunny' : 'mdi-weather-night'"
                :color="white" @click="toggleTheme"></v-btn>
            </v-toolbar>

            <v-divider></v-divider>
            <v-container class="py-8 px-6" fluid>
                <slot />
            </v-container>
        </v-main>
    </v-app>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import { useTheme } from 'vuetify';
import axios from 'axios';
import { updateThemeColors } from '../plugins/vuetify';

// Props
const props = defineProps({
    title: String,
    modelRoute: String,
    rail: Boolean,
});


const fav = ref(true)
const menu = ref(false)
const message = ref(false)
const hints = ref(true)

// Refs
const drawer = ref(true);
const links = ref([]);
const company = ref({});
const snackbar = ref({
    show: false,
    text: '',
    color: 'success'
});

// Theme
const theme = useTheme();

const toggleTheme = () => {
    theme.global.name.value = theme.global.current.value.dark ? 'light' : 'dark';
    localStorage.setItem('theme', theme.global.name.value);
};

// Computed
const isActive = computed(() => {
    return (route) => {
        return "/admin/" + props.modelRoute === route;
    };
});

// Methods
const showSnackbar = (text, color = 'success') => {
    snackbar.value = {
        show: true,
        text,
        color
    };
};

const getCompany = async () => {
    try {
        const response = await axios.get('/company');
        company.value = response.data;
    } catch (error) {
        console.error("Failed to fetch company data:", error);
        showSnackbar('Failed to fetch company information. Please try again.', 'error');
    }
};

const loadJsonData = async () => {
    try {
        const response = await axios.get('/data/menu.json');
        links.value = response.data;
    } catch (error) {
        console.error('Error loading JSON data:', error);
        showSnackbar('Failed to load menu data', 'error');
    }
};

const handleLogout = async () => {
    try {
        await router.post(route('logout'));
    } catch (error) {
        console.error('Logout failed:', error);
        showSnackbar('Logout failed. Please try again.', 'error');
    }
};

const refreshTheme = async () => {
    await updateThemeColors();
};

// Lifecycle hooks
onMounted(() => {
    // Load theme from local storage
    const storedTheme = localStorage.getItem('theme');
    if (storedTheme) {
        theme.global.name.value = storedTheme;
    }

    // Load initial data
    loadJsonData();
    getCompany();


    window.addEventListener('theme-updated', refreshTheme);

});
</script>
