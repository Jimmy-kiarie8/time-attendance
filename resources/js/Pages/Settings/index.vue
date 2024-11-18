<template>
    <MainLayout title="Dashboard">
        <v-card>
            <v-container class="billing-settings">
                <h1 class="text-h4 mb-2">Settings</h1>
                <p class="text-subtitle-1 mb-6">Manage your account settings and preferences.</p>
                <v-sheet elevation="3" rounded="lg">
                    <v-tabs v-model="tab" :items="tabs" align-tabs="center" height="60"
                        slider-color="#f78166">
                        <template v-slot:tab="{ item }">
                            <v-tab :prepend-icon="item.icon" :text="item.text" :value="item.value"
                                class="text-none"></v-tab>
                        </template>

                    </v-tabs>
                </v-sheet>


                <v-window v-model="tab">
                    <v-window-item value="appearance">
                        <myAppearance />
                    </v-window-item>
                    <v-window-item value="billings">
                        <myBilling />
                    </v-window-item>
                    <v-window-item value="profile">
                        <myAccount />
                    </v-window-item>
                    <v-window-item value="organization">
                        <myOrganization />
                    </v-window-item>
                    <v-window-item value="settings">
                        <mySettings :formData="formData" />
                    </v-window-item>
                    <v-window-item value="integrations">
                        <myIntegration :sms="sms" :email="email" />
                    </v-window-item>
                </v-window>
            </v-container>
        </v-card>
    </MainLayout>
</template>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import myBilling from './billing.vue';
import myAppearance from './appearance.vue';
import myAccount from './account.vue';
import myOrganization from './organization.vue';
import mySettings from './settings.vue';
import myIntegration from './integrations.vue';

import { shallowRef } from 'vue'


const props = defineProps({
    formData: Object,
    email: Object,
    sms: Object

});

const tab = shallowRef('settings')
const tabs = [
    {
        icon: 'mdi-account-circle',
        text: 'Profile',
        value: 'profile',
    },
    {
        icon: 'mdi-domain',
        text: 'Organization',
        value: 'organization',
    },
    {
        icon: 'mdi-shield-account',
        text: 'Security',
        value: 'security',
    },
    {
        icon: 'mdi-eye-arrow-left',
        text: 'Appearance',
        value: 'appearance',
    },
    {
        icon: 'mdi-card-account-details',
        text: 'Billings',
        value: 'billings',
    },
    {
        icon: 'mdi-handshake-outline',
        text: 'Plan',
        value: 'plan',
    },
    {
        icon: 'mdi-cog',
        text: 'System Settings',
        value: 'settings',
    },
    {
        icon: 'mdi-math-integral-box',
        text: 'Integrations',
        value: 'integrations',
    },
]


// const tab = ref('billings');

</script>

<style scoped>
.billing-settings {
    margin: 0 auto;
}
</style>
