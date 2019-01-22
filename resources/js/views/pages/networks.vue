<template>
<v-app>
<v-container mt-5 v-if="friendscount != null">
    <v-card v-if="friendscount != null" class="elevation-6">
    <v-layout row wrap>
        <v-flex xs12
        align-center
        justify-center
        layout
        text-xs-center
        >
           <v-card-title @click="viewConnection" v-if="friendscount">
            {{ friendscount }} <br/>
            View Connections
          </v-card-title>
           <v-card-title v-else>
            No Connections
          </v-card-title>
        </v-flex>
    </v-layout>
    </v-card>
</v-container>

<v-container v-if="pending != null">
    <v-card v-if="pending != null" class="elevation-6">
    <v-layout row wrap>
        <v-flex xs7
        >
           <v-card-title v-if="pending == 0">
             No Pending Invitations
          </v-card-title>
          <v-card-title v-else-if="pending > 0">
             {{pending}} Pending Invitations
          </v-card-title>
        </v-flex>
         <v-flex xs4
         offset-xs1
        >
           <v-card-title v-if="pending != null" class="blue--text" @click="manageAll">
            Manage All
          </v-card-title>
        </v-flex>
    </v-layout>
    </v-card>
</v-container>
<v-container v-if="data == 0" mt-5 mb-5>
     <infinite-loading v-show="infinite" direction="bottom" @distance="1" @infinite="infiniteHandler"></infinite-loading>
</v-container>
<v-container v-if="data != 0" mb-5>
    <v-card v-if="data != 0" class="elevation-6">
        <v-card-title>People you may know</v-card-title>
    </v-card>
    <v-divider v-if="data != 0"></v-divider>
    <v-card v-if="data != 0">
    <v-layout row wrap>
        <v-flex xs6
         align-center
        justify-center
        layout
        text-xs-center
        v-for="(user, index) in data" :key="index"
        >
          <Suggestion v-on:removesuggest="doSomething" :user="user" :keys="index"></Suggestion>
        </v-flex>
    </v-layout>
    </v-card>
    <infinite-loading v-show="infinite" direction="bottom" @distance="1" @infinite="infiniteHandler"></infinite-loading>
</v-container>
</v-app>
</template>
<script>
import Suggestion from './suggestions.vue';
import Connect from './connects.vue';
import Request from './requests.vue';
export default {
    components: {
     Connect,
     Suggestion,
     Request
    },
  mounted () {
      //fetch connects suggestion
      //fetch number of pending invitations
      //fetch number of friends
      //this.fetchSuggestions()
    //this.fetchAuthenticatedUser()
  },

  data () {
    return {
        infinite: true,
        page : 1,
    drawer: null,
      disable: false,
      listVideo: false,
      dialog: false,
      info: false,
      infotext: '',
      data: [],
      friendscount: null,
      users: '',
      pending: null,
      notShown: false,
      avatar: '',
    }
  },
  computed: {
      logoutLoadStatus(){
       return this.$store.getters.getLogoutLoadStatus;
     },
     //user(){
       //return this.$store.getters.getUserData;
     //},
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
       infiniteHandler($state) {
        axios.get('/api/suggestions?page='+this.page).then(response =>  {
                     console.log(response.data);
                     this.friendscount = response.data.friends_count;
                     this.pending = response.data.pending_request;
                      this.users = response.data.user
                if (response.data.friends_of_friends.last_page > this.page || response.data.suggestions.last_page > this.page) {
                        this.page += 1;
                    if (response.data.friends_of_friends.data.length == 0){
                        this.data.push(...response.data.suggestions.data);
                    }
                    else if (response.data.friends_of_friends.data.length < 20) {
                        let fof = response.data.friends_of_friends.data;
                        let suggestion = response.data.suggestions.data.slice(0, response.data.friends_of_friends.data.length);
                        let all = _.concat(fof, suggestion);
                        this.data.push(...all);
                    }
                    else {
                        this.data.push(...response.data.friends_of_friends.data);
                    }
                        $state.loaded();
                     }else {
                        this.data.push(...response.data.suggestions.data);
                        $state.complete();
                        this.infinite = false;
                     }

                    //this.page = this.page + 1;
                }).catch(error => {
                    $state.error();
                });
},
      doSomething(value) {
          this.data.splice( value, 1 );
          //console.log(value);
      },
      viewConnection() {
        this.$router.push('/connects');
      },
      manageAll() {
        this.$router.push('/received');
      },
      addConnect(id){
        this.click = true;
      },
        logout() {
          this.$store.dispatch( 'logoutUser');
        },
        fetchSuggestions() {

         axios.get('/api/suggestions').then(response =>  {
                  this.data = response.data;
                }).catch(error => {

                });
    },
    //fetchAuthenticatedUser() {
      //this.$store.dispatch( 'getUser');
    //},
  }
}
</script>
