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

onMounted(async () => {
  processing.value = true;
  try {
    const { data } = await http.get("/account/trips", {
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
          <div class="text-h6">Minha viagens</div>
        </q-card-section>

        <q-markup-table>
          <thead>
            <tr>
              <th class="text-left">Modelo do carro</th>
              <th class="text-left">Local de partida</th>
              <th class="text-left">Destino</th>
              <th class="text-left">Data de partida</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(trip, index) in list" :key="index">
              <td>{{ trip?.car?.model }}</td>
              <td>{{ trip?.departure_location }}</td>
              <td>{{ trip?.destination }}</td>
              <td>{{ trip?.departure_time }}</td>
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
