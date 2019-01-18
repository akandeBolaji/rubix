<template>
     <v-card-text v-show="clicked == post.id">
                <v-form>
               <v-layout
        >
          <v-flex xs2 sm1 md1>
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
          <v-flex xs10>
              <v-text-field v-model="data.comment" name="text" label="Leave your thoughts here" type="text"></v-text-field>
          </v-flex>
               </v-layout>
               <v-layout>
          <v-flex xs8>
              <v-btn outline class="white--text" @click="submit(post.id, post)" :disabled="dialog || !data.comment" :loading="dialog" color="blue">Post Comment</v-btn>
          </v-flex>
        </v-layout>
              </v-form>
        </v-card-text>
</template>

<script>
export default {
     props:['post', 'user', 'clicked'],
  data () {
    return {
        dialog: false,
        data:{
           comment: '',
            post_id: '',
        },
    }
  },
  computed: {
   },


  methods: {
     userPic(data){
         return 'http://rubix.site/images/users/' + data;
     },
        submit(post, data) {
            this.data.post_id = post;
            this.dialog = true;
             axios.post('/api/posts/comment', this.data).then(response =>  {
                    this.dialog = false;
                    this.data = {};
                    this.$emit('addcomment', data);
                }).catch(error => {
                    this.dialog = false;
                });
           console.log('lik post');
    }
  }
}
</script>
