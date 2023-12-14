<script setup>
import { useQuasar } from "quasar";
import { email } from "src/module/validation";
import { useAuth } from "stores/authentication";
import { reactive, ref } from "vue";
import { useRouter } from "vue-router";
const router = useRouter();
const auth = useAuth();

const { notify } = useQuasar();

const input = reactive({
  email: null,
  password: null,
  device_name: "UNNAMED",
});

const errors = ref({});
const processing = ref(false);
const isPwd = ref(true);

const POST = async () => {
  processing.value = true;
  try {
    const { data } = await auth.login(input);
    errors.value = {};
    router.push({ name: "branches" });
  } catch (error) {
    if (error?.response) {
      if (error.response.status === 422) {
        errors.value = error.response.data.errors;
      } else {
        errors.value = {};
        notify({ message: error.response.data.message, type: "negative" });
      }
    } else {
      notify({ message: "Erro do sistema.", type: "negative" });
      console.log(error);
    }
  } finally {
    processing.value = false;
  }
};
</script>

<template>
  <q-layout view="lHr lpR lFr">
    <q-header bordered class="bg-white"></q-header>

    <q-page-container>
      <q-page class="flex items-center">
        <q-form @submit.prevent="POST" class="form | q-mx-auto">
          <div class="flex flex-center">
            <q-img
              src="/image/red_cross.svg"
              fit="contain"
              style="height: 64px; aspect-ratio: 1; object-fit: contain"
            />
          </div>
          <q-card flat class="q-pa-md q-ma-md">
            <q-input
              square
              class="q-mb-md"
              autocomplete="email"
              v-model="input.email"
              label="Email"
              outlined
              lazy-rules
              :rules="[
                (val) => (val && val.length > 0) || 'Por favor digite algo.',
                (val) => email(val) || 'Deve ser um email válido.',
              ]"
              :error="!!errors?.email"
              :error-message="errors?.email?.[0]"
            />

            <q-input
              square
              class="q-mb-md"
              v-model="input.password"
              autocomplete="current-password"
              outlined
              label="Palavra-passe"
              lazy-rules
              :type="isPwd ? 'password' : 'text'"
              :rules="[
                (val) => (val && val.length > 0) || 'Por favor digite algo.',
              ]"
            >
              <template v-slot:append>
                <q-icon
                  :name="isPwd ? 'visibility_off' : 'visibility'"
                  class="cursor-pointer"
                  @click="isPwd = !isPwd"
                />
              </template>
            </q-input>

            <div class="column" style="gap: 12px">
              <q-btn
                square
                color="primary"
                type="submit"
                label="Autenticar"
                :loading="processing"
                :disable="processing"
              >
                <template v-slot:loading>
                  <q-spinner :size="24" />
                </template>
              </q-btn>

              <q-btn
                :to="{ name: 'forgot_password' }"
                color="secondary"
                type="button"
                label="Esqueci a palavra-passe"
                flat
              />

              <q-separator inset />

              <q-btn
                :to="{ name: 'register' }"
                color="secondary"
                type="button"
                label="Criar uma conta"
              />
            </div>
          </q-card>
        </q-form>
      </q-page>
    </q-page-container>

    <q-footer bordered class="bg-white"></q-footer>
  </q-layout>
</template>

<style lang="scss" scoped>
.form {
  width: 100%;
  max-width: 408px;
}
</style>
