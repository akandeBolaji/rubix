<template>
<f7-app>
</f7-app>
</template>

 <script>
// Import Routes
import routes from '../routes.js'
import helper from '../services/helper'

 export default {
    data() {
    return {
      //isLoggedIn : this.$root.$data.isLoggedIn,
    }
    },
    methods: {
    check() {
      this.$store.dispatch('check')
    }
  },

  mounted() {
  this.check();
  },

  computed: {
       checkStatus(){
       return this.$store.getters.getCheckStatus;
     },
      editProfileStatus(){
       return this.$store.getters.getEditProfileStatus;
     },
     removeSkillStatus(){
       return this.$store.getters.getRemoveSkillStatus;
     },
     removeExperienceStatus(){
       return this.$store.getters.getRemoveExperienceStatus;
     },
     removeAccomplishmentStatus(){
       return this.$store.getters.getRemoveAccomplishmentStatus;
     },
     postAddStatus(){
       return this.$store.getters.getPostAddStatus;
     },
  },

   watch: {
     'checkStatus': function(){
         if(this.checkStatus == 2){
           app.dialog.close();
           if (this.$store.getters.getCheckMessage == true) {
           this.$f7router.navigate("/hometab/");
           }
           else {
             this.$f7router.navigate("/login/");
           }
           //this.isLoggedIn = true;
         }
         else if (this.checkStatus == 3){
           app.dialog.close();
           this.$f7router.navigate("/login/");
           //this.isLoggedIn= false;
         }
         else if (this.checkStatus == 1){
           app.dialog.preloader();
         }
       },

     'postAddStatus': function(){
         if(this.postAddStatus == 2){
           app.dialog.alert(this.$store.getters.getPostAddMessage);
           app.dialog.close();
           //this.$f7router.navigate("/");
         }
         else if (this.postAddStatus == 3){
           app.dialog.close();
           app.dialog.alert(this.$store.getters.getPostAddMessage);
         }
         else if (this.postAddStatus == 1){
           app.dialog.preloader();
         }
       },

       'editProfileStatus': function(){
         if(this.editProfileStatus == 2){
           app.dialog.alert(this.$store.getters.getEditProfileMessage);
           app.dialog.close();
           //this.$f7router.navigate("/profiletab/");
         }
         else if (this.editProfileStatus == 3){
           app.dialog.close();
           app.dialog.alert(this.$store.getters.getEditProfileMessage);
         }
         else if (this.editProfileStatus == 1){
           app.dialog.preloader();
         }
       },

       'removeSkillStatus': function(){
         if(this.removeSkillStatus == 2){
           app.dialog.alert(this.$store.getters.getRemoveSkillMessage);
           app.dialog.close();
         }
         else if (this.removeSkillStatus == 3){
           app.dialog.close();
           app.dialog.alert(this.$store.getters.getRemoveSkillMessage);
         }
         else if (this.removeSkillStatus == 1){
           app.dialog.preloader();
         }
       },

       'removeExperienceStatus': function(){
         if(this.removeExperienceStatus == 2){
           app.dialog.alert(this.$store.getters.getRemoveExperienceMessage);
           app.dialog.close();
         }
         else if (this.removeExperienceStatus == 3){
           app.dialog.close();
           app.dialog.alert(this.$store.getters.getRemoveExperienceMessage);
         }
         else if (this.removeExperienceStatus == 1){
           app.dialog.preloader();
         }
       },

       'removeAccomplishmentStatus': function(){
         if(this.removeAccomplishmentStatus == 2){
           app.dialog.alert(this.$store.getters.getRemoveAccomplishmentMessage);
           app.dialog.close();
         }
         else if (this.removeAccomplishmentStatus == 3){
           app.dialog.close();
           app.dialog.alert(this.$store.getters.getRemoveAccomplishmentMessage);
         }
         else if (this.removeAccomplishmentStatus == 1){
           app.dialog.preloader();
         }
       },

   },


}
 </script>
