<template>
    <f7-page>
       <f7-block-title>Profile Overview</f7-block-title>

       <f7-block strong inset>
            <f7-fab @click='addAvatar()' color="white" position='center-center'>
              <f7-icon color="black" ios="f7:camera" md="material:camera"></f7-icon>
            </f7-fab>
           <div class="img" >
             <img :src="profilePics" width="220" height="220"  />
           </div>
         <p>{{ profile.profile.first_name + " " + profile.profile.last_name }}</p>
         <p>{{ profile.profile.headline}}</p> <span>From {{ profile.profile.location}}</span>

         <p>0 <span> <f7-icon class="icon-fill" ios="f7:persons_fill" md="material:home"></f7-icon></span></p>
         <f7-button big fill raised href="/editprofile/" >Edit Profile</f7-button>
       </f7-block>
       <f7-block inset strong>
         <f7-row no-gap>
        <f7-col>
          0 Profile Views
        </f7-col>
        <f7-col>
          0 Connections
        </f7-col>
      </f7-row>
       </f7-block>
       <f7-block-title>Experience and Education</f7-block-title>
    <f7-list media-list>
      <f7-list-item v-for="experience in profile.experience" v-bind:key='experience.id'
        :title="experience.name"
        :subtitle="experience.location"
        :text="experience.start_date + ' - ' + experience.end_date"
      >
        <img slot="media" width="35" />
      </f7-list-item>
    </f7-list>
         <f7-list accordion-list>
          <f7-list-item accordion-item title="Skills">
            <f7-accordion-content>
              <f7-block>
              <f7-chip v-for="skill in profile.skill" v-bind:key='skill.id' :text="skill.description"></f7-chip>
              </f7-block>
           </f7-accordion-content>
          </f7-list-item>
          <f7-list-item accordion-item title="Works and Accomplishments">
            <f7-accordion-content>
              <f7-list>
                <f7-list-item v-for="accomplishment in profile.accomplishment" v-bind:key='accomplishment.id' :header="accomplishment.name" :title="accomplishment.description"  footer="link to view or download work">
                </f7-list-item>
              </f7-list>
           </f7-accordion-content>
          </f7-list-item>
          <f7-list-item accordion-item title="Contacts">
            <f7-accordion-content>
              <f7-list>
                <f7-list-item header="Phone" :title="profile.profile.phone"></f7-list-item>
                <f7-list-item header="Email" :title="profile.profile.email"></f7-list-item>
                <f7-list-item v-show='profile.profile.linkedin_profile' header="Linkedin" :title="profile.profile.linkedin_profile"></f7-list-item>
              </f7-list>
           </f7-accordion-content>
          </f7-list-item>
         </f7-list>
         <f7-list>
      <f7-list-item v-show=false>
        <input type="file" id="file" accept="image/*" ref="file" @change="handleFileUpload()"/>
      </f7-list-item>
         </f7-list>
    </f7-page>
</template>
<script>
export default {
  created () {
    this.fetchAuthenticatedUser()
  },

  data () {
    return {
      notShown: false,
      avatar: '',
    }
  },
  computed: {

     profile(){
       return this.$store.getters.getUserData;
     },

     updateAvatarStatus(){
       return this.$store.getters.getUpdateAvatarStatus;
     },

     profilePics(){
       return 'http://rubix.site/images/users/' + this.profile.profile.avatar;
     }

   },

   watch: {
       'updateAvatarStatus': function(){
         if(this.updateAvatarStatus == 2){
           app.dialog.alert(this.$store.getters.getUpdateAvatarMessage);
           app.dialog.close();
           //this.$f7router.navigate("/profiletab/");
         }
         else if (this.updateAvatarStatus == 3){
           app.dialog.close();
           app.dialog.alert(this.$store.getters.getUpdateAvatarMessage);
         }
         else if (this.updateAvatarStatus == 1){
           app.dialog.preloader();
         }
       },

   },

  methods: {
    fetchAuthenticatedUser() {
      axios.get('/user')
      .then(response => {
        console.log('hello');
      })
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

<style scoped>
.img img {
  display: block;
  margin-left: auto;
  margin-right:auto;
  border-radius : 50%;
};
</style>

