<template>
  <div id="app">
    <div class="container">
      <router-view @setLoader="setLoader"></router-view>
    </div>
    <loader v-show="loading"></loader>
  </div>
</template>

<script>
import Loader from "@/components/Loader";

export default {
  name: "App",
  components: {
    Loader
  },
  data() {
    return {
      loading: false
    };
  },
  methods: {
    setLoader(val) {
      this.loading = val;
    }
  }
};
</script>

