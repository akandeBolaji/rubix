<template>
<v-app>
    <v-toolbar fixed color="blue lighten-1">
    <v-icon @click="goBack" dark>arrow_back</v-icon>
    <v-toolbar-title class="white--text" >Post</v-toolbar-title>
</v-toolbar>
<v-container v-if="infinite" mt-5 mb-5>
     <infinite-loading v-show="infinite" direction="bottom" @distance="1" @infinite="infiniteHandler"></infinite-loading>
</v-container>
 <v-container fluid mt-5 mb-5 v-if="!infinite">
      <v-card>
          <v-card-text>
          <v-layout>
          <v-flex @click="showUser(post.user)" xs2 sm2 md2>
            <v-avatar
             v-if="post.user && post.user.avatar"
            color="grey lighten-4"
            >
              <img
          :src="userPic(post.user.avatar)"
                alt="Avatar"
              >
            </v-avatar>
              <v-icon
              large
              style="font-size: 50px;"
                v-else
              >account_circle</v-icon>
          </v-flex>

          <v-flex @click="showUser(post.user)" sm11 md10 xs10>
             <strong><b>{{ post.user.first_name + " " + post.user.last_name }}</b></strong><br/><span  v-if="post.user.headline"> {{post.user.headline}} <br/> </span> {{ getTime(post.created_at) }}
          </v-flex>
        </v-layout>
          </v-card-text>
          <v-card-text v-if="post.text">
            {{ post.text }}
        </v-card-text>
            <xgplayer v-if="post.videos != 0" v-for="(video) in post.videos" v-bind:key='video.id' :options="playerOption(video.path)"></xgplayer>
        <v-container fluid grid-list-sm>
          <v-layout v-if="post.images" row wrap>
                <v-flex v-for="(image) in post.images"
           xs12
        v-bind:key='image.id'
        >
        <v-img
          :src="postImage(image.path)"
          aspect-ratio="1"
        ></v-img>
           </v-flex>
          </v-layout>
        </v-container>
         <v-card-text v-if="post.likes && post.likes.length != 0 || post.comments.length != 0"><span v-if="post.likes.length > 1">{{ post.likes.length }} likes .</span>
         <span v-else-if="post.likes && post.likes.length == 1">{{ post.likes.length }} like .</span>
         <span v-if="post.comments && post.comments.length == 1">{{ post.comments.length }} comment</span>
         <span v-else-if="post.comments && post.comments.length > 1">{{ post.comments.length }} comments</span></v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
         <v-layout>
              <v-flex  v-if="post.userlike && post.userlike.length > 0" xs4 sm4 @click="removeLike()">
              <v-btn color="blue" flat><v-icon color="blue">favorite</v-icon>UnLike</v-btn>
            </v-flex>
            <v-flex v-else xs4 sm4 @click="addLike()">
                <v-btn flat><v-icon>favorite</v-icon>Like</v-btn>
            </v-flex>
             <v-flex  @click="commentRef()" sm4>
             <v-btn flat><v-icon>message</v-icon>Comment</v-btn>
            </v-flex>
             <Shares :post="post" :user="user"></Shares>
         </v-layout>
        </v-card-actions>
      </v-card>
      <v-divider></v-divider>
      <v-card>
      <h3> Likes</h3>
        <v-layout @click="likesdialog = true" v-if="post.likes != 0 && post.likes.length < 6">
          <v-flex align-center justify-center layout text-xs-center v-for="like in post.likes" v-bind:key='like.id' xs2 sm1 md1>
            <v-avatar
             v-if="like.avatar"
            color="grey lighten-4"
            >
              <img
          :src="userPic(like.avatar)"
                alt="Avatar"
              >
            </v-avatar>
                 <v-avatar
            v-else
            color="grey"
            >
              {{like.last_name.slice(0,1) + like.first_name.slice(0,1)}}
            </v-avatar>
          </v-flex>
          <v-flex xs2>
              <v-avatar color="grey">
             <v-icon
              style="font-size: 35px;"
              >more</v-icon>
              </v-avatar>
          </v-flex>
        </v-layout>
         <v-layout @click="likesdialog = true"  v-else-if="post.likes != 0 && post.likes.length > 0 && post.likes.length > 5">
          <v-flex align-center justify-center layout text-xs-center v-for="(like,index) in post.likes.slice(0,5)" v-bind:key='index' xs2 sm1 md1>
              <v-avatar
             v-if="like.avatar"
            color="grey lighten-4"
            >
              <img
          :src="userPic(like.avatar)"
                alt="Avatar"
              >
            </v-avatar>
                 <v-avatar
                 style="font-size: 35px;"
            v-else
            color="grey"
            >
              {{like.last_name.slice(0,1) + like.first_name.slice(0,1)}}
            </v-avatar>
          </v-flex>
          <v-flex xs2>
              <v-avatar color="grey">
             <v-icon
              style="font-size: 35px;"
              >more</v-icon>
              </v-avatar>
          </v-flex>
        </v-layout>
       <h3 v-else> <v-icon>favorite</v-icon>Be the first to like this post</h3>
      <br/><v-divider></v-divider>
      </v-card>
      <v-card v-if="post.comments != 0 && post.comments.length > 0">
      <h3> Comments</h3>
      <span v-if="post.comments != 0 && post.comments.length > 0" v-for="(comment,index) in post.comments" v-bind:key='index'>
      <v-layout >
            <v-flex @click="showUser(comment)" align-center justify-center layout xs2>
               <v-avatar style="font-size: 35px;" v-if="comment.avatar" color="grey lighten-4">
              <img :src="userPic(comment.avatar)" alt="Avatar">
            </v-avatar>
            <v-icon large style="font-size: 50px;" v-else>account_circle</v-icon>
          </v-flex>
          <v-flex xs10>
             <v-card-text><span @click="showUser(comment)" style="font-size: 11px;"><b>{{comment.first_name + " " + comment.last_name}}</b><br/>{{comment.headline}}<br/></span><span style="font-size: 16px;">{{ comment.data.text }}</span></v-card-text>
          </v-flex>
    </v-layout>
         <v-divider></v-divider>
      </span>
      </v-card>
      <v-card v-else>
        <h3> Comments</h3>
       <h3>Be the first to comment on this post</h3>
      </v-card>

      <v-footer height="60px" fixed color="white">
         <v-layout>
           <v-flex align-center justify-center layout text-xs-center  xs2>
            <v-avatar v-if="user.avatar" color="grey lighten-4">
              <img :src="userPic(user.avatar)" alt="Avatar">
            </v-avatar>
            <v-icon large style="font-size: 30px;" v-else>account_circle</v-icon>
          </v-flex>
           <v-flex align-center justify-center layout text-xs-center xs10>
              <v-text-field v-model="data.comment" ref="comment" name="text" label="Leave your thoughts here" type="text"></v-text-field>
          </v-flex>
          <v-flex justify-center layout text-xs-center align-center xs4 v-show="data.comment">
              <v-btn @click="submit" class="white--text" color="blue" :disabled="dialog || !data.comment" :loading="dialog">Post</v-btn>
          </v-flex>
               </v-layout>
      </v-footer>
     </v-container>
       <v-dialog v-if="post.likes" v-model="likesdialog" fullscreen hide-overlay transition="dialog-bottom-transition">
           <v-toolbar fixed color="blue lighten-1">
                <v-icon @click="likesdialog = false" dark>arrow_back</v-icon>
                <v-toolbar-title class="white--text" v-if="post.likes.length > 1">{{post.likes.length }} Likes</v-toolbar-title>
                <v-toolbar-title class="white--text" v-else>1 like</v-toolbar-title>
            </v-toolbar>
        <v-card>
        <v-container mt-3>
        <v-card-text v-if="post.likes.length > 0">
               <v-layout @click="showUser(like)" v-for="(like,index) in post.likes" v-bind:key='index'>
            <v-flex align-center justify-center layout text-xs-center xs1>
               <v-avatar v-if="like.avatar" color="grey lighten-4">
              <img :src="userPic(like.avatar)" alt="Avatar">
            </v-avatar>
            <v-icon large style="font-size: 50px;" v-else>account_circle</v-icon>
          </v-flex>
          <v-flex xs11>
             <v-card-text><b>{{like.first_name + " " + like.last_name}}</b><br/>{{like.headline}}</v-card-text>
          </v-flex>
          <v-divider></v-divider>
    </v-layout>
        </v-card-text>
        </v-container>
    </v-card>
     </v-dialog>
