import Vue from 'vue'
import axios from 'axios'
import VeeValidate from 'vee-validate'
import Vuetify from 'vuetify'
import VueXgplayer from 'vue-xgplayer'
//import 'material-design-icons-iconfont/dist/material-design-icons.css'

// require videojs style
import 'video.js/dist/video-js.css'
import InfiniteLoading from 'vue-infinite-loading';
import VueResource from 'vue-resource'
import SocialSharing from 'vue-social-sharing';

Vue.use(SocialSharing);


Vue.use(VueResource);

Vue.use(InfiniteLoading, { /* options */ });


Vue.use(VueXgplayer, {
    // globalOptions
    enterLogo: {
      url: '/images/video-player-loading.png',
      width: 100,
      height: 40
    },
    playsinline: false,
    download: true,
    airplay: true,
  })

import 'vuetify/dist/vuetify.min.css'




window.Vue = Vue;
Vue.use(Vuetify, {
    //iconfont: 'fa'
    //iconfont: 'fa' || 'mdi' || 'md' || 'fa4'
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

function debounce(fn, delay = 300) {
	var timeoutID = null;

    return function () {
		clearTimeout(timeoutID);

        var args = arguments;
        var that = this;

        timeoutID = setTimeout(function () {
        	fn.apply(that, args);
        }, delay);
    }
};

// this is where we integrate the v-debounce directive!
// We can add it globally (like now) or locally!
Vue.directive('debounce', (el, binding) => {
	if (binding.value !== binding.oldValue) {
		// window.debounce is our global function what we defined at the very top!
		el.oninput = debounce(ev => {
			el.dispatchEvent(new Event('change'));
		}, parseInt(binding.value) || 300);
	}
});

