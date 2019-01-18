<template>
           <v-flex v-if="post.userlike.length > 0 && see == true || liked == true || fakelike == true" xs4 sm4 @click="removeLike(post.id, post)">
              <v-btn color="blue" flat><v-icon color="blue">favorite</v-icon>UnLike</v-btn>
          </v-flex>
           <v-flex v-else-if="!post.userlike.length > 0 || unliked == true|| fakeunlike == true" xs4 sm4 @click="addLike(post.id, post)">
              <v-btn flat><v-icon>favorite</v-icon>Like</v-btn>
          </v-flex>
</template>
<script>
export default {
     props:['post', 'keys'],
   data () {
    return {
        fakelike : null,
        see: true,
        fakeunlike: null,
        liked: null,
        unliked: null
    }
  },

   methods: {
       addLike(data, post){
            this.fakelike = true;
          this.fakeunlike = false;
          this.$emit('addlike', post);
          axios.post( '/api/posts/' + data + '/like').then(response =>  {
                    this.fakelike = null;
                    this.fakeunlike = null;
                     this.unliked = false;
                    this.liked = true;

                }).catch(error => {
                    //this.$emit('removelike', post);
                     this.fakelike = null;
                    this.fakeunlike = null;
                });
           console.log('lik post');
       },
        removeLike(data, post){
          this.fakeunlike = true;
          this.fakelike = false;
          this.see = false;
          this.$emit('removelike', post);
           axios.delete('/api/posts/' + data + '/like').then(response =>  {
               this.fakeunlike = null;
               this.liked = false;
                    this.fakelike = null;
                    this.unliked = true;

                }).catch(error => {
                     this.fakelike = null;
                    this.fakeunlike = null;
                    //this.$emit('addlike', post);
                });
                console.log('unliked post');
       },

   },



  computed: {

  /*
    Determines if the cafe is still processing the like action.
  */
  postLikeStatus(){
    return this.$store.getters.getPostLikeStatus;
  },

   postLikedStatus(){
    return this.$store.getters.getPostLiked;
  },

   postUnlikedStatus(){
    return this.$store.getters.getPostUnliked;
  },

  /*
    Determines if the cafe is still processing the un-like action.
  */
  postUnlikeStatus(){
    return this.$store.getters.getPostUnlikeStatus;
  },

     posts(){
       return this.$store.getters.getPosts;
     },
  }
}
</script>

