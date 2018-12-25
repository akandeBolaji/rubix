<template>
<f7-page>
  <f7-page>
    <f7-navbar>
      <f7-nav-title>Welcome to Rubik</f7-nav-title>
    </f7-navbar>
  <f7-button fill raised login-screen-open="#signup-screen">SignUp Screen</f7-button>
  </f7-page>
   <!-- Login Screen -->
    <f7-login-screen id="signup-screen">
      <f7-view>
        <f7-page login-screen>
          <f7-login-screen-title>SignUp</f7-login-screen-title>
          <f7-list form>
            <f7-list-item>
              <f7-label>Firstname</f7-label>
              <f7-input name="first_name" placeholder="Enter first name here" type="text" @input="registerForm.first_name = $event.target.value" ></f7-input>
            </f7-list-item>
            <f7-list-item>
              <f7-label>Lastname</f7-label>
              <f7-input name="last_name" placeholder="Enter Last name here" type="text" @input="registerForm.last_name = $event.target.value" ></f7-input>
            </f7-list-item>
            <f7-list-item>
              <f7-label>Email</f7-label>
              <f7-input name="email" placeholder="Enter Email here" type="text" @input="registerForm.email = $event.target.value" ></f7-input>
            </f7-list-item>
            <f7-list-item>
              <f7-label>Password</f7-label>
              <f7-input name="password" type="password" placeholder="Enter Password here"  @input="registerForm.password = $event.target.value"></f7-input>
            </f7-list-item>
            <f7-list-item>
              <f7-label>Password Again</f7-label>
              <f7-input name="password_confirmation" type="password" placeholder="Re-Password here"  @input="registerForm.password_confirmation = $event.target.value"></f7-input>
            </f7-list-item>
          </f7-list>
          <f7-list>
            <f7-list-button  @click="signUp" title="Sign Up"></f7-list-button>
             <f7-list-button @click="loginScreen" title="or go back to SignIn"></f7-list-button>
          </f7-list>
        </f7-page>
      </f7-view>
    </f7-login-screen>
</f7-page>
</template>
<script>
export default {
  data() {
            return {
                registerForm: {
                    email: '',
                    password: '',
                    password_confirmation: '',
                    first_name: '',
                    last_name: ''
                }
            }
        },

   watch: {
       'registerLoadStatus': function(){
         if(this.registerLoadStatus == 2){
            app.dialog.close();
            app.dialog.alert(this.$store.getters.getRegisterMessage);
            app.loginScreen.close();
            this.$f7router.navigate('/login/');
         }
         else if (this.registerLoadStatus == 3){
           app.dialog.close();
           app.dialog.alert(this.$store.getters.getRegisterMessage);
           this.$f7router.navigate('/login/');
         }
         else if (this.registerLoadStatus == 1){
           app.dialog.preloader();
         }
       }
   },


   computed: {

     registerLoadStatus(){
       return this.$store.getters.getRegisterLoadStatus;
     }

   },

   methods: {
            signUp(e){
               let registerData;
               registerData = this.registerForm
               this.$store.dispatch( 'registerUser',
               {
               registerData
               }
               );
            },

              loginScreen(e){
              app.loginScreen.close();
              this.$f7router.navigate('/login/');
            },
        }
}
</script>
