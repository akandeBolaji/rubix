<template>
<v-app>
<v-container v-if="user.friends_count">
    <v-card class="elevation-6">
    <v-layout row wrap>
        <v-flex xs12
        align-center
        justify-center
        layout
        text-xs-center
        >
           <v-card-title @click="viewConnection" v-if="user.friends_count">
            {{ user.friends_count }} <br/>
            View Connections
          </v-card-title>
        </v-flex>
    </v-layout>
    </v-card>
</v-container>

<v-container>
    <v-card class="elevation-6">
    <v-layout row wrap>
        <v-flex xs7
        >
           <v-card-title v-if="user.pending_request == 0">
             No Pending Invitations
          </v-card-title>
          <v-card-title v-else-if="user.pending_request > 0">
             {{user.pending_request.length}} Pending Invitations
          </v-card-title>
        </v-flex>
         <v-flex xs4
         offset-xs1
        >
           <v-card-title class="blue--text" @click="manageAll">
            Manage All
          </v-card-title>
        </v-flex>
    </v-layout>
    </v-card>
</v-container>

<v-container mb-5>
    <v-card class="elevation-6">
        <v-card-title>People you may know</v-card-title>
    </v-card>
    <v-divider></v-divider>
    <v-card>
    <v-layout row wrap>
        <v-flex xs6
         align-center
        justify-center
        layout
        fill-height
        text-xs-center
        v-for="user in user.all" :key="user.id"
        >
          <Suggestion :user="user"></Suggestion>
        </v-flex>
    </v-layout>
    </v-card>
</v-container>

</v-app>
</template>
<script>
import Suggestion from './suggestions.vue';
import Connect from './connects.vue';
import Request from './requests.vue';
export default {
    components: {
     Connect,
     Suggestion,
     Request
    },
  mounted () {
    this.fetchAuthenticatedUser()
  },

  data () {
    return {
    drawer: null,
      disable: false,
      listVideo: false,
      dialog: false,
      info: false,
      infotext: '',
      notShown: false,
      avatar: '',
    }
  },
  computed: {
      logoutLoadStatus(){
       return this.$store.getters.getLogoutLoadStatus;
     },
     user(){
       return this.$store.getters.getUserData;
     },
   },

   watch: {
        'logoutLoadStatus': function(){
         if(this.logoutLoadStatus == 2){
           this.dialog = false;
           this.$router.push("/login");
         }
         else if (this.logoutLoadStatus == 3){
           this.dialog = false;
            if (this.$store.getters.getLogoutMessage) {
           this.infotext = this.$store.getters.getLogoutMessage
           this.info = true;
           }
           else {
             this.infotext = 'An error Occured. Please check your network';
             this.info = true;
           };
         }
         else if (this.logoutLoadStatus == 1){
           this.dialog = true;
         }
       },
   },

  methods: {
      viewConnection() {
        this.$router.push('/connects');
      },
      manageAll() {
        this.$router.push('/received');
      },
      addConnect(id){
        this.click = true;
      },
      dashboard() {
          this.dialog = true;
          this.$router.push('/dashboard');
        },
        logout() {
          this.$store.dispatch( 'logoutUser');
        },
    fetchAuthenticatedUser() {
      this.$store.dispatch( 'getUser');
    },
  }
}
</script>
