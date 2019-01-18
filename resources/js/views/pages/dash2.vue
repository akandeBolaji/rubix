<template>
  <v-app id="inspire">
        <v-toolbar fixed>
            <v-container fluid fill-height align-center justify-center>
         <v-toolbar-title class="blue--text"> <v-icon @click="searchdialog = true"  color="blue" size="23">search</v-icon>Rubix</v-toolbar-title>
            </v-container>
            <v-icon @click="notification">notifications</v-icon>
       </v-toolbar>

         <v-dialog v-model="searchdialog" fullscreen hide-overlay transition="dialog-bottom-transition">
             <v-toolbar fixed color="white">
        <v-icon size="22px"  @click="searchdialog = false">arrow_back</v-icon>
        <v-toolbar-title>
            <v-layout>
            <v-flex xs12 align-content-center>
            <v-text-field clearable flat solo v-model.lazy="keywords" v-debounce="500" name="text" label="Search" type="text"></v-text-field>
            </v-flex>
            </v-layout>
        </v-toolbar-title>
    </v-toolbar>
    <v-card>
    <v-container v-if="results != 0 && results != null" mt-5 mb-5>
        <v-layout v-if="results != 0"  @click="showUser(user.id)" v-for="user in results" v-bind:key='user.id'>
            <v-flex align-center justify-center layout text-xs-center xs1>
               <v-avatar v-if="user.avatar" color="grey lighten-4">
              <img :src="userPic(user.avatar)" alt="Avatar">
            </v-avatar>
            <v-icon large style="font-size: 50px;" v-else>account_circle</v-icon>
          </v-flex>
          <v-flex xs11>
             <v-card-text><b>{{user.first_name + " " + user.last_name}}</b><br/>{{user.headline}}</v-card-text>
          </v-flex>
          <v-divider></v-divider>
    </v-layout>
    </v-container>
    <v-container v-else-if="loading" mt-5 mb-5>
      <Spinner size="medium" />
    </v-container>
    <v-container v-else-if="results == null" mt-5 mb-5>
       <v-card>
           <v-card-text>
             Enter a user to search
           </v-card-text>
       </v-card>
    </v-container>
    <v-container v-else mt-5 mb-5>
       <v-card>
           <v-card-text>
             No such user
           </v-card-text>
       </v-card>
    </v-container>
    </v-card>
     </v-dialog>

  <v-app>
      <router-view></router-view>

<v-footer fixed height="60">
    <v-layout>
        <v-flex xs12>
      <v-tabs color="white" dark icons-and-text>
    <v-tabs-slider color="yellow"></v-tabs-slider>
    <v-tab class="blue--text" to="/feeds">
      Home
      <v-icon color="blue">home</v-icon>
    </v-tab>
    <v-tab class="blue--text" to="/messages">
      Messages
      <v-icon color="blue">message</v-icon>
    </v-tab>
    <v-tab class="blue--text" to="/networks">
      Networks
      <v-icon color="blue">people</v-icon>
    </v-tab>
    <v-tab class="blue--text" to="/profile">
      Profile
      <v-icon color="blue">person</v-icon>
    </v-tab>
  </v-tabs>
  </v-flex>
    </v-layout>
</v-footer>
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
import Spinner from 'vue-simple-spinner'
var _ = require('lodash');
export default {
    components: {
     Spinner
    },
  data() {
   return {
        empty: false,
        error: false,
        loading: false,
        keywords: null,
        results: null,
       searchdialog: false,
       bottomNav: '',
       activeTab:"/hometab",
      drawer: null,
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
        keywords: {
            handler: _.debounce(function () {
            this.fetch()
            }, 400)
        },
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
       showUser(data){
                    this.$router.push(`/user/${data}`);
                    console.log('show the user information');
            },
         userPic(data){
                return 'http://rubix.site/images/users/' + data;
            },

         goBack(){
                this.$router.go(-1);
            },
        fetch() {
            this.loading = true;
            axios.get('/api/search', { params: { keywords: this.keywords } })
                .then(response => {
                    console.log(response.data);
                    this.results = response.data.data
                    this.loading = false;
                })
                .catch(error => {
                    this.loading = false;
                });
        },
      search() {
          this.$router.push('/search');
        },
         notification() {
          this.dialog = true;
          this.$router.push('/notifications');
        },
        logout() {
          this.$store.dispatch( 'logoutUser');
        },

  }
}
</script>
