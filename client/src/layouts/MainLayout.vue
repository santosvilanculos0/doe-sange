<script setup>
import EssentialLink from "src/components/EssentialLink.vue";
import { useAuth } from "stores/authentication";
import { ref } from "vue";
import { useRouter } from "vue-router";
const router = useRouter();
const auth = useAuth();

const links = [
  { title: "Conta", route_name: "account", icon: "person" },
  { title: "Locais de Doação", route_name: "branches", icon: "house" },
  { title: "Minhas Doações", route_name: "donations", icon: "history" },
  { title: "Minhas Marcações", route_name: "myappointments", icon: "list" },
];

const leftDrawerOpen = ref(true);
const toggleLeftDrawer = () => {
  leftDrawerOpen.value = !leftDrawerOpen.value;
};

const logout = () => {
  auth.logout();
  router.push({ name: "login" });
};
</script>

<template>
  <q-layout view="hHh LpR lFf">
    <q-header bordered class="bg-primary text-white">
      <q-toolbar>
        <q-btn dense flat round icon="menu" @click="toggleLeftDrawer" />

        <q-toolbar-title>
          <q-avatar>
            <img src="/image/red_cross.svg" />
            Doe Sangue
          </q-avatar>
        </q-toolbar-title>

        <span>{{ auth.user?.name }}</span>
      </q-toolbar>
    </q-header>

    <q-drawer show-if-above v-model="leftDrawerOpen" side="left" bordered>
      <EssentialLink
        v-for="(link, index) in links"
        :key="index"
        v-bind="link"
      />
      <div class="q-mx-sm">
        <q-btn
          class="full-width bg-red q-mx-sm"
          label="Logout"
          @click="logout"
        />
      </div>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>
