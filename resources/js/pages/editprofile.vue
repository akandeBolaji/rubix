<template>
<f7-page>
  <f7-navbar class="elevation-5">
      <f7-nav-left></f7-nav-left>
      <f7-nav-title>Edit Profile</f7-nav-title>
  </f7-navbar>
    <f7-list no-hairlines-md>
       <f7-block-title>General Profile</f7-block-title>
       <f7-list-item>
        <f7-icon icon="demo-list-icon" slot="media"></f7-icon>
        <f7-label>Career summary</f7-label>
        <f7-input v-if="userData.profile.headline" type="text" :placeholder="userData.profile.headline" @input="profile.headline = $event.target.value"></f7-input>
        <f7-input v-else type="text" placeholder="What you do" @input="profile.headline = $event.target.value"></f7-input>
      </f7-list-item>

      <f7-list-item>
        <f7-icon icon="demo-list-icon" slot="media"></f7-icon>
        <f7-label>Phone</f7-label>
         <f7-input v-if="userData.profile.phone" type="tel" :placeholder="userData.profile.phone" @input="profile.phone = $event.target.value"></f7-input>
        <f7-input v-else type="tel" placeholder="Your phone number" @input="profile.phone = $event.target.value" clear-button></f7-input>
      </f7-list-item>

      <f7-list-item>
        <f7-icon icon="demo-list-icon" slot="media"></f7-icon>
        <f7-label>Location</f7-label>
        <f7-input v-if="userData.profile.location" type="text" :placeholder="userData.profile.location" @input="profile.location = $event.target.value"></f7-input>
        <f7-input v-else type="text" placeholder="Your Location" @input="profile.location = $event.target.value" clear-button></f7-input>
      </f7-list-item>

      <f7-list-item>
        <f7-icon icon="demo-list-icon" slot="media"></f7-icon>
        <f7-label>Facebook Profile</f7-label>
        <f7-input v-if="userData.profile.facebook_profile" type="text" :placeholder="userData.profile.facebook_profile" @input="profile.facebook_profile = $event.target.value"></f7-input>
        <f7-input v-else type="text" placeholder="Your facebook username" @input="profile.facebook_profile = $event.target.value"></f7-input>
      </f7-list-item>

      <f7-list-item>
        <f7-icon icon="demo-list-icon" slot="media"></f7-icon>
        <f7-label>Linkedin Profile</f7-label>
        <f7-input v-if="userData.profile.linkedin_profile" type="text" :placeholder="userData.profile.linkedin_profile" @input="profile.linkedin_profile = $event.target.value"></f7-input>
        <f7-input v-else type="text" placeholder="Your Linkedin Url" @input="profile.linkedin_profile = $event.target.value"></f7-input>
      </f7-list-item>

      <f7-list-item>
        <f7-icon icon="demo-list-icon" slot="media"></f7-icon>
        <f7-label>Google Plus Profile</f7-label>
        <f7-input v-if="userData.profile.google_plus_profile" type="text" :placeholder="userData.profile.google_plus_profile" @input="profile.google_plus_profile = $event.target.value"></f7-input>
        <f7-input v-else type="text" placeholder="Your Google Plus Username" @input="profile.google_plus_profile = $event.target.value"></f7-input>
      </f7-list-item>

      <f7-list-item>
        <f7-icon icon="demo-list-icon" slot="media"></f7-icon>
        <f7-label>Twitter Profile</f7-label>
         <f7-input v-if="userData.profile.twitter_profile" type="text" :placeholder="userData.profile.twitter_profile" @input="profile.twitter_profile = $event.target.value"></f7-input>
        <f7-input v-else type="text" placeholder="Your twitter username" @input="profile.twitter_profile = $event.target.value"></f7-input>
      </f7-list-item>

      <f7-list-item>
        <f7-icon icon="demo-list-icon" slot="media"></f7-icon>
        <f7-label>Gender</f7-label>
         <f7-input v-if="userData.profile.gender" type="select" :value="userData.profile.gender" @input="profile.gender = $event.target.value">
          <option value="Male">Male</option>
          <option value="Female">Female</option>
        </f7-input>
        <f7-input v-else type="select" value="Male" @input="profile.gender = $event.target.value">
          <option value="Male">Male</option>
          <option value="Female">Female</option>
        </f7-input>
      </f7-list-item>

      <f7-list-item>
        <f7-icon icon="demo-list-icon" slot="media"></f7-icon>
        <f7-label>Date of Birth</f7-label>
        <f7-input v-if="userData.profile.date_of_birth" type="text"  :placeholder="userData.profile.date_of_birth" @input="profile.date_of_birth = $event.target.value"></f7-input>
        <f7-input v-else type="date"  placeholder="Please choose..." @input="profile.date_of_birth = $event.target.value"></f7-input>
      </f7-list-item>
    </f7-list>

    <f7-block-title v-if="userData.skill[0]">Existing Skills</f7-block-title>
    <f7-chip deleteable @click="deleteSkill( skill.id )" media-text-color="white" :media="skill.description.slice(0,1)" :media-bg-color="getRandomColor" v-for="(skill) in userData.skill" v-bind:key='skill.id' :text="skill.description"></f7-chip>

    <f7-block-title v-show="skillFalse">New Skills</f7-block-title>
    <f7-chip deleteable @click="removeSkill( key )" media-text-color="white" :media="skill.slice(0,1)" :media-bg-color="getRandomColor" v-for="(skill, key) in skills" v-bind:key='skill' :text="skill"></f7-chip>

    <f7-list>
      <f7-block-title>Add Skills</f7-block-title>
       <f7-list-item>
        <f7-icon icon="demo-list-icon" slot="media"></f7-icon>
        <input type="text" placeholder="Add skill" name="skill" v-model="skill" v-validate="'required|min:3'">
      </f7-list-item>
      <f7-button fill @click="addSkill">Add Skill</f7-button>
      </f7-list>

   <f7-block-title v-if="userData.experience[0]">Existing Experience</f7-block-title>
      <f7-block strong v-for="(experience) in userData.experience" v-bind:key='experience.id'>
        <b>Name of Organisation</b><br/>
        {{ experience.name }}<br/>
        <b>Location of Organisation</b><br/>
        {{ experience.location }}<br/>
        <b>Start Date - End Date</b><br/>
        {{ experience.start_date }} - {{ experience.end_date }}<br/>
        <f7-button fill @click="deleteExperience( experience.id )">Delete Experience</f7-button>
      </f7-block>

   <f7-block-title v-show="experienceFalse">New Experience</f7-block-title>
      <f7-block strong v-for="(experience, key) in experiences" v-bind:key='experience.name'>
        <b>Name of Organisation</b><br/>
        {{ experience.name }}<br/>
        <b>Location of Organisation</b><br/>
        {{ experience.location }}<br/>
        <b>Start Date - End Date</b><br/>
        {{ experience.start_date }} - {{ experience.end_date }}<br/>
        <f7-button fill @click="removeExperience( key )">Remove Experience</f7-button>
      </f7-block>

    <f7-list>
      <f7-block-title>Add Experience</f7-block-title>
       <f7-list-item>
        <f7-icon icon="demo-list-icon" slot="media"></f7-icon>
        <input type="text" placeholder="Name of Organisation" v-model="experience.name">
       </f7-list-item>
       <f7-list-item>
        <f7-icon icon="demo-list-icon" slot="media"></f7-icon>
        <input type="text" placeholder="Location of Organisation" v-model="experience.location">
       </f7-list-item>
       <f7-list-item>
        <f7-icon icon="demo-list-icon" slot="media"></f7-icon>
        <input type="text" placeholder="Start Date" v-model="experience.start_date">
       </f7-list-item>
       <f7-list-item>
        <f7-icon icon="demo-list-icon" slot="media"></f7-icon>
        <input type="text" placeholder="End Date" v-model="experience.end_date">
       </f7-list-item>
      <f7-button fill @click="addExperience">Add Experience</f7-button>
      </f7-list>

      <f7-block-title v-if="userData.accomplishment[0]">Existing Work and Accomplishment</f7-block-title>
      <f7-block strong v-for="(accomplishment) in userData.accomplishment" v-bind:key='accomplishment.id'>
        <b>Accomplishment</b><br/>
        {{ accomplishment.name }}<br/>
        <b>Description</b><br/>
        {{ accomplishment.description }}<br/>
        <p v-if="accomplishment.certificates||accomplishment.links">
        <b>Links to certificates and works</b><br/>
        {{ accomplishment.certificates }}<br/> {{ accomplishment.links }}<br/>
        </p>
        <f7-button fill @click="deleteAccomplishment( accomplishment.id )">Delete Accomplishment</f7-button>
      </f7-block>

      <f7-block-title v-show="accomplishmentFalse">New Work and Accomplishment</f7-block-title>
      <f7-block strong v-for="(accomplishment, key) in accomplishments" v-bind:key='accomplishment.name'>
        <b>Accomplishment</b><br/>
        {{ accomplishment.name }}<br/>
        <b>Description</b><br/>
        {{ accomplishment.description }}<br/>
        <p v-if="accomplishment.certificates||accomplishment.links">
        <b>Links to certificates and works</b><br/>
        {{ accomplishment.certificates }}<br/> {{ accomplishment.links }}<br/>
        </p>
        <f7-button fill @click="removeAccomplishment( key )">Remove Accomplishment</f7-button>
      </f7-block>

     <f7-list>
      <f7-block-title>Add Works and Accomplishments</f7-block-title>
       <f7-list-item>
        <f7-icon icon="demo-list-icon" slot="media"></f7-icon>
        <input type="text" placeholder="Name of Accomplishment" v-model="accomplishment.name">
       </f7-list-item>
       <f7-list-item>
        <f7-icon icon="demo-list-icon" slot="media"></f7-icon>
        <input type="text" placeholder="Description" v-model="accomplishment.description">
       </f7-list-item>
       <f7-list-item>
        <f7-icon icon="demo-list-icon" slot="media"></f7-icon>
        <input type="text" placeholder=" Link to certificate (optional)" v-model="accomplishment.certificates">
       </f7-list-item>
       <f7-list-item>
        <f7-icon icon="demo-list-icon" slot="media"></f7-icon>
        <input type="text" placeholder=" Link to works (optional)" v-model="accomplishment.links">
       </f7-list-item>
      <f7-button fill @click="addAccomplishment">Add</f7-button>
      </f7-list>

      <f7-button big fill raised @click="editProfile">Update Profile</f7-button>
