<template>
     <v-flex xs5 sm4 @click="addComment(post)">
             <v-btn flat><v-icon>message</v-icon>Comment</v-btn>
      </v-flex>
</template>
<script>
export default {
    props:['post'],
  created () {
  },

  data () {
    return {
 files: [],
 comment: '',
    }
  },
  computed: {

   },


  methods: {
      addComment(data){
          this.$emit('add', data);
      }
  }
}
</script>
