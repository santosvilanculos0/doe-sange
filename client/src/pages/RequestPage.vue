<script setup>
import { useQuasar } from "quasar";
import http from "src/module/http";
import { useAuth } from "stores/authentication";
import { onMounted, reactive, ref } from "vue";
const auth = useAuth();
const { notify } = useQuasar();

const form = reactive({
  car_id: null,
  departure_time: null,
  departure_location: null,
  destination: null,
});

const cars = ref([]);
const errors = ref({});
const processing = ref(false);
const processingForm = ref(false);

onMounted(async () => {
  processing.value = true;
  try {
    const { data } = await http.get("/cars", {
      headers: { Authorization: `Bearer ${auth.token}` },
    });
    cars.value = data;
    console.log(data);
  } catch ({ response }) {
    if (response.status === 422) {
      notify({ message: "Erro no servidor.", type: "negative" });
    } else {
      notify({ message: response.data.message, type: "negative" });
    }
  } finally {
    processing.value = false;
  }
});

const submitForm = async () => {
  processingForm.value = true;
  try {
    const { data } = await http.post("/account/requests", form, {
      headers: { Authorization: `Bearer ${auth.token}` },
    });
    notify({ message: "Requisitado com successo", type: "positive" });

    errors.value = {};
    console.log(data);
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
</script>

<template>
  <q-page>
    <div class="container q-mx-auto q-pa-md">
      <div v-if="processing" class="flex flex-center">
        <q-spinner size="40px" />
      </div>
      <q-form @submit.prevent="submitForm" class="form | q-mx-auto">
        <q-card flat bordered class="q-pa-sm q-ma-sm">
          <q-card-section>
            <div class="text-h6">Requisitar</div>
          </q-card-section>

          <q-card-section>
            <q-select
              class="q-mb-md"
              emit-value
              map-options
              filled
              v-model="form.car_id"
              label="Carro"
              lazy-rules
              :rules="[(val) => !!val || 'Por favor digite algo.']"
              :error="!!errors?.car_id"
              :error-message="errors?.car_id?.[0]"
              required
              :options="cars.map((p) => ({ label: p.model, value: p.id }))"
            />

            <q-input
              class="q-mb-md"
              filled
              autocomplete="name"
              v-model="form.departure_time"
              label="Data e Hora"
              lazy-rules
              type="datetime-local"
              :rules="[(val) => !!val || 'Por favor digite algo.']"
              :error="!!errors?.departure_time"
              :error-message="errors?.departure_time?.[0]"
              required
            />

            <q-input
              class="q-mb-md"
              filled
              autocomplete="name"
              v-model="form.departure_location"
              label="Local de partida"
              lazy-rules
              :rules="[
                (val) => (val && val.length > 0) || 'Por favor digite algo.',
              ]"
              :error="!!errors?.departure_location"
              :error-message="errors?.departure_location?.[0]"
              required
            />

            <q-input
              class="q-mb-md"
              filled
              autocomplete="name"
              v-model="form.destination"
              label="Destino"
              lazy-rules
              :rules="[
                (val) => (val && val.length > 0) || 'Por favor digite algo.',
              ]"
              :error="!!errors?.destination"
              :error-message="errors?.destination?.[0]"
              required
            />

            <q-btn
              class="full-width"
              color="primary"
              type="submit"
              label="Enviar"
              :loading="processingForm"
              :disable="processingForm"
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
.container {
  max-width: 768px;
}
</style>
