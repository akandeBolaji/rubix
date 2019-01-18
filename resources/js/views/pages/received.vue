<template>
  <v-app>
      <v-container mt-5 mb-5>
      <v-card height="100%" v-if="data.pending_request == 0">
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
      <v-card v-else-if="data.pending_request != 0">
        <span v-for="request in data.pending_request" :key="request.id" row wrap>
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
    this.fetchReceived()
    //this.fetchAuthenticatedUser()
  },

  data () {
    return {
    drawer: null,
      disable: false,
      listVideo: false,
      dialog: false,
      data: '',
      info: false,
      infotext: '',
      notShown: false,
      avatar: '',
    }
  },


  methods: {
    fetchReceived() {
         axios.get('/api/received').then(response =>  {
                  this.data = response.data;
                }).catch(error => {

                });
    },

  }
}
</script>

