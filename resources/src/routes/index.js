import Vue from "vue";
import Router from "vue-router";

Vue.use(Router);

import List from "@/views/Clients";
import Form from "@/views/Clients/form";

export default new Router({
  routes: [
    {
      path: "/clients",
      name: "clients",
      meta: {
        name: "Listar"
      },
      component: List
    },
    {
      path: "/clients/register",
      name: "clients.register",
      meta: {
        name: "Cadastrar"
      },
      component: Form
    },
    {
      path: "/clients/:id",
      name: "clients.edit",
      meta: {
        name: "Editar"
      },
      component: Form
    },
    {
      path: "*",
      redirect: "/clients"
    }
  ]
});
