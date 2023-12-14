<script setup>
import { useQuasar } from "quasar";
import http from "src/module/http";
import { useAuth } from "stores/authentication";
import { onMounted, ref } from "vue";
import { useRoute, useRouter } from "vue-router";
const router = useRouter();
const route = useRoute();
const auth = useAuth();
const { notify } = useQuasar();

const branch = ref({});
const processing = ref(false);

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
      <q-card class="my-card">
        <img
          :src="branch?.image"
          style="aspect-ratio: 16/9; display: block; object-fit: cover"
        />

        <q-card-section>
          <div class="text-h6 text-grey-10">{{ branch?.name }}</div>
          <div class="text-subtitle2 text-grey-8">
            {{ branch?.address }}
          </div>
        </q-card-section>

        <q-card-section>
          <q-btn
            label="Marcar doação"
            color="primary"
            :to="{ name: 'appointment', params: { id: branch?.id } }"
          />
        </q-card-section>
      </q-card>
    </div>
  </q-page>
</template>

<style lang="scss" scoped>
.container {
  max-width: 768px;
}
</style>