</v-app>
</template>
<script>
var moment = require('moment-timezone');
import Shares from './shares.vue';
import Likes from './likes.vue';
import addComment from './add-comment.vue';
var _ = require('lodash');
var removal = '';
export default {
    components: {
        Shares,
      Likes,
      addComment,
    },
     data() {
            return {
                infinite: true,
                liked: null,
                unliked: null,
                current: '',
                likevalue : true,
                unlikevalue : true,
                comment: {
                   first_name: '',
                   headline: '',
                   last_name: '',
                   avatar: '',
                   data: {
                       text: ''
                   }
                },
                dialog: false,
                data:{
                comment: '',
                post_id: ''
                },
                clicked: '',
                likesdialog: false,
                addcomment:false,
                sheet: false,
                image: false,
                id:this.$route.params.id,
                post: {
                    userlike: '',
                    comments: [],
                    likes: [],
                    user: {
                    id : '',
                    first_name: '',
                    last_name: '',
                    avatar: ''
                }
                },
                user: {
                    id : '',
                    first_name: '',
                    last_name: '',
                    avatar: ''
                }
            }
        },
        created(){
            //this.getPost();
        },

        computed: {

        },

        methods: {
            getTime(time){
         var timezone = moment.tz.guess();
         console.log(timezone);
        return moment.utc(time).local().fromNow();
       //return moment(time).tz(timezone).fromNow();
       //return moment().utc(timezone).local().fromNow();
     },
            commentRef() {
            this.$refs.comment.focus();
            },
            submit() {
            this.data.post_id = this.post.id;
            this.dialog = true;
             axios.post('/api/posts/comment', this.data).then(response =>  {
                    this.dialog = false;
                    //this.data = {};
                    this.comment = {
                       first_name: this.user.first_name,
                        last_name: this.user.last_name,
                        avatar: this.user.avatar,
                        headline: this.user.headline,
                        data: {
                            text: this.data.comment
                        }
                    };
                    this.post.comments.push(this.comment);
                    this.data = {};
                }).catch(error => {
                    this.dialog = false;
                });
            },
             addLike() {
                this.post.userlike = [1];
               const data = this.post.id;
               this.post.likes.push(this.user);
          axios.post( '/api/posts/' + data + '/like').then(response =>  {
                 //this.post.likes.push(this.user);
                }).catch(error => {
                    this.post.userlike = '';
                     const likedata = this.post.likes;
                    const removal = _.remove(likedata, (n) => n.id == this.user.id);
                    this.post.likes = likedata;
                });

            },
            removeLike() {
             const data = this.post.id;
             this.post.userlike = '';
              var removes = _.filter(this.post.likes, (n) => n.id != this.user.id);
              this.post.likes = removes;
           axios.delete('/api/posts/' + data + '/like').then(response =>  {
                    console.log(this.post.likes);
                   //this.post.likes.pop();
                }).catch(error => {
                     this.post.userlike = [1];
                    this.post.likes.push(this.user);
                });
            },
            playerOption(data) {
                const source = '/post_videos/' + data;
                return {
                    url: source,
                    keyShortcut: 'off',
                    width: '100%' // Depends on its wrapper element.
                }
                },
            addComment(data){
                this.clicked = data;
                //this.addcomment = true;
                //return data;
            },
            sharePost(data){
                    console.log('share the post to others');
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
            userPic(data){
                return '/images/users/' + data;
            },

            postImage(data){
                return '/post_images/' + data;
            },
            postVideo(data){
                return '/post_videos/' + data;
            },
            goBack(){
                this.$router.push('/feeds');
            },
             infiniteHandler($state) {
                  let id = this.$route.params.id;
       axios.get('/api/post/' + id).then(response =>  {
                    this.post = response.data.post;
                     this.user = response.data.auth;
                     Echo.private(`postcomment.${this.post.id}`)
                        .listen('Comment', (e) => {
                            console.log(e);
                            const last = _.last(e.comments);
                             this.post.comments.push(last);
                            console.log(last);
                            //this.message.push(e.message);
                        });
                      Echo.private(`postlike.${this.post.id}`)
                        .listen('Like', (e) => {
                            console.log(e);
                            this.post.likes.unshift(e.auth);

                            //this.post.unshift(e.post);
                            console.log(this.post);
                            //this.message.push(e.message);
                        });
                        Echo.private(`postlike.${this.post.id}`)
                        .listen('Unlike', (e) => {
                            console.log(e);
                            //var removal = _.remove(this.post.likes, (n) => n.id == e.auth.id);
                            var removes = _.filter(this.post.likes, (n) => n.id != e.auth.id);
                             this.post.likes = removes;
                            console.log(this.post);
                            this.post = this.post;
                        });
                        $state.complete();
                        this.infinite = false;

                }).catch(error => {
                    $state.error();
                });
    },
            getPost() {
                let id = this.$route.params.id;
                 axios.get('/api/post/' + id).then(response =>  {
                     //console.log(response.data);
                     this.post = response.data.post;
                     this.user = response.data.auth;
                }).catch(error => {
                    //this.dialog = false;
                });
            },
        }

}
</script>



