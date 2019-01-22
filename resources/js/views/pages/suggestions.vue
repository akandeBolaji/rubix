<template>
    <v-card height="300px" width="100%" v-show="submitted">
        <v-card-title>
        <v-layout>
        <v-flex xs10>
        <v-avatar
             v-if="user.avatar"
            size="70px"
            >
              <img
          :src="userPic(user.avatar)"
                alt="Avatar"
              >
            </v-avatar>
              <v-icon
              large
              style="font-size: 80px;"
                v-else
              >account_circle
              </v-icon>
        </v-flex>
        <v-flex xs2>
               <v-icon
               @click="removeConnect(keys)"
              style="font-size: 20px;"
              >cancel
              </v-icon>
        </v-flex>
        </v-layout>
        </v-card-title>
          <v-card-text v-if="user.first_name">
             <b>{{ user.first_name + " " + user.last_name }}</b> <br/>
             <span v-if="user.headline.length < 15">{{user.headline}}</span>
             <span v-if="user.headline.length > 15">{{user.headline.substring(0, 15)}}...</span>
             <br/>
             <span v-if="user.mutualcounts == 1"> <v-icon style="font-size: 15px;">person</v-icon>{{user.mutualcounts}} mutual connection</span>
             <span v-if="user.mutualcounts > 1"><v-icon style="font-size: 15px;">people</v-icon>{{user.mutualcounts}} mutual connections</span>
             <br/>
          </v-card-text>
          <v-card-text >
          <v-btn color="blue" outline class="white--text" :loading="click" :disabled="click" @click="addConnect(user.id, keys)">Connect</v-btn>
          </v-card-text>
    </v-card>
</template>
<script>
export default {
    props:['user', 'keys'],
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
      addConnect(id, key){
        this.click = true;
        axios.post( '/api/connect/' + id + '/befriend').then(response =>  {
                    this.click = false;
                    //this.submitted = false;
                    this.$emit('removesuggest', key);
                }).catch(error => {
                     this.click = false;
                });
      },
       removeConnect(key){
        this.$emit('removesuggest', key);
      },
  }
}
</script>

