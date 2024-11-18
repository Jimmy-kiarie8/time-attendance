import "vuetify/styles";
import { createVuetify } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";
import "@mdi/font/css/materialdesignicons.css";
import axios from 'axios';

// Function to generate theme settings for light and dark modes
const createThemeSettings = (colors) => ({
    light: {
        dark: false,
        colors: {
            ...colors,
            'primary-darken-1': colors.primary,
            'secondary-darken-1': colors.secondary,
            'surface': '#FFFFFF',
            'background': '#F5F5F5',
            'on-background': '#000000',
            'on-surface': '#000000',
        },
    },
    dark: {
        dark: true,
        colors: {
            ...colors,
            'primary-darken-1': colors.primary,
            'secondary-darken-1': colors.secondary,
            'surface': '#121212',
            'background': '#000000',
            'on-background': '#FFFFFF',
            'on-surface': '#FFFFFF',
        },
    },
});

// Default colors while loading
const defaultColors = {
    primary: '#2196f3',
    secondary: '#48a9a6',
    accent: '#82B1FF',
    error: '#b00020',
    success: '#4caf50',
    warning: '#fb8c00',
};

// Create initial Vuetify instance with default colors
const vuetify = createVuetify({
    components,
    directives,
    icons: {
        defaultSet: "mdi",
    },
    theme: {
        defaultTheme: 'light',
        themes: createThemeSettings(defaultColors),
    },
});

// Function to update theme colors dynamically
export const updateThemeColors = async () => {
    try {
        const response = await axios.get('/theme');
        const newColors = response.data.colors;

        // Create new theme settings with fetched colors
        const newThemeSettings = createThemeSettings(newColors);

        // Update both light and dark themes
        vuetify.theme.themes.value.light.colors = {
            ...vuetify.theme.themes.value.light.colors,
            ...newThemeSettings.light.colors,
        };

        vuetify.theme.themes.value.dark.colors = {
            ...vuetify.theme.themes.value.dark.colors,
            ...newThemeSettings.dark.colors,
        };

        console.log('Updated theme colors:', vuetify.theme.themes.value);
    } catch (error) {
        console.error('Failed to fetch theme colors:', error);
    }
};

// Initialize the theme colors on load
export const initializeTheme = () => {
    updateThemeColors();
};

export default vuetify;
