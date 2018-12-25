<template>
  <v-app id="inspire">
        <v-toolbar fixed>
         <v-toolbar-title class="green--text darken-1">Polibet</v-toolbar-title>
         <v-spacer></v-spacer>
         <v-toolbar-side-icon class="hidden-md-and-up" @click.stop="drawer = !drawer"></v-toolbar-side-icon>
         <div class="hidden-sm-and-down">
         <v-btn @click="openStats" class="white--text" color="green darken-2">Check Statistics</v-btn>
         <v-btn @click="login" v-if="loggedOut" class="white--text" color="green darken-2">Login</v-btn>
         <v-btn @click="register" v-if="loggedOut" class="white--text" color="green darken-2">Register</v-btn>
         <v-btn @click="dashboard" v-if="!loggedOut"  class="white--text" color="green darken-2" >Go to Dashboard</v-btn>
         <v-btn @click="logout" v-if="!loggedOut"  class="white--text" color="green darken-2" >Logout</v-btn>
         </div>
       </v-toolbar>
       <section>
         <v-parallax
       src="/images/background/polibet/new.jpg"
       height="600"
       >
    <v-layout
      align-center
      column
      justify-center
    >
      <h1 class="display-2 font-weight-thin mb-2 text-xs-center">Polibet</h1>
      <h4 class="subheading mb-5 text-xs-center">Research, Predict, and Vote</h4>
      <v-divider></v-divider>
      <v-btn
              class="white green--text darken-2 mt-5"
              dark
              large
              @click="register"
            >
              Get Started
            </v-btn>
    </v-layout>
  </v-parallax>
       </section>

       <h3 class="text-xs-center">
               Existing Users - {{this.statsData.users}}
        </h3>


        <section>
        <v-layout
          column
          wrap
          class="my-5"
          align-center
        >
          <v-flex xs12>
            <v-container grid-list-xl>
              <v-layout row wrap align-center>
                <v-flex xs12 md6>
                  <v-card class="elevation-3 transparent">
                      <v-card-text class="text-xs-center">
                      <v-icon x-large class="green--text text--lighten-2">new_releases</v-icon>
                    </v-card-text>
                    <v-card-title primary-title class="layout justify-center">
                      <div class="headline text-xs-center">What We Are?</div>
                    </v-card-title>
                    <v-card-text>
                      Polibet is a prediction and research platform created to get the Nigerian youths actively involved in the coming general elections.
                      We were greatly influenced by the positive impact and role popular research and prediction platform 'predictit.org' plays
                      in the United States and other top world countries politics.
                    </v-card-text>
                    <h3 class="text-xs-center">
                    <v-btn
                        class="align-center green mb-4 darken-2 white--text"
                        dark
                        large
                        @click="openStats"
                        >
                        Check Statistics
                        </v-btn>
                    </h3>
                  </v-card>
                </v-flex>
                <v-flex xs12 md6>
                  <v-card class="elevation-3 transparent">
                    <v-card-text class="text-xs-center">
                      <v-icon x-large class="green--text text--lighten-2">view_agenda</v-icon>
                    </v-card-text>
                    <v-card-title primary-title class="layout justify-center">
                      <div class="headline">How we operate</div>
                    </v-card-title>
                    <v-card-title class="layout justify-center">
                      <div><b>Win up to 200% of your stake amount !!!</b></div>
                    </v-card-title>
                    <v-card-text>
                        Win amounts are variable and dependent on other users as they are calculated by dividing the amount staked for a predict and dividing it by the total similar predicts for that category,
                        the result is then multiplied by the total predicts for that category. <b>Predicts for each category closes an hour to election.</b>
                    </v-card-text>
                    <v-card-title class="layout justify-center">
                      <div><b>Verifying total amount staked in each category</b></div>
                    </v-card-title>
                    <v-card-text>
                        Since Accounts can only be funded via Paystack, The total amount staked in the system can be verified via our account statement from Paystack which would be shared with all users.
                        Each user would be allowed to place subsequent predicts for only one candidate in a category.
                       <b>A 5% transaction fee would be deducted on all earnings.</b>
                    </v-card-text>
                    <h3 class="text-xs-center">
                    <v-btn
                        class="align-center green darken-2  mb-4 white--text"
                        dark
                        large
                        @click="calculateWin"
                        >
                        Calculate Possible Win
                        </v-btn>
                    </h3>
                  </v-card>
                </v-flex>
              </v-layout>
            </v-container>
          </v-flex>
        </v-layout>
      </section>

        <section>
        <v-container grid-list-xl>
          <v-layout row wrap justify-center>
            <v-flex xs12 sm4>
              <v-card class="elevation-0 transparent">
                <v-card-title primary-title class="layout justify-center">
                  <div class="headline">Want to know More ?</div>
                </v-card-title>
                <v-card-text>
                 Take your time to read our <router-link to="/about-us" class="green--text"> Privacy Policy</router-link>
                  and <router-link to="/about-us" class="green--text"> Terms and Conditions</router-link> to know more about how we operate.
                </v-card-text>
              </v-card>
            </v-flex>
            <v-flex xs12 sm4 offset-sm1>
              <v-card class="elevation-0 transparent">
                <v-card-title primary-title class="layout justify-center">
                  <div class="headline">Contact us</div>
                </v-card-title>
                  <v-card-text>
                 In cases of complaints and feedbacks, you can reach us through the following :
                </v-card-text>
                <v-list class="transparent">
                  <v-list-tile>
                    <v-list-tile-action>
                      <v-icon class="green--text text--lighten-2">phone</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                      <v-list-tile-title>2348052764314</v-list-tile-title>
                    </v-list-tile-content>
                  </v-list-tile>
                  <v-list-tile>
                    <v-list-tile-action>
                      <v-icon class="green--text text--lighten-2">email</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                      <v-list-tile-title>support@polibet.ng</v-list-tile-title>
                    </v-list-tile-content>
                  </v-list-tile>
                </v-list>
              </v-card>
            </v-flex>
          </v-layout>
        </v-container>
      </section>
      <v-footer class="elevation-3" color="green darken-2" height="auto">
          <v-layout

      justify-center
      row
      wrap
    >
           <v-flex
        white
        lighten-2
        py-3
        text-xs-center
        green--text
        xs12
      >
        &copy;2018 — <strong>Polibet</strong>
      </v-flex>
      </v-layout>
          <v-layout row wrap align-center>
          <v-flex xs12>
            <div class="white--text ml-3 text-xs-center">
              Made with
              <v-icon class="white--text">favorite</v-icon>
              by <a class="white--text" href="http://codebator.me" target="_blank">CodeBator</a>
            </div>
          </v-flex>
        </v-layout>
      </v-footer>
       <v-navigation-drawer
      v-model="drawer"
      fixed
      temporary
      height="400px"
    >
      <v-list class="pt-0" dense>
           <v-list-tile @click="openStats">
          <v-list-tile-action>
            <v-icon color="green">collections</v-icon>
          </v-list-tile-action>

          <v-list-tile-content>
            <v-list-tile-title>Check Statistics</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>

        <v-list-tile v-if="!loggedOut" @click="dashboard">
          <v-list-tile-action>
            <v-icon color="green">dashboard</v-icon>
          </v-list-tile-action>

          <v-list-tile-content>
            <v-list-tile-title>Dashboard</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>

        <v-list-tile v-if="!loggedOut" @click="logout">
          <v-list-tile-action>
            <v-icon color="red">logout</v-icon>
          </v-list-tile-action>

          <v-list-tile-content>
            <v-list-tile-title>Logout</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>

        <v-list-tile v-if="loggedOut" @click="login">
          <v-list-tile-action>
            <v-icon color="green">lock_open</v-icon>
          </v-list-tile-action>

          <v-list-tile-content>
            <v-list-tile-title>Login</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>

        <v-list-tile v-if="loggedOut" @click="register">
          <v-list-tile-action>
            <v-icon color="green">create</v-icon>
          </v-list-tile-action>

          <v-list-tile-content>
            <v-list-tile-title>Register</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
      </v-list>
    </v-navigation-drawer>

      <v-dialog
      v-model="dialog"
      hide-overlay
      persistent
      width="300"
    >
      <v-card
        color="green"
        dark
      >
        <v-card-text>
          Please wait
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
        <v-card-title class="headline">{{ this.infotext }}</v-card-title>
        <div>
        <v-spacer></v-spacer>
        <v-btn color="green" @click="info = false">OK</v-btn>
        </div>
     </v-card>
    </v-dialog>
    <v-dialog
    v-model="openStats_dialog"
    >
          <div slot="header">General Statistics</div>
      >
        <v-card>
          <v-card-title><h4>Presidential Category</h4></v-card-title>
          <v-divider></v-divider>
          <v-list dense v-if="statsData.vote && statsData.amount">
            <v-list-tile class="grey lighten-3">
              <v-list-tile-content>Total Predicts in Category:</v-list-tile-content>
              <v-list-tile-content class="align-end">{{statsData.vote.category_one}}</v-list-tile-content>
            </v-list-tile>
            <v-list-tile>
              <v-list-tile-content>Total Amount staked in Category:</v-list-tile-content>
              <v-list-tile-content class="align-end">N {{statsData.amount.category_one }}</v-list-tile-content>
            </v-list-tile>
             <v-list-tile class="grey lighten-3">
              <v-list-tile-content>Probability of Buhari Winning:</v-list-tile-content>
              <v-list-tile-content class="align-end"> {{buhariProb}}</v-list-tile-content>
            </v-list-tile>
            <v-list-tile>
              <v-list-tile-content>Probability of Atiku Winning:</v-list-tile-content>
              <v-list-tile-content class="align-end"> {{atikuProb}}</v-list-tile-content>
            </v-list-tile>
            <v-list-tile class="grey lighten-3">
              <v-list-tile-content>Total Predicts for Buhari:</v-list-tile-content>
              <v-list-tile-content class="align-end"> {{statsData.vote.candidate_one}}</v-list-tile-content>
            </v-list-tile>
            <v-list-tile>
              <v-list-tile-content>Total Predicts for Atiku:</v-list-tile-content>
              <v-list-tile-content class="align-end"> {{statsData.vote.candidate_two}}</v-list-tile-content>
            </v-list-tile>
            <v-list-tile class="grey lighten-3">
              <v-list-tile-content>Total Amount Staked for Buhari:</v-list-tile-content>
              <v-list-tile-content class="align-end">N {{statsData.amount.candidate_one}} </v-list-tile-content>
            </v-list-tile>
            <v-list-tile>
              <v-list-tile-content>Total Amount Staked for Atiku:</v-list-tile-content>
              <v-list-tile-content class="align-end">N{{statsData.amount.candidate_two}}</v-list-tile-content>
            </v-list-tile>
          </v-list>
        </v-card>

        <v-card>
          <v-card-title><h4>Lagos Governorship Category</h4></v-card-title>
          <v-divider></v-divider>
            <v-list dense v-if="statsData.vote && statsData.amount">
            <v-list-tile class="grey lighten-3">
              <v-list-tile-content>Total Predicts in Category:</v-list-tile-content>
              <v-list-tile-content class="align-end"> {{statsData.vote.category_two}}</v-list-tile-content>
            </v-list-tile>
             <v-list-tile>
              <v-list-tile-content>Total Amount staked in Category:</v-list-tile-content>
              <v-list-tile-content class="align-end">N{{statsData.amount.category_two}}</v-list-tile-content>
            </v-list-tile>
            <v-list-tile class="grey lighten-3">
              <v-list-tile-content>Probability of Sanwo olu Winning:</v-list-tile-content>
              <v-list-tile-content class="align-end"> {{sanwoProb }}</v-list-tile-content>
            </v-list-tile>
            <v-list-tile >
              <v-list-tile-content>Probability of Agbaje Winning:</v-list-tile-content>
              <v-list-tile-content class="align-end"> {{agbajeProb}}</v-list-tile-content>
            </v-list-tile>
            <v-list-tile class="grey lighten-3">
              <v-list-tile-content>Total Predicts for Sanwo-Olu:</v-list-tile-content>
              <v-list-tile-content class="align-end"> {{statsData.vote.candidate_three}}</v-list-tile-content>
            </v-list-tile>
            <v-list-tile>
              <v-list-tile-content>Total Predicts for Agbaje:</v-list-tile-content>
              <v-list-tile-content class="align-end"> {{statsData.vote.candidate_four}}</v-list-tile-content>
            </v-list-tile>
            <v-list-tile class="grey lighten-3">
              <v-list-tile-content>Total Amount Staked for Sanwo-Olu:</v-list-tile-content>
              <v-list-tile-content class="align-end" >N{{statsData.amount.candidate_three}}</v-list-tile-content>
            </v-list-tile>
            <v-list-tile>
              <v-list-tile-content>Total Amount Staked for Agbaje:</v-list-tile-content>
              <v-list-tile-content class="align-end"> N{{statsData.amount.candidate_four}}</v-list-tile-content>
            </v-list-tile>
          </v-list>
        </v-card>
  <v-spacer></v-spacer>
  <v-card>
      <v-spacer></v-spacer>
        <v-btn color="green" class="white--text" @click="openStats_dialog = false">Close</v-btn>
  </v-card>
    </v-dialog>
     <v-dialog
      v-model="calculateWin_dialog"
    >
    <v-card>
        <v-card-title>
          <span class="headline">Calculate present possible win</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-layout wrap>
                <v-text-field label="Stake Amount" v-model="calculate.amount" data-vv-scope="calculate" name="Amount" v-validate="'required|numeric|min_value:5000'"></v-text-field>
                <span :value="errors.has('calculate.Amount')" style="color:red">{{ errors.first('calculate.Amount') }}</span>
                <v-select
                :items="options.category"
                name="Category"
                data-vv-scope="calculate"
                v-validate="'required'"
                v-model="calculate.category"
                label="Category"
                 ></v-select>
                 <span :value="errors.has('calculate.Category')" style="color:red">{{ errors.first('calculate.Category') }}</span>
                <v-select
                v-if="calculate.category"
                :items="filteredCandidate"
                name="Candidate"
                data-vv-scope="calculate"
                v-validate="'required'"
                label="Candidate"
                v-model="calculate.candidate"
                ></v-select>
                <span :value="errors.has('calculate.Candidate')" style="color:red">{{ errors.first('calculate.Candidate') }}</span>
                <span class="headline">Win amount: N{{ this.calculate.win_amount }}</span>
            </v-layout>
          </v-container>
        </v-card-text>
        <v-card-actions>
                <v-btn flat @click="calculateWin_dialog = false">Close</v-btn>
                <v-spacer></v-spacer>
                <v-btn color="green" class="white--text" @click="calculated">Calculate</v-btn>
        </v-card-actions>
    </v-card>

     </v-dialog>
  </v-app>
