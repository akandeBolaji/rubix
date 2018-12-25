<template>
<f7-page>
  <f7-page>
    <f7-navbar>
      <f7-nav-title>Welcome to Rubik</f7-nav-title>
    </f7-navbar>
  <f7-button fill raised login-screen-open="#forgot-screen">Forgot Password Screen</f7-button>
  </f7-page>
   <!-- Login Screen -->
    <f7-login-screen id="forgot-screen">
      <f7-view>
        <f7-page login-screen>
          <f7-login-screen-title>Forgot Password?</f7-login-screen-title>
          <f7-list form>
            <f7-list-item>
              <f7-label>Email</f7-label>
              <f7-input name="email" placeholder="Email" type="text" @input="passwordForm.email = $event.target.value" ></f7-input>
            </f7-list-item>
          </f7-list>
          <f7-list>
            <f7-list-button  @click="reset" title="Reset Password"></f7-list-button>
             <f7-list-button @click="loginScreen" title="or Go back to login"></f7-list-button>
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
                passwordForm: {
                    email: ''
                }
            }
        },

    watch: {
       'resetPassStatus': function(){
         if(this.resetPassStatus == 2){
            app.dialog.close();
            app.dialog.alert(this.$store.getters.getResetMessage);
            app.loginScreen.close();
            this.$f7router.navigate('/login/');
         }
         else if (this.registerLoadStatus == 3){
           app.dialog.close();
           app.dialog.alert(this.$store.getters.getResetMessage);
         }
         else if (this.registerLoadStatus == 1){
           app.dialog.preloader();
         }
       }
   },


   computed: {

     resetPassStatus(){
       return this.$store.getters.getResetPassStatus;
     }

   },

   methods: {
            reset(e){
              let resetData;
               resetData = this.passwordForm
               this.$store.dispatch( 'resetPass',
               {
               resetData
               }
               );
            },
            loginScreen(e){
              this.$f7router.navigate('/login/');
               app.loginScreen.close();
            },
        }
}
</script>
