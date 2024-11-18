import './bootstrap';
// import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';

import vuetify, { initializeTheme } from "./plugins/vuetify";

import "../css/global.css"
import NProgress from 'nprogress'
import { router } from '@inertiajs/vue3'

import { currencyPlugin } from './utils/currencyFormatter';



const appName = import.meta.env.VITE_APP_NAME || 'Logixsaas';
initializeTheme() // Initialize theme colors from database

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        router.on('start', () => NProgress.start())

        router.on('finish', (event) => {
            if (event.detail.visit.completed) {
                NProgress.done()
            } else if (event.detail.visit.interrupted) {
                NProgress.set(0)
            } else if (event.detail.visit.cancelled) {
                NProgress.done()
                NProgress.remove()
            }
        })


        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(vuetify)
            .use(currencyPlugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#fff',
    },

});
