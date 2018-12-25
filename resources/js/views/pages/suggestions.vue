<template>
    <div v-show="submitted">
        <v-avatar
             v-if="user.profile && user.profile.avatar"
            color="grey lighten-4"
            size="80px"
            >
              <img
          :src="userPic(user.profile.avatar)"
                alt="Avatar"
              >
            </v-avatar>
              <v-icon
              large
              style="font-size: 80px;"
                v-else
              >account_circle
              </v-icon>
          <v-card-text v-if="user.full_name">
             <b>{{user.full_name}}</b> <br/> <span>Web Developer</span> <br/> <span v-if="user.mutual">{{user.mutual}} mutual connections</span> <br/>
          </v-card-text>
          <v-btn color="blue" outline class="white--text" :loading="click" :disabled="click" @click="addConnect(user.id)">Connect</v-btn>
           <v-divider></v-divider>
    </div>
</template>
<script>
export default {
    props:['user'],
     data () {
    return {
       click: false,
       submitted: true,
    }
  },
  methods: {
      userPic(data){
         return 'http://rubix.site/images/users/' + data;
     },
      addConnect(id){
        this.click = true;
        axios.post( '/api/connect/' + id + '/befriend').then(response =>  {
                    this.click = false;
                    this.submitted = false;
                    this.$emit('submit', user.id);
                }).catch(error => {
                     this.click = false;
                });
      },
  }
}
</script>

