<script setup>
import { useQuasar } from "quasar";
import http from "src/module/http";
import { email } from "src/module/validation";
import { useAuth } from "stores/authentication";
import { onMounted, reactive, ref } from "vue";
import { useRouter } from "vue-router";
const router = useRouter();
const auth = useAuth();
const { notify } = useQuasar();

/**
 * ==================
 */
const form1 = reactive({
  name: null,
  email: null,
});
const errorsForm1 = ref({});
const processingForm1 = ref(false);
const submitForm1 = async () => {
  processingForm1.value = true;
  try {
    const { data } = await http.put("/account", form1, {
      headers: { Authorization: `Bearer ${auth.token}` },
    });
    notify({ message: "Atualizado com successo", type: "positive" });

    errorsForm1.value = {};
    console.log(data);
  } catch ({ response }) {
    if (response.status === 422) {
      errorsForm1.value = response.data.errors;
    } else {
      errorsForm1.value = {};
      notify({ message: response.data.message, type: "negative" });
    }
  } finally {
    processingForm1.value = false;
  }
};

/**
 * ==============================
 */
const form2 = reactive({
  current_password: null,
  new_password: null,
  new_password_confirmation: null,
});
const errorsForm2 = ref({});
const processingForm2 = ref(false);
const isPwd = ref(true);
const isPwd2 = ref(true);

const submitForm2 = async () => {
  processingForm2.value = true;
  try {
    const { data } = await http.put("/account/password", form2, {
      headers: { Authorization: `Bearer ${auth.token}` },
    });
    errorsForm2.value = {};
    console.log(data);
    notify({
      message: "Palavra-passe atualizada com successo",
      type: "positive",
    });
  } catch ({ response }) {
    if (response.status === 422) {
      errorsForm2.value = response.data.errors;
      if (response.data?.message) {
        notify({
          message: response.data.message,
          type: "negative",
        });
      }
    } else {
      errorsForm2.value = {};
      notify({ message: response.data.message, type: "negative" });
    }
  } finally {
    processingForm2.value = false;
  }
};

/**
 * ==================
 */
onMounted(async () => {
  processingForm1.value = true;
  try {
    const { data } = await http.get("/user", {
      headers: { Authorization: `Bearer ${auth.token}` },
    });
    form1.name = data?.name;
    form1.email = data?.email;
    console.log(data);
  } catch ({ response }) {
    if (response.status === 422) {
      notify({ message: "Erro no servidor.", type: "negative" });
    } else {
      notify({ message: response.data.message, type: "negative" });
    }
    router.push({ name: "branches" });
  } finally {
    processingForm1.value = false;
  }
});
</script>

<template>
  <q-page>
    <div class="container column q-pt-md">
      <q-form @submit.prevent="submitForm1" class="form">
        <q-card flat bordered square class="q-pa-sm q-ma-sm">
          <q-card-section>
            <div class="text-h6">Perfil</div>
          </q-card-section>

          <q-card-section>
            <q-input
              class="q-mb-md"
              filled
              autocomplete="name"
              v-model="form1.name"
              label="Nome"
              lazy-rules
              :rules="[
                (val) => (val && val.length > 0) || 'Por favor digite algo.',
              ]"
              :error="!!errorsForm1?.name"
              :error-message="errorsForm1?.name?.[0]"
            />

            <q-input
              class="q-mb-md"
              filled
              autocomplete="email"
              v-model="form1.email"
              label="Email"
              lazy-rules
              type="email"
              :rules="[
                (val) => (val && val.length > 0) || 'Por favor digite algo.',
                (val) => email(val) || 'Deve ser um email válido.',
              ]"
              :error="!!errorsForm1?.email"
              :error-message="errorsForm1?.email?.[0]"
            />

            <q-btn
              class="full-width"
              color="primary"
              type="submit"
              label="Enviar"
              :loading="processingForm1"
              :disable="processingForm1"
            >
              <template v-slot:loading>
                <q-spinner :size="24" />
              </template>
            </q-btn>
          </q-card-section>
        </q-card>
      </q-form>

      <q-form @submit.prevent="submitForm2" class="form q-mt-md">
        <q-card flat square bordered class="q-pa-sm q-ma-sm">
          <q-card-section>
            <div class="text-h6">Palavra-passe</div>
          </q-card-section>

          <q-card-section>
            <q-input
              class="q-mb-md"
              filled
              v-model="form2.current_password"
              autocomplete="current-password"
              label="Palavra-passe atual"
              lazy-rules
              :type="isPwd ? 'password' : 'text'"
              :rules="[
                (val) => (val && val.length > 0) || 'Por favor digite algo.',
              ]"
              :error="!!errorsForm2?.current_password"
              :error-message="errorsForm2?.current_password?.[0]"
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
              filled
              v-model="form2.new_password"
              autocomplete="new-password"
              label="Nova Palavra-passe"
              lazy-rules
              :type="isPwd2 ? 'password' : 'text'"
              :rules="[
                (val) => (val && val.length > 0) || 'Por favor digite algo.',
              ]"
              :error="!!errorsForm2?.new_password"
              :error-message="errorsForm2?.new_password?.[0]"
            >
              <template v-slot:append>
                <q-icon
                  :name="isPwd2 ? 'visibility_off' : 'visibility'"
                  class="cursor-pointer"
                  @click="isPwd2 = !isPwd2"
                />
              </template>
            </q-input>

            <q-input
              class="q-mb-md"
              filled
              v-model="form2.new_password_confirmation"
              autocomplete="current-password"
              label="Confirmar Nova Palavra-passe"
              lazy-rules
              :type="isPwd2 ? 'password' : 'text'"
              :rules="[
                (val) => (val && val.length > 0) || 'Por favor digite algo.',
              ]"
            >
            </q-input>

            <q-btn
              class="full-width"
              color="primary"
              type="submit"
              label="Alterar palavra-passe"
              :loading="processingForm2"
            >
              <template v-slot:loading>
                <q-spinner :size="24" />
              </template>
            </q-btn>
          </q-card-section>
        </q-card>
      </q-form>
    </div>
  </q-page>
</template>

<style lang="scss" scoped>
.q-page {
  background-image: url("/image/image_1.jpg");
  background-repeat: no-repeat;
  background-size: cover;
}
</style>
