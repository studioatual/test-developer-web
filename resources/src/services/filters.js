import Vue from "vue";

import Vue2Filters from "vue2-filters";
import VueTheMask from "vue-the-mask";

Vue.use(Vue2Filters);
Vue.use(VueTheMask);

import VeeValidator, { Validator } from "vee-validate";
import CpfValidator from "../validators/cpf.validator";
import Dictionary from "../validators/dictionary";

Validator.extend("cpf", CpfValidator);
Vue.use(VeeValidator, { locale: "pt", dictionary: Dictionary });

Vue.filter("first", value => {
  if (value) {
    if (value.length > 0) {
      return value[0];
    }
  }
  return "";
});
