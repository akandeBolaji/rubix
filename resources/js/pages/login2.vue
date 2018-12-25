<template>
<f7-app>
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
</f7-app>
</template>
<script>
import Framework7 from 'framework7/framework7.esm.bundle.js'
export default {
  data() {
            return {
                loginForm: {
                    email: '',
                    password: ''
                },
                error: null
            }
        },
   methods: {
            signIn(e){
                app.dialog.preloader();
                setTimeout(function () {
                  app.dialog.close();
                }, 5000);
                axios.post('/api/auth/login', this.loginForm).then(response =>  {
                    localStorage.setItem('auth_token',response.data.token);
                    axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('auth_token');
                    app.dialog.alert(response.data.message);
                    app.loginScreen.close();
                    this.$root.$data.isLoggedIn = true ;
                    this.$f7router.navigate("/", {reloadCurrent: true, ignoreCache: true,});
                }).catch(error => {
                    this.error =error.response.data.message;
                     app.dialog.alert(this.error);
                });
            },
            signUp(e){
              app.dialog.preloader();
              setTimeout(function () {
                  app.dialog.close();
                }, 3000);
              this.$f7router.navigate('/signup/');
               app.loginScreen.close();
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
