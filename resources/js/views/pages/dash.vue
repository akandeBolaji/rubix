<template>
  <v-app id="inspire">
    <v-navigation-drawer
      v-model="drawer"
      fixed
      temporary
      height="400px"
    >

      <v-list class="pt-0" dense>
            <v-list-tile @click="dashboard">
          <v-list-tile-action>
            <v-icon color="blue">dashboard</v-icon>
          </v-list-tile-action>

          <v-list-tile-content>
            <v-list-tile-title>Dashboard</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>

        <v-list-tile @click="logout">
          <v-list-tile-action>
            <v-icon color="red">logout</v-icon>
          </v-list-tile-action>

          <v-list-tile-content>
            <v-list-tile-title>Logout</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
      </v-list>
    </v-navigation-drawer>
        <v-toolbar>
            <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
            <v-container fluid fill-height align-center justify-center>
         <v-toolbar-title class="blue--text">Rubix</v-toolbar-title>
            </v-container>
             <v-badge small color="red" overlap>
           <span slot="badge">3</span>
            <v-icon>notifications</v-icon>
             </v-badge>
       </v-toolbar>

  <v-app>
      <router-view></router-view>
    <v-bottom-nav
      fixed
      :value="true"
      color="white"
    >
      <v-btn
        color="blue"
        flat
        to="/feeds"
        value="/hometab"
      >
        <span>Home</span>
        <v-icon>home</v-icon>
      </v-btn>

      <v-btn
        color="blue"
        flat
        to="/messages"
        value="messagetab"
      >
        <span>Messages</span>
        <v-icon>message</v-icon>
      </v-btn>

      <v-btn
        color="blue"
        flat
        to="/networks"
        value="networktab"
      >
        <span>Network</span>
        <v-icon>people</v-icon>
      </v-btn>

      <v-btn
        color="blue"
        flat
        to="/profile"
        value="profiletab"
      >
        <span>Profile</span>
        <v-icon>account_box</v-icon>
      </v-btn>
    </v-bottom-nav>
  </v-app>



      <v-dialog
      v-model="dialog"
      hide-overlay
      persistent
      width="300"
    >
      <v-card
        color="blue"
        dark
      >
        <v-card-text>
          Please wait...
          <v-progress-linear
            indeterminate
            color="white"
            class="mb-0"
          ></v-progress-linear>
        </v-card-text>
      </v-card>
    </v-dialog>

    <v-dialog
      v-model="info"
      max-width="290"
    >
     <v-card>
        <v-card-title class="headline">{{this.infotext}}</v-card-title>
        <div>
        <v-spacer></v-spacer>
        <v-btn color="blue" @click="info = false">OK</v-btn>
        </div>
     </v-card>
    </v-dialog>
  </v-app>
</template>

<script>
export default {
  data() {
   return {
       bottomNav: "/hometab",
       activeTab:"/hometab",
      drawer: null,
       text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
      disable: false,
      dialog: false,
      info: false,
      infotext: '',

   }
  },

  computed: {
      logoutLoadStatus(){
       return this.$store.getters.getLogoutLoadStatus;
     }
   },

   watch: {
        'logoutLoadStatus': function(){
         if(this.logoutLoadStatus == 2){
           this.dialog = false;
           this.$router.push("/login");
         }
         else if (this.logoutLoadStatus == 3){
           this.dialog = false;
            if (this.$store.getters.getLogoutMessage) {
           this.infotext = this.$store.getters.getLogoutMessage
           this.info = true;
           }
           else {
             this.infotext = 'An error Occured. Please check your network';
             this.info = true;
           };
         }
         else if (this.logoutLoadStatus == 1){
           this.dialog = true;
         }
       },


   },

  methods: {
      dashboard() {
          this.dialog = true;
          this.$router.push('/dashboard');
        },
        logout() {
          this.$store.dispatch( 'logoutUser');
        },

  }
}
</script>
