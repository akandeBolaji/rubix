<template>
<v-app>
    <v-toolbar fixed color="blue lighten-1">
    <v-icon @click="goBack" dark>arrow_back</v-icon>
    <v-toolbar-title class="white--text" v-if="this.users.first_name" >{{ this.users.first_name + " " + this.users.last_name}}
        <span v-show="typing"><b><i>is typing</i></b></span><br/>
        <span v-if="online"><i>Online</i></span>
        <span v-else><i style="font-size:12px;">last seen {{ this.computedLastSeen }}</i></span>
    </v-toolbar-title>
</v-toolbar>
<v-container   :style="{ maxHeight: winHeight}" class="scroll-y" mt-5 mb-5>
    <infinite-loading v-show="infinite" direction="top" @distance="1" @infinite="infiniteHandler"></infinite-loading>
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
             <Message :sending="sending" :message="message" :user="users" :authuser="authuser"></Message><br/>
            </span>
          </span>
      </div>
      </v-container>
         <v-divider></v-divider>
          <v-footer fixed height="150px" color="white">
              <v-container justify-start align-content-start>
            <v-layout row wrap>
            <v-flex xs12>
          <v-text-field outline box auto-grow rows="1" v-model="user.message" @keydown="isTyping" @keyup.enter="postMessage" name="text" label="Write a message..." type="text"></v-text-field>
            </v-flex>
            </v-layout>
           <v-layout justify-start row wrap>
          <v-flex justify-start xs4>
                 <upload-btn
                title=""
                :fileChangedCallback="imageChanged"
                accept="image/*"
                :flat = true
                :outline = true
                :uniqueId = true
                >
                <template slot="icon">
                    <v-icon left>image</v-icon>
                </template>
                </upload-btn>
          </v-flex>
          <v-flex xs4>
              <upload-btn
                title=""
                :fileChangedCallback="fileChanged"
                accept="audio/mp3, application/pdf, application/txt]"
                :flat = true
                :outline = true
                :uniqueId = true
                >
                <template slot="icon">
                    <v-icon left>attach_file</v-icon>
                </template>
                </upload-btn>
          </v-flex>
          <v-flex xs4>
              <v-btn type="submit" class="white--text align-center" @click="postMessage" :disabled="!user.message" :loading="dialog" color="blue">Post</v-btn>
          </v-flex>
        </v-layout>
              </v-container>
          </v-footer>
