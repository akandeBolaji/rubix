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
            <v-icon
              large
              style="font-size: 50px;"
                v-else
              >account_circle</v-icon>
          </v-flex>
          <v-flex xs7>
             <v-card-text><b>{{ user.first_name + " " + user.last_name }}</b><br/>{{user.headline}}</v-card-text>
          </v-flex>
          <v-flex align-center justify-center layout text-xs-center xs3>
           <v-btn small color="blue" outline class="white--text" :loading="click" :disabled="click" @click="withdraw(user.id)">Withdraw</v-btn>
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
    }
  },
  methods: {
       userPic(data){
         return '/images/users/' + data;
     },
      withdraw(id){
        this.click = true;
        axios.post( '/api/connect/' + id + '/removefriend').then(response =>  {
                     this.submit =false;
                    this.click = false;
                }).catch(error => {
                     this.click = false;
                });
      },
  }
}
</script>

