<script setup>
import { useQuasar } from "quasar";
import http from "src/module/http";
import { email } from "src/module/validation";
import { useAuth } from "src/stores/authentication";
import { reactive, ref } from "vue";
import { useRouter } from "vue-router";
const router = useRouter();
const auth = useAuth();

const { notify } = useQuasar();

const input = reactive({
  name: null,
  email: null,
  password: null,
  password_confirmation: null,
});

const errors = ref({});
const processing = ref(false);
const isPwd = ref(true);

const POST = async () => {
  processing.value = true;
  try {
    const { data } = await http.post("/register", input);
    auth.setToken(data?.token);
    auth.setUser(data?.user);
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
              class="q-mb-md"
              outlined
              v-model="input.name"
              label="Nome"
              square
              lazy-rules
              :rules="[
                (val) => (val && val.length > 0) || 'Por favor digite algo.',
              ]"
              :error="!!errors?.name"
              :error-message="errors?.name?.[0]"
              required
            />

            <q-input
              class="q-mb-md"
              outlined
              v-model="input.email"
              square
              label="Email"
              lazy-rules
              :rules="[
                (val) => (val && val.length > 0) || 'Por favor digite algo.',
                (val) => email(val) || 'Deve ser um email válido.',
              ]"
              :error="!!errors?.email"
              :error-message="errors?.email?.[0]"
              required
            />

            <q-input
              class="q-mb-md"
              outlined
              v-model="input.password"
              label="Palavra-passe"
              lazy-rules
              :type="isPwd ? 'password' : 'text'"
              :rules="[
                (val) => (val && val.length > 0) || 'Por favor digite algo.',
              ]"
              :error="!!errors?.password"
              square
              :error-message="errors?.password?.[0]"
              required
            >
              <template v-slot:append>
                <q-icon
                  :name="isPwd ? 'visibility_off' : 'visibility'"
                  class="cursor-pointer"
                  @click="isPwd = !isPwd"
                />
              </template>
            </q-input>

            <q-input
              class="q-mb-md"
              outlined
              v-model="input.password_confirmation"
              square
              label="Confirmar Palavra-passe"
              lazy-rules
              :type="isPwd ? 'password' : 'text'"
              :rules="[
                (val) => (val && val.length > 0) || 'Por favor digite algo.',
              ]"
              :error="!!errors?.password_confirmation"
              :error-message="errors?.password_confirmation?.[0]"
              required
            />

            <div class="column" style="gap: 12px">
              <q-btn
                color="primary"
                type="submit"
                square
                label="Registar"
                :loading="processing"
              >
                <template v-slot:loading>
                  <q-spinner :size="24" />
                </template>
              </q-btn>

              <q-separator inset />

              <q-btn
                square
                :to="{ name: 'login' }"
                color="secondary"
                type="button"
                label="Fazer login"
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
