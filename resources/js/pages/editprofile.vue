<template>
  <v-app id="inspire">
   <v-toolbar fixed color="blue lighten-1">
        <v-icon @click="goBack" dark>arrow_back</v-icon>
        <v-toolbar-title class="white--text" >Edit Profile</v-toolbar-title>
    </v-toolbar>
      <v-container mt-5 fluid fill-height>
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md4>
            <v-card class="elevation-12">
              <v-toolbar dark color="blue">
                <v-toolbar-title >Edit Profile</v-toolbar-title>
              </v-toolbar>
              <v-card-text>
                <v-form>
                  <v-card-text><b>General Profile</b></v-card-text>
                  <v-text-field v-if="userData && userData.headline" prepend-icon="work"  v-model="profile.headline" name="headline" :placeholder="userData.headline" label="Career Summary" type="text"></v-text-field>
                  <v-text-field v-else prepend-icon="work" v-model="profile.headline" data-vv-scope="profile" v-validate="'required|min:2'"  name="headline" label="Career Summary" type="text"></v-text-field>
                  <span :value="errors.has('profile.headline')" style="color:red">{{ errors.first('profile.headline') }}</span>
                  <v-text-field v-if="userData.profile && userData.profile.phone" prepend-icon="phone" :placeholder="userData.profile.phone" v-model="profile.phone" name="phone" label="Your Phone number" type="text"></v-text-field>
                  <v-text-field v-else prepend-icon="phone" data-vv-scope="profile" v-validate="'required|numeric'" v-model="profile.phone" name="phone" label="Your Phone number" type="text"></v-text-field>
                  <span :value="errors.has('profile.phone')"  style="color:red">{{ errors.first('profile.phone') }}</span>
                  <v-text-field v-if="userData.profile && userData.profile.location" prepend-icon="location_city" v-model="profile.location" :placeholder="userData.profile.location" name="Location" label="Location" type="text"></v-text-field>
                  <v-text-field v-else prepend-icon="location_city" data-vv-scope="profile" v-validate="'required'" v-model="profile.location" name="Location" label="Location" type="text"></v-text-field>
                  <span :value="errors.has('profile.Location')" style="color:red">{{ errors.first('profile.Location') }}</span>
                  <v-text-field v-if="userData.profile && userData.profile.facebook_profile" prepend-icon="chat" :placeholder="userData.profile.facebook_profile" v-model="profile.facebook_profile"  label="Facebook Profile" name="Facebook Profile" type="text"></v-text-field>
                  <v-text-field v-else prepend-icon="chat" v-model="profile.facebook_profile"  label="Facebook Profile" name="Facebook Profile" type="text"></v-text-field>
                  <v-text-field v-if="userData.profile && userData.profile.linkedin_profile" prepend-icon="people" :placeholder="userData.profile.linkedin_profile" label="Linkedin Profile" v-model="profile.linkedin_profile"  name="Linkedin Profile" type="text" ></v-text-field>
                  <v-text-field v-else prepend-icon="people" label="Linkedin Profile" v-model="profile.linkedin_profile"  name="Linkedin Profile" type="text" ></v-text-field>
                  <v-text-field v-if="userData.profile && userData.profile.twitter_profile" prepend-icon="chat_bubble" :placeholder="userData.profile.twitter_profile" name="Twitter Profile" v-model="profile.twitter_profile" label="Twitter Profile" type="text"></v-text-field>
                  <v-text-field v-else prepend-icon="chat_bubble" name="Twitter Profile" v-model="profile.twitter_profile" label="Twitter Profile" type="text"></v-text-field>

                  <v-divider></v-divider>

                    <v-card-text v-if="userData.skill != null && userData.skill != 0"><b>Existing Skills</b></v-card-text>
                    <v-chip small v-for="(skill) in userData.skill" v-bind:key='skill.id'>
                     <v-avatar :class="getRandomColor">{{skill.description.slice(0,1)}}</v-avatar>
                     {{skill.description}}
                     <v-icon  @click="deleteSkill( skill.id )" color="red" right>close</v-icon>
                   </v-chip>

                   <v-divider></v-divider>

                   <v-card-text v-show="skillFalse"><b>New Skills</b></v-card-text>
                   <v-chip small v-for="(skill, key) in skills" v-bind:key='skill'>
                     <v-avatar :class="getRandomColor">{{skill.slice(0,1)}}</v-avatar>
                     {{skill}}
                     <v-icon  @click="removeSkill( key )" color="red" right>close</v-icon>
                   </v-chip>
                   <v-card-text><b>Add Skills</b></v-card-text>
                   <v-text-field prepend-icon="work"  data-vv-scope="skill" v-validate="'required|min:3'" v-model="skill" name="skill" label="Add skill" type="text"></v-text-field>
                  <v-btn @click="addSkill" class="white--text" color="blue">Add Skill</v-btn>

                  <v-divider></v-divider>

                  <v-card-text v-if="userData.experience != null && userData.experience != 0"><b>Existing Experience</b></v-card-text>
                   <v-list dense v-for="(experience) in userData.experience" v-bind:key='experience.id'>
                    <v-list-tile class="grey lighten-3">
                    <v-list-tile-content>Name of Organisation:</v-list-tile-content>
                    <v-list-tile-content class="align-end">{{ experience.name }}</v-list-tile-content>
                    </v-list-tile>
                    <v-list-tile>
                    <v-list-tile-content>Location of Organisation:</v-list-tile-content>
                    <v-list-tile-content class="align-end">{{ experience.location }}</v-list-tile-content>
                    </v-list-tile>
                    <v-list-tile class="grey lighten-3">
                    <v-list-tile-content>Start Date - End Date:</v-list-tile-content>
                    <v-list-tile-content class="align-end"> {{ experience.start_date }} - {{ experience.end_date }}</v-list-tile-content>
                    </v-list-tile>
                    <v-btn @click="deleteExperience( experience.id )" class="white--text" color="blue">Delete Experience</v-btn>
                   </v-list>

                   <v-divider></v-divider>

                  <v-card-text v-show="experienceFalse"><b>New Experience</b></v-card-text>
                   <v-list dense v-for="(experience, key) in experiences" v-bind:key='experience.name'>
                    <v-list-tile class="grey lighten-3">
                    <v-list-tile-content>Name of Organisation:</v-list-tile-content>
                    <v-list-tile-content class="align-end">{{ experience.name }}</v-list-tile-content>
                    </v-list-tile>
                    <v-list-tile>
                    <v-list-tile-content>Location of Organisation:</v-list-tile-content>
                    <v-list-tile-content class="align-end">{{ experience.location }}</v-list-tile-content>
                    </v-list-tile>
                    <v-list-tile class="grey lighten-3">
                    <v-list-tile-content>Start Date - End Date:</v-list-tile-content>
                    <v-list-tile-content class="align-end"> {{ experience.start_date }} - {{ experience.end_date }}</v-list-tile-content>
                    </v-list-tile>
                    <v-btn @click="removeExperience( key )" class="white--text" color="blue">Remove Experience</v-btn>
                   </v-list>

                   <v-card-text><b>Add Experience</b></v-card-text>
                   <v-text-field prepend-icon="people" data-vv-scope="experience" v-validate="'required|min:3'" v-model="experience.name" name="Name of Organisation" label="Name of Organisation" type="text"></v-text-field>
                  <v-text-field prepend-icon="location_city" data-vv-scope="experience" v-validate="'required|min:3'" v-model="experience.location" name="Location of Organisation" label="Location of Organisation" type="text"></v-text-field>
                  <v-text-field prepend-icon="info" data-vv-scope="experience" v-validate="'required|min:3'" v-model="experience.start_date" name="Start Date" label="Start Date" type="text"></v-text-field>
                  <v-text-field prepend-icon="info" data-vv-scope="experience" v-validate="'required|min:3'" v-model="experience.end_date" name="End Date" label="End Date" type="text"></v-text-field>
                  <v-btn @click="addExperience" class="white--text" color="blue">Add Experience</v-btn>

                  <v-divider></v-divider>

                  <v-card-text v-if="userData.accomplishment != 0 && userData.accomplishment != null"><b>Existing Work and Accomplishment</b></v-card-text>
                   <v-list dense v-for="(accomplishment) in userData.accomplishment" v-bind:key='accomplishment.id'>
                    <v-list-tile class="grey lighten-3">
                    <v-list-tile-content>Accomplishment:</v-list-tile-content>
                    <v-list-tile-content class="align-end">{{ accomplishment.name }}</v-list-tile-content>
                    </v-list-tile>
                    <v-card-text>Description</v-card-text>
                    <v-list-tile>
                    <v-list-tile-content>{{ accomplishment.description }}</v-list-tile-content>
                    </v-list-tile>
                    <v-list-tile v-if="accomplishment.certificates||accomplishment.links" class="grey lighten-3">
                    <v-list-tile-content>Links to certificates and works:</v-list-tile-content>
                    <v-list-tile-content class="align-end"> {{ accomplishment.certificates }}<br/> {{ accomplishment.links }}<br/></v-list-tile-content>
                    </v-list-tile>
                    <v-btn @click="deleteAccomplishment( accomplishment.id )" class="white--text" color="blue">Delete Accomplishment</v-btn>
                   </v-list>
                    <v-divider></v-divider>

                  <v-card-text v-show="accomplishmentFalse"><b>New Work and Accomplishment</b></v-card-text>
                   <v-list dense v-for="(accomplishment, key) in accomplishments" v-bind:key='accomplishment.name'>
                   <v-list-tile class="grey lighten-3">
                    <v-list-tile-content>Accomplishment:</v-list-tile-content>
                    <v-list-tile-content class="align-end">{{ accomplishment.name }}</v-list-tile-content>
                    </v-list-tile>
                   <v-card-text>Description</v-card-text>
                    <v-list-tile>
                    <v-list-tile-content>{{ accomplishment.description }}</v-list-tile-content>
                    </v-list-tile>
                    <v-list-tile v-if="accomplishment.certificates||accomplishment.links" class="grey lighten-3">
                    <v-list-tile-content>Links to certificates and works:</v-list-tile-content>
                    <v-list-tile-content class="align-end"> {{ accomplishment.certificates }}<br/> {{ accomplishment.links }}<br/></v-list-tile-content>
                    </v-list-tile>
                    <v-btn @click="removeAccomplishment( key )" class="white--text" color="blue">Remove Accomplishment</v-btn>
                   </v-list>

                   <v-card-text><b>Add Works and Accomplishments</b></v-card-text>
                   <v-text-field prepend-icon="info" data-vv-scope="work" v-validate="'required|min:3'" v-model="accomplishment.name" name="Name" label="Name of Accomplishment" type="text"></v-text-field>
                  <v-textarea prepend-icon="info" data-vv-scope="work" v-validate="'required|min:3'" v-model="accomplishment.description" name="Description" label="Description" type="text"></v-textarea>
                  <v-text-field prepend-icon="info"  v-model="accomplishment.certificates" name="First Name" label="Link to certificate (optional)" type="text"></v-text-field>
                  <v-text-field prepend-icon="info" v-model="accomplishment.links" name="First Name" label="Link to works (optional)" type="text"></v-text-field>
                  <v-btn @click="addAccomplishment" class="white--text" color="blue">Add</v-btn>
                </v-form>
              </v-card-text>
              <v-card-actions>
                  <v-spacer></v-spacer>
                <v-btn type="submit" class="white--text" @click="editProfile" :disabled="dialog" :loading="dialog" color="blue">Update Profile</v-btn>
              </v-card-actions>
            </v-card>
          </v-flex>
        </v-layout>
      </v-container>
      <v-footer height="auto" color="blue">
           <v-layout
      justify-center
      row
      wrap
    >
           <v-flex
        grey
        lighten-2
        py-3
        text-xs-center
        blue--text
        xs12
      >
        &copy;2018 — <strong>Rubix</strong>
      </v-flex>
      </v-layout>
      </v-footer>
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
      drawer: null,
      disable: false,
      dialog: false,
      info: false,
      infotext: '',
      skillFalse: false,
      experienceFalse: false,
      accomplishmentFalse: false,
      accomplishments: [],
      accomplishment: {
         name: '',
         description: '',
         certificates: '',
         links: ''
      },
      skills: [],
      skill: '',
      experiences: [],
      experience: {
        name: '',
        location: '',
        start_date: '',
        end_date: ''
      },
      skillFirst: '',
      profile: {
        avatar: '',
        date_of_birth: '',
        facebook_profile: '',
        gender: '',
        headline: '',
        google_plus_profile: '',
        phone: '',
        gender: '',
        linkedin_profile: '',
        location: '',
        twitter_profile: ''
      },
    }
  },

  created () {
    this.fetchData()
  },

  methods: {
       goBack(){
                this.$router.push('/profile');
            },
      dashboard() {
          this.dialog = true;
          this.$router.push('/dashboard');
        },
        logout() {
          this.$store.dispatch( 'logoutUser');
        },
    fetchData() {
         this.$store.dispatch( 'getUser');
       },
    addSkill() {
      this.$validator.validateAll('skill').then(result => {
        if (result) {
        this.skills.push(this.skill);
        this.skill = '';
        this.skillFalse = true;
        console.log(this.skills);
       }
       else {
          this.infotext = "Please fill field with a minimum of 3 characters";
          this.info = true;
      }
      })
    },
    removeSkill(key) {
      this.skills.splice( key, 1 );
      if (!this.skills[0]) {
        this.skillFalse = false;
      }
    },
    addExperience() {
      this.$validator.validateAll('experience').then(result => {
        if (result) {
        this.experiences.push(this.experience);
        this.experience = {};
        this.experienceFalse = true;
        console.log(this.experiences);
      }
       else {
          this.infotext = "Please fill all fields with a minimum of 3 characters";
          this.info = true;
      }
      })
    },
    removeExperience(key) {
      this.experiences.splice( key, 1 );
      if (!this.experiences[0]) {
        this.experienceFalse = false;
      }
    },

    addAccomplishment() {
      this.$validator.validateAll('work').then(result => {
        if (result) {
        this.accomplishments.push(this.accomplishment);
        this.accomplishment = {};
        this.accomplishmentFalse = true;
        console.log(this.accomplishments);
      }
      else {
          this.infotext = "Please fill name and description fields with a minimum of 3 characters";
          this.info = true;
      }
      })
    },

    removeAccomplishment(key) {
      this.accomplishments.splice( key, 1 );
      if (!this.accomplishments[0]) {
        this.accomplishmentFalse = false;
      }
    },

    editProfile() {
        if (this.experiences != 0 || this.skills != 0 || this.accomplishments != 0 || this.profile.headline != 0 || this.profile.location != 0 || this.profile.phone != 0 || this.profile.twitter_profile != 0 || this.profile.facebook_profile != 0 || this.profile.linkedin_profile != 0){
         this.$validator.validateAll('profile').then(result => {
            if (result) {
      let profileData;
      let experienceData;
      let skillData;
      let accomplishmentData;
      profileData = this.profile;
      experienceData = this.experiences;
      skillData = this.skills;
      accomplishmentData = this.accomplishments;
      this.$store.dispatch( 'editProfile',
               {
               profileData,
               experienceData,
               skillData,
               accomplishmentData
               }
               );
            }
         })

    } else {
        this.infotext = "You did not make any update";
          this.info = true;
    }
    }
    ,

    deleteSkill( key ) {
      console.log(key);
      this.$store.dispatch('removeSkill',
      {
        key
      }
      )
    },

    deleteExperience( key ) {
      console.log(key);
      this.$store.dispatch('removeExperience',
      {
        key
      }
      )
    },

    deleteAccomplishment( key ) {
      console.log(key);
      this.$store.dispatch('removeAccomplishment',
      {
        key
      }
      )
    }

    },

    watch: {
      'editProfileStatus': function(){
         if(this.editProfileStatus == 2){
          //this.$router.push("/profiletab");
          this.dialog = false;
           this.infotext = this.$store.getters.getEditProfileMessage
           this.info = true;
         }

        else if (this.editProfileStatus == 3){
             this.dialog = false;
            this.infotext = this.$store.getters.getEditProfileMessage
           this.info = true;
         }
         else if (this.editProfileStatus == 1){
           this.dialog = true;
         }
       },
        'userLoadStatus': function(){
         if(this.userLoadStatus == 2){
             this.dialog = false;
         }
         else if (this.userLoadStatus == 3){
           this.$router.go();
         }
         else if (this.userLoadStatus == 1){
           this.dialog = true;
         }
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
       }
   },

    computed: {
      userData(){
       return this.$store.getters.getUserData;
     },

      editProfileStatus(){
       return this.$store.getters.getEditProfileStatus;
     },

      getRandomColor() {
        var colorArray = [
          "blue", "green", "yellow", "orange", "black", "red"
        ];
        var randomColor = Math.floor(Math.random() * 6);
        return colorArray[randomColor];
      },
       userLoadStatus(){
       return this.$store.getters.getUserStatus;
     },
     logoutLoadStatus(){
       return this.$store.getters.getLogoutLoadStatus;
     }
    }
}
</script>

