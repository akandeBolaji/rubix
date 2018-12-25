<template>
 <v-layout @click="openThread(thread.withUser.id)">
                <v-flex align-center justify-center layout text-xs-center xs2>
               <v-avatar
            v-if="thread.withUser.avatar"
              color="grey lighten-4"
            >
              <img
          :src="userPic(thread.withUser.avatar)"
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
             <v-card-text><b>{{thread.withUser.full_name}}</b><br/>{{thread.thread.message}}</v-card-text>
          </v-flex>
          <v-divider></v-divider>
    </v-layout>
</template>
<script>
export default {
    props:['thread'],
     data () {
    return {

    }
  },
  methods: {
      openThread(id){
           //this.$router.push({ path: '/conversation', query: { id: this.$route.query.id }})
          this.$router.push(`/conversation/${id}`);
      },
  }
}
</script>
