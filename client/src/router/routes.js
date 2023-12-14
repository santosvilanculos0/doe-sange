const routes = [
  {
    path: "/",
    redirect: { name: "login" },
  },
  {
    path: "/",
    component: () => import("layouts/MainLayout.vue"),
    children: [
      {
        path: "/branches",
        name: "branches",
        component: () => import("pages/IndexPage.vue"),
        meta: {
          auth: true,
        },
      },
      {
        path: "/account",
        name: "account",
        component: () => import("pages/AccountPage.vue"),
        meta: {
          auth: true,
        },
      },
      {
        path: "/branches/:id",
        name: "branches.view",
        component: () => import("pages/ShowBranch.vue"),
        meta: {
          auth: true,
        },
      },
      {
        path: "appointment/branch/:id",
        name: "appointment",
        component: () => import("pages/CreateAppointment.vue"),
        meta: {
          auth: true,
        },
      },
      {
        path: "appointment",
        name: "myappointments",
        component: () => import("pages/ShowAppointments.vue"),
        meta: {
          auth: true,
        },
      },
      {
        path: "/donations",
        name: "donations",
        component: () => import("pages/HistoryPage.vue"),
        meta: {
          auth: true,
        },
      },
    ],
  },
  {
    path: "/login",
    name: "login",
    component: () => import("pages/auth/LoginPage.vue"),
    meta: {
      guest: true,
    },
  },
  {
    path: "/register",
    name: "register",
    component: () => import("pages/auth/RegisterPage.vue"),
    meta: {
      guest: true,
    },
  },
  {
    path: "/forgot_password",
    name: "forgot_password",
    component: () => import("pages/auth/ForgotPage.vue"),
    meta: {
      guest: true,
    },
  },
  {
    path: "/:catchAll(.*)*",
    component: () => import("pages/ErrorNotFound.vue"),
  },
];

export default routes;
