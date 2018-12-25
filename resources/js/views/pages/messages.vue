<template>
<v-app>
<v-container  v-if="!user.threads" mb-5>
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
              <v-card-title><h3>No threads yet</h3></v-card-title>
             </v-flex>
         </v-layout>
          </v-card-text>
      </v-card>
</v-container>
<v-card  v-else-if="user.threads != 0">
        <span  v-for="thread in user.threads" :key="thread.id" row wrap>
            <Thread :thread="thread"></Thread>
            <v-divider></v-divider>
        </span>
</v-card>
</v-app>
</template>
<script>
import Thread from './threads.vue';
export default {
    components: {
     Thread
    },
  mounted () {
    this.fetchAuthenticatedUser()
  },
     data () {
    return {

    }
  },
   computed: {
     user(){
       return this.$store.getters.getUserData;
     },
   },
  methods: {
       fetchAuthenticatedUser() {
      this.$store.dispatch( 'getUser');
    },
  }
}
</script>

