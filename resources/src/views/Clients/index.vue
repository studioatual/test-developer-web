<template>
  <div class="pages">
    <div class="pages-title">
      <h1>Lista de Clientes</h1>
      <div class="pages-title-btn">
        <router-link :to="{ name: 'clients.register' }" class="btn green">Novo Cliente</router-link>
      </div>
    </div>
    <div class="pages-body">
      <search-container :query="query" @search="search" @changeResultPage="changeResultPage" />
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <th class="align-center" style="width: 50px; min-width: 50px; max-width: 50px;">
              <span
                @click="setOrder('id')"
                class="title"
                :class="{ 'title-red': query.order == 'id' }"
              >
                Id
                <i class="fa fa-arrows-alt-v"></i>
              </span>
            </th>
            <th width="50%" class="align-left">
              <span
                @click="setOrder('name')"
                class="title"
                :class="{ 'title-red': query.order == 'name' }"
              >
                Nome
                <i class="fa fa-arrows-alt-v"></i>
              </span>
            </th>
            <th class="align-center" width="30%">
              <span
                @click="setOrder('email')"
                class="title"
                :class="{ 'title-red': query.order == 'email' }"
              >
                E-mail
                <i class="fa fa-arrows-alt-v"></i>
              </span>
            </th>
            <th class="align-center" width="20%">
              <span
                @click="setOrder('cpf')"
                class="title"
                :class="{ 'title-red': query.order == 'cpf' }"
              >
                CPF
                <i class="fa fa-arrows-alt-v"></i>
              </span>
            </th>
            <th class="align-center" style="width: 70px; min-width: 70px; max-width: 70px;">
              <a href="#" @click="refresh()" title="Atualizar" class="btn btn-sm orange">
                <i class="fa fa-sync-alt"></i>
              </a>
            </th>
          </tr>
        </thead>
        <tbody id="tablelist">
          <tr v-for="item in list" v-bind:key="item.id">
            <td
              class="align-center"
              style="width: 50px; min-width: 50px; max-width: 50px;"
            >{{ item.id }}</td>
            <td width="50%" class="align-left">{{ item.name }}</td>
            <td class="align-center" width="30%">{{ item.email }}</td>
            <td class="align-center" width="20%">{{ item.cpf }}</td>
            <td class="align-center nopad" style="width: 70px; min-width: 70px; max-width: 70px;">
              <router-link
                :to="{
                  name: 'clients.edit',
                  params: { id: item.id },
                }"
                title="Editar"
                class="btn btn-sm blue btn-margin"
              >
                <i class="fa fa-edit"></i>
              </router-link>
              <a href="#" @click="remove(item.id)" title="Remover" class="btn btn-sm red">
                <i class="fa fa-trash"></i>
              </a>
            </td>
          </tr>
        </tbody>
      </table>
      <pagination :current_page="current_page" :total_page="total_page" @changePage="changePage" />
    </div>
  </div>
</template>
<script>
import SearchContainer from "@/components/SearchContainer";
import Pagination from "@/components/Pagination";
import api from "@/services/api";
import Swal from "sweetalert2";

export default {
  name: "Clients",
  components: {
    SearchContainer,
    Pagination
  },
  data() {
    return {
      query: {
        page: 1,
        per_page: 10,
        order: "id",
        direction: "desc",
        search: "",
        type: "name"
      },
      list: [],
      current_page: 1,
      per_page: 10,
      total: 0
    };
  },
  methods: {
    refresh() {
      this.query = {
        page: 1,
        per_page: 10,
        order: "id",
        direction: "desc",
        search: "",
        type: "name"
      };
      this.getList();
    },
    changePage(page) {
      this.query.page = page;
      this.getList();
    },
    changeResultPage() {
      this.query.page = 1;
      this.search();
    },
    search() {
      this.query.page = 1;
      this.getList();
    },
    setOrder(order) {
      if (order != this.query.order) {
        this.query.order = order;
      }
      this.query.direction = this.query.direction == "desc" ? "asc" : "desc";
      this.getList();
    },
    async getList() {
      try {
        let params = "?";
        params += `page=${this.query.page}`;
        params += `&per_page=${this.query.per_page}`;
        params += `&order=${this.query.order}`;
        params += `&direction=${this.query.direction}`;
        if (this.query.search != "") {
          params += `&search=${this.query.search}`;
          params += `&type=${this.query.type}`;
        }
        this.$emit("setLoader", true);
        const response = (await api.get(`clients${params}`)).data;
        this.list = response.data;
        this.current_page = response.current_page;
        this.per_page = response.per_page;
        this.total = response.total;
        this.$emit("setLoader", false);
      } catch (err) {
        this.$emit("setLoader", false);
        console.log(err);
      }
    },
    remove(id) {
      Swal.fire({
        title: "Confirmar Exclusão",
        text: "Deseja Realmente excluir esse item?",
        type: "question",
        showCancelButton: true,
        confirmButtonColor: "#c70000",
        confirmButtonText: "Sim, Excluir",
        cancelButtonColor: "#1C7CD5",
        cancelButtonText: "Não"
      }).then(result => {
        if (result.value) {
          this.delItem(id);
        }
      });
    },
    async delItem(id) {
      try {
        this.$emit("setLoader", true);
        await api.delete(`clients/${id}`);
        this.$emit("setLoader", false);
        Swal.fire(
          "Sucesso",
          "Item removido do banco de dados!",
          "success"
        ).then(result => {
          this.getList();
        });
      } catch (err) {
        console.log(err);
      }
    }
  },
  computed: {
    total_page() {
      if (this.total != 0) {
        return this.total % this.per_page == 0
          ? this.total / this.per_page
          : Math.floor(this.total / this.per_page) + 1;
      }
      return 0;
    }
  },
  mounted() {
    this.getList();
  }
};
</script>

