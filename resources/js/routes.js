import Vue from 'vue'
import VueRouter from 'vue-router'
import helper from './services/helper'
import CreatePost from './pages/createpost.vue';
import EditProfile from './pages/editprofile.vue';

Vue.use(VueRouter);

let routes = [
    {
        path: '/feeds',
        component: require('./views/pages/dash'),
        meta: { requiresAuth: true },
        children: [
            {
                path: "/",
                name: "feeds",
                component: require('./views/pages/feeds'),
              },
              {
                path: "/messages",
                name: "messages",
                component: require('./views/pages/messages'),
              },
              {
                path: "/networks",
                name: "networks",
                component: require('./views/pages/networks'),
              },
              {
                path: "/profile",
                name: "profile",
                component: require('./views/pages/profile'),
              }
        ]
    },

    {
        path: '/createpost',
        name: "Create",
        component: CreatePost,
        meta: { requiresAuth: true }
    },
    {
        path: '/conversation/:id',
        component: require('./views/pages/conversation'),
        meta: { requiresAuth: true },
    },
    {
        path: '/post/:id',
        component: require('./views/pages/post'),
        meta: { requiresAuth: true },
    },
    {
        path: '/user/:id',
        component: require('./views/pages/user'),
        meta: { requiresAuth: true },
    },
    {
        path: '/editprofile',
        component: EditProfile,
        meta: { requiresAuth: true }
    },
    {
        path: '/notifications',
        component: require('./views/pages/notification'),
        meta: { requiresAuth: true }
    },
    {
        path: '/connects',
        component: require('./views/pages/connects-list'),
        meta: { requiresAuth: true }
    },
    {
        path: '/search',
        component: require('./views/pages/search'),
        meta: { requiresAuth: true }
    },
    {
        path: '/received',
        component: require('./views/pages/manage-connects'),
        meta: { requiresAuth: true },
        children: [
            {
                path: "/",
                name: "received",
                component: require('./views/pages/received'),
              },
              {
                path: "/sent",
                name: "sent",
                component: require('./views/pages/sent'),
              }
            ]
    },
    {
        path: '/login/',
        component: require('./views/auth/login'),
        meta: { requiresGuest: true },
    },

    {
        path: '/',
        component: require('./views/auth/login'),
        meta: { requiresGuest: true },
    },

    {
        path: '/password',
        component: require('./views/auth/password'),
        meta: { requiresGuest: true },
    },

    {
        path: '/register',
        component: require('./views/auth/register'),
        meta: { requiresGuest: true },
    },

    {
        path: '/about-us',
        component: require('./views/pages/about'),
    },


    {
        path: '/auth/:token/activate',
        component: require('./views/auth/activate'),
        meta: { requiresGuest: true },
    },

    {
        path: '/password/reset/:token',
        component: require('./views/auth/reset'),
        meta: { requiresGuest: true },
    },

    {
        path: '*',
        component : require('./views/errors/page-not-found'),
    }
];

const router = new VueRouter({
	routes,
    linkActiveClass: 'active',
    mode: 'history'
});

router.beforeEach((to, from, next) => {

    if (to.matched.some(m => m.meta.requiresAuth)){
        return helper.check().then(response => {
            if(!response){
                return next({ path : '/login'})
            }
            return next();
        })
    }

    if (to.matched.some(m => m.meta.requiresGuest)){
        return helper.check().then(response => {
            if(response){
                return next({ path : '/feeds'})
            }
            return next();
        })
    }

    return next()
});

export default router;
