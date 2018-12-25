<template>
<v-app>
     <v-layout mb-5>

    <v-flex xs12 sm6 offset-sm3>
         <v-btn
              color="blue"
              dark
              right
              absolute
              fixed
              fab
               @click='createpost'
            >
              <v-icon>create</v-icon>
            </v-btn>
        <v-container>
      <v-card>
          <v-card-text>
          <v-layout
        >
          <v-flex xs2 sm1 md1>
            <v-avatar
              color="black"
            >
              <img
              v-if="image"
          src="https://cdn.vuetifyjs.com/images/cards/desert.jpg"
                alt="Avatar"
              >
              <v-icon
              large
              dark
                v-else
              >account_circle</v-icon>
            </v-avatar>
          </v-flex>

          <v-flex sm10 md10 xs9 @click="showUser">
             <strong>Akande Bolaji</strong><br/>Head of Sales - Jumia<br/> 30 mins ago
          </v-flex>
          <v-flex sm1 md1 xs1>
             <v-icon @click="sheet = true">more</v-icon>
          </v-flex>
        </v-layout>
          </v-card-text>
          <v-card-text @click="showPost">
            Located two hours south of Sydney in the <br>Southern Highlands of New South Wales, ...<span @click="showPost" style="color:grey">see more</span>
        </v-card-text>

        <v-img
        @click="viewImage"
         v-if="image"
          src="https://cdn.vuetifyjs.com/images/cards/desert.jpg"
          aspect-ratio="1.75"
        ></v-img>
         <v-card-text>90 likes . 120 comments</v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
         <v-layout>
          <v-flex xs5 sm4 @click="addComment">
             <v-btn flat><v-icon>message</v-icon>Comment</v-btn>
          </v-flex>
          <v-flex xs6 sm4 @click="sharePost">
             <v-btn flat><v-icon>share</v-icon>Share</v-btn>
          </v-flex>
         </v-layout>
        </v-card-actions>
      </v-card>
     </v-container>

      <v-container  v-for="(post) in posts" v-bind:key='post.id'>
      <v-card>
          <v-card-text>
          <v-layout
          @click="showUser(post.user.id)"
        >
          <v-flex xs2 sm1 md1>
            <v-avatar
             v-if="post.user && post.user.profile && post.user.profile.avatar"
            color="grey lighten-4"
            >
              <img
          :src="userPic(post.user.profile.avatar)"
                alt="Avatar"
              >
            </v-avatar>
              <v-icon
              large
              style="font-size: 50px;"
                v-else
              >account_circle</v-icon>
          </v-flex>

          <v-flex sm10 md10 xs9>
             <strong><b>{{ post.user.profile.first_name + " " + post.user.profile.last_name }}</b></strong><br/><span  v-if="post.user.profile.headline"> {{post.user.profile.headline}} <br/> </span> {{ post.createdDate }}
          </v-flex>
          <v-flex sm1 md1 xs1>
             <v-icon @click="sheet = true">more</v-icon>
          </v-flex>
        </v-layout>
          </v-card-text>
          <v-card-text v-if="post.text.length < 250" @click="showPost(post.id)">
            {{ post.text }}
        </v-card-text>
          <v-card-text v-if="post.text.length >= 250" @click="showPost(post.id)">
            {{post.text.substring(0, 250)}}...<span @click="showPost" style="color:grey"><i>see more</i></span>
        </v-card-text>
        <v-container fluid grid-list-sm>
          <v-layout v-if="post.images.length == 1" row wrap>
                <v-flex v-for="(image) in post.images"
           xs12
        v-bind:key='image.id'
        >
        <v-img
        @click="viewImage(image.id)"
          :src="postImage(image.path)"
          aspect-ratio="1"
        ></v-img>
           </v-flex>
          </v-layout>
          <v-layout v-if="post.images.length == 2" row wrap>
             <v-flex v-for="(image) in post.images"
           xs6
        v-bind:key='image.id'
        >
        <v-img
        @click="viewImage(image.id)"
          :src="postImage(image.path)"
          aspect-ratio="1"
        ></v-img>
           </v-flex>
           </v-layout>
           <v-layout v-if="post.images.length == 3" row wrap>
           <v-flex v-for="(image) in post.images.slice(0,1)"
           xs12
        v-bind:key='image.id'
        >
        <v-img
        @click="viewImage(image.id)"
          :src="postImage(image.path)"
          aspect-ratio="1.65"
        ></v-img>
           </v-flex>
           <v-flex v-for="(image) in post.images.slice(1)"
           xs6
        v-bind:key='image.id'
        >
        <v-img
        @click="viewImage(image.id)"
          :src="postImage(image.path)"
          aspect-ratio="1"
        ></v-img>
           </v-flex>
           </v-layout>
               <v-layout v-if="post.images.length > 3" row wrap>
              <v-flex v-for="(image) in post.images.slice(0, 3)"
           xs6
        v-bind:key='image.id'
        >
        <v-img
        @click="viewImage(image.id)"
          :src="postImage(image.path)"
          aspect-ratio="1"
        ></v-img>
           </v-flex>
           <v-flex
           xs6
           >
           <v-img
            @click="viewImage(image.id)"
          :src="postImage(post.images[3].path)"
          aspect-ratio="1"
           >
           <v-container justify-center align-center>
               <v-card color="transparent" justify-center align-center>
                   <v-card-text  class="white--text" justify-center align-center>
            <span class="white--text"><h4><b>+ {{ post.images.slice(4).length }} more ...</b></h4></span>
                   </v-card-text>
               </v-card>
           </v-container>
           </v-img>
           </v-flex>
       </v-layout>
        </v-container>
         <v-card-text>90 likes . 120 comments</v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
         <v-layout>
             <Likes :post="post"></Likes>
             <v-flex xs5 sm4 @click="addComment(post.id)">
             <v-btn flat><v-icon>message</v-icon>Comment</v-btn>
            </v-flex>
          <v-flex xs6 sm4 @click="sharePost(post.id)">
             <v-btn flat><v-icon>share</v-icon>Share</v-btn>
          </v-flex>
         </v-layout>
        </v-card-actions>
        <addComment :clicked="clicked" :user="user" :post="post"></addComment>
      </v-card>
     </v-container>
    </v-flex>
  </v-layout>
   <v-bottom-sheet v-model="sheet">
      <v-list>
        <v-list-tile
          @click="hidePost(post.id)"
        >
          <v-list-tile-avatar>
            <v-avatar size="32px" tile>
              <v-icon>share</v-icon>
            </v-avatar>
          </v-list-tile-avatar>
          <v-list-tile-title><b>Hide this post</b></v-list-tile-title>
        </v-list-tile>
           <v-list-tile
          @click="unfollowUser(post.user.id)"
        >
          <v-list-tile-avatar>
            <v-avatar size="32px" tile>
              <v-icon>share</v-icon>
            </v-avatar>
          </v-list-tile-avatar>
          <v-list-tile-title><b>Unfollow User</b></v-list-tile-title>
        </v-list-tile>
         <v-list-tile
          @click="reportPost(post.id)"
        >
          <v-list-tile-avatar>
            <v-avatar size="32px" tile>
              <v-icon>share</v-icon>
            </v-avatar>
          </v-list-tile-avatar>
          <v-list-tile-title><b>Report this post</b></v-list-tile-title>
        </v-list-tile>
         <v-list-tile
          @click="improveFeed"
        >
          <v-list-tile-avatar>
            <v-avatar size="32px" tile>
              <v-icon>share</v-icon>
            </v-avatar>
          </v-list-tile-avatar>
          <v-list-tile-title><b>Improve my feed</b></v-list-tile-title>
        </v-list-tile>
      </v-list>
    </v-bottom-sheet>
