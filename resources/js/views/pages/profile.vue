<template>
<v-app>
<v-container v-if="user == 0" mt-5 mb-5>
     <infinite-loading v-show="infinite" direction="bottom" @distance="1" @infinite="infiniteHandler"></infinite-loading>
</v-container>
<v-container v-if="user != 0" mt-5 mb-5>
        <v-container>
            <v-layout row wrap>
                <v-flex xs12 sm8>
                    <v-card class="elevation-6">
                        <v-toolbar dark color="blue">
                            <v-toolbar-title>Profile Overview</v-toolbar-title>
                        </v-toolbar>
                        <v-layout>
                       <v-flex
                            mb-2
                            mt-2
                            xs12
                            align-center
                            justify-center
                            layout
                            text-xs-center
                        >
                            <v-avatar
                            size="230px"
                            color="grey lighten-4"
                            >
                            <img :src="profilePics"
                            v-if="user && user.avatar && !preview"
                            alt="avatar">
                            <img :src="preview"
                            v-else-if="preview"
                            alt="avatar">
                            <img
                            v-else
                        :src="userAv(user.id)"
                                alt="Avatar"
                            >
                             <v-btn
                                @click='addAvatar()'
                                absolute
                                dark
                                fab
                                bottom
                                right
                                color="blue"
                                >
                                <v-icon>image</v-icon>
                                </v-btn>
                            </v-avatar>
                        </v-flex>
                        </v-layout>
                        <v-layout>
                             <v-flex
                            v-if="user"
                            mt-3
                            xs12
                            align-center
                            justify-center
                            layout
                            text-xs-center
                        >
                            <b><h3>{{ user.first_name + " " + user.last_name }}</h3></b>
                        </v-flex>
                        </v-layout>
                        <v-layout>
                             <v-flex
                            v-if="user && user.headline"
                            xs12
                            align-center
                            justify-center
                            layout
                            text-xs-center
                        >
                          {{ user.headline}}
                        </v-flex>
                        </v-layout>
                         <v-layout>
                             <v-flex
                            v-if="user && user.profile && user.profile.location"
                            xs12
                            align-center
                            justify-center
                            layout
                            text-xs-center
                        >
                         Lives in {{ user.profile.location}}
                        </v-flex>
                        </v-layout>
                        <v-layout>
                             <v-flex
                            xs12
                            mb-2
                            align-center
                            justify-center
                            layout
                            text-xs-center
                        >
                           <v-btn large class="white--text"  @click="editProfile"  :disabled="dialog" :loading="dialog" color="blue">Edit Profile</v-btn>
                        </v-flex>
                        </v-layout>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-container>

        <v-container>
            <v-layout row wrap>
                <v-flex
                 xs12 sm8>
                    <v-card
                    height="50px" class="elevation-6">
                         <v-layout
                          align-center
                            justify-center
                             text-xs-center
                         >
                             <v-flex
                            xs6
                            align-center
                            justify-center
                            layout
                            text-xs-center
                        >
                        <v-card-text>
                          {{ user.view }} Profile Views
                        </v-card-text>
                        </v-flex>
                         <v-flex
                            xs6
                            align-center
                            justify-center
                            layout
                            text-xs-center
                        >
                        <v-card-text>
                         {{ friends }} Connections
                        </v-card-text>
                        </v-flex>
                        </v-layout>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-container>

        <v-container v-if="user.posts != null">
             <v-card-text v-if="user.posts != null"><b>Feed HighLights</b></v-card-text>
            <v-card v-for="post in user.posts.slice(0, 4)"
                            :key="post.id"
                     class="elevation-6">
                 <v-card-text><i>created a post {{post.createdDate}}</i><br/><b>{{post.text.substring(0, 30)}}....</b></v-card-text>
                 <v-btn align-center class="white--text" @click="showPost(post.id)" color="blue">View Post</v-btn>
            </v-card>
        </v-container>


         <v-container v-if="user && user.experiences != 0">
              <v-card-text v-if="user && user.experiences != 0"><b>Experience and Education</b></v-card-text>
                    <v-card
                    v-for="experience in user.experiences"
                            :key="experience.id"
                     class="elevation-6">
                        <v-layout
                            >
                            <v-flex xs2 sm1 md1>
                                <v-avatar
                                v-if="experience.avatar"
                                color="grey lighten-4"
                                >
                                <img
                            :src="profilePics"
                                    alt="Avatar"
                                >
                                </v-avatar>
                                <v-icon
                                large
                                style="font-size: 50px;"
                                v-else
                                >
                                people
                            </v-icon>
                            </v-flex>

                            <v-flex sm10 md10 xs9 mb-2>
                                <strong><b>{{ experience.name }}</b></strong><br/><span> {{experience.location }} <br/> </span> {{ experience.start_date + ' - ' + experience.end_date }}
                            </v-flex>
                            </v-layout>
                    </v-card>
        </v-container>


        <v-container v-if="user && user.skills != 0">
             <v-card-text v-if="user && user.skills != 0"><b>Skills</b></v-card-text>
            <v-card>
                 <v-chip v-for="skill in user.skills" v-bind:key='skill.id'>
                     <v-avatar class="blue">{{ skill.description.slice(0,1) }}</v-avatar>
                     {{skill.description}}
                   </v-chip>
            </v-card>
        </v-container>

         <v-container v-if="user && user.accomplishments != 0">
             <v-card-text v-if="user && user.accomplishments != 0"><b>Works and Accomplishments</b></v-card-text>
           <v-card
                    v-for="accomplishment in user.accomplishments"
                            :key="accomplishment.id"
                     class="elevation-6">
                         <v-card-text><b>{{accomplishment.name}}</b></v-card-text>
                          <v-card-text>{{accomplishment.description}}</v-card-text>
                           <v-card-text v-if="accomplishment.certificates">{{accomplishment.certificates}}</v-card-text>
                            <v-card-text v-if="accomplishment.works">{{accomplishment.works}}</v-card-text>
                    </v-card>
        </v-container>

            <v-container>
             <v-expansion-panel>
    <v-expansion-panel-content
    >
      <div slot="header">Contacts</div>

        <v-list two-line>
          <v-list-tile v-if="user && user.profile && user.profile.phone">
            <v-list-tile-action>
              <v-icon color="blue">phone</v-icon>
            </v-list-tile-action>

            <v-list-tile-content>
              <v-list-tile-title>{{user.profile.phone}}</v-list-tile-title>
              <v-list-tile-sub-title>Mobile</v-list-tile-sub-title>
            </v-list-tile-content>
          </v-list-tile>

          <v-divider v-if="user.profile && user.profile.phone" inset></v-divider>

          <v-list-tile v-if="user && user.profile && user.profile.email">
            <v-list-tile-action>
              <v-icon color="blue">mail</v-icon>
            </v-list-tile-action>

            <v-list-tile-content>
              <v-list-tile-title>{{user.profile.email}}</v-list-tile-title>
              <v-list-tile-sub-title>Personal</v-list-tile-sub-title>
            </v-list-tile-content>
          </v-list-tile>

          <v-divider inset></v-divider>

           <v-list-tile v-if="user && user.profile && user.profile.linkedin_profile">
            <v-list-tile-action>
              <v-icon color="blue">chat</v-icon>
            </v-list-tile-action>

            <v-list-tile-content>
              <v-list-tile-title>{{user.profile.linkedin_profile}}</v-list-tile-title>
              <v-list-tile-sub-title>Personal</v-list-tile-sub-title>
            </v-list-tile-content>
          </v-list-tile>

        </v-list>
    </v-expansion-panel-content>
  </v-expansion-panel>
        </v-container>


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

     <v-card-text v-show=false>
        <input type="file" id="file" accept="image/*" ref="file" @change="handleFileUpload()"/>
     </v-card-text>

  </v-container>
