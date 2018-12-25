<template>
  <v-layout>
       <v-flex align-center justify-center layout text-xs-center xs1>
               <v-avatar
            v-if="message.sender.avatar"
              color="grey lighten-4"
            >
              <img
          :src="userPic(message.sender.avatar)"
                alt="Avatar"
              >
            </v-avatar>
            <v-icon
              large
              style="font-size: 50px;"
                v-else
              >account_circle</v-icon>
          </v-flex>
          <v-flex xs11>
             <v-card-text><b>{{message.sender.full_name}}</b> . {{ getTime(message.created_at) }}<br/>{{ message.message }}</v-card-text>
          </v-flex>
  </v-layout>
</template>
<script>
var moment = require('moment-timezone');
export default {
    props:['message', 'user', 'authuser'],
     data () {
    return {
       click: false,
       submitted: true,
    }
  },
  methods: {

     goBack(){
         this.$router.push('/networks');
     },
     getTime(time){
         var timezone = moment.tz.guess();
         console.log(timezone);
       return moment(time).tz(timezone).format('LT');
     },
  },
  computed: {
  }
}

</script>

