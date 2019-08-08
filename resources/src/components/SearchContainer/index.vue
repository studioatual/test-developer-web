<template>
  <div class="search">
    <form @submit.prevent="search()">
      <input type="text" v-model="query.search" placeholder="Pesquise Aqui..." />
      <select v-model="query.type">
        <option value="id">Id</option>
        <option value="name">Nome</option>
        <option value="email">E-mail</option>
        <option value="cpf">CPF</option>
        <option value="phone">Telefone</option>
      </select>
      <button type="submit">
        <i class="fa fa-search"></i>
      </button>
    </form>
    <div class="resultpage">
      <label for="per_page">Resultados:</label>
      <select name="per_page" @change="changeResultPage()" v-model="query.per_page">
        <option value="5">5</option>
        <option value="10">10</option>
        <option value="15">15</option>
        <option value="20">20</option>
        <option value="30">30</option>
        <option value="40">40</option>
        <option value="50">50</option>
        <option value="100">100</option>
      </select>
    </div>
  </div>
</template>

<script>
export default {
  name: "SearchContainer",
  props: ["query"],
  methods: {
    search() {
      this.$emit("search");
    },
    changeResultPage() {
      this.$emit("changeResultPage");
    }
  }
};
</script>

