<template>
<v-app>
    <v-toolbar fixed color="blue lighten-1">
    <v-icon @click="goBack" dark>arrow_back</v-icon>
    <v-toolbar-title class="white--text" >{{ this.users.full_name}}</v-toolbar-title>
</v-toolbar>
<v-container  :style="{ maxHeight: winHeight}" class="scroll-y" mt-5 mb-5>
      <v-card height="100%" v-if="!message && typemessage == false">
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
              <v-card-title><h3>Start Conversation</h3></v-card-title>
             </v-flex>
         </v-layout>
          </v-card-text>
      </v-card>


      <div>
          <span v-for="(value, key) in computedMessage" :key="value.id">
              <v-subheader>
             {{key}}
            </v-subheader>
            <span v-for="message in value" :key="message.id" >
             <Message :message="message" :user="users" :authuser="authuser"></Message>
            </span>
          </span>
      </div>

         <v-layout v-show="typing">
       <v-flex align-center justify-center layout text-xs-center xs1>
            <v-icon
              large
              style="font-size: 30px;"
              >account_circle</v-icon>
          </v-flex>
          <v-flex xs11>
             <v-card-text><i><b>{{this.users.full_name}}</b> is typing</i></v-card-text>
          </v-flex>
      </v-layout>
         <v-divider></v-divider>
          <v-footer fixed>
          <v-layout>
              <v-flex align-center justify-center layout text-xs-center xs10>
          <v-text-field v-model="user.message" @keydown="isTyping" @keyup="notTyping" @keyup.enter="postMessage" name="text" label="Start typing here" type="text"></v-text-field>
              </v-flex>
          <v-flex align-center justify-center layout text-xs-center xs2>
              <v-btn outline class="white--text" @click="postMessage" :disabled="dialog" :loading="dialog" color="blue">Send</v-btn>
          </v-flex>
        </v-layout>
          </v-footer>
      </v-container>
</v-app>
</template>
<script>
import Message from './message.vue';
var moment = require('moment');
 moment.updateLocale('en', {
    calendar : {
        lastDay : '[Yesterday]',
        sameDay : '[Today]',
        nextDay : 'LL',
        lastWeek : 'LL',
        nextWeek : 'LL',
        sameElse : 'LL'
    }
});
var _ = require('lodash');
export default {
    components: {
     Message
    },
     data() {
            return {
                winHeight: window.innerHeight *0.8 + "px",
                typing: false,
                typemessage: false,
                user: {
                createdDate: '',
                sender: {
                    full_name: '',
                }
                },
                dialog: false,
                message: null,
                users: {
                    id: '',
                },
                authuser: {
                    id: '',
                    fullname: '',
                },
                info: false,
                infotext: '',
                id:this.$route.params.id,
            }
        },
        created(){
            this.getConversation();
        },

        computed: {
          computedMessage() {
              const messages = this.message;
              if (messages) {
                  let groupedResults = _.groupBy(messages, (message) => moment(message['created_at']).calendar());
                  console.log(groupedResults);
                  return groupedResults;
              }
          }
        },

        methods: {
             computedMessag() {
              const messages = this.message;
              //if (messages) {
                  let groupedResults = _.groupBy(messages, (message) => moment(message['created_at']).format('LL'));
                  console.log(groupedResults);
              //}
          },
            goBack(){
                this.$router.push('/messages');
            },
            isTyping() {
            //console.log('yes');
            let channel = Echo.private(`messag.${this.authuser.id}.${this.users.id}`);

            setTimeout(function() {
                channel.whisper('typing', {
                //user: Laravel.user,
                    typing: true
                });
            }, 300);
            },
            notTyping() {
            //console.log('yes');
            let channel = Echo.private(`messag.${this.authuser.id}.${this.users.id}`);

            setTimeout(function() {
                channel.whisper('typing', {
                //user: Laravel.user,
                    typing: false
                });
            }, 500);
            },
            getConversation() {
                let _this = this;
                let id = this.$route.params.id;
                 axios.get('/api/message/' + id).then(response =>  {
                     //console.log(response.data);
                     this.message = response.data.msg;
                     this.users = response.data.user;
                     this.authuser = response.data.authuser;
                     this.scrollToEnd();
                     this.computedMessag();

                       Echo.private(`message.${this.users.id}.${this.authuser.id}`)
                        .listen('MessageSent', (e) => {
                            //console.log(e);
                            //console.log('hello');
                            this.message.push(e.message);
                        });
                       Echo.private(`messag.${this.users.id}.${this.authuser.id}`)
                        .listenForWhisper('typing', (e) => {
                        //this.user = e.user;
                        this.typing = e.typing;

                        // remove is typing indicator after 0.9s
                        setTimeout(function() {
                            _this.typing = false;
                        }, 5000);
                        });
                }).catch(error => {
                    this.dialog = false;
                });
            },
            scrollToEnd() {
            this.$nextTick(() => {
            var container = this.$el.querySelector(".container");
            container.scrollTop = container.scrollHeight;
            })
            },
            postMessage() {
                //moment("1995-12-25")
                //moment().format('LL');
                this.typemessage = true;
                //this.user.id = random(1, 3456778)
                this.user.sender.full_name = this.authuser.full_name;
                this.user.createdDate = moment().format('LT');
                this.message.push(this.user);
                this.scrollToEnd();
                let message = this.user.message;
                this.user = {
                    message : '',
                    sender : {
                        full_name : this.authuser.full_name
                    },
                };
                //this.user.sender.full_name = this.authuser.full_name;
                let id = this.$route.params.id;
                 axios.post('/api/message', {message,id }).then(response =>  {
                     console.log(response.data);
                    //this.dialog = false;
                    //this.submitted = true
                }).catch(error => {
                    this.dialog = false;
                });
            }
        }

}
</script>



