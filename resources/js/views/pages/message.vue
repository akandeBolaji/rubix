<template>
  <v-layout>
       <v-flex xs2>
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
              style="font-size: 60px;"
                v-else
              >account_circle</v-icon>
          </v-flex>
          <v-flex xs11>
            <span v-if="message.message && message.sender.type == 'admin'"><b>{{message.sender.first_name + " " + message.sender.last_name}}</b> . {{ getTime(message.created_at) }}<br/><span v-html="message.message"></span></span>
            <span v-else-if="message.message"><b>{{message.sender.first_name + " " + message.sender.last_name}}</b> . {{ getTime(message.created_at) }}<br/>{{ message.message }}</span>
            <span v-else-if="message.file"><b>{{message.sender.first_name + " " + message.sender.last_name}}</b> . {{ getTime(message.created_at) }}<br/>
            <v-card>
                <v-list>
                <v-list-tile
            avatar
          >
            <v-list-tile-avatar>
              <v-icon>file_upload</v-icon>
            </v-list-tile-avatar>

            <v-list-tile-content>
              <v-list-tile-title>
                  <span v-if="message.file.length < 15">{{ message.file }}</span>
                  <span v-else>{{ message.file.slice(0, 15) }}...</span>
              </v-list-tile-title>
              <v-list-tile-sub-title style="color: green;" v-show="sending == message.sendstats">
                  <h3><b><i>
                <span v-if="message.sendstatus == 'sending'" style="color: green;">{{ message.sendstatus}}</span>
                <span v-else-if="message.sendstatus == 'failed'" style="color: red;">{{ message.sendstatus}}</span>
                </i></b></h3>
              </v-list-tile-sub-title>
            </v-list-tile-content>

            <v-list-tile-action v-show="sending == null">
              <v-btn @click="downloadFile(message.file)" icon ripple>
                <v-icon color="grey lighten-1">file_download</v-icon>
              </v-btn>
            </v-list-tile-action>
          </v-list-tile>
                </v-list>
            </v-card>
            </span>
             <span v-else-if="message.preview"><b>{{message.sender.first_name + " " + message.sender.last_name}}</b> . {{ getTime(message.created_at) }}<br/>
             <v-img
          :src="message.preview"
          aspect-ratio="1"
        >
        <v-card-text v-show="sending == message.sendstats"><h3><b><i>
            <span v-if="message.sendstatus = 'sending'" style="color: green;">{{ message.sendstatus}}</span>
            <span v-else-if="message.sendstatus = 'failed'" style="color: red;">{{ message.sendstatus}}</span>
            </i></b></h3></v-card-text>
        </v-img>
            </span>
            <span v-else-if="message.image"><b>{{message.sender.first_name + " " + message.sender.last_name}}</b> . {{ getTime(message.created_at) }}<br/>
             <v-img
          :src="messageImage(message.image)"
          aspect-ratio="1"
        >
        <v-btn v-show="sending == null" @click="downloadImage(message.image)" icon ripple>
                <v-icon color="grey lighten-1">file_download</v-icon>
              </v-btn>
        </v-img>
            </span>
          </v-flex>
  </v-layout>
</template>
<script>
var moment = require('moment-timezone');
export default {
    props:['message', 'sending', 'user', 'authuser'],
     data () {
    return {
       click: false,
       submitted: true,
    }
  },
  methods: {
    downloadFile(data){
        axios({
        url: '/message_files/' + data,
        method: 'GET',
        responseType: 'blob', // important
        }).then((response) => {
        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', data); //or any other extension
        document.body.appendChild(link);
        link.click();
        });
    },
    downloadImage(data){
        axios({
        url: '/message_images/' + data,
        method: 'GET',
        responseType: 'blob', // important
        }).then((response) => {
        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', data); //or any other extension
        document.body.appendChild(link);
        link.click();
        });
    },
     goBack(){
         this.$router.push('/networks');
     },
     userPic(data){
         return '/images/users/' + data;
     },
     getTime(time){
         var timezone = moment.tz.guess();
         console.log(timezone);
          return moment.utc(time).local().format('LT')
        //return moment(time).tz(timezone).format('LT');
        //return moment().utc(timezone).local().format('LT');
     },
     messageImage(data){
           return '/message_images/' + data;
     },
  },
  computed: {

  }
}

</script>

