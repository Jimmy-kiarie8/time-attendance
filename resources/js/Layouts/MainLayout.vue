<template>
    <v-app id="inspire">
        <v-navigation-drawer v-model="drawer" :expand-on-hover="rail" :rail="rail" color="primary" >
            <img :src="company.logo" alt="" srcset="" class="logo" />

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

        <v-app-bar id="tool-bar" color="primary">
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

            <!-- <v-app-bar-title>
                <img :src="company.logo" alt="" srcset="" style="width: 180px;" />
            </v-app-bar-title> -->
            <v-spacer></v-spacer>

            <v-menu v-model="menu" :close-on-content-click="false" location="end">
                <template v-slot:activator="{ props }">
                    <v-btn icon color="white" v-bind="props">
                        <v-icon>mdi-account-circle</v-icon>
                    </v-btn>
                </template>
                <v-divider vertical></v-divider>

                <v-card min-width="300">
                    <v-list>
                        <v-list-item :prepend-avatar="$page.props.auth.user.profile_photo_url"
                            :subtitle="$page.props.auth.user.email" :title="$page.props.auth.user.name">
                            <template v-slot:append>
                                <v-btn :class="fav ? 'text-red' : ''" icon="mdi-heart" variant="text"
                                    @click="fav = !fav"></v-btn>
                            </template>
                        </v-list-item>
                    </v-list>

                    <v-divider></v-divider>

                    <v-list>
                        <v-list-item :href="route('profile.show')">
                            <template v-slot:prepend>
                                <v-icon>mdi-account-circle</v-icon>
                            </template>
                            Profile
                        </v-list-item>

                    </v-list>

                    <v-card-actions>
                        <v-spacer></v-spacer>


                        <form @submit.prevent="handleLogout">
                            <v-btn variant="outlined" color="error" type="submit"> <v-icon>mdi-logout</v-icon>
                                Logout</v-btn>
                        </form>
                    </v-card-actions>
                </v-card>
            </v-menu>

            <div style="margin-right: 10px;"></div>


            <v-btn class="ma-2" variant="text"
                :icon="theme.global.current.value.dark ? 'mdi-white-balance-sunny' : 'mdi-weather-night'"
                color="white" @click="toggleTheme"></v-btn>
        </v-app-bar>

        <v-main>
            <slot />
        </v-main>

        <v-snackbar v-model="snackbar.show" :color="snackbar.color">
            {{ snackbar.text }}
            <template v-slot:actions>
                <v-btn color="pink" variant="text" @click="snackbar.show = false">
                    Close
                </v-btn>
            </template>
        </v-snackbar>
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
        return '/'+ props.modelRoute === route;
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

<style>
.v-app {
    overflow-x: hidden !important;
}

.v-theme--light #main-layout a {
    text-decoration: none;
    cursor: pointer;
    color: #fff !important;
}

.v-theme--dark #main-layout .v-list-item--nav .v-list-item-title {
    text-decoration: none;
    cursor: pointer;
    color: #fff !important;
}

.v-navigation-drawer {
    border: none !important;
}

.v-btn {
    height: calc(var(--v-btn-height) + 0px);
    text-transform: none;
}
.v-theme--dark .isActive {
    background-color: rgba(255, 255, 255, 0.1) !important; /* Light background with opacity for dark theme */
    border-right: 2px solid #fff;
}

.v-theme--light .isActive {
    background-color: rgba(0, 0, 0, 0.1) !important; /* Dark background with opacity for light theme */
    border-right: 2px solid #fff;
}


.v-main {
    margin: 20px;
}

.v-theme--dark .v-list-subheader__text {
    font-weight: bolder;
    color: #f0f0f0 !important;
}

.v-theme--light .v-list-subheader__text {
    font-weight: bolder;
    color: #fff !important;
}

#main-layout a,
#main-layout .v-list-item--nav .v-list-item-title {
    text-decoration: none;
    cursor: pointer;
    color: #fff;
}

.v-card {
    padding: 15px !important;
    border-radius: 10px 0 10px 10px !important;
}

.v-list-subheader__text,
.v-list-item-title {
    font-size: 13px !important;
}

.logo {
    width: 220px;
    border-radius: 20px;
    margin: auto;
    text-align: center;
    margin-left: 10px;
    margin-top: 10px;
}


</style>
