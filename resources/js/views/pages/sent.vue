<template>
  <v-app>
      <v-container mt-5 mb-5>
      <v-card v-if="!user.pending_friendship" height="100%">
         <v-layout>
             <v-flex
            align-center
            justify-center
            layout
            fill-height
            text-xs-center
             >
             <v-icon>message</v-icon>
              <v-card-title>No Pending Sent Invitations</v-card-title>
             </v-flex>
         </v-layout>
      </v-card>
      <v-card v-else-if="user.pending_friendship">
          <v-card-text>
              <span v-for="pending in user.pending_friendship" :key="pending.id">
            <Pending :user="pending"></Pending>
            <v-divider></v-divider>
            </span>
          </v-card-text>
      </v-card>
      </v-container>
  </v-app>
</template>
<script>
import Pending from './pendings.vue';
export default {
    components: {
     Pending
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

