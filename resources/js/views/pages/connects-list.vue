<template>
<v-app>
<v-toolbar fixed color="blue lighten-1">
    <v-icon @click="goBack" dark>arrow_back</v-icon>
     <v-toolbar-title class="white--text">Connects</v-toolbar-title>
</v-toolbar>
<v-container mt-5 mb-5>
      <v-card height="100%" v-if="data.friends == 0 || data.friends == null">
          <v-card-text
          height="100%"
          >
         <v-layout row wrap>
             <v-flex
            align-center
            justify-center
            layout
            text-xs-center
             >
             <v-icon>people</v-icon><br/>
              <v-card-title><h3>No Connects</h3></v-card-title>
             </v-flex>
         </v-layout>
          </v-card-text>
      </v-card>
      <v-card v-else-if="data.friends != 0">
        <span v-for="friend in data.friends" :key="friend.id" row wrap>
            <Connect :user="friend"></Connect>
            <v-divider></v-divider>
        </span>
      </v-card>
      </v-container>
</v-app>
</template>
<script>
import Connect from './connects.vue';
export default {
    components: {
     Connect
    },
  mounted () {
      //fetch connects
      this.fetchConnects()
    //this.fetchAuthenticatedUser()
  },
     data () {
    return {
       click: false,
       data: '',
       submitted: true,
    }
  },
   computed: {
     //user(){
       //return this.$store.getters.getUserData;
     //},
     connect(){
       return this.$store.getters.getConnectData;
     },
   },
  methods: {
     fetchConnects() {
          axios.get('/api/connects').then(response =>  {
                  this.data = response.data;
                }).catch(error => {

                });
     // this.$store.dispatch( 'getConnect');
    },
     goBack(){
         this.$router.push('/networks');
     }
  }
}
</script>
