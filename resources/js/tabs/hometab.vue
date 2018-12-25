<template>
    <f7-page>
     <f7-fab position="left-bottom" @click='createpost'>
      <f7-icon ios="f7:add" md="material:add"></f7-icon>
     </f7-fab>
      <f7-searchbar cancel-link="Cancel" placeholder="Search for people" :clear="true"></f7-searchbar>
      <f7-block-title>People you may know</f7-block-title>
    <f7-list>
      <f7-list-item title="Ivan Petrov" footer="music artist">
        <f7-icon slot="media"> <div class="demo-facebook-avatar img"><img src="../../images/dani.jpg" width="45" height="45"/></div></f7-icon>
        <f7-button slot="after">Send Request</f7-button>
      </f7-list-item>
      <f7-list-item header="" title="John Doe" footer="music producer">
        <f7-icon slot="media"><div class="demo-facebook-avatar img"><img src="../../images/dani.jpg" width="45" height="45"/></div></f7-icon>
        <f7-button slot="after">Send Request</f7-button>
      </f7-list-item>
      <f7-list-item title="Jenna Smith" footer="music director">
        <f7-icon slot="media"><div class="demo-facebook-avatar img"><img src="../../images/dani.jpg" width="45" height="45"/></div></f7-icon>
        <f7-button slot="after">Send Request</f7-button>
      </f7-list-item>
      <f7-list-item link="#" title="See more suggestions..."></f7-list-item>
    </f7-list>

      <f7-block strong class="elevation-5">
        <p strong> News Feeds</p>
      </f7-block>
     <f7-card class="demo-facebook-card elevation-10">
      <f7-card-header class="no-border">
        <div class="demo-facebook-avatar img"><img src="../../images/dani.jpg" width="45" height="45"/></div>
        <div class="demo-facebook-name">John Doe</div>
        <div class="demo-facebook-date">Monday at 2:15 PM</div>
      </f7-card-header>
      <f7-card-content>
        <p>What a nice music i dropped yesterday!</p>
        <f7-swiper pagination navigation scrollbar :params="{observer:true, speed:500, spaceBetween: 20}">
        <f7-swiper-slide><img src="../../images/dani.jpg" width="100%" height="100%"/></f7-swiper-slide>
        <f7-swiper-slide><img src="../../images/dani.jpg" width="100%" height="100%"/></f7-swiper-slide>
        <f7-swiper-slide><img src="../../images/dani.jpg" width="100%" height="100%"/></f7-swiper-slide>
        </f7-swiper>
        <p class="likes">Likes: 112 &nbsp;&nbsp; Comments: 43</p>
      </f7-card-content>
      <f7-card-footer class="no-border">
        <f7-link>Like</f7-link>
        <f7-link>Comment</f7-link>
        <f7-link>Share</f7-link>
      </f7-card-footer>
    </f7-card>

    <f7-card v-for="(post) in posts" v-bind:key='post.id' class="demo-facebook-card elevation-10">
      <f7-card-header class="no-border">
        <div class="demo-facebook-avatar img"><img :src="userPic(post.user.profile.avatar)" width="45" height="45"/></div>
        <div class="demo-facebook-name">{{ post.user.profile.first_name + " " + post.user.profile.last_name }}</div>
        <div class="demo-facebook-date">{{ post.createdDate }}</div>
      </f7-card-header>
      <f7-card-content>
        <p>{{ post.text }}</p>
        <f7-swiper pagination navigation scrollbar :params="{observer:true, speed:500, spaceBetween: 20}">
        <f7-swiper-slide v-for="(video) in post.videos" v-bind:key='video.id'><video width="100%" height="100%" autoplay><source :src="postVideo(video.path)" type="video/mp4" width="100%" height="100%"/></video></f7-swiper-slide>
        <f7-swiper-slide v-for="(image) in post.images" v-bind:key='image.id'><img :src="postImage(image.path)" width="100%" height="100%"/></f7-swiper-slide>
        </f7-swiper>
        <p class="likes">Likes: 112 &nbsp;&nbsp; Comments: 43</p>
      </f7-card-content>
      <f7-card-footer class="no-border">
        <f7-link @click="likePost(post.id)">Like</f7-link>
        <f7-link >Comment</f7-link>
        <f7-link>Share</f7-link>
      </f7-card-footer>
    </f7-card>
    </f7-page>
</template>

<script>
export default {
  created () {
    this.getPosts();
  },


  data () {
    return {

    }
  },

   methods: {
       createpost() {
      this.$router.push('createpost');
    },
    getPosts() {
      this.$store.dispatch( 'loadPosts');
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

  computed: {

     posts(){
       return this.$store.getters.getPosts;
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
