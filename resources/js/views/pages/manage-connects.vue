<template>
<v-app>
<v-toolbar fixed color="blue lighten-1">
    <v-icon @click="goBack" dark>arrow_back</v-icon>
    <v-spacer></v-spacer>
  <v-tabs slider-color="white" color="blue lighten-1" fixed-tabs>
    <v-tab to="/received" class="white--text">
      Received
    </v-tab>
    <v-tab to="/sent" class="white--text">
      Sent
    </v-tab>
  </v-tabs>
</v-toolbar>
<router-view/>
</v-app>
</template>
<script>
export default {
    props:['user'],
     data () {
    return {
       click: false,
       submitted: true,
    }
  },
  methods: {
     goBack(){
         this.$router.push('/networks');
     }
  }
}
</script>

