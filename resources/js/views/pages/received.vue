<template>
  <v-app>
      <v-container mt-5 mb-5>
      <v-card height="100%" v-if="user.pending_request == 0">
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
             <v-icon>message</v-icon><br/>
              <v-card-title><h3>No Pending Invitations</h3></v-card-title>
             </v-flex>
         </v-layout>
          </v-card-text>
      </v-card>
      <v-card v-else-if="user.pending_request != 0">
        <span v-for="request in user.pending_request" :key="request.id" row wrap>
            <Request :user="request"></Request>
            <v-divider></v-divider>
        </span>
      </v-card>
      </v-container>
  </v-app>
</template>
<script>
import Request from './requests.vue';
export default {
    components: {
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
     user(){
       return this.$store.getters.getUserData;
     },
   },

   watch: {

   },

  methods: {
    userPic(data){
         return 'http://rubix.site/images/users/' + data;
     },
    fetchAuthenticatedUser() {
      this.$store.dispatch( 'getUser');
    },
  }
}
</script>

