<template>
<v-app id="inspire" style="background-image: url('/images/background/polibet/new.jpg')">
 <div>
    <v-container fill-height>
      <v-layout align-center>
        <v-flex>
          <h3 class="display-3 white--text">404</h3>
          <h3 class="display-3 white--text">Oops! There is something wrong!</h3>

          <span class="subheading white--text">The page you have requested is either moved away or doesn't exist.</span>

          <v-divider class="my-3"></v-divider>


        <router-link to="/">
          <v-btn
            class="mx-0 white--text"
            color="green"
            large
          >
            Back to Home
          </v-btn>
          </router-link>
        </v-flex>
      </v-layout>
    </v-container>
 </div>
</v-app>
</template>

<script>
    export default {
        mounted() {
        }
    }
</script>
<style scoped>
body {
  background-image: url("http://polibet.site/images/background/polibet/new.jpg");
}
</style>

