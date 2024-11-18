<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, watch, onMounted } from 'vue';
import { useTheme } from 'vuetify';

// Props and form setup remain the same
defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const visible = ref(false);
const theme = useTheme();
const isDark = ref(false);

// Toggle theme function
const toggleTheme = () => {
    isDark.value = !isDark.value;
    theme.global.name.value = isDark.value ? 'dark' : 'light';
};

// Watch for system theme changes (optional)
watch(
    () => isDark.value,
    (val) => {
        localStorage.setItem('theme', val ? 'dark' : 'light');
    }
);

// Initialize theme from localStorage or system preference
onMounted(() => {
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme) {
        isDark.value = savedTheme === 'dark';
        theme.global.name.value = savedTheme;
    } else {
        isDark.value = window.matchMedia('(prefers-color-scheme: dark)').matches;
        theme.global.name.value = isDark.value ? 'dark' : 'light';
    }
});

// Rest of your existing code...

const slides = ref([
    {
        title: "Welcome to the Absolute staff attendance",
        content: "Enhancing employee management for Hr and admins."
    },
    {
        title: "Key Features",
        content: "User-friendly interface, real-time employee tracking, and automated notifications."
    },
    {
        title: "Staff Responsibilities",
        content: "Manage employee attendance effectively."
    }
]);

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <v-card class="main">
        <v-container fluid class="fill-height" :class="{ 'bg-black': isDark, 'bg-white': !isDark }">
            <v-btn icon @click="toggleTheme" class="theme-toggle" position="absolute" top right>
                <v-icon>
                    {{ isDark ? 'mdi-weather-sunny' : 'mdi-weather-night' }}
                </v-icon>
            </v-btn>

            <!-- Rest of your existing template... -->
            <v-row justify="center" align="center">
                <!-- Your existing content... -->
                <v-col cols="12" sm="8" md="10">
                    <v-card class="bg-transparent" flat>
                        <v-row>
                            <!-- Login Form Section -->
                            <v-col cols="12" md="6">

                                <div class="pa-4">
                                    <!-- Logo/Brand -->
                                    <div class="mb-8" style="    text-align: center;">
                                        <img src="/images/logo/abs.jpg" alt="" style="width:250px;border-radius: 30px;margin: auto" />
                                        <!-- <h1 class="text-h4  font-weight-bold">QuickRenda</h1> -->
                                    </div>

                                    <form @submit.prevent="submit">
                                        <h2 class="text-h6  mb-6">
                                            Welcome back!
                                        </h2>

                                        <!-- Email Field -->
                                        <v-text-field v-model="form.email" label="Email" type="email" variant="outlined"
                                            placeholder="johndoe@gmail.com" :error-messages="form.errors.email" required
                                            class="mb-2"></v-text-field>

                                        <!-- Password Field -->
                                        <v-text-field v-model="form.password" label="Password"
                                            :type="visible ? 'text' : 'password'" variant="outlined"
                                            :error-messages="form.errors.password"
                                            :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
                                            @click:append-inner="visible = !visible" required
                                            class="mb-2"></v-text-field>

                                        <!-- Remember Me & Forgot Password -->
                                        <div class="d-flex justify-space-between align-center mb-6">
                                            <v-checkbox v-model="form.remember" label="Remember me" hide-details
                                                class=""></v-checkbox>
                                            <v-btn v-if="canResetPassword" :href="route('password.request')"
                                                variant="text" class="text-none">
                                                Forgot Password
                                            </v-btn>
                                        </div>

                                        <!-- Sign In Button -->
                                        <v-btn type="submit" color="#fe7c02" block height="48"
                                            :loading="form.processing" class="mb-6">
                                            Sign in
                                        </v-btn>

                                        <!-- Social Login -->


                                    </form>
                                </div>
                            </v-col>

                            <!-- Right Side Content -->
                            <v-col cols="12" md="6" class="d-none d-md-block">
                                <v-card color="#fe7c02">
                                    <v-card-text class="h-100 d-flex flex-column justify-space-between" >
                                        <!-- Testimonial Section -->
                                        <!-- <img src="/images/logo/logo.png" alt="" style="height: 150px; width:150px;margin: auto" /> -->
                                        <div>
                                            <h2 class="text-h4 font-weight-bold  mb-4">
                                                Why Choose Us?
                                            </h2>

                                            <li>Real-time: Get the employee status in real-time.</li>
                                            <li>Secure & Confidential: Your information is safe with us.</li>
                                            <br>

                                            <div class="mb-8">
                                                <p class="text-h6 font-weight-bold ">Need help?</p>
                                                <p class="text-subtitle-1  text-opacity-70">
                                                    Our support team is just a click away! <a
                                                        href="mailto:support@hillsdata.com">Contact</a> us for
                                                    assistance.
                                                </p>
                                            </div>
                                        </div>
                                        <br>


                                        <!-- Bottom Card -->
                                        <v-carousel height="220" progress="white" hide-delimiters show-arrows="hover"
                                            cycle>
                                            <v-carousel-item v-for="(slide, i) in slides" :key="i">
                                                <v-card variant="tonal" color="white">
                                                    <v-card-text>
                                                        <h3 class="text-h5 font-weight-bold  mb-2">{{
                                                            slide.title }}</h3>
                                                        <p class="text-body-1  text-opacity-70">{{
                                                            slide.content }}</p>
                                                    </v-card-text>
                                                </v-card>
                                            </v-carousel-item>
                                        </v-carousel>


                                    </v-card-text>
                                </v-card>
                            </v-col>
                        </v-row>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </v-card>
</template>

<style>
/* Your existing styles... */
.theme-toggle {
    margin: 16px;
    z-index: 1;
}

/* Adjust text colors based on theme */
:root {
    --text-color: v-bind(isDark ? '#f0f0f0' : '#000000');
}
a {
    color: #fff;
}
.v-container {
    margin-top: 3%;
    width: 60% !important;
    height: 90vh !important;
    border-radius: 20px 20px 20px 0;
    background: v-bind(isDark ? '#1E1E1E' : '#215956') !important;
}
.bg-white {
    background: #fff !important;
}
.main {
    width: 100vw;
    height: 100vh;
    background: v-bind(isDark ? '#121212' : '#f0f0f0') !important;
    border-radius: 0;
}
</style>
