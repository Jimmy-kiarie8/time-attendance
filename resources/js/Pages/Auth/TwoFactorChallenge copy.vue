<script setup>
import { nextTick, ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const recovery = ref(false);

const form = useForm({
    code: '',
    recovery_code: '',
});

const recoveryCodeInput = ref(null);
const codeInput = ref(null);

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
    form.post(route('two-factor.login'));
};
</script>

<template>

<form @submit.prevent="submit">
    <div>
      <v-img
        class="mx-auto my-6"
        max-width="228"
        src="https://cdn.vuetifyjs.com/docs/images/logos/vuetify-logo-v3-slim-text-light.svg"
      ></v-img>

      <v-card
        class="mx-auto pa-12 pb-8"
        elevation="8"
        max-width="448"
        rounded="lg"
      >
        <div v-if="! recovery">
        <div class="text-subtitle-1 text-medium-emphasis">Code</div>
            <v-text-field
                id="code"
                ref="codeInput"
                v-model="form.code"
                type="text"
                inputmode="numeric"
                variant="outlined"
                class="mt-1 block w-full"
                autofocus
                autocomplete="one-time-code"
                density="compact"
                placeholder="Code"
                prepend-inner-icon="mdi-lock-clock"
            ></v-text-field>
            <p class="mt-2" style="color: red">{{ form.errors.code }} </p>
        </div>
        <div v-else>
        <div class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between">
            Recovery Code
        </div>

        <v-text-field
            id="recovery_code"
            ref="recoveryCodeInput"
            v-model="form.recovery_code"
            variant="outlined"
            type="text"
            class="mt-1 block w-full"
            autocomplete="one-time-code"
            placeholder="Recovery"
            prepend-inner-icon="mdi-refresh"
        ></v-text-field>
        <p class="mt-2" style="color: red">{{ form.errors.password }} </p>
    </div>
        <v-btn
          block
          class="mb-8"
          color="blue"
          size="large"
          variant="tonal"
          @click="submit"
        >
          Log In
        </v-btn>
      <div class="flex items-center justify-end mt-4">
                <button type="button" class="text-sm text-gray-600 hover:text-gray-900 underline cursor-pointer" @click.prevent="toggleRecovery">
                    <template v-if="! recovery">
                        Use a recovery code
                    </template>

                    <template v-else>
                        Use an authentication code
                    </template>
                </button>
            </div>

        <v-card-text class="text-center">
          <a
            class="text-blue text-decoration-none"
            href="#"
            rel="noopener noreferrer"
            target="_blank"
          >
            Sign up now <v-icon icon="mdi-chevron-right"></v-icon>
          </a>
        </v-card-text>
      </v-card>


    </div>
    </form>
</template>
