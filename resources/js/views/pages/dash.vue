<template>
  <v-app id="inspire"
  v-touch="{
      left: () => swipe('Left'),
      right: () => swipe('Right'),
    }"
>
  >
  <v-navigation-drawer
      v-model="drawer"
      touchless
      fixed
      temporary
      height="40px"
    >
      <v-list class="pt-0" dense>

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
        <v-toolbar fixed>
            <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
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
    <v-bottom-nav
      fixed
      :active.sync="bottomNav"
      :value="true"
      color="white"
    >
      <v-btn
        color="blue"
        flat
        to="/feeds"
        value="feeds"
      >
        <span>Home</span>
        <v-icon>home</v-icon>
      </v-btn>

      <v-btn
        color="blue"
        flat
        to="/messages"
        value="messages"
      >
        <span>Messages</span>
        <v-icon>message</v-icon>
      </v-btn>

      <v-btn
        color="blue"
        flat
        to="/networks"
        value="networks"
      >
        <span>Network</span>
        <v-icon>people</v-icon>
      </v-btn>

      <v-btn
        color="blue"
        flat
        to="/profile"
        value="profile"
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
       bottomNav: this.$router.currentRoute.name,
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
       swipe(direction){
           if (this.bottomNav == 'feeds') {
                if (direction == 'Left') {
             this.bottomNav = 'messages' ;
              this.$router.push('/messages');
          }
        }
        else if (this.bottomNav == 'messages') {
                if (direction == 'Left') {
                 this.bottomNav = 'networks' ;
                 this.$router.push('/networks');
            }
            else if (direction = 'Right') {
             this.bottomNav = 'feeds' ;
             this.$router.push('/feeds');
          }
        }
         else if (this.bottomNav == 'networks') {
                if (direction == 'Left') {
                 this.bottomNav = 'profile' ;
                 this.$router.push('/profile');
            }
            else if (direction == 'Right') {
             this.bottomNav = 'messages' ;
             this.$router.push('/messages');
          }
        }
        else if (this.bottomNav == 'profile') {
                if (direction == 'Right') {
                 this.bottomNav = 'networks' ;
                 this.$router.push('/networks');
            }
        }
        console.log(this.$router);
           console.log(this.bottomNav);
       },
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
