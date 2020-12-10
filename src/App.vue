<template>

  <v-app id="app">
    <v-main>

      <Programa/>

    </v-main>
  </v-app>

</template>

<script>
import Programa from './components/Programa';

export default {
  name: 'App',

  components: {
    Programa,
  },

  data: () => ({
    //
  }),
};
</script>
<style>
*{ text-transform: none !important; }
#app {
    background: #7E8995;
    background: -webkit-radial-gradient(center, #7E8995, #435659);
    background: -moz-radial-gradient(center, #7E8995, #435659);
    background: radial-gradient(ellipse at center, #7E8995, #435659);
}

</style>
