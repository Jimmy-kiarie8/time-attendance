<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

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

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('client.login'), {
        onFinish: () => window.location.href = '/client/dashboard',
    });
};
</script>

<template>

<form @submit.prevent="submit">
    <div>
      <v-img class="mx-auto my-6" max-width="228" src="/images/logo.jpeg"></v-img>

      <v-card class="mx-auto pa-12 pb-8" elevation="8" max-width="448" rounded="lg">
        <div class="text-subtitle-1 text-medium-emphasis">Account</div>

        <v-text-field v-model="form.email" autocomplete="email" density="compact" placeholder="Email address" prepend-inner-icon="mdi-email-outline" variant="outlined"></v-text-field>
        <p class="mt-2" style="color: red">{{ form.errors.email }} </p>

        <div class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between">
          Password

          <a class="text-caption text-decoration-none text-blue" :href="route('password.request')" rel="noopener noreferrer">
            Forgot login password?</a>
        </div>

        <v-text-field density="compact" type="password" autocomplete="password" v-model="form.password" placeholder="Enter your password" prepend-inner-icon="mdi-lock-outline" variant="outlined" @click:append-inner="visible = !visible"></v-text-field>
        <p class="mt-2" style="color: red">{{ form.errors.password }} </p>

        <v-card class="mb-12" color="surface-variant" variant="tonal">
          <v-card-text class="text-medium-emphasis text-caption">
            Warning: After 3 consecutive failed login attempts, you account will be temporarily locked for three hours. If you must login now, you can also click "Forgot login password?" below to reset the login password.
          </v-card-text>
        </v-card>

        <v-btn block class="mb-8" color="blue" size="large" variant="tonal" @click="submit" :loading="form.processing">
          Log In
        </v-btn>

        <v-card-text class="text-center">

          <Link href="/register" class="text-blue text-decoration-none">
            Sign up now <v-icon icon="mdi-chevron-right"></v-icon>
          </Link>
        </v-card-text>
      </v-card>
    </div>
    </form>
</template>
