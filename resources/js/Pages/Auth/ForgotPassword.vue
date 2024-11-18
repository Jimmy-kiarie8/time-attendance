<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import { ref } from 'vue';

defineProps({
    status: String,
});

const form = useForm({
    email: '',
});

let loading = ref(false)

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>

<form @submit.prevent="submit">


<v-card class="mx-auto" elevation="1" max-width="500">
  <v-card-title class="py-5 font-weight-black">Securely manage your orders</v-card-title>

  <v-card-text>
    To continue, enter a code sent to your phone or use the Google Authenticator app. If you can't access this, use the recovery code.
  </v-card-text>

  <v-card-text>

    <div v-if="status" style="color: #49c170">
        {{ status }}
    </div>
    <br />
    <v-text-field id="code" label="Enter Email" v-model="form.email" type="text" inputmode="numeric" variant="outlined" class="mt-1 block w-full" autofocus autocomplete="email" density="compact" placeholder="" prepend-inner-icon="mdi-email"></v-text-field>
    <InputError class="mt-2" :message="form.errors.email" style="color: #d71818" />
    <br />

    <v-btn :disabled="form.processing" :loading="form.processing" block class="text-none mb-4" color="indigo-darken-3" size="x-large" variant="flat" @click="submit">
      Reset
    </v-btn>

  </v-card-text>

  <v-card-text class="text-center">
          
          <Link href="/login" class="text-blue text-decoration-none">
            
            Login up now <v-icon icon="mdi-chevron-right"></v-icon>
          </Link>
        </v-card-text>
</v-card>
</form>


<!-- 
    <Head title="Forgot Password" />

    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo />
        </template>

        <div class="mb-4 text-sm text-gray-600">
            Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
        </div>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="email" value="Email" />
                <TextInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full"
                    required
                    autofocus
                    autocomplete="username"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Email Password Reset Link
                </PrimaryButton>
            </div>
        </form>
    </AuthenticationCard> -->
</template>
