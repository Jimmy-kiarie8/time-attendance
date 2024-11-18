<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';


const form = useForm({
    name: '',
    email: '',
    phone: '',
    address: '',
    city: '',
    dob: '',
    gender: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};

const resetForm = () => {
    form.reset();
};

const errorMessages = ref('');
const formHasErrors = ref(false);
const loading = ref(false);
const visible = ref(false);

const countries = ref([
    // Your list of countries
]);


const gender = ref([
    'Male', 'Female'
]);

</script>

<template>
    <v-card class="mx-auto" max-width="600" title="User Registration">
      <v-container>
        <v-text-field v-model="form.name" color="primary" label="Full name" variant="outlined"></v-text-field>
        <p class="mt-2" style="color: red">{{ form.errors.name }} </p>

        <v-text-field v-model="form.email" color="primary" label="Email" variant="outlined"></v-text-field>
        <p class="mt-2" style="color: red">{{ form.errors.email }} </p>

        <v-text-field v-model="form.phone" color="primary" label="Phone No." variant="outlined"></v-text-field>
        <p class="mt-2" style="color: red">{{ form.errors.phone }} </p>

        <v-text-field v-model="form.address" color="primary" label="Address" variant="outlined"></v-text-field>
        <p class="mt-2" style="color: red">{{ form.errors.address }} </p>

        <v-text-field v-model="form.dob" color="primary" type="date" label="Date of birth" variant="outlined"></v-text-field>
        <p class="mt-2" style="color: red">{{ form.errors.dob }} </p>

        <v-text-field v-model="form.password" type="password" color="primary" label="Password" placeholder="Enter your password" variant="outlined"></v-text-field>
        <p class="mt-2" style="color: red">{{ form.errors.password }} </p>

        <v-text-field v-model="form.password_confirmation" type="password" color="primary" label="Password" placeholder="Enter your password" variant="outlined"></v-text-field>
        <p class="mt-2" style="color: red">{{ form.errors.password_confirmation }} </p>

        <v-checkbox v-model="form.terms" color="secondary" label="I agree to site terms and conditions"></v-checkbox>
        <p class="mt-2" style="color: red">{{ form.errors.terms }} </p>
      </v-container>

      <v-divider></v-divider>

      <v-card-actions>
        <v-spacer></v-spacer>

        <v-btn color="success"  :disabled="form.processing" :loading="form.processing" @click="submit">
          Complete Registration

          <v-icon icon="mdi-chevron-right" end></v-icon>
        </v-btn>
      </v-card-actions>


      <v-card-text class="text-center">

          <Link href="/login" class="text-blue text-decoration-none">

            Login up now <v-icon icon="mdi-chevron-right"></v-icon>
          </Link>
        </v-card-text>
    </v-card>
</template>
