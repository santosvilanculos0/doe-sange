<script setup>
import { useQuasar } from "quasar";
import http from "src/module/http";
import { email } from "src/module/validation";
import { reactive, ref } from "vue";

const { notify } = useQuasar();

const input = reactive({
  email: null,
});

const errors = ref({});
const processing = ref(false);

const POST = async () => {
  processing.value = true;
  try {
    const response = await http.post("/forgot-password", input);
    console.log(response);
  } catch ({ response }) {
    if (response.status === 422) {
      errors.value = response.data.errors;
    } else {
      errors.value = {};
      notify(response.data.message);
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
            <q-card-section class="q-pa-none q-mb-sm">
              Esqueceu sua senha? Sem problemas. Basta nos informar seu endereço
              de e-mail e enviaremos por e-mail um link de redefinição de senha
              que permitirá que você escolha uma nova.
            </q-card-section>

            <q-card-section class="q-pa-none">
              <q-input
                square
                class="q-mb-md"
                outlined
                v-model="input.email"
                label="Email"
                lazy-rules
                :rules="[
                  (val) => (val && val.length > 0) || 'Por favor digite algo.',
                  (val) => email(val) || 'Deve ser um email válido.',
                ]"
                :error="!!errors?.email"
                :error-message="errors?.email?.[0]"
              />

              <div class="column" style="gap: 12px">
                <q-btn
                  color="primary"
                  type="submit"
                  label="Enviar o link"
                  :loading="processing"
                  square
                >
                  <template v-slot:loading>
                    <q-spinner :size="24" />
                  </template>
                </q-btn>

                <q-separator inset />

                <q-btn
                  :to="{ name: 'login' }"
                  color="secondary"
                  type="button"
                  label="Fazer login"
                />
              </div>
            </q-card-section>
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
