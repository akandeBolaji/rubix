<template>
<f7-page>
  <f7-page>
    <f7-navbar>
      <f7-nav-title>Welcome to Rubik</f7-nav-title>
    </f7-navbar>
  <f7-button fill raised login-screen-open="#login-screen">Login Screen</f7-button>
  </f7-page>
   <!-- Login Screen -->
    <f7-login-screen id="login-screen">
      <f7-view>
        <f7-page login-screen>
          <f7-login-screen-title>Login</f7-login-screen-title>
          <f7-list form>
            <f7-list-item>
              <f7-label>Email</f7-label>
              <f7-input name="email" placeholder="Email" type="text" @input="loginForm.email = $event.target.value" ></f7-input>
            </f7-list-item>
            <f7-list-item>
              <f7-label>Password</f7-label>
              <f7-input name="password" type="password" placeholder="Password"  @input="loginForm.password = $event.target.value"></f7-input>
            </f7-list-item>
          </f7-list>
          <f7-list>
            <f7-list-button  @click="signIn" title="Sign In"></f7-list-button>
             <f7-list-button @click="signUp" title="or Sign Up"></f7-list-button>
            <f7-block-footer>
              <p>Click <f7-link @click="forgotPass"> Here </f7-link> if you forgot password</p>
            </f7-block-footer>
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
                loginForm: {
                    email: '',
                    password: ''
                },
            }
        },
   watch: {
       'loginLoadStatus': function(){
         if(this.loginLoadStatus == 2){
            app.loginScreen.close();
            this.$root.$data.isLoggedIn = true ;
            localStorage.setItem('auth_token', this.$store.getters.getToken);
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('auth_token');
            this.$f7router.navigate("/hometab/");
            app.dialog.close();
            app.dialog.alert(this.$store.getters.getLoginMessage);
         }
         else if (this.loginLoadStatus == 3){
           app.dialog.close();
           app.dialog.alert(this.$store.getters.getLoginMessage);
         }
         else if (this.loginLoadStatus == 1){
           app.dialog.preloader();
         }
       }
   },

   computed: {

     loginLoadStatus(){
       return this.$store.getters.getLoginLoadStatus;
     }

   },

   methods: {
            signIn(e){
               let loginData;
               loginData = this.loginForm;
               this.$store.dispatch( 'loginUser',
               {
               loginData
               }
               );
               this.$store.dispatch( 'getUser');
            },
            signUp(e){
              app.dialog.preloader();
              //setTimeout(function () {
               // }, 3000);
               app.loginScreen.close();
              this.$f7router.navigate('/signup/');
              app.dialog.close();

            },
             forgotPass(e){
              app.dialog.preloader();
              setTimeout(function () {
                  app.dialog.close();
                }, 3000);
              this.$f7router.navigate('/forgotpass/');
               app.loginScreen.close();
            }
        }
}
</script>
