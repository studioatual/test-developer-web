<template>
  <div class="pages">
    <div class="pages-title">
      <h1>Cadastro de Cliente</h1>
      <div class="pages-title-btn">
        <router-link :to="{ name: 'clients' }" class="btn default">Lista de Clientes</router-link>
      </div>
    </div>
    <div class="pages-body">
      <form @submit.prevent="validateBeforeSubmit" autocomplete="off" class="form">
        <div class="row">
          <div class="col-md-6">
            <div
              class="form-group"
              v-bind:class="{ 'form-error': errors.has('name') || error.name }"
            >
              <label for="name">Nome</label>
              <input
                type="text"
                v-model="client.name"
                v-validate="{required: true, regex: /^[a-záàâãéèêíïóôõöúçñ ]+$/i}"
                data-vv-as="Nome"
                data-vv-name="name"
                class="form-control"
              />
              <span>{{ errors.first('name') }}</span>
              <span>{{ error.name | first }}</span>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group" v-bind:class="{ 'form-error': errors.has('cpf') || error.cpf }">
              <label for="cpf_cnpj">CPF</label>
              <input
                type="text"
                v-model="client.cpf"
                v-mask="'###.###.###-##'"
                v-validate="'required|cpf'"
                data-vv-as="CPF"
                data-vv-name="cpf"
                placeholder="___.___.___-__"
                class="form-control"
              />
              <span>{{ errors.first('cpf') }}</span>
              <span>{{ error.cpf | first }}</span>
            </div>
          </div>
          <div class="col-md-3">
            <div
              class="form-group"
              v-bind:class="{ 'form-error': errors.has('phone') || error.phone }"
            >
              <label for="phone">Telefone / Celular</label>
              <input
                type="text"
                v-model="client.phone"
                v-mask="['(##) ####-####', '(##) #####-####']"
                v-validate="{required: true, regex: /\(\d{2,}\) \d{4,}\-\d{4}$/}"
                data-vv-as="Telefone / Celular"
                data-vv-name="phone"
                placeholder="(__) ____-_____"
                class="form-control"
              />
              <span>{{ errors.first('phone') }}</span>
              <span>{{ error.phone | first }}</span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div
              class="form-group"
              v-bind:class="{ 'form-error': errors.has('email') || error.email }"
            >
              <label for="email">E-mail</label>
              <input
                type="email"
                v-model="client.email"
                v-validate="'required|email'"
                data-vv-as="E-mail"
                data-vv-name="email"
                class="form-control"
              />
              <span>{{ errors.first('email') }}</span>
              <span>{{ error.email | first }}</span>
            </div>
          </div>
          <div class="col-md-3">
            <div
              class="form-group"
              v-bind:class="{ 'form-error': errors.has('birthdate') || error.birthdate }"
            >
              <label for="birthdate">Data de Nascimento</label>
              <input
                type="text"
                v-validate="'required|date_format:dd/MM/yyyy'"
                v-model="birthdate"
                v-mask="'##/##/####'"
                data-vv-name="birthdate"
                data-vv-as="Data de Nascimento"
                class="form-control"
              />
              <span>{{ errors.first('birthdate') }}</span>
              <span>{{ error.birthdate | first }}</span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-3">
            <div class="form-group" :class="{'form-error': errors.has('zipcode') || error.zipcode}">
              <label for="cep">CEP</label>
              <input
                type="text"
                v-model="client.zipcode"
                @keyup="getAddress"
                v-mask="'##.###-###'"
                v-validate="{ required:true, regex: /^\d{2}.\d{3}-\d{3}$/}"
                data-vv-name="zipcode"
                data-vv-as="CEP"
                class="form-control"
              />
              <span>{{ errors.first('zipcode') }}</span>
              <span>{{ error.zipcode | first }}</span>
            </div>
          </div>
          <div class="col-sm-7">
            <div class="form-group" :class="{'form-error': errors.has('address') || error.address}">
              <label for="address">Endereço</label>
              <input
                type="text"
                v-model="client.address"
                v-validate="'required'"
                data-vv-name="address"
                data-vv-as="Endereço"
                class="form-control"
              />
              <span>{{ errors.first('address') }}</span>
              <span>{{ error.address | first }}</span>
            </div>
          </div>
          <div class="col-sm-2">
            <div class="form-group" :class="{'form-error': errors.has('number') || error.number}">
              <label for="name">Número</label>
              <input
                type="text"
                v-model="client.number"
                v-validate="'required'"
                data-vv-name="number"
                data-vv-as="Número"
                class="form-control"
              />
              <span>{{ errors.first('number') }}</span>
              <span>{{ error.number | first }}</span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label for="name">Complemento</label>
              <input type="text" v-model="client.complement" class="form-control" />
            </div>
          </div>
          <div class="col-sm-6">
            <div
              class="form-group"
              :class="{'form-error': errors.has('district') || error.district}"
            >
              <label for="name">Bairro</label>
              <input
                type="text"
                v-model="client.district"
                v-validate="'required'"
                data-vv-name="district"
                data-vv-as="Bairro"
                class="form-control"
              />
              <span>{{ errors.first('district') }}</span>
              <span>{{ error.district | first }}</span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-7">
            <div class="form-group" :class="{'form-error': errors.has('city') || error.city}">
              <label for="name">Cidade</label>
              <input
                type="text"
                v-model="client.city"
                v-validate="'required'"
                data-vv-name="city"
                data-vv-as="Cidade"
                class="form-control"
              />
              <span>{{ errors.first('city') }}</span>
              <span>{{ error.city | first }}</span>
            </div>
          </div>
          <div class="col-sm-5">
            <div class="form-group" :class="{'form-error': errors.has('state')}">
              <label for="name">Estado</label>
              <select v-model="client.state" class="form-control">
                <option
                  v-for="(state, index) in states"
                  :key="index"
                  :value="state.sigla"
                >{{ state.name }}</option>
              </select>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="name">Observações</label>
          <textarea v-model="client.obs" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-lg" :class="classButton()">{{ nameButton() }}</button>
      </form>
    </div>
  </div>
