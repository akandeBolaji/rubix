<template>
<v-app>
  <v-layout mt-5 mb-5>
    <v-flex xs12 sm6 offset-sm3>
         <v-btn color="blue" dark right absolute fixed fab @click="createpost">
            <v-icon>create</v-icon>
         </v-btn>
                <v-btn v-if="this.newpost > 0" fab outline  style="font-size: 10px;" fixed absolute color="blue" class="white--text" large @click="scrollToTop">
                   <v-icon size="50" color="blue">arrow_drop_up</v-icon><br/><br/> {{ this.newpost }} New
                </v-btn>
      <v-container v-for="(post,index) in post" v-if="post.text && post.user" v-bind:key='index'>
      <v-card>
          <div v-if="post && post.friendcomments && post.type != 'admin' || post && post.friendlikes && post.type != 'admin' || post && post.friendshares && post.type != 'admin' ">
          <v-card-text v-if="post && post.friendcomments && post.friendcomments.length > 0 && post.type != 'admin'"><b>{{ post.friendcomments[0].first_name + " " + post.friendcomments[0].last_name }} commented on this post</b></v-card-text>
          <v-card-text v-else-if="post && post.friendlikes && post.friendlikes.length == 1 && post.type != 'admin'"><b> {{ post.friendlikes[0].first_name + " " + post.friendlikes[0].last_name }} liked this post</b></v-card-text>
          <v-card-text v-else-if="post && post.friendlikes && post.friendlikes.length > 1" && post.type != 'admin'><b>{{ post.friendlikes[0].first_name + " " + post.friendlikes[0].last_name }} and {{ post.friendlikes.length - 1 }} other connects liked this post</b></v-card-text>
          <v-card-text v-else-if="post && post.friendshares && post.friendshares.length > 1 && post.type != 'admin'"><b>{{ post.friendshares[0].first_name + " " + post.friendshares[0].last_name }} shared a post</b></v-card-text>
          </div>
          <v-divider></v-divider>
          <v-card-text>
          <v-layout>
          <v-flex xs2 sm2 md2>
            <v-avatar
             v-if="post.user && post.user.avatar"
            @click="showUser(post.user)"
            color="grey lighten-4"
            >
              <img
          :src="userPic(post.user.avatar)"
                alt="Avatar"
              >
            </v-avatar>
              <v-icon
                @click="showUser(post.user)"
              large
              style="font-size: 50px;"
                v-else
              >account_circle</v-icon>
          </v-flex>

          <v-flex @click="showUser(post.user)" sm10 md10 xs9>
             <strong><b>{{ post.user.first_name + " " + post.user.last_name }}</b></strong><br/><span  v-if="post.user.headline"> {{post.user.headline}} <br/> </span> {{ getTime(post.created_at) }}
          </v-flex>
          <v-flex sm1 md1 xs1>
             <v-icon>more</v-icon>
          </v-flex>
        </v-layout>
          </v-card-text>
          <v-card-text v-if="post.text.length < 250">
            <span @click="showPost(post.id)">{{ post.text }}</span>
        </v-card-text>
          <v-card-text v-if="post.text.length >= 250">
            <span @click="showPost(post.id)">{{post.text.substring(0, 250)}}...<span @click="showPost(post.id)" style="color:grey"><i>see more</i></span></span>
        </v-card-text>
            <xgplayer v-if="post.videos != 0" v-for="(video) in post.videos" v-bind:key='video.id' :noDestroy="false" :options="playerOption(video.path)"></xgplayer>
        <v-container fluid grid-list-sm>
          <v-layout v-if="post.images.length == 1" row wrap>
                <v-flex v-for="(image) in post.images"
           xs12
        v-bind:key='image.id'
        >
        <v-img
         @click="showPost(post.id)"
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
         @click="showPost(post.id)"
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
         @click="showPost(post.id)"
          :src="postImage(image.path)"
          aspect-ratio="1.65"
        ></v-img>
           </v-flex>
           <v-flex v-for="(image) in post.images.slice(1)"
           xs6
        v-bind:key='image.id'
        >
        <v-img
         @click="showPost(post.id)"
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
         @click="showPost(post.id)"
          :src="postImage(image.path)"
          aspect-ratio="1"
        ></v-img>
           </v-flex>
           <v-flex
           xs6
           >
           <v-img
            @click="showPost(post.id)"
          :src="postImage(post.images[3].path)"
          aspect-ratio="1"
           >
           <v-container justify-center align-center>
               <v-card color="transparent" justify-center align-center>
                   <v-card-text  class="white--text" justify-center align-center>
            <span class="white--text"  @click="showPost(post.id)"><h4><b>+ {{ post.images.slice(4).length }} more ...</b></h4></span>
                   </v-card-text>
               </v-card>
           </v-container>
           </v-img>
           </v-flex>
       </v-layout>
        </v-container>
         <v-card-text v-if="post.likes && post.likes.length != 0 || post.comments && post.comments.length != 0"><span @click="showPost(post.id)"  v-if="post.likes.length > 1">{{ post.likes.length }} likes .</span>
         <span @click="showPost(post.id)"  v-else-if="post.likes.length == 1">{{ post.likes.length }} like .</span>
         <span @click="showPost(post.id)"  v-if="post.comments.length == 1">{{ post.comments.length }} comment</span>
         <span @click="showPost(post.id)"  v-else-if="post.comments.length > 1">{{ post.comments.length }} comments</span>
         </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
         <v-layout>
             <Likes :post="post" v-on:addlike="likeAdded" v-on:removelike="likeRemoved"></Likes>
             <v-flex xs5 sm4 @click="addComment(post.id)">
             <v-btn flat><v-icon>message</v-icon>Comment</v-btn>
            </v-flex>
            <Shares :post="post" :user="user"></Shares>
         </v-layout>
        </v-card-actions>
        <addComment v-on:addcomment="commentAdded"  :clicked="clicked" :user="user" :post="post"></addComment>
      </v-card>
     </v-container>
     <infinite-loading v-show="infinite" @distance="1" @infinite="infiniteHandler"></infinite-loading>
    </v-flex>
  </v-layout>
