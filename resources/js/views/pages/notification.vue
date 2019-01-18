<template>
<v-app>
    <v-toolbar fixed color="blue lighten-1">
    <v-icon @click="goBack" dark>arrow_back</v-icon>
    <v-toolbar-title class="white--text" >Notifications</v-toolbar-title>
</v-toolbar>
<v-container  v-if="!data.notifications" mt-5 mb-5>
      <v-card height="100%">
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
              <v-card-title><h3>No Notifications yet</h3></v-card-title>
             </v-flex>
         </v-layout>
          </v-card-text>
      </v-card>
</v-container>
<v-container mt-5 mb-5  v-else-if="data.notifications != 0">
<span v-for="notification in data.notifications" :key="notification.id" row wrap>
            <Notify :notification="notification.data"></Notify>
            <v-divider></v-divider>
 </span>
</v-container>
</v-app>
</template>
<script>
import Notify from './notify.vue';
export default {
     components: {
     Notify
    },
  mounted () {
    //fetch notifications
    this.fetchNotifications()
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
  computed: {

   },

   watch: {

   },

  methods: {
      goBack() {
        this.$router.push('/feeds');
      },
    fetchNotifications() {
         axios.get('/api/notifications').then(response =>  {
                  this.data = response.data;
                }).catch(error => {

                });
    },

    addAvatar() {
      this.$refs.file.click();
    },

  }
}
</script>
