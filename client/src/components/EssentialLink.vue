<script setup>
defineProps({
  title: {
    type: String,
    required: true,
  },

  route_name: {
    type: String,
    required: true,
  },

  icon: {
    type: String,
    required: true,
  },
});
</script>

<template>
  <q-item
    clickable
    :active="route_name === $route.name"
    :active-class="'active-link'"
    :to="{ name: route_name }"
  >
    <q-item-section v-if="icon" avatar>
      <q-icon :name="icon" />
    </q-item-section>

    <q-item-section>
      <q-item-label>{{ title }}</q-item-label>
    </q-item-section>
  </q-item>
</template>
<style lang="scss">
.active-link {
  color: red;
  background-color: rgba(red, 0.04);
}
</style>