</v-app>
</template>
<script>
import UploadButton from 'vuetify-upload-button';
import Message from './message.vue';
var moment = require('moment');
moment.locale('en-cust', {
    relativeTime : {
    future: "in %s",
    past:   "%s",
    s:  "now",
    m:  "1m",
    mm: "%dm+",
    h:  "1h",
    hh: "%dh+",
    d:  "1d",
    dd: "%dd+",
    w: "%dw",
    ww: "1w+",
    M:  "1w+",
    MM: "1w+",
    y:  "1w+",
    yy: "1w+"
    }
});
 moment.updateLocale('en-cust', {
            calendar : {
            lastDay : '[yesterday at] LT',
                sameDay : '[today at] LT',
                nextDay : '[tomorrow at] LT',
                lastWeek : 'll [at] LT',
                nextWeek : 'll [at] LT',
                sameElse : 'll [at] LT'
            }
        });
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
    'upload-btn': UploadButton,
     Message
    },
     data() {
            return {
                page: 50,
                infinite: true,
                online: false,
                winHeight: window.innerHeight *0.75 + "px",
                url: null,
                typing: false,
                file: '',
                typemessage: false,
                user: {
                createdDate: '',
                sender: {
                    first_name: '',
                    last_name: '',
                }
                },
                dialog: false,
                message: [

                ],
                sending: null,
                file: null,
                image: null,
                users: {
                    id: '',
                },
                authuser: {
                    id: '',
                    first_name: '',
                    last_name: '',
                    avatar: ''
                },
                info: false,
                infotext: '',
                id:this.$route.params.id,
            }
        },
        created(){
            //this.getConversation();
        },

        computed: {
        computedLastSeen() {
            const then = moment(this.users.last_seen).locale('en-cust')
            return then.calendar();
        },
          computedMessage() {
              const messages = this.message;
              if (messages) {
                  let sortedResult = _.orderBy(messages, ['created_at'], ['asc']); ;
                  let groupedResults = _.groupBy(sortedResult, (message) => moment(message['created_at']).calendar());
                  console.log(groupedResults);
                  return groupedResults;
              }
          }
        },

        methods: {
            infiniteHandler($state) {
                let _this = this;
                let id = this.$route.params.id;
                 axios.get('/api/message/' + id + '/' + this.page).then(response =>  {
                 this.users = response.data.user;
                 this.authuser = response.data.authuser;
                console.log(response.data);
                 Echo.join(`chat-room.${this.authuser.id}`);

                Echo.join(`chat-room.${this.users.id}`)
                .here(function (members) {
                    console.log(members);
                        _.forEach(members, function(member) {
                        if (member.id == _this.users.id) {
                            _this.online = true;
                        }
                        })
                })
                .joining(function (member, members) {
                        console.log(member);
                        if (member.id == _this.users.id) {
                            _this.online = true;
                        }
                })
                .leaving(function (member, members) {
                        console.log(member);
                        if (member.id == _this.users.id) {
                            _this.online = false;
                            _this.users.last_seen = moment();
                        }
                });

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
                if (response.data.count > this.page) {
                        _this.page += 50;
                        let result = _.orderBy(response.data.msg, ['created_at'], ['asc']);
                        _this.message.push(...result);
                     _this.scrollToEnd();
                        $state.loaded();
                     }else {
                         let result = _.orderBy(response.data.msg, ['created_at'], ['asc']);
                        _this.message.push(...result);
                     //_this.scrollToEnd();
                        $state.complete();
                        _this.infinite = false;
                     }

                    //this.page = this.page + 1;
                }).catch(error => {
                    $state.error();
                });
},
            rndStr(len) {
                let text = " "
                let chars = "abcdefghijklmnopqrstuvwxyz"

            for( let i=0; i < len; i++ ) {
                        text += chars.charAt(Math.floor(Math.random() * chars.length))
            }

                    return text;
                },
            fileChanged (file) {
            console.log(file);
                this.user.sender.first_name = this.authuser.first_name;
                this.user.sender.last_name = this.authuser.last_name;
                this.user.sender.id = this.authuser.id;
                this.user.sender.avatar = this.authuser.avatar;
                this.user.sendstats = this.rndStr(5);
                this.user.sendstatus = 'sending';
                this.user.createdDate = moment().format('LT');
                this.user.file = file.name;
                this.sending = this.user.sendstats;
                this.message.push(this.user);
                this.scrollToEnd();
                this.user = {
                    file : '',
                    sender : {
                        first_name : this.authuser.first_name,
                        last_name : this.authuser.last_name,
                        id : this.authuser.id
                    },
                };
                 const formData = new FormData();
                 const id = this.$route.params.id;
                formData.append('file', file);
                formData.append('id', id);
                 const config = {
                headers: {'content-type': 'multipart/form-data'}
                }
                axios.post('/api/message-file', formData, config).then(response =>  {
                     console.log(response.data);
                     this.sending = '';
                    //this.dialog = false;
                    //this.submitted = true
                }).catch(error => {
                    this.user.sendstatus = 'failed';
                    //this.$router.go(-1);
                });
            },
             imageChanged (file) {
            console.log(file);
            this.user.sender.first_name = this.authuser.first_name;
                this.user.sender.last_name = this.authuser.last_name;
                this.user.sender.avatar = this.authuser.avatar;
                this.user.createdDate = moment().format('LT');
                this.user.sendstats = this.rndStr(5);
                this.user.sendstatus = 'sending';
                this.user.sender.id = this.authuser.id;
                this.user.preview = URL.createObjectURL(file);
                 this.sending = this.user.sendstats;
                 //this.url = URL.createObjectURL(file);
                this.message.push(this.user);
                 this.scrollToEnd();
                this.user = {
                    image : '',
                    sender : {
                        first_name : this.authuser.first_name,
                        last_name : this.authuser.last_name,
                        id : this.authuser.id
                    },
                };
                 const formData = new FormData();
                 const id = this.$route.params.id;
                formData.append('image', file);
                formData.append('id', id);
                 const config = {
                headers: {'content-type': 'multipart/form-data'}
                }
                axios.post('/api/message-image', formData, config).then(response =>  {
                     console.log(response.data);
                     this.sending = '';
                    //this.dialog = false;
                    //this.submitted = true
                }).catch(error => {
                    this.user.sendstatus = 'failed';
                    //this.$router.go(-1);
                });
            },
             userPic(data){
                return 'http://rubix.site/images/users/' + data;
            },
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
             let channels = Echo.private(`messag.${this.users.id}`);
             let user = this.authuser;

            setTimeout(function() {
                channel.whisper('typing', {
                    //user: user,
                    typing: true
                });
                 channels.whisper('typing', {
                    user: user,
                    typing: true
                });
            }, 300);
            },

            scrollToEnd() {
            this.$nextTick(() => {
                //$vuetify.goTo(99999, {duration: 342, offset: 0, easing: linear});
            var container = this.$el.querySelector(".container");
            container.scrollTop = container.scrollHeight;
            })
            },
            postMessage() {
                //moment("1995-12-25")
                //moment().format('LL');
                this.typemessage = true;
                //this.user.id = random(1, 3456778)
                this.user.sender.first_name = this.authuser.first_name;
                this.user.sender.last_name = this.authuser.last_name;
                 this.user.sender.id = this.authuser.id;
                 this.user.sender.avatar = this.authuser.avatar;
                this.user.createdDate = moment().format('LT');
                this.message.push(this.user);
                this.scrollToEnd();
                let message = this.user.message;
                this.user = {
                    message : '',
                    sender : {
                        first_name : this.authuser.first_name,
                        last_name : this.authuser.last_name,
                        id : this.authuser.id,
                        avatar: this.authuser.avatar
                    },
                };
                //this.user.sender.full_name = this.authuser.full_name;
                let id = this.$route.params.id;
                 axios.post('/api/message', {message,id }).then(response =>  {
                     console.log(response.data);
                    //this.dialog = false;
                    //this.submitted = true
                }).catch(error => {
                    //this.$router.go(-1);
                });
            }
        }

}
</script>



