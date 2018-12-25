import HomePage from './pages/home.vue';
import AboutPage from './pages/about.vue';
import FormPage from './pages/form.vue';
import DynamicRoutePage from './pages/dynamic-route.vue';
import NotFoundPage from './pages/not-found.vue';
import Main from './pages/main.vue';
import PanelLeftPage from './pages/panel-left.vue';
import PanelRightPage from './pages/panel-right.vue';
import HomeTab from './tabs/hometab.vue';
import MessagesTab from './tabs/messagestab.vue';
import NetworkTab from './tabs/networktab.vue';
import ProfileTab from './tabs/profiletab.vue';
import CreatePost from './pages/createpost.vue';
import EditProfile from './pages/editprofile.vue';



export default [
  {
    path: '/',
    component: HomePage,
    tabs: [
      {
        path: "/hometab/",
        id: "tab-1",
        component: HomeTab
      },
      {
        path: "/messagestab/",
        id: "tab-2",
        component: MessagesTab
      },
      {
        path: "/networktab/",
        id: "tab-3",
        component: NetworkTab
      },
      {
        path: "/profiletab/",
        id: "tab-4",
        component: ProfileTab
      },
    ]
  },
  {
    path: '/createpost/',
    component: CreatePost,
  },
  {
    path: '/editprofile/',
    component: EditProfile,
  },
  {
    path: '/main/',
    component: Main,
  },
  {
    path: '/panel-left/',
    component: PanelLeftPage,
  },
  {
    path: '/panel-right/',
    component: PanelRightPage,
  },
  {
    path: '/about/',
    component: AboutPage,
  },
  {
    path: '/form/',
    component: FormPage,
  },
  {
    path: '/dynamic-route/blog/:blogId/post/:postId/',
    component: DynamicRoutePage,
  },
  {
    path: '(.*)',
    component: NotFoundPage,
  },
];
