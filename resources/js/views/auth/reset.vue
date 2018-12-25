<template>
  <v-app id="inspire">
    <v-content>
          <v-toolbar fixed>
         <v-toolbar-title class="blue--text">Rubix</v-toolbar-title>
         <v-spacer></v-spacer>
         <v-toolbar-side-icon class="hidden-md-and-up" @click.stop="drawer = !drawer"></v-toolbar-side-icon>
         <div class="hidden-sm-and-down">
         <v-btn @click="register" class="white--text" color="green">Register</v-btn>
         <v-btn @click="login" class="white--text" color="green">Login</v-btn>
        </div>
       </v-toolbar>
       <v-navigation-drawer
      v-model="drawer"
      absolute
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

       <v-container v-if="showForm" fluid fill-height>
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md4>
            <v-card class="elevation-12">
              <v-toolbar dark color="blue">
                <v-toolbar-title>Reset Password</v-toolbar-title>
              </v-toolbar>
              <v-card-text>
                <v-form>
                  <v-text-field prepend-icon="person" v-validate="'required|email'" v-model="resetForm.email" name="Email" label="Email" type="text"></v-text-field>
                  <span :value="errors.has('Email')" style="color:red">{{ errors.first('Email') }}</span>
                  <v-text-field id="password"  v-validate="'required|min:6'" prepend-icon="lock" v-model="resetForm.password" name="password" label="Password" type="password" ref="password"></v-text-field>
                  <span :value="errors.has('password')" style="color:red">{{ errors.first('password') }}</span>
                  <v-text-field id="password_confirmation" v-validate="'required|confirmed:password'" prepend-icon="lock" v-model="resetForm.password_confirmation" name="password_confirmation" data-vv-as="password" label="Password Again" type="password"></v-text-field>
                  <span :value="errors.has('password_confirmation')" style="color:red">{{ errors.first('password_confirmation') }}</span>
                </v-form>
              </v-card-text>
              <v-card-actions>
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
        <v-card-title class="headline">{{ infotext }}</v-card-title>
        <div>
        <v-spacer></v-spacer>
        <v-btn color="green" @click="info = false">OK</v-btn>
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
                resetForm: {
                    email: '',
                    password: '',
                    password_confirmation: '',
                    token:this.$route.params.token,
                },
                drawer: null,
                infotext: 'hello',
                showForm: false,
                dialog: false,
                info: false,
                message: '',
                status: true,
                showMessage: false
            }
        },

        created(){
            //this.check();
            this.reset();
        },
        methods: {
            reset() {
               let confirmResetData;
               confirmResetData = this.resetForm.token
               this.$store.dispatch( 'confirmResetPass',
               {
               confirmResetData
               }
               );
            },
            submit(){
                  let passData;
                 passData = this.resetForm
                 this.$store.dispatch( 'changePass',
                 {
                 passData
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
                    'confirmResetPassStatus': function(){
                        if (this.confirmResetPassStatus == 2){
                            this.dialog = false;
                            this.showForm = true;
                        }
                        else if (this.confirmResetPassStatus == 3){
                            this.dialog = false;
                            this.$router.push('/login');
                        }
                        else if (this.confirmResetPassStatus == 1){
                            this.dialog = true;
                        }
                    },

                       'changePassStatus': function(){
                        if (this.changePassStatus == 2){
                            this.dialog = false;
                            this.$router.push('/login');
                        }
                        else if (this.changePassStatus == 3){
                            this.dialog = false;
                            if (this.$store.getters.getChangePassMessage) {
                                this.infotext = this.$store.getters.getChangePassMessage;
                                this.info = true;
                                }
                                else {
                                this.infotext = 'An error Occured. Please check your network';
                                this.info = true;
                            }
                        }
                        else if (this.changePassStatus == 1){
                            this.dialog = true;
                        }
                    },

                },


            computed: {
                    confirmResetPassStatus(){
                    return this.$store.getters.getConfirmResetPassStatus;
                    },

                    changePassStatus(){
                        return this.$store.getters.getChangePassStatus;
                    }

                },
    }
</script>
