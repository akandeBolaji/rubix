<template>
  <!-- App -->
  <f7-app :params="f7params">

    <!-- Statusbar -->
    <f7-statusbar></f7-statusbar>

    <!-- Main View
    <f7-view v-if = "isLoggedIn" id="main-view" url="/"></f7-view>

    <f7-view v-if = "!isLoggedIn" url="/login/"></f7-view> -->

    <f7-view url="/main/"></f7-view>
  </f7-app>
</template>

<script>
// Import Routes
import Framework7 from 'framework7/framework7.esm.bundle.js'
//var app = new Framework7();
import routes from '../../f7routes.js'

export default {
  data() {
    return {
      // Framework7 parameters here
      f7params: {
        animateNavBackIcon: true,
        id: 'io.framework7.testapp', // App bundle ID
        name: 'Rubik', // App name
        theme: 'auto', // Automatic theme detection
        // App routes
        routes: routes,
      },
    }
  },

}
</script>
<style>
@import '/css/framework7.css';
</style>