</v-app>
</template>


<script>
import Likes from './likes.vue';
import Comment from './comment.vue';
import addComment from './add-comment.vue';
export default {
    components: {
      Likes,
      addComment,
      Comment
    },
  created () {
    this.getPosts();
     this.fetchAuthenticatedUser();
  },


  data () {
    return {
        clicked: '',
        addcomment:false,
        sheet: false,
       image: false,
    }
  },

   methods: {
       hidePost(data){
         console.log('hide this post');
       },
       unfollowUser(data){
          console.log('unfollow user');
       },
       reportPost(data){
           console.log('report this post');
       },
       improveFeed(){
           console.log('improve feeds');
       },
       addComment(data){
           this.clicked = data;
           //this.addcomment = true;
           //return data;
       },
       sharePost(data){
            console.log('share the post to others');
       },
       showPost(data){
           console.log('go to post page');
       },
        showUser(data){
            console.log('show the user information');
       },
        viewImage(data){
              console.log('view the image of the post');
       },
       createpost() {
      this.$router.push('/createpost');
    },
    getPosts() {
      this.$store.dispatch( 'loadPosts');
    },
    fetchAuthenticatedUser() {
      this.$store.dispatch( 'getUser');
    },
     userPic(data){
         return 'http://rubix.site/images/users/' + data;
     },

     postImage(data){
           return 'http://rubix.site/post_images/' + data;
     },
     postVideo(data){
           return 'http://rubix.site/post_videos/' + data;
     }
  },

  watch: {

   },

  computed: {

  /*
    Determines if the cafe is still processing the like action.
  */
     posts(){
       return this.$store.getters.getPosts;
     },
      user(){
       return this.$store.getters.getUserData;
     },

     postImages(){
       this.posts.forEach(function(post) {
         post.images.forEach(function(image) {
           return 'http://rubix.site/post_images/' + image.path;
         });
       });
     },
     postVideos(){
       this.posts.forEach(function(post) {
         post.videos.forEach(function(video) {
           return 'http://rubix.site/post_videos/' + video.path;
         });
       });
     }

   },


}
</script>


<style scoped>
.img img {
  border-radius : 50%;
};
</style>