</template>

<script>

  export default {
    data: () => ({
         options: {
          category: [{
              text:'Presidential Election',
              value: 1 }, {
              text:'Lagos State Governorship Election',
              value: 2
           }],
           candidate: [{
               text: 'Muhammadu Buhari (APC)',
               value: 1,
               dependency: 1 }, {
               text: 'Atiku Abubakar (PDP)',
               value: 2,
               dependency: 1 }, {
               text: 'Jide Sanwo-olu (APC)',
               value: 3,
               dependency: 2 }, {
               text: 'Jimi Agbaje (PDP)',
               value: 4,
               dependency: 2
           }]
      },
        calculate: {
         amount: '',
         category: '',
         candidate: '',
         win_amount: 0
        },
      dialog: false,
      info: false,
      infotext: '',
      openStats_dialog: false,
      calculateWin_dialog:false,
      loggedOut: true,
      disable: false,
      drawer: null,
    }),
    props: {},

    created() {
       this.check();
      this.fetchData();
    },

    methods: {
        calculated(){
            this.$validator.validateAll('calculate').then(result => {
        if (result) {
          let data = this.$store.getters.getStatsData;
          let amount = this.calculate.amount;
          let category = this.calculate.category;
          let candidate = this.calculate.candidate;
          if (category == 1){
              if (candidate == 1  && data.amount.category_one != 0 && data.amount.candidate_one != 0) {
                this.calculate.win_amount =  Math.floor((amount/data.amount.candidate_one) * data.amount.category_one);
              }
              else if (candidate == 2  && data.amount.category_one != 0 && data.amount.candidate_two != 0) {
                this.calculate.win_amount =   Math.floor((amount/data.amount.candidate_two) * data.amount.category_one);
              }
              else if (candidate == 1  && data.amount.category_one != 0 && data.amount.candidate_one == 0){
                  this.calculate.win_amount =  data.amount.category_one;
              }
               else if (candidate == 2  && data.amount.category_one != 0 && data.amount.candidate_two == 0){
                  this.calculate.win_amount =  data.amount.category_one;
              }
              else {
                  this.calculate.win_amount = amount;
              }
          }
          else if (category == 2 ) {
              if (candidate == 3  && data.amount.category_two != 0 && data.amount.candidate_three != 0) {
                this.calculate.win_amount =   Math.floor((amount/data.amount.candidate_three) * data.amount.category_two);
              }
              else if (candidate == 4  && data.amount.category_two != 0 && data.amount.candidate_four != 0) {
                this.calculate.win_amount =   Math.floor((amount/data.amount.candidate_four) * data.amount.category_two);
              }
               else if (candidate == 3  && data.amount.category_two != 0 && data.amount.candidate_three == 0){
                  this.calculate.win_amount =  data.amount.category_two;
              }
               else if (candidate == 4  && data.amount.category_two != 0 && data.amount.candidate_four == 0){
                  this.calculate.win_amount =  data.amount.category_two;
              }
              else {
                  this.calculate.win_amount = amount ;
              }
          }
          console.log("calculate win");
        }
        })
        },
        openStats(){
            this.openStats_dialog = true;
          console.log("open stats");
        },
        calculateWin(){
            this.calculateWin_dialog = true;
          console.log("calculate win");
        },
       fetchData() {
         this.$store.dispatch( 'getStats');
       },

       check() {
          this.$store.dispatch('check')
       },

        login() {
          this.dialog = true;
          this.$router.push('/login');

        },
        register() {
          this.dialog = true;
          this.$router.push({ path: '/register', query: { ref: this.$route.query.ref }})
        },
        dashboard() {
          this.dialog = true;
          this.$router.push('/dashboard');
        },
        logout() {
          this.$store.dispatch( 'logoutUser');
        },
    },


   computed: {
       filteredCandidate(){
          let candidate = this.options.candidate;
          return candidate.filter(o => o.dependency == this.calculate.category);
        },
       buhariProb(){
        let data = this.$store.getters.getStatsData;
        if (data.vote.category_one != 0 && data.vote.candidate_one != 0){
        let answer = (data.vote.candidate_one/data.vote.category_one * 100).toFixed(1);
        return answer + '%';
        }
         else {
            return '100%' ;
        }
       },
        atikuProb(){
        let data = this.$store.getters.getStatsData;
        if (data.vote.category_one != 0 && data.vote.candidate_two != 0){
        let answer = ((data.vote.candidate_two/data.vote.category_one) * 100).toFixed(1);
        return answer + '%';
        }
        else {
            return '100%' ;
        }
       },
        sanwoProb(){
        let data = this.$store.getters.getStatsData;
        if (data.vote.category_two != 0 && data.vote.candidate_three != 0){
        let answer =((data.vote.candidate_three/data.vote.category_two) * 100).toFixed(1);
        return answer + '%';
        }
        else {
            return '100%' ;
        }
       },
       agbajeProb(){
        let data = this.$store.getters.getStatsData;
        if (data.vote.category_two != 0 && data.vote.candidate_four != 0){
        let answer = ((data.vote.candidate_four/data.vote.category_two) * 100).toFixed(1);
        return answer + '%';
        }
        else {
            return '100%' ;
        }
       },
          logoutLoadStatus(){
       return this.$store.getters.getLogoutLoadStatus;
     },
     statsData(){
       return this.$store.getters.getStatsData;
     },
       checkStatus(){
       return this.$store.getters.getCheckStatus;
     },
     checkStats(){
       return this.$store.getters.getaStatsStatus;
     },
   },

   watch: {
     'checkStatus': function(){
         if(this.checkStatus == 2){
           this.dialog = false;
           if (this.$store.getters.getCheckMessage == true) {
           this.loggedOut = false;
           }
           else {
             this.loggedOut = true;
           }
         }
         else if (this.checkStatus == 3){
            this.$router.go();
         }
         else if (this.checkStatus == 1){
           this.dialog = true;
         }
       },

          'checkStats': function(){
         if(this.checkStats == 2){
           this.dialog = false;
         }
         else if (this.checkStats == 3){
            this.dialog = false;
             this.infotext = "Network is unavailable";
             this.info = true;
         }
         else if (this.checkStats == 1){
           this.dialog = true;
         }
       },

         'logoutLoadStatus': function(){
         if(this.logoutLoadStatus == 2){
           this.dialog = false;
           this.$router.push("/login");
         }
         else if (this.logoutLoadStatus == 3){
           this.dialog = false;
            if (this.$store.getters.getLogoutMessage) {
           this.infotext = this.$store.getters.getLogoutMessage
           this.info = true;
           }
           else {
             this.infotext = 'An error Occured. Please check your network';
             this.info = true;
           };
         }
         else if (this.logoutLoadStatus == 1){
           this.dialog = true;
         }
       }
   }
  }
</script>
