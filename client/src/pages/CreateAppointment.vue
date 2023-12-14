<script setup>
import { useQuasar } from "quasar";
import http from "src/module/http";
import { useAuth } from "stores/authentication";
import { onMounted, reactive, ref } from "vue";
import { useRoute, useRouter } from "vue-router";
const router = useRouter();
const route = useRoute();
const auth = useAuth();
const { notify } = useQuasar();

const branch = ref({});
const processing = ref(false);
const processingForm = ref(false);
const errors = ref({});
const form = reactive({
  date: null,
  time: null,
});

const submitForm = async () => {
  processingForm.value = true;
  try {
    const { data } = await http.post(
      `/branches/${route.params?.id}/appointments`,
      form,
      { headers: { Authorization: `Bearer ${auth.token}` } }
    );
    errors.value = {};
    notify({ message: "Marcação feita com sucesso.", type: "positive" });
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
    processingForm.value = false;
  }
};

onMounted(async () => {
  processing.value = true;
  try {
    const { data } = await http.get(`/branches/${route.params.id}`, {
      headers: { Authorization: `Bearer ${auth.token}` },
    });
    branch.value = data.data;
    console.log(data);
  } catch ({ response }) {
    if (response.status === 422) {
      notify({ message: "Erro no servidor.", type: "negative" });
    } else if (response.status === 404) {
      router.push("/404");
    } else {
      notify({ message: response.data.message, type: "negative" });
    }
  } finally {
    processing.value = false;
  }
});
</script>

<template>
  <q-page>
    <div class="container q-mx-auto q-pa-md">
      <div v-if="processing" class="flex flex-center">
        <q-spinner size="40px" />
      </div>
      <q-form @submit.prevent="submitForm">
        <q-card flat bordered square class="q-pa-md q-ma-md">
          <q-input
            class="q-mb-md"
            disable
            outlined
            square
            :model-value="branch?.name"
            :error="!!errors?.branch_id"
            :error-message="errors?.branch_id?.[0]"
            label="Ponto de coleta"
          />
          <q-input
            class="q-mb-md"
            outlined
            v-model="form.date"
            label="Data"
            square
            lazy-rules
            :rules="[(val) => !!val || 'Por favor digite algo.']"
            :error="!!errors?.date"
            :error-message="errors?.date?.[0]"
            required
            type="date"
          />
          <q-input
            class="q-mb-md"
            outlined
            v-model="form.time"
            square
            label="Hora"
            lazy-rules
            :rules="[(val) => !!val || 'Por favor digite algo.']"
            :error="!!errors?.time"
            :error-message="errors?.time?.[0]"
            required
            type="time"
            hint="Pontes de coleta abertos das 7 as 15:30"
          />

          <q-btn
            color="primary"
            type="submit"
            square
            label="Enviar"
            :loading="processingForm"
          >
            <template v-slot:loading>
              <q-spinner :size="24" />
            </template>
          </q-btn>
        </q-card>
      </q-form>
    </div>
  </q-page>
</template>

<style lang="scss" scoped>
.container {
  max-width: 768px;
}
</style>
