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
        <div>
      <v-img
        class="mx-auto my-6"
        max-width="228"
        src="https://cdn.vuetifyjs.com/docs/images/logos/vuetify-logo-v3-slim-text-light.svg"
      ></v-img>

      <v-card
        class="mx-auto pa-12 pb-8"
        elevation="8"
        max-width="800"
        rounded="lg"
      >
    <v-row justify="center">
        <v-col
        class="mx-auto pa-12 pb-8"
        elevation="8">
            <v-card ref="form">
                <v-card-text>
                    <v-text-field v-model="form.name" :rules="[() => !!form.name || 'This field is required']" label="Full Name" placeholder="John Doe" variant="outlined" required></v-text-field>
                    <v-text-field v-model="form.address" :rules="[
                            () => !!form.address || 'This field is required',
                            () => (form.address && form.address.length <= 25) || 'Address must be less than 25 characters',
                        ]" label="Address Line" placeholder="Snowy Rock Pl" variant="outlined" counter="25" required></v-text-field>
                    <!-- Other form fields... -->


                    <v-text-field v-model="form.email" :rules="[() => !!form.email || 'This field is required']" label="Email" placeholder="" variant="outlined" required></v-text-field>


                    <v-text-field v-model="form.phone" :rules="[() => !!form.phone || 'This field is required']" label="Phone No." placeholder="" variant="outlined" required></v-text-field>


                    <v-text-field v-model="form.name" :rules="[() => !!form.name || 'This field is required']" label="Full Name" placeholder="" variant="outlined" required></v-text-field>


                    <v-text-field v-model="form.dob" :rules="[() => !!form.dob || 'This field is required']" label="Date of birth" type="date" placeholder="" variant="outlined" required></v-text-field>

                    <v-autocomplete
                        v-model="form.gender"
                        :rules="[
                            () => !!form.gender || 'This field is required',
                        ]"
                        :items="gender"
                        label="Country"
                        placeholder="Select..."
                        required
                        variant="outlined"
                    ></v-autocomplete>

                    <v-text-field
                        :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
                        :type="visible ? 'text' : 'password'"
                        label="Password"
                        density="compact"
                        placeholder="Enter your password"
                        v-model="password"
                        prepend-inner-icon="mdi-lock-outline"
                        variant="outlined"
                        @click:append-inner="visible = !visible"
                    ></v-text-field>

                    <v-text-field
                        :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
                        :type="visible ? 'text' : 'password'"
                        label="Password Confirmation"
                        density="compact"
                        placeholder="Enter your password"
                        v-model="password_confirmation"
                        prepend-inner-icon="mdi-lock-outline"
                        variant="outlined"
                        @click:append-inner="visible = !visible"
                    ></v-text-field>
                </v-card-text>
                <v-divider class="mt-12"></v-divider>
                <v-card-actions>
                    <v-btn variant="text"> Login </v-btn>
                    <v-spacer></v-spacer>
                    <v-slide-x-reverse-transition>
                        <v-tooltip v-if="formHasErrors" location="left">
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn icon class="my-0" v-bind="attrs" @click="resetForm" v-on="on">
                                    <v-icon>mdi-refresh</v-icon>
                                </v-btn>
                            </template>
                            <span>Refresh form</span>
                        </v-tooltip>
                    </v-slide-x-reverse-transition>
                    <v-btn color="primary" @click="submit" variant="outlined" :loading="loading">
                       <v-icon>mdi-account</v-icon> Register
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-col>
    </v-row>
    </v-card>
    </div>
</template>
