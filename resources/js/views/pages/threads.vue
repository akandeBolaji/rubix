<template>
 <v-layout @click="openThread(thread.withUser.id)">
                <v-flex align-center justify-center layout text-xs-center xs2>
               <v-avatar
            v-if="thread.withUser.avatar"
              color="grey lighten-4"
            >
              <img
          :src="userPic(thread.withUser.avatar)"
                alt="Avatar"
              >
            </v-avatar>
            <v-avatar
            v-else
              color="grey lighten-4"
            >
              <img
          :src="userAv(thread.withUser.id)"
                alt="Avatar"
              >
            </v-avatar>
          </v-flex>
          <v-flex xs6>
             <v-card-text><b> {{thread.withUser.first_name + " " + thread.withUser.last_name}}</b><br/>
             <span v-if="thread.thread.message">
            <span v-if="thread.thread.message.length >= 40">
                 <span v-if="user.id == thread.thread.sender.id">You : {{thread.thread.message.substring(0, 40)}} ...</span>
                 <span v-else-if="thread.thread.sender.type == 'admin'" v-html="thread.thread.message.substring(0, 50)"></span>
                 <span v-else>
                     {{thread.thread.message.substring(0, 40)}} ...
                  </span>
            </span>
             <span v-else>
               <span v-if="user.id == thread.thread.sender.id">You : {{thread.thread.message}}</span>
               <span v-else-if="thread.thread.sender.type == 'admin'" v-html="thread.thread.message"></span>
               <span v-else>{{thread.thread.message}}</span>
             </span>
             </span>
             <span v-else-if="thread.thread.file">
                 <span v-if="user.id == thread.thread.sender.id">You : <v-icon size="20px">file_upload</v-icon> file</span>
                 <span v-else>
                     <v-icon size="20px">file_upload</v-icon> file
                  </span>
             </span>
             <span v-else-if="thread.thread.image">
                 <span v-if="user.id == thread.thread.sender.id">You : <v-icon size="20px">image</v-icon> image </span>
                 <span v-else>
                     <v-icon size="20px">image</v-icon> image
                  </span>
             </span>
             </v-card-text>
          </v-flex>
           <v-flex v-if="user.id != thread.thread.sender.id && thread.thread.is_seen == 0 && thread.thread.updated_at != 2" align-center justify-center layout text-xs-center offset-xs2 xs2>
             <v-avatar size="30px" color="blue lighten-2" class="white--text">{{ thread.unread }} </v-avatar>
          </v-flex>
          <v-flex v-else-if="thread.thread.updated_at == 2" align-center justify-center layout text-xs-center xs4>
             <span style="color:blue;"><i>typing</i></span>
          </v-flex>
          <v-flex v-else align-center justify-center layout text-xs-center xs4>
              {{ getTime(thread.thread.created_at)}}
          </v-flex>
          <v-divider></v-divider>
    </v-layout>
</template>
<script>
var moment = require('moment-timezone');
export default {
    props:['thread', 'user'],
     data () {
    return {

    }
  },
  methods: {
             userAv(id){
         return `https://robohash.org/${id}`;
     },
      getTime(time){
         var timezone = moment.tz.guess();
         console.log(timezone);
          return moment.utc(time).local().format('LT')
        //return moment(time).tz(timezone).format('LT');
        //return moment().utc(timezone).local().format('LT');
     },
       userPic(data){
         return '/images/users/' + data;
     },
      openThread(id){
           //this.$router.push({ path: '/conversation', query: { id: this.$route.query.id }})
          this.$router.push(`/conversation/${id}`);
      },
  }
}
</script>
