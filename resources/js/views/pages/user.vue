<template>
<v-app>
    <v-toolbar fixed color="blue lighten-1">
    <v-icon @click="goBack" dark>arrow_back</v-icon>
    <v-toolbar-title class="white--text" >User</v-toolbar-title>
</v-toolbar>
 <v-container v-if="user != 0" fluid mt-5 mb-5>
            <v-layout row wrap>
                <v-flex xs12 sm8>
                    <v-card class="elevation-6">
                        <v-toolbar dark color="blue">
                            <v-toolbar-title>Profile Overview</v-toolbar-title>
                        </v-toolbar>
                        <v-layout>
                       <v-flex mb-2 mt-2 xs12 align-center justify-center layout text-xs-center>
                            <v-avatar size="230px" color="grey lighten-4">
                            <img :src="profilePics"
                            v-if="user && user.avatar"
                            alt="avatar">
                            <img :src="userAv(user.id)"
                            v-else
                            alt="avatar">
                            </v-avatar>
                        </v-flex>
                        </v-layout>
                        <v-layout>
                             <v-flex v-if="user" mt-3 xs12 align-center justify-center layout text-xs-center>
                            <b><h3>{{ user.first_name + " " + user.last_name }}</h3></b>
                        </v-flex>
                        </v-layout>
                        <v-layout>
                             <v-flex v-if="user.headline" xs12 align-center justify-center layout text-xs-center>
                          {{ user.headline}}
                        </v-flex>
                        </v-layout>
                        <v-layout>
                             <v-flex xs12 align-center justify-center layout text-xs-center>
                          0 Connections
                        </v-flex>
                        </v-layout>
                         <v-layout>
                             <v-flex v-if="user.profile && user.profile.location" xs12 align-center justify-center layout text-xs-center>
                         Lives in {{ user.profile.location}}
                        </v-flex>
                        </v-layout>
                        <v-layout v-if="status == 'send'">
                             <v-flex xs12 mb-2 align-center justify-center layout text-xs-center>
                           <v-btn large @click="sendRequest" class="white--text" :disabled="dialog" :loading="dialog" color="blue">Connect</v-btn>
                        </v-flex>
                        </v-layout>
                        <v-layout v-else-if="status == 'friends'">
                             <v-flex xs12 mb-2 align-center justify-center layout text-xs-center>
                           <v-btn large @click="messageUser" class="white--text" :disabled="dialog" :loading="dialog" color="blue">Message</v-btn>
                        </v-flex>
                        </v-layout>
                        <v-layout v-else-if="status == 'accept'">
                             <v-flex xs6 mb-2 align-center justify-center layout text-xs-center>
                           <v-btn large @click="acceptRequest" class="white--text" :disabled="dialog" :loading="dialog" color="blue">Accept Connect</v-btn>
                        </v-flex>
                        <v-flex xs6 mb-2 align-center justify-center layout text-xs-center>
                           <v-btn large @click="rejectRequest" class="white--text" :disabled="dialog" :loading="dialog" color="blue">Reject Connect</v-btn>
                        </v-flex>
                        </v-layout>
                        <v-layout v-else-if="status == 'pending'">
                             <v-flex xs12 mb-2 align-center justify-center layout text-xs-center>
                           <v-btn large class="white--text" :disabled=true color="blue">Pending Request</v-btn>
                        </v-flex>
                        </v-layout>
                        <v-layout v-else>
                             <v-flex xs12 mb-2 align-center justify-center layout text-xs-center>
                           <v-btn @click="sendRequest" large class="white--text" :disabled="dialog" :loading="dialog" color="blue">Connect</v-btn>
                        </v-flex>
                        </v-layout>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-container>

         <v-container v-if="user.experiences != 0">
              <v-card-text v-if="user.experiences != 0"><b>Experience and Education</b></v-card-text>
                    <v-card
                    v-for="experience in user.experiences"
                            :key="experience.id"
                     class="elevation-6">
                        <v-layout
                            >
                            <v-flex xs2 sm1 md1>
                                <v-avatar v-if="experience.avatar" color="grey lighten-4">
                                <img :src="profilePics" alt="Avatar">
                                </v-avatar>
                                <v-icon large style="font-size: 50px;" v-else>
                                people
                            </v-icon>
                            </v-flex>

                            <v-flex sm10 md10 xs9 mb-2>
                                <strong><b>{{ experience.name }}</b></strong><br/><span> {{experience.location }} <br/> </span> {{ experience.start_date + ' - ' + experience.end_date }}
                            </v-flex>
                            </v-layout>
                    </v-card>
        </v-container>


        <v-container v-if="user.skills">
             <v-card-text v-if="user.skills != 0"><b>Skills</b></v-card-text>
            <v-card>
                 <v-chip v-for="skill in user.skills" v-bind:key='skill.id'>
                     <v-avatar class="blue">{{ skill.description.slice(0,1) }}</v-avatar>
                     {{skill.description}}
                   </v-chip>
            </v-card>
        </v-container>

         <v-container v-if="user.accomplishments">
             <v-card-text v-if="user.accomplishments != 0"><b>Works and Accomplishments</b></v-card-text>
           <v-card
                    v-for="accomplishment in user.accomplishments"
                            :key="accomplishment.id"
                     class="elevation-6">
                         <v-card-text><b>{{accomplishment.name}}</b></v-card-text>
                          <v-card-text>{{accomplishment.description}}</v-card-text>
                           <v-card-text v-if="accomplishment.certificates">{{accomplishment.certificates}}</v-card-text>
                            <v-card-text v-if="accomplishment.links">{{accomplishment.links}}</v-card-text>
                    </v-card>
        </v-container>

    <v-container v-if="user.profile && user.profile.phone ||user.profile && user.profile.email ||user.profile && user.profile.linkedin_profile  ">
    <v-expansion-panel>
    <v-expansion-panel-content>
      <div slot="header">Contacts</div>

        <v-list two-line>
          <v-list-tile v-if="user.profile && user.profile.phone">
            <v-list-tile-action>
              <v-icon color="blue">phone</v-icon>
            </v-list-tile-action>

            <v-list-tile-content>
              <v-list-tile-title>{{user.profile.phone}}</v-list-tile-title>
              <v-list-tile-sub-title>Mobile</v-list-tile-sub-title>
            </v-list-tile-content>
          </v-list-tile>

          <v-divider inset></v-divider>

          <v-list-tile v-if="user.profile && user.profile.email">
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
  <v-container v-else-if="loading" mt-5 mb-5>
      <Spinner size="medium" />
    </v-container>
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
            loading: false,
            user: [],
            dialog: false,
            click: false,
            status: '',
            }
        },
        mounted(){
            this.getUser();
        },

        computed: {
           profilePics(){
         const user =this.user;
        if (user.avatar){
       return '/images/users/' + user.avatar;
        }
     }
        },

        methods: {
             userAv(id){
         return `https://robohash.org/${id}`;
     },
            sendRequest() {
                 this.dialog = true;
                 this.click = true;
                 const id = this.user.id
            axios.post( '/api/connect/' + id + '/befriend').then(response =>  {
                        this.status = 'pending';
                    }).catch(error => {
                        this.dialog = false;
                        this.click = false;
                    });
            },
             acceptRequest() {
                 this.dialog = true;
                 const id = this.user.id
                 axios.post( '/api/connect/' + id + '/acceptfriend').then(response =>  {
                     this.status = 'friends';
                }).catch(error => {
                     this.dialog = false;
                });
            },
            rejectRequest(){
                 this.dialog = true;
                 const id = this.user.id;
                axios.post( '/api/connect/' + id + '/denyfriend').then(response =>  {
                         this.status = 'send';
                        }).catch(error => {
                            this.dialog = false;
                        });
            },
             messageUser() {
                const id = this.user.id;
                this.$router.push(`/conversation/${id}`);
            },
            goBack(){
             this.$router.go(-1);
            },

            getUser() {
                this.loading = true;
                let id = this.$route.params.id;
                 axios.get('/api/user/' + id).then(response =>  {
                     if (response.data.status == 'user') {
                         this.$router.push('/profile');
                     }
                     console.log(response.data);
                     this.user = response.data.user;
                     this.status = response.data.status;
                     this.loading = false;
                }).catch(error => {
                     this.loading = false;
                    //this.dialog = false;
                });
            },
        }

}
</script>



