<template>
  <v-app id="inspire">
    <v-navigation-drawer
      v-model="drawer"
      fixed
      temporary
      height="400px"
    >

      <v-list class="pt-0" dense>
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
        <v-toolbar>
         <v-toolbar-title class="blue--text">Rubix</v-toolbar-title>
         <v-spacer></v-spacer>
         <v-toolbar-side-icon class="hidden-md-and-up" @click.stop="drawer = !drawer"></v-toolbar-side-icon>
         <div class="hidden-sm-and-down">
         <v-btn @click="login" class="white--text" color="blue">Login</v-btn>
        </div>
       </v-toolbar>
      <v-container fluid fill-height>
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md4>
            <v-card class="elevation-12">
              <v-toolbar dark color="blue">
                <v-toolbar-title >Register form</v-toolbar-title>
              </v-toolbar>
              <v-card-text>
                <v-form>
                  <v-card-text><b>PERSONAL INFORMATION</b></v-card-text>
                  <v-text-field prepend-icon="person_add" v-validate="'required|min:2'" v-model="data.first_name" name="First Name" label="First Name" type="text"></v-text-field>
                  <span :value="errors.has('First Name')" style="color:red">{{ errors.first('First Name') }}</span>
                  <v-text-field prepend-icon="person_add" v-validate="'required|min:2'" v-model="data.last_name" name="Last Name" label="Last Name" type="text"></v-text-field>
                  <span :value="errors.has('Last Name')" style="color:red">{{ errors.first('Last Name') }}</span>
                  <v-text-field prepend-icon="person_add" v-validate="'required|min:2'" v-model="data.headline" name="Career Summary" label="Career Summary" type="text"></v-text-field>
                  <span :value="errors.has('Career Summary')" style="color:red">{{ errors.first('Career Summary') }}</span>
                  <v-text-field prepend-icon="contact_mail" v-validate="'required|email'" v-model="data.email" name="email" label="Email" type="text"></v-text-field>
                  <span :value="errors.has('email')" style="color:red">{{ errors.first('email') }}</span>
                  <v-text-field prepend-icon="person_outline" v-validate="'required|numeric|min_value:18'" v-model="data.age" name="Age" label="Age" type="text"></v-text-field>
                  <span :value="errors.has('Age')" style="color:red">{{ errors.first('Age') }}</span>
                  <v-select  prepend-icon="people" :items="sex" label="Choose Gender"  v-validate="'required'" v-model="data.gender" name="Gender" type="text" ></v-select>
                  <span :value="errors.has('Gender')" style="color:red">{{ errors.first('Gender') }}</span>
                  <v-text-field prepend-icon="phone" name="Phone" v-validate="'required|numeric'" v-model="data.phone" label="Phone number" type="text"></v-text-field>
                  <span :value="errors.has('Phone')" style="color:red">{{ errors.first('Phone') }}</span>
                  <v-text-field id="password"  v-validate="'required|min:6'" prepend-icon="lock" v-model="data.password" name="password" label="Password" type="password" ref="password"></v-text-field>
                  <span :value="errors.has('password')" style="color:red">{{ errors.first('password') }}</span>
                  <v-text-field id="password_confirmation" v-validate="'required|confirmed:password'" prepend-icon="lock" v-model="data.password_confirmation" name="password_confirmation" data-vv-as="password" label="Password Again" type="password"></v-text-field>
                  <span :value="errors.has('password_confirmation')" style="color:red">{{ errors.first('password_confirmation') }}</span>
                  <v-divider></v-divider>
                   <v-checkbox v-validate="'required:true'" name="terms and condition" v-model="data.checkbox" label="Do you agree with our terms and condition?"></v-checkbox>
                   <span :value="errors.has('terms and condition')" style="color:red">{{ errors.first('terms and condition') }}</span>
                </v-form>
              </v-card-text>
              <v-card-actions>
                <v-btn flat :disabled="dialog" @click="login" color="blue" >or Login?</v-btn>
                <v-spacer></v-spacer>
                <v-btn type="submit" class="white--text" @click="signUp" :disabled="dialog" :loading="dialog" color="blue">Get Registered</v-btn>
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
           sex: [
               'Male',
               'Female'
           ],
           dialog: false,
           info: false,
           infotext: '',
           disable: false,
           drawer: null,
            data: {
                    email: '',
                    age: '',
                    checkbox: '',
                    gender: '',
                    phone: '',
                    password: '',
                    password_confirmation: '',
                    first_name: '',
                    last_name: '',
                    headline: ''
                }
        }
    },

    props: {},

    watch: {
       'registerLoadStatus': function(){
         if(this.registerLoadStatus == 2){
             this.dialog = false;
            this.$router.push('/login');
         }
         else if (this.registerLoadStatus == 3){
             this.dialog = false;
              if (this.$store.getters.getRegisterMessage) {
                 this.infotext = this.$store.getters.getRegisterMessage;
                 this.info = true;
                }
                else {
                 this.infotext = 'An error Occured. Please check your network';
                 this.info = true;
               }
         }
         else if (this.registerLoadStatus == 1){
             this.dialog = true;
         }
       },
   },


   computed: {
     registerLoadStatus(){
       return this.$store.getters.getRegisterLoadStatus;
     },
   },

    methods: {
        signUp(e){
            this.$validator.validate().then(result => {
            if (result) {
               this.disable = true;
               let registerData;
               registerData = this.data
               this.$store.dispatch( 'registerUser',
               {
               registerData
               }
               );
              }
             })
            },

        login() {
          this.dialog= true;
          this.$router.push('/login');
        },
    }
  }
</script>
