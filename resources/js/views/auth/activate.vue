<template>
   <v-app id="inspire">
    <v-content>
        <v-toolbar fixed dense>
         <v-toolbar-side-icon class="hidden-md-and-up"></v-toolbar-side-icon>
         <v-spacer></v-spacer>
         <v-container fluid fill-height align-center justify-center>
              <v-toolbar-title class="blue--text">Rubix</v-toolbar-title>
            </v-container>
       </v-toolbar>
                 <v-container fluid fill-height align-center justify-center>
                <v-btn @click="login" class="white--text" color="blue" >Go back to Login</v-btn>
                 </v-container>
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
                Processing...
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
    </v-content>
</v-app>
</template>

<script>
    export default {
        data() {
            return {
                dialog: false,
                info: false,
                infotext: '',
                token:this.$route.params.token,
            }
        },
        created(){
            this.activate();
        },

        methods: {
            activate() {
               let activateData;
               activateData = this.token
               this.$store.dispatch( 'activateUser',
               {
               activateData
               }
               );
            },
            login() {
              this.dialog= true;
              this.$router.push('/login');
            },
        },

        watch: {
       'activateLoadStatus': function(){
         if(this.activateLoadStatus == 2){
             this.dialog = false;
            this.$router.push('/login');
         }
         else if (this.activateLoadStatus == 3){
             this.dialog = false;
             if (this.$store.getters.getActivateMessage) {
              this.infotext = this.$store.getters.getActivateMessage;
              this.info = true;
             }
             else {
                 this.infotext = 'An error Occured. Please check your network';
                 this.info = true;
             }
         }
         else if (this.activateLoadStatus == 1){
             this.dialog = true;
         }
       }
   },


   computed: {
     activateLoadStatus(){
       return this.$store.getters.getActivateLoadStatus;
     }

   },

    }
</script>
<style>
</style>
