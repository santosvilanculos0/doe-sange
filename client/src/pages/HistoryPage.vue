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
    const { data } = await http.get("/account/donations", {
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
          <div class="text-h6">Doações</div>
        </q-card-section>

        <q-markup-table>
          <thead>
            <tr>
              <th class="text-left">Data</th>
              <th class="text-left">Volume (ml)</th>
              <th class="text-left">Hemoglobina (g/dL)</th>
              <th class="text-left">Pressao sanguinea (mmHg)</th>
              <th class="text-left">Tipo sanguineo</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(donation, index) in list" :key="index">
              <td>{{ donation?.created_at }}</td>
              <td>{{ donation?.volume }}</td>
              <td>{{ donation?.hemoglobin }}</td>
              <td>{{ donation?.blood_pressure }}</td>
              <td>{{ donation?.blood_type?.name }}</td>
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
