<template>
 <v-layout v-show="submit">
                <v-flex align-center justify-center layout text-xs-center xs2>
               <v-avatar
            v-if="user.avatar"
              color="grey lighten-4"
            >
              <img
          :src="userPic(user.avatar)"
                alt="Avatar"
              >
            </v-avatar>
            <v-avatar
            v-else
              color="grey lighten-4"
            >
              <img
          :src="userAv(user.id)"
                alt="Avatar"
              >
            </v-avatar>
          </v-flex>
          <v-flex xs6>
             <v-card-text><b>{{ user.first_name + " " + user.last_name }}</b><br/>{{user.headline}}</v-card-text>
          </v-flex>
          <v-flex align-center justify-center layout text-xs-center xs4>
        <v-btn fab small flat color="green" outline class="white--text" :loading="click" :disabled="click" @click="acceptConnect(user.id)"><v-icon >done</v-icon></v-btn>
           <v-btn fab small flat color="red" outline class="white--text" :loading="clicks" :disabled="clicks" @click="rejectConnect(user.id)"><v-icon >cancel</v-icon></v-btn>
          </v-flex>
          <v-divider></v-divider>
    </v-layout>
</template>
<script>
export default {
    props:['user'],
     data () {
    return {
       submit: true,
       click: false,
       clicks: false,
    }
  },
  methods: {
       userAv(id){
         return `https://robohash.org/${id}`;
     },
       userPic(data){
         return '/images/users/' + data;
     },
      acceptConnect(id){
        this.click = true;
        axios.post( '/api/connect/' + id + '/acceptfriend').then(response =>  {
                    this.click = false;
                    this.submit = false;
                }).catch(error => {
                     this.click = false;
                });
      },

      rejectConnect(id){
        this.clicks = true;
        axios.post( '/api/connect/' + id + '/denyfriend').then(response =>  {
                    this.submit = false;
                    this.clicks = false;
                }).catch(error => {
                     this.clicks = false;
                });
      },
  }
}
</script>