</template>
<script>
import Swal from "sweetalert2";
import states from "@/services/states";
import api from "@/services/api";
import axios from "axios";

export default {
  name: "ClientsForm",
  data() {
    return {
      client: {
        id: null,
        name: "",
        cpf: "",
        birthdate: "",
        zipcode: "",
        address: "",
        number: "",
        complement: "",
        district: "",
        city: "",
        state: "SP",
        phone: "",
        email: "",
        obs: ""
      },
      states,
      error: []
    };
  },
  methods: {
    validateBeforeSubmit() {
      this.$validator.validateAll().then(result => {
        if (result) {
          this.setClient();
          return;
        }
        Swal.fire("Erro", "Verifique os campos com erro!", "error");
      });
    },
    async getAddress() {
      let cep = String(this.client.zipcode)
        .match(/\d+/g)
        .join("");
      if (cep.length == 8) {
        this.$emit("setLoader", true);
        let response = (await axios.get(
          "https://viacep.com.br/ws/" + cep + "/json/"
        )).data;
        this.$emit("setLoader", false);
        if (response.erro) {
          this.client.zipcode = "";
          Swal.fire("Erro", "Cep Inválido!", "error");
          return;
        }
        this.client.address = response.logradouro;
        this.client.district = response.bairro;
        this.client.city = response.localidade;
        this.client.state = response.uf;
      }
    },
    async getClient(id = null) {
      try {
        this.$emit("setLoader", true);
        const response = await api.get(`clients/${id}`);
        this.client = response.data;
        this.$emit("setLoader", false);
      } catch (err) {
        this.$emit("setLoader", false);
        console.log(err);
      }
    },
    async setClient() {
      try {
        this.$emit("setLoader", true);
        if (this.client.id) {
          await api.put(`clients/${this.client.id}`, this.client);
        } else {
          await api.post("clients", this.client);
        }
        this.$emit("setLoader", false);
        this.$router.push({ name: "clients" });
        Swal.fire("Sucesso", "Seus dados foram registrados!", "success");
      } catch (err) {
        this.$emit("setLoader", false);
        this.error = err.response.data;
      }
    },
    resetClient() {
      this.client = {
        id: null,
        name: "",
        cpf: "",
        birthdate: "",
        zipcode: "",
        address: "",
        number: "",
        complement: "",
        district: "",
        city: "",
        state: "SP",
        phone: "",
        email: "",
        obs: ""
      };
    },
    nameButton() {
      return this.client.id ? "Alterar" : "Cadastrar";
    },
    classButton() {
      return this.client.id ? "blue" : "green";
    }
  },
  computed: {
    birthdate: {
      get() {
        if (this.client.birthdate.indexOf("-") !== -1) {
          let part = this.client.birthdate.split("-");
          let formated = `${part[2]}/${part[1]}/${part[0]}`;
          this.client.birthdate = formated;
          return formated;
        }
        return this.client.birthdate;
      },
      set(value) {
        this.client.birthdate = value;
      }
    }
  },
  mounted() {
    if (this.$route.params.id) {
      this.getClient(this.$route.params.id);
    } else {
      this.resetClient();
    }
  }
};
</script>

