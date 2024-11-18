<script setup>
import { nextTick, ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const recovery = ref(false);

const form = useForm({
    code: '',
    recovery_code: '',
});

const recoveryCodeInput = ref(null);
const codeInput = ref(null);
let loading = ref(false);

const toggleRecovery = async () => {
    recovery.value ^= true;
    await nextTick();

    if (recovery.value) {
        recoveryCodeInput.value.focus();
        form.code = '';
    } else {
        codeInput.value.focus();
        form.recovery_code = '';
    }
};

const submit = () => {
    loading = true
    // setTimeout(() => (loading = true), 2000)

    form.post(route('two-factor.login'));
};
</script>

<template>

<form @submit.prevent="submit">

  <v-card class="mx-auto" elevation="1" max-width="500">
    <v-card-title class="py-5 font-weight-black">Securely access your tax form</v-card-title>

    <v-card-text>
      To continue, enter a code sent to your phone or use the Google Authenticator app. If you can't access this, use the recovery code.
    </v-card-text>

    <v-card-text>
      <v-text-field id="code" v-if="! recovery" label="Enter code" ref="codeInput" single-line v-model="form.code" type="text" inputmode="numeric" variant="outlined" class="mt-1 block w-full" autofocus autocomplete="one-time-code" density="compact" placeholder="Code" prepend-inner-icon="mdi-lock-clock"></v-text-field>

      <v-text-field v-else id="recovery_code" ref="recoveryCodeInput" v-model="form.recovery_code" variant="outlined" type="text" class="mt-1 block w-full" autocomplete="one-time-code" placeholder="Recovery" prepend-inner-icon="mdi-refresh"></v-text-field>
        <p class="mt-2" style="color: red">{{ form.errors.password }} </p>
        <p class="mt-2" style="color: red">{{ form.errors.code }} </p>

      <v-btn :disabled="form.processing" :loading="form.processing" block class="text-none mb-4" color="indigo-darken-3" size="x-large" variant="flat" @click="submit">
        Verify and continue
      </v-btn>

      <v-btn block class="text-none" color="grey-lighten-3" size="x-large" variant="flat" @click.prevent="toggleRecovery">
      <template v-if="! recovery">
            Use a recovery code
        </template>

        <template v-else>
            Use an authentication code
        </template>
      </v-btn>
    </v-card-text>
  </v-card>
</form>


</template>
