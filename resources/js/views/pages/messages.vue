<template>
<v-app
v-touch="{
      left: () => swipe('Left'),
      right: () => swipe('Right'),
    }"
>
<v-layout mt-5 mb-5>
<v-flex xs12>
<v-card mt-2 v-if="threads && threads.threads != 0 ">
        <span  v-for="thread in threads.threads" :key="thread.id" row wrap>
            <Thread :thread="thread" :user="threads.user"></Thread>
            <v-divider></v-divider>
        </span>
</v-card>
<v-container mt-5 v-else-if="!threads && !infinite" mb-5>
      <v-card height="100%">
          <v-card-text
          height="100%"
          >
         <v-layout row wrap>
             <v-flex
            align-center
            justify-center
            layout
            text-xs-center
             >
             <v-icon>message</v-icon><br/>
              <v-card-title><h3>No threads yet</h3></v-card-title>
             </v-flex>
         </v-layout>
          </v-card-text>
      </v-card>
</v-container>
<infinite-loading v-show="infinite" spinner="circles" @distance="1" @infinite="infiniteHandler">
           <span slot="no-more"></span>
       </infinite-loading>
</v-flex>
</v-layout>
</v-app>
</template>
<script>
import Thread from './threads.vue';
export default {
    components: {
     Thread
    },
  mounted () {
    //fetch threads
    //this.fetchThreads()
    //this.fetchAuthenticatedUser()
  },
     data () {
    return {
      threads: null,
      infinite: true
    }
  },
   computed: {
     //user(){
       //return this.$store.getters.getUserData;
     //},
   },
  methods: {
      swipe(direction){
          if (direction == 'Left') {
             //this.$router.push('/networks');
          }
          else if (direction == 'Right') {
             //this.$router.push('/feeds');
          }

       },
      infiniteHandler($state) {
     axios.get('/api/thread').then(response =>  {
                     console.log(response.data);
                      this.threads = response.data;
                  let _this = this;
                  let user = this.threads.user.id
                  Echo.join(`chat-room.${this.threads.user.id}`);
                   Echo.private(`message.${this.threads.user.id}`)
                        .listen('MessageSent', (e) => {
                            //console.log(e);
                            _.forEach(this.threads.threads, function(value) {
                            if (value.withUser.id == e.user.id) {
                                 value.thread.message = e.message.message;
                                 value.thread.is_seen = 0;
                                 value.unread = value.unread + 1;
                            }
                            console.log(value);
                            });

                        });
                       Echo.private(`messag.${this.threads.user.id}`)
                        .listenForWhisper('typing', (e) => {
                        console.log(e);
                        _.forEach(this.threads.threads, function(value) {
                            if (value.withUser.id == e.user.id) {
                                 value.thread.updated_at = 2;
                        setTimeout(function() {
                            value.thread.updated_at = 0;
                            //_this.typing = false;
                        }, 5000);
                         }
                        });
                        });
                        $state.complete();
                        this.infinite = false;

                }).catch(error => {
                    //$state.complete();
                });
},
      fetchThreads() {
         axios.get('/api/thread').then(response =>  {
                  this.threads = response.data;
                  let _this = this;
                  let user = this.threads.user.id
                  Echo.join(`chat-room.${this.threads.user.id}`);
                   Echo.private(`message.${this.threads.user.id}`)
                        .listen('MessageSent', (e) => {
                            //console.log(e);
                            _.forEach(this.threads.threads, function(value) {
                            if (value.withUser.id == e.user.id) {
                                 value.thread.message = e.message.message;
                                 value.thread.is_seen = 0;
                                 value.unread = value.unread + 1;
                            }
                            console.log(value);
                            });
                            //console.log('hello');
                            //this.message.push(e.message);
                        });
                       Echo.private(`messag.${this.threads.user.id}`)
                        .listenForWhisper('typing', (e) => {
                        console.log(e);
                        _.forEach(this.threads.threads, function(value) {
                            if (value.withUser.id == e.user.id) {
                                 value.thread.updated_at = 2;


                        //this.user = e.user;
                        //this.typing = e.typing;

                        // remove is typing indicator after 0.9s
                        setTimeout(function() {
                            value.thread.updated_at = 0;
                            //_this.typing = false;
                        }, 5000);
                         }
                        //console.log(value);
                        });
                        });
                }).catch(error => {

                });
      },
       //fetchAuthenticatedUser() {
      //this.$store.dispatch( 'getUser');
    //},
  }
}
</script>