</v-app>
</template>


<script>
import Likes from './likes.vue';
import Shares from './shares.vue';
import Comment from './comment.vue';
import addComment from './add-comment.vue';
var _ = require('lodash');
var moment = require('moment-timezone');
export default {
    components: {
      Likes,
      Shares,
      addComment,
      Comment
    },

  created () {
    //this.getPosts();
  },


  data () {
    return {
        newpost: 0,
        clicked: '',
        post: [


        ],
        infinite: true,
        user: {

        },
        page: 1,
        addcomment:false,
        sheet: false,
        sharesheet: false,
       image: false,
    }
  },

   methods: {
        onScroll (e) {
        //console.log(e.target.scrollTop)
      },
        scrollToTop() {
            var target = 0;
            var options = {
                duration: 70,
                offset: 0,
                easing: "linear"
                };
            this.newpost = 0;
            this.$vuetify.goTo(target, options);
            },
       likeAdded(value) {
          console.log(value)
          value.likes.push(1);
       },
       likeRemoved(value) {
          console.log(value)
          value.likes.pop();
       },
        commentAdded(value) {
          console.log(value)
          value.comments.push(1);
       },
      playerOption(data) {
           const source = '/post_videos/' + data;
           return {
               download: true,
               airplay: true,
             url: source,
              keyShortcut: 'off',
             width: '100%' // Depends on its wrapper element.
           }
        },
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
           this.$router.push(`/post/${data}`);
           console.log('go to post page');
       },
        showUser(data){
            if (data.id != this.user.id && data.type != 'admin') {
             this.$router.push(`/user/${data.id}`);
            console.log('show the user information');
            }
       },
        viewImage(data){
              console.log('view the image of the post');
       },
       createpost() {
      this.$router.push('/createpost');
    },
    infiniteHandler($state) {
     axios.get('/api/posts?page='+this.page).then(response =>  {
                     console.log(response.data);
                      this.user = response.data.user
                      Echo.private(`post.${this.user.id}`)
                        .listen('PostEvent', (e) => {
                            console.log(e.post);
                            this.post.unshift(e.post);
                            this.newpost = this.newpost + 1;
                            console.log(this.post);
                            //this.message.push(e.message);
                        });
                       Echo.private(`comment.${this.user.id}`)
                        .listen('CommentEvent', (e) => {
                            console.log(e);
                            const checker = _.some(this.post, ['id', e.post.id]);
                            console.log(checker);
                            if (checker == true) {
                            _.forEach(this.post, function(post) {
                                if (post.id == e.post.id) {
                                   //add one to comment
                                    post.comments.push(1);
                                }
                             })
                            }
                            else {
                                  const newpost = {
                                    comments: e.post.comments,
                                    created_at: e.post.created_at,
                                    id : e.post.id,
                                    images : e.post.images,
                                    likes : e.post.likes,
                                    friendcomments : [e.auth],
                                    text : e.post.text,
                                    user : e.post.user,
                                    user_id : e.post.user_id,
                                    userlike : e.post.userlike,
                                    videos : e.post.videos,
                                  };
                                  this.post.unshift(newpost);
                                  this.newpost = this.newpost + 1;
                                }
                            //this.post.unshift(e.post);
                            console.log(this.post);
                            //this.message.push(e.message);
                        });
                         Echo.private(`share.${this.user.id}`)
                        .listen('ShareEvent', (e) => {
                            console.log(e);
                            const checker = _.some(this.post, ['id', e.post.id]);
                            console.log(checker);
                            if (checker != true) {
                              const newpost = {
                                    comments: e.post.comments,
                                    created_at: e.post.created_at,
                                    id : e.post.id,
                                    images : e.post.images,
                                    likes : e.post.likes,
                                    friendshares : [e.auth],
                                    text : e.post.text,
                                    user : e.post.user,
                                    user_id : e.post.user_id,
                                    usershare : e.post.usershare,
                                    videos : e.post.videos,
                                  };
                                  this.post.unshift(newpost);
                                  this.newpost = this.newpost + 1;
                            }
                            //this.post.unshift(e.post);
                            console.log(this.post);
                            //this.message.push(e.message);
                        });
                        Echo.private(`like.${this.user.id}`)
                        .listen('LikeEvent', (e) => {
                            console.log(e);
                            const checker = _.some(this.post, ['id', e.post.id]);
                            console.log(checker);
                            if (checker == true) {
                            _.forEach(this.post, function(post) {
                                if (post.id == e.post.id) {
                                   //add one to comment
                                    post.likes.push(1);
                                }
                             })
                            }
                            else {
                                  const newpost = {
                                    comments: e.post.comments,
                                    created_at: e.post.created_at,
                                    id : e.post.id,
                                    images : e.post.images,
                                    likes : e.post.likes,
                                    friendlikes : [e.auth],
                                    text : e.post.text,
                                    user : e.post.user,
                                    user_id : e.post.user_id,
                                    userlike : e.post.userlike,
                                    videos : e.post.videos,
                                  };
                                  this.post.unshift(newpost);
                                  this.newpost = this.newpost + 1;
                                }
                            //this.post.unshift(e.post);
                            console.log(this.post);
                            //this.message.push(e.message);
                        });
                        Echo.private(`like.${this.user.id}`)
                        .listen('UnlikeEvent', (e) => {
                            console.log(e);
                            const checker = _.some(this.post, ['id', e.post.id]);
                            console.log(checker);
                            if (checker == true) {
                            _.forEach(this.post, function(post) {
                                if (post.id == e.post.id) {
                                   //add one to comment
                                    post.likes.pop();
                                }
                             })
                            }
                            //this.post.unshift(e.post);
                            console.log(this.post);
                            //this.message.push(e.message);
                        });
                if (response.data.friendspost.last_page > this.page || response.data.friendlikes.last_page > this.page || response.data.friendcomments.last_page > this.page || response.data.userpost.last_page > this.page) {
                        this.page += 1;
                        const friendspost = response.data.friendspost.data;
                        const friendslike = response.data.friendlikes.data;
                        const friendscomment = response.data.friendcomments.data;
                        const friendshares = response.data.friendshares.data;
                        const userpost = response.data.userpost.data;
                        const adminpost = response.data.adminpost.data;
                        const all = _.concat(friendscomment, friendslike, adminpost, friendshares, friendspost, userpost);
                        const alls = _.orderBy(all, ['created_at'], ['desc']);
                        //let alls = _.orderBy(_.uniqBy([alls], 'id'), ['created_at'], ['desc']);
                        const unique =_.uniqBy(alls, 'id');
                        // this.post.push(...unique);
                        //$state.loaded();
                        if (this.post.length != 0) {
                         const uniques = _.filter(unique, function(n) {
                             const checker = _.some(this.post, ['id', n.id]);
                                   return  !checker;
                                });
                                if (uniques.length != 0){
                               this.post.push(...uniques);
                                }
                                $state.loaded();
                       }
                       else {
                          this.post.push(...unique);
                        $state.loaded();
                       }
                        //console.log(alls);
                        //console.log(unique);

                     }else {
                         const friendspost = response.data.friendspost.data;
                        const friendslike = response.data.friendlikes.data;
                        const friendshares = response.data.friendshares.data;
                        const adminpost = response.data.adminpost.data;
                        const friendscomment = response.data.friendcomments.data;
                        const userpost = response.data.userpost.data;
                        const all = _.concat(friendscomment, friendslike, adminpost, friendshares, friendspost, userpost);
                        const alls = _.orderBy(all, ['created_at'], ['desc']);
                        //let alls = _.orderBy(_.uniqBy([alls], 'id'), ['created_at'], ['desc']);
                        const unique =_.uniqBy(alls, 'id');
                        console.log(alls);
                        console.log(unique);
                         //this.post.push(...unique);
                        //$state.complete()
                       if (this.post.length != 0) {
                         const uniques = _.filter(unique, function(n) {
                                  const checker = _.some(this.post, ['id', n.id]);
                                   return  !checker;
                                });
                                if (uniques.length != 0){
                               this.post.push(...uniques);
                                }
                                $state.complete();
                       }
                       else {
                          this.post.push(...unique);
                        $state.complete();
                       }
                        this.infinite = false;
                     }

                    //this.page = this.page + 1;
                }).catch(error => {
                    $state.error();
                });
},

 getTime(time){
         var timezone = moment.tz.guess();
         console.log(timezone);
        return moment.utc(time).local().fromNow();
       //return moment(time).tz(timezone).fromNow();
       //return moment().utc(timezone).local().fromNow();
     },

    fetchAuthenticatedUser() {
      this.$store.dispatch( 'getUser');
    },
     userPic(data){
         return '/images/users/' + data;
     },

     postImage(data){
           return '/post_images/' + data;
     },
     postVideo(data){
           return '/post_videos/' + data;
     },
     settPosts(data){

     }
  },

  watch: {

   },

  computed: {
       target () {
         return 0
      },
      options () {
        return {
          duration: 70,
          offset: 0,
          easing: "linear"
        }
      },
     player() {
        return this.$refs.videoPlayer.player
      },
     posts(){
         const friendspost = this.$store.getters.getPosts.friendspost;
         const friendslike = this.$store.getters.getPosts.friendlikes;
         const friendscomment = this.$store.getters.getPosts.friendcomments;
         const userpost = this.$store.getters.getPosts.userpost;
         const all = _.concat(friendscomment, friendslike, friendspost, userpost);
         const alls = _.orderBy(all, ['created_at'], ['desc']);
         console.log(alls);
         this.post = alls;
         return this.post;
       //return this.$store.getters.getPosts;
     },

     postImages(){
       this.posts.forEach(function(post) {
         post.images.forEach(function(image) {
           return '/post_images/' + image.path;
         });
       });
     },
     postVideos(){
       this.posts.forEach(function(post) {
         post.videos.forEach(function(video) {
           return '/post_videos/' + video.path;
         });
       });
     }

   },


}
</script>


<style>
.img img {
  border-radius : 50%;
};
</style>