</f7-page>
</template>

<script>
export default {
  data() {
    return {

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

  methods: {
    addSkill() {
      if (this.skill) {
        this.skills.push(this.skill);
        this.skill = '';
        this.skillFalse = true;
        console.log(this.skills);
        }
    },
    removeSkill(key) {
      this.skills.splice( key, 1 );
      if (!this.skills[0]) {
        this.skillFalse = false;
      }
    },
    addExperience() {
      if (this.experience.name && this.experience.location && this.experience.start_date && this.experience.end_date) {
        this.experiences.push(this.experience);
        this.experience = {};
        this.experienceFalse = true;
        console.log(this.experiences);
      }
    },
    removeExperience(key) {
      this.experiences.splice( key, 1 );
      if (!this.experiences[0]) {
        this.experienceFalse = false;
      }
    },

    addAccomplishment() {
      if (this.accomplishment.name && this.accomplishment.description) {
        this.accomplishments.push(this.accomplishment);
        this.accomplishment = {};
        this.accomplishmentFalse = true;
        console.log(this.accomplishments);
      }
    },

    removeAccomplishment(key) {
      this.accomplishments.splice( key, 1 );
      if (!this.accomplishments[0]) {
        this.accomplishmentFalse = false;
      }
    },

    editProfile() {
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
    },

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
          this.$f7router.navigate("/profiletab/");
          //  app.dialog.alert(this.$store.getters.getEditProfileMessage);
           // app.dialog.close();
         }
      }
        // else if (this.editProfileStatus == 3){
          // app.dialog.close();
          // app.dialog.alert(this.$store.getters.getEditProfileMessage);
        // }
        // else if (this.editProfileStatus == 1){
          // app.dialog.preloader();
         //}
      // }
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
      }
    }
}
</script>

