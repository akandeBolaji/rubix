<template>
  <v-app id="inspire">
    <v-content>
          <v-toolbar fixed>
         <v-toolbar-title class="blue--text">Rubix</v-toolbar-title>
         <v-spacer></v-spacer>
         <v-toolbar-side-icon class="hidden-md-and-up" @click.stop="drawer = !drawer"></v-toolbar-side-icon>
         <div class="hidden-sm-and-down">
         <v-btn @click="register" class="white--text" color="blue">Register</v-btn>
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
      </v-list>
       </v-navigation-drawer>
      <v-container fluid fill-height>
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md4>
            <v-card class="elevation-12">
              <v-toolbar dark color="blue">
                <v-toolbar-title>Login form</v-toolbar-title>
              </v-toolbar>
              <v-card-text>
                <v-form>
                  <v-text-field prepend-icon="person" v-validate="'required|email'" v-model="loginForm.email" name="Email" label="Email" type="text"></v-text-field>
                  <span :value="errors.has('Email')" style="color:red">{{ errors.first('Email') }}</span>
                  <v-text-field id="password" :append-icon="show1 ? 'visibility_off' : 'visibility'" :type="show1 ? 'text' : 'password'"  v-validate="'required|min:6'" prepend-icon="lock" v-model="loginForm.password" name="password" label="Password" @click:append="show1 = !show1"></v-text-field>
                  <span :value="errors.has('password')" style="color:red">{{ errors.first('password') }}</span>
                </v-form>
              </v-card-text>
              <v-card-actions>
              <v-btn color="blue" @click="register" :disabled="dialog" flat>Register?</v-btn>
              <v-spacer></v-spacer>
              <v-btn color="blue" flat @click="forgot" :disabled="dialog" >Forgot Password?</v-btn>
              </v-card-actions>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn @click="signIn" class="white--text" :disabled="dialog" :loading="dialog" color="blue">Login</v-btn>
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
        &copy;2019 — <strong>Rubix</strong>
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
          Please wait ...
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
      infotext: '',
      show1: false,
      info: false,
      dialog: false,
      drawer: null,
      loginForm: {
                    email: '',
                    password: ''
                },
      }
    },

    props: {},

       watch: {
       'loginLoadStatus': function(){
         if(this.loginLoadStatus == 2){
            localStorage.setItem('auth_token', this.$store.getters.getToken);
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('auth_token');
            this.$router.push('/feeds');
         }
         else if (this.loginLoadStatus == 3){
           this.dialog = false;
            if (this.$store.getters.getLoginMessage) {
              this.infotext = this.$store.getters.getLoginMessage;
              this.info = true;
             }
             else {
                 this.infotext = 'An error Occured. Please check your network';
                 this.info = true;
             }
         }
         else if (this.loginLoadStatus == 1){
           this.dialog = true;
         }
       },
   },

   created() {
     this.checkInfo();

    },

   computed: {
     loginLoadStatus(){
       return this.$store.getters.getLoginLoadStatus;
     },
   },

    methods: {
        checkInfo(){
            if (this.$store.getters.getConfirmResetPassStatus == 3){
                this.dialog = false;
                if (this.$store.getters.getConfirmResetMessage) {
                 this.infotext = this.$store.getters.getConfirmResetMessage;
                 this.info = true;
                }
                else {
                 this.infotext = 'An error Occured. Please check your network';
                 this.info = true;
               }
            };
            if (this.$store.getters.getChangePassStatus == 2){
                this.dialog = false;
                this.infotext = this.$store.getters.getChangePassMessage;
                this.info = true;
            };
              if (this.$store.getters.getLogoutLoadStatus == 2){
                this.info = true;
                this.dialog = false;
                this.infotext = this.$store.getters.getLogoutMessage;
            };
              if (this.$store.getters.getActivateLoadStatus == 2){
                this.info = true;
                this.dialog = false;
                this.infotext = this.$store.getters.getActivateMessage;
            };
            if (this.$store.getters.getRegisterLoadStatus == 2){
                this.info = true;
                this.dialog = false;
                this.infotext = this.$store.getters.getRegisterMessage;
            };
        },

        signIn(e){
             this.$validator.validate().then(result => {
              if (result) {
               let loginData;
               loginData = this.loginForm;
               this.$store.dispatch( 'loginUser',
               {
               loginData
               }
               );
              }
             })
            },

        register() {
          this.dialog= true;
          this.$router.push('/register');
        },
        forgot() {
          this.dialog= true;
          this.$router.push('/password');
        }
    }
  }
</script>
