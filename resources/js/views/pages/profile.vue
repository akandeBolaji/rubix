<template>
<v-container mb-5>
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
                            v-if="user.profile && user.profile.avatar"
                            alt="avatar">
                            <v-icon
                                large
                                style="font-size: 230px;"
                                v-else
                                >
                                account_circle
                            </v-icon>
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
                            <b><h3>{{ user.profile.first_name + " " + user.profile.last_name }}</h3></b>
                        </v-flex>
                        </v-layout>
                        <v-layout>
                             <v-flex
                            v-if="user.profile && user.profile.headline"
                            xs12
                            align-center
                            justify-center
                            layout
                            text-xs-center
                        >
                          {{ user.profile.headline}}
                        </v-flex>
                        </v-layout>
                         <v-layout>
                             <v-flex
                            v-if="user.profile && user.profile.location"
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
                           <v-btn large class="white--text"  href="/editprofile/" :disabled="dialog" :loading="dialog" color="blue">Edit Profile</v-btn>
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
                          0 Profile Views
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
                         0 Connections
                        </v-card-text>
                        </v-flex>
                        </v-layout>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-container>


         <v-container v-if="user.experience != 0">
              <v-card-text v-if="user.experience != 0"><b>Experience and Education</b></v-card-text>
                    <v-card
                    v-for="experience in user.experience"
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


        <v-container v-if="user.skill != 0">
             <v-card-text v-if="user.skill != 0"><b>Skills</b></v-card-text>
            <v-card>
                 <v-chip v-for="skill in user.skill" v-bind:key='skill.id'>
                     <v-avatar class="blue">{{ skill.description.slice(0,1) }}</v-avatar>
                     {{skill.description}}
                   </v-chip>
            </v-card>
        </v-container>

         <v-container v-if="user.accomplishment != 0">
             <v-card-text v-if="user.accomplishment != 0"><b>Works and Accomplishments</b></v-card-text>
           <v-card
                    v-for="accomplishment in user.accomplishment"
                            :key="accomplishment.id"
                     class="elevation-6">
                         <v-card-text><b>{{accomplishment.name}}</b></v-card-text>
                          <v-card-text>{{accomplishment.description}}</v-card-text>
                           <v-card-text v-if="accomplishment.certificates">{{accomplishment.certificates}}</v-card-text>
                            <v-card-text v-if="accomplishment.works">{{accomplishment.works}}</v-card-text>
                    </v-card>
        </v-container>

            <v-container v-if="user.skill != 0">
             <v-expansion-panel>
    <v-expansion-panel-content
    >
      <div slot="header">Contacts</div>

        <v-list two-line>
          <v-list-tile>
            <v-list-tile-action>
              <v-icon color="blue">phone</v-icon>
            </v-list-tile-action>

            <v-list-tile-content>
              <v-list-tile-title>{{user.profile.phone}}</v-list-tile-title>
              <v-list-tile-sub-title>Mobile</v-list-tile-sub-title>
            </v-list-tile-content>
          </v-list-tile>

          <v-divider inset></v-divider>

          <v-list-tile>
            <v-list-tile-action>
              <v-icon color="blue">mail</v-icon>
            </v-list-tile-action>

            <v-list-tile-content>
              <v-list-tile-title>{{user.profile.email}}</v-list-tile-title>
              <v-list-tile-sub-title>Personal</v-list-tile-sub-title>
            </v-list-tile-content>
          </v-list-tile>

          <v-divider inset></v-divider>

           <v-list-tile v-if="user.profile && user.profile.linkedin_profile">
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
</template>
<script>
export default {
  mounted () {
    this.fetchAuthenticatedUser()
  },

  data () {
    return {
    drawer: null,
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
     user(){
       return this.$store.getters.getUserData;
     },

     updateAvatarStatus(){
       return this.$store.getters.getUpdateAvatarStatus;
     },

     profilePics(){
         const user =this.$store.getters.getUserData;
        if (user.profile && user.profile.avatar){
       return 'http://rubix.site/images/users/' + this.user.profile.avatar;
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
      dashboard() {
          this.dialog = true;
          this.$router.push('/dashboard');
        },
        logout() {
          this.$store.dispatch( 'logoutUser');
        },
    fetchAuthenticatedUser() {
      this.$store.dispatch( 'getUser');
    },

    addAvatar() {
      this.$refs.file.click();
    },

    handleFileUpload() {
      this.avatar = this.$refs.file.files[0];
      let formData = new FormData();
      let avatar = this.avatar;
      formData.append('avatar', avatar);
      this.$store.dispatch( 'updateAvatar',
       {
         formData
       }
     );
    },
  }
}
</script>