</v-app>
</template>
<script>
export default {
  mounted () {
    //this.fetchAuthenticatedUser()
  },

  data () {
    return {
        preview: '',
        user: [],
        friends: '',
    drawer: null,
    infinite: true,
      disable: false,
      listVideo: false,
      dialog: false,
      info: false,
      infotext: '',
      notShown: false,
      avatar: '',
    }
  },
  computed: {
        getRandomColor() {
        var colorArray = [
          "blue", "green", "yellow", "orange", "black", "red"
        ];
        var randomColor = Math.floor(Math.random() * 6);
        return colorArray[randomColor];
      },
      logoutLoadStatus(){
       return this.$store.getters.getLogoutLoadStatus;
     },

     updateAvatarStatus(){
       return this.$store.getters.getUpdateAvatarStatus;
     },

     profilePics(){
         const user =this.user;
        if (user && user.avatar){
       return '/images/users/' + user.avatar;
        }
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
       'updateAvatarStatus': function(){
         if(this.updateAvatarStatus == 2){
           //app.dialog.alert(this.$store.getters.getUpdateAvatarMessage);
           //app.dialog.close();
           //this.$f7router.navigate("/profiletab/");
         }
         else if (this.updateAvatarStatus == 3){
           //app.dialog.close();
           //app.dialog.alert(this.$store.getters.getUpdateAvatarMessage);
         }
         else if (this.updateAvatarStatus == 1){
           //app.dialog.preloader();
         }
       },

   },

  methods: {
       userAv(id){
         return `https://robohash.org/${id}`;
     },
      showPost(data){
           this.$router.push(`/post/${data}`);
           console.log('go to post page');
       },
      editProfile() {
      this.$router.push('/editprofile')
      },
      dashboard() {
          this.dialog = true;
          this.$router.push('/dashboard');
        },
        logout() {
          this.$store.dispatch( 'logoutUser');
        },
        infiniteHandler($state) {
      axios.get('/api/auth/user').then(response =>  {
                     console.log(response.data);
                  this.user = response.data.user;
                  this.friends = response.data.friends_count;

                        $state.complete();
                        this.infinite = false;

                }).catch(error => {
                    $state.error();
                });
    },
    fetchAuthenticatedUser() {
      this.$store.dispatch( 'getUser');
    },

    addAvatar() {
      this.$refs.file.click();
    },

    handleFileUpload() {
      this.avatar = this.$refs.file.files[0];
      this.preview = URL.createObjectURL(this.avatar);
      let formData = new FormData();
      let avatar = this.avatar;
      formData.append('avatar', avatar);
      const config = {
      headers: {'content-type': 'multipart/form-data'}
    }
      axios.post('/api/user/update-avatar', formData, config ).then(response =>  {
                     console.log(response.data);
                }).catch(error => {
                   this.preview = '';
                });
    },
  }
}
</script>



