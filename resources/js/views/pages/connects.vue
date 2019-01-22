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
          <v-flex xs6>
             <v-card-text><b>{{user.first_name + " " + user.last_name}}</b><br/>{{user.headline}}</v-card-text>
          </v-flex>
          <v-flex align-center justify-center layout text-xs-center xs4>
        <v-btn fab small flat color="green" outline class="white--text" :loading="click" :disabled="click" @click="messageConnect(user.id)"><v-icon >message</v-icon></v-btn>
           <v-btn fab small flat color="red" outline class="white--text" :loading="clicks" :disabled="clicks" @click="confirmRemove(user.first_name, user.last_name)"><v-icon >cancel</v-icon></v-btn>
          </v-flex>
          <v-divider></v-divider>
               <v-dialog
      v-model="info"
      max-width="290"
    >
     <v-card>
        <v-card-title class="headline">{{this.infotext}}</v-card-title>
        <v-card-actions>
        <v-btn flat @click="info = false">Cancel</v-btn>
        <v-spacer></v-spacer>
        <v-btn color="blue" @click="removeConnect(user.id)">OK</v-btn>
        </v-card-actions>
     </v-card>
    </v-dialog>
    </v-layout>
</template>
<script>
export default {
    props:['user'],
     data () {
    return {
        submit: true,
        info: false,
        infotext: '',
       click: false,
       clicks: false,
    }
  },
  methods: {
       userPic(data){
         return '/images/users/' + data;
     },
      confirmRemove(name, last){
         this.infotext = "Are you sure you want to remove" + " " + name + " " + last + " " + "from your connections ?";
        this.info = true;
      },
      removeConnect(id){
          this.info = false;
        this.click = true;
        axios.post( '/api/connect/' + id + '/removefriend').then(response =>  {
            this.submit = false;
                    this.click = false;
                }).catch(error => {
                     this.click = false;
                });
      },

       messageConnect(id){
           //this.$router.push({ path: '/conversation', query: { id: this.$route.query.id }})
          this.$router.push(`/conversation/${id}`);
      },
  }
}
</script>
