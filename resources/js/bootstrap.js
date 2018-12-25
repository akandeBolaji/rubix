import Vue from 'vue'
import axios from 'axios'
import VeeValidate from 'vee-validate'
import Vuetify from 'vuetify'
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import VueChatScroll from 'vue-chat-scroll'
Vue.use(VueChatScroll)
import 'vuetify/dist/vuetify.min.css'




window.Vue = Vue;
Vue.use(Vuetify, {
    //iconfont: 'fa'
    //iconfont: 'mdi' // 'md' || 'mdi' || 'fa' || 'fa4'
   });
window.axios = axios;
Vue.use(VeeValidate);


//

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('auth_token');

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo'

window.Pusher = require('pusher-js');

 window.Echo = new Echo({
    broadcaster: 'pusher',
    //authEndpoint: "/api/auth/check",
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    encrypted: true,
    auth: {
        headers: {
            Authorization: 'Bearer ' + localStorage.getItem('auth_token')
        },
    },
});

