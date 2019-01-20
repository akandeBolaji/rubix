<template>
<span>
<v-flex xs6 sm4 @click="sharesheet = true">
             <v-btn flat><v-icon>share</v-icon>Share</v-btn>
</v-flex>
  <v-bottom-sheet inset v-model="sharesheet">
      <v-list>
          <v-list-tile
          v-if="post.usershare.length == 0 && post.userlike.length == 0 && post.usercomment.length == 0 && post.user.id != user.id && shared == true"
          @click="sharePost(post.id, post)"
        >
          <v-list-tile-avatar>
            <v-avatar size="32px" tile>
              <v-icon>share</v-icon>
            </v-avatar>
          </v-list-tile-avatar>
          <v-list-tile-title v-if="sharing"><i>Sharing</i></v-list-tile-title>
          <v-list-tile-title v-else><b>Share to Friends on Rubix</b></v-list-tile-title>
        </v-list-tile>
         <social-sharing :url= posturl(post)
            :title = title(post)
            :description= description(post)
            quote=" "
            hashtags=" "
            twitter-user=" "
            inline-template>
        <div>
            <network network="facebook">
                <i class="fa fa-facebook"></i>
                <v-list-tile>
                <v-list-tile-avatar>
                    <v-avatar size="32px" tile>
                    <v-icon>share</v-icon>
                    </v-avatar>
                </v-list-tile-avatar>
                <v-list-tile-title><b>Share on Facebook</b></v-list-tile-title>
                </v-list-tile>
            </network>
        </div>
        </social-sharing>

         <social-sharing :url= posturl(post)
            :title = title(post)
            :description= description(post)
            quote= ''
            hashtags= " "
            twitter-user=" "
            inline-template>
        <div>
            <network network="linkedin">
        <i class="fa fa-linkedin"></i>
               <v-list-tile>
          <v-list-tile-avatar>
            <v-avatar size="32px" tile>
              <v-icon>share</v-icon>
            </v-avatar>
          </v-list-tile-avatar>
          <v-list-tile-title><b>Share on LinkedIn</b></v-list-tile-title>
        </v-list-tile>
            </network>
        </div>
        </social-sharing>

        <social-sharing url= posturl(post)
            :title = title(post)
            :description= description(post)
            quote=" "
            hashtags=" "
            twitter-user=" "
            inline-template>
        <div>
           <network network="whatsapp">
        <i class="fa fa-whatsapp"></i>
               <v-list-tile>
          <v-list-tile-avatar>
            <v-avatar size="32px" tile>
              <v-icon>share</v-icon>
            </v-avatar>
          </v-list-tile-avatar>
          <v-list-tile-title><b>Share on Whatsapp</b></v-list-tile-title>
        </v-list-tile>
            </network>
        </div>
        </social-sharing>
      </v-list>
    </v-bottom-sheet>
</span>
</template>
<script>
export default {
     props:['post', 'user'],
   data () {
    return {
    sharing: false,
   sharesheet: false,
   shared : true
    }
  },

   methods: {
        posturl(data){
        return `https://rubix.site/post/${data.id}`;
       },
       title(data){
        return `A Post by ${data.user.first_name} ${data.user.last_name}`;
       },
       description(data){
         return `${data.text.slice(0,200)} ...`;
       },
       sharePost(data, post){
           this.sharing = true;
          axios.post( '/api/posts/' + data + '/share').then(response =>  {
                   this.sharesheet = false;
                   this.shared = false;
                }).catch(error => {
                   this.sharing = false;
                });
       },
  }
}
</script>
