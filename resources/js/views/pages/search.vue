<template>
<v-app>
     <v-toolbar fixed color="white">
        <v-icon size="22px" @click="goBack">arrow_back</v-icon>
        <v-toolbar-title>
            <v-layout>
            <v-flex xs12 align-content-center>
            <v-text-field clearable flat solo v-model.lazy="keywords" v-debounce="500" name="text" label="Search" type="text"></v-text-field>
            </v-flex>
            </v-layout>
        </v-toolbar-title>
    </v-toolbar>
    <v-container v-if="results != 0 && results != null" mt-5 mb-5>
        <v-layout v-if="results != 0"  @click="showUser(user.id)" v-for="user in results" v-bind:key='user.id'>
            <v-flex align-center justify-center layout text-xs-center xs1>
               <v-avatar v-if="user.avatar" color="grey lighten-4">
              <img :src="userPic(user.avatar)" alt="Avatar">
            </v-avatar>
            <v-icon large style="font-size: 50px;" v-else>account_circle</v-icon>
          </v-flex>
          <v-flex xs11>
             <v-card-text><b>{{user.first_name + " " + user.last_name}}</b><br/>{{user.headline}}</v-card-text>
          </v-flex>
          <v-divider></v-divider>
    </v-layout>
    </v-container>
    <v-container v-else-if="loading" mt-5 mb-5>
      <Spinner size="medium" />
    </v-container>
    <v-container v-else-if="results == null" mt-5 mb-5>
       <v-card>
           <v-card-text>
             Enter a user to search
           </v-card-text>
       </v-card>
    </v-container>
    <v-container v-else mt-5 mb-5>
       <v-card>
           <v-card-text>
             No such user
           </v-card-text>
       </v-card>
    </v-container>
</v-app>
</template>

<script>
import Spinner from 'vue-simple-spinner'
export default {
     components: {
     Spinner
    },

    data() {
        return {
            empty: false,
            error: false,
            loading: false,
            keywords: null,
            results: null
        };
    },

    watch: {
        keywords: {
            handler: _.debounce(function () {
            this.fetch()
            }, 400)
        }
    },

    methods: {
         showUser(data){
                    this.$router.push(`/user/${data}`);
                    console.log('show the user information');
            },
         userPic(data){
                return '/images/users/' + data;
            },

         goBack(){
                this.$router.go(-1);
            },
        fetch() {
            this.loading = true;
            axios.get('/api/search', { params: { keywords: this.keywords } })
                .then(response => {
                    console.log(response.data);
                    this.results = response.data.data
                    this.loading = false;
                })
                .catch(error => {
                    this.loading = false;
                });
        }
    }
}
</script>
