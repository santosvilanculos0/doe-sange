<script setup>
import { useQuasar } from "quasar";
import http from "src/module/http";
import { useAuth } from "stores/authentication";
import { onMounted, ref } from "vue";
import { useRouter } from "vue-router";
const router = useRouter();
const auth = useAuth();
const { notify } = useQuasar();

const list = ref([]);
const processing = ref(false);

const cancel = async (id) => {
  try {
    const { data } = await http.put(`/account/appointments/${id}/cancel`, {
      headers: { Authorization: `Bearer ${auth.token}` },
    });
    await get();
    console.log(data);
  } catch ({ response }) {
    if (response.status === 422) {
      notify({ message: "Erro no servidor.", type: "negative" });
    } else {
      notify({ message: response.data.message, type: "negative" });
    }
  }
};

const get = async () => {
  processing.value = true;
  try {
    const { data } = await http.get("/account/appointments", {
      headers: { Authorization: `Bearer ${auth.token}` },
    });
    list.value = data;
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
};

onMounted(async () => {
  await get();
});
</script>

<template>
  <q-page>
    <div class="container q-mx-auto q-pa-md">
      <div v-if="processing" class="flex flex-center">
        <q-spinner size="40px" />
      </div>
      <q-card class="my-card" flat bordered>
        <q-card-section>
          <div class="text-h6">Doações</div>
        </q-card-section>

        <q-markup-table>
          <thead>
            <tr>
              <th class="text-left">Local</th>
              <th class="text-left">Data</th>
              <th class="text-left">Hora</th>
              <th class="text-left">Status</th>
              <th class="text-left">Ações</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(appointment, index) in list" :key="index">
              <td>{{ appointment?.branch?.name }}</td>
              <td>{{ appointment?.date }}</td>
              <td>{{ appointment?.time }}</td>
              <td>
                <span class="badge">
                  {{ appointment?.status?.name }}
                </span>
              </td>
              <td>
                <q-btn
                  label="Cancelar"
                  v-if="appointment?.status?.id === 1"
                  @click="cancel(appointment?.id)"
                />
              </td>
            </tr>
          </tbody>
        </q-markup-table>
      </q-card>
    </div>
  </q-page>
</template>

<style lang="scss" scoped>
.container {
  max-width: 768px;
}
</style>
