import "./scss/main.scss";

import Vue from "vue";
import App from "./App";

import router from "./routes";
import "./services/filters";

new Vue({
  el: "#app",
  router,
  render: h => h(App)
});
