<template>
<span>
    <v-layout v-if="notification.type == 1">
                <v-flex align-center justify-center layout text-xs-center xs2>
               <v-avatar
            v-if="notification.avatar"
              color="grey lighten-4"
            >
              <img
          :src="userPic(notification.avatar)"
                alt="Avatar"
              >
            </v-avatar>
            <v-icon
              large
              style="font-size: 50px;"
                v-else
              >account_circle</v-icon>
          </v-flex>
          <v-flex xs9>
             <v-card-text><b>{{notification.first_name + " " + notification.last_name}}</b>
             <span>sent you a Connect Request</span><br/>
             <v-btn flat outline color="blue" Large> Manage all Requests</v-btn>
             </v-card-text>
          </v-flex>
          <v-divider></v-divider>
    </v-layout>
     <v-layout v-else-if="notification.type == 2">
                <v-flex align-center justify-center layout text-xs-center xs2>
               <v-avatar
            v-if="notification.avatar"
              color="grey lighten-4"
            >
              <img
          :src="userPic(notification.avatar)"
                alt="Avatar"
              >
            </v-avatar>
            <v-icon
              large
              style="font-size: 50px;"
                v-else
              >account_circle</v-icon>
          </v-flex>
          <v-flex xs6>
             <v-card-text><b>{{notification.first_name + " " + notification.last_name}}</b>
             <span>Accepted your Connect Request</span><br/>
             <v-btn flat outline color="blue" Large> See All connects</v-btn>
             </v-card-text>
          </v-flex>
          <v-divider></v-divider>
    </v-layout>
</span>
</template>
<script>
    export default {
    props:['notification'],
     data () {
    return {
       click: false,
       submitted: true,
    }
  },
  methods: {
       userPic(data){
         return '/images/users/' + data;
     },

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

