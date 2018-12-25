<template>
  <v-app id="inspire">
    <v-content>
          <v-toolbar fixed>
         <v-toolbar-title class="blue--text">Rubix</v-toolbar-title>
         <v-spacer></v-spacer>
         <v-toolbar-side-icon class="hidden-md-and-up" @click.stop="drawer = !drawer"></v-toolbar-side-icon>
         <div class="hidden-sm-and-down">
         <v-btn @click="register" class="white--text" color="blue">Register</v-btn>
         <v-btn @click="login" class="white--text" color="blue">Login</v-btn>
        </div>
       </v-toolbar>
       <v-navigation-drawer
      v-model="drawer"
      fixed
      temporary
      height="400px"
    >

      <v-list class="pt-0" dense>
        <v-list-tile @click="register">
          <v-list-tile-action>
            <v-icon>create</v-icon>
          </v-list-tile-action>

          <v-list-tile-content>
            <v-list-tile-title>Register</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>

         <v-list-tile @click="login">
          <v-list-tile-action>
            <v-icon>lock_open</v-icon>
          </v-list-tile-action>

          <v-list-tile-content>
            <v-list-tile-title>Login</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
      </v-list>
       </v-navigation-drawer>

       <v-container fluid fill-height>
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md4>
            <v-card class="elevation-12">
              <v-toolbar dark color="blue">
                <v-toolbar-title>Password Reset form</v-toolbar-title>
              </v-toolbar>
              <v-card-text>
                <v-form>
                  <v-text-field prepend-icon="person" v-validate="'required|email'" v-model="passwordForm.email" name="Email" label="Email" type="text"></v-text-field>
                  <span :value="errors.has('Email')" style="color:red">{{ errors.first('Email') }}</span>
                </v-form>
              </v-card-text>
              <v-card-actions>
              <v-btn color="blue" @click="register" :disabled="dialog" flat>Register?</v-btn>
              <v-spacer></v-spacer>
              <v-btn color="blue" flat @click="login" :disabled="dialog" >Back to Login?</v-btn>
              </v-card-actions>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn @click="submit" class="white--text" :disabled="dialog" :loading="dialog" color="blue">Reset Password</v-btn>
              </v-card-actions>
            </v-card>
          </v-flex>
        </v-layout>
      </v-container>
      <v-footer fixed height="auto" color="blue">
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
    </v-content>
     </v-app>
</template>

<script>

    export default {
        data() {
            return {
                drawer: null,
                dialog: false,
                info: false,
                infotext: '',
                passwordForm: {
                    email: ''
                }
            }
        },
        created(){},
        methods: {
            submit(){
                 let resetData;
                 resetData = this.passwordForm
                 this.$store.dispatch( 'resetPass',
                 {
                 resetData
                 }
                 );
            },
        login() {
          this.dialog= true;
          this.$router.push('/login');
        },
         register() {
          this.dialog= true;
          this.$router.push('/register');
        },
        },

          watch: {
       'resetPassStatus': function(){
         if(this.resetPassStatus == 2){
             this.dialog = false;
             this.infotext= this.$store.getters.getResetMessage;
            this.info = true;
         }
         else if (this.resetPassStatus == 3){
             this.dialog = false;
             if (this.$store.getters.getResetMessage) {
                 this.infotext = this.$store.getters.getResetMessage;
                 this.info = true;
                }
                else {
                 this.infotext = 'An error Occured. Please check your network';
                 this.info = true;
               }
         }
         else if (this.resetPassStatus == 1){
             this.dialog = true;
         }
       }
   },


   computed: {
     resetPassStatus(){
       return this.$store.getters.getResetPassStatus;
     }

   },

    }
</script>


