import Vue from 'vue'
import Router from 'vue-router'
import DashboardLayout from '@/layout/DashboardLayout'
import AuthLayout from '@/layout/AuthLayout'
Vue.use(Router)

export default new Router({
  linkExactActiveClass: 'active',
  mode:'history',
  routes: [
    {
      path: '/',
      redirect: 'login',
      component: DashboardLayout,
      children: [
        // {
        //   path: '/dashboard',
        //   name: 'dashboard',
        //   // route level code-splitting
        //   // this generates a separate chunk (about.[hash].js) for this route
        //   // which is lazy-loaded when the route is visited.
        //   component: () => import(/* webpackChunkName: "demo" */ './views/Dashboard.vue')
        // },
        // {
        //   path: '/icons',
        //   name: 'icons',
        //   component: () => import(/* webpackChunkName: "demo" */ './views/Icons.vue')
        // },//Result-Upload Home user-Regstration
        {
          path: '/courceDetail-Controller',
          name: 'courceDetail-Controller',
          component: () => import(/* webpackChunkName: "demo" */ './views/CourceControll')
        },
        {
          path: '/view-Repeat-subjects',
          name: '/view-Repeat-subjects',
          component: () => import(/* webpackChunkName: "demo" */ './views/viewRepeatSubjects')
        },
        {
          path: '/user-Regstration',
          name: 'user-Regstration',
          component: () => import(/* webpackChunkName: "demo" */ './views/UserRegistration')
        },
        {
          path: '/Home',
          name: 'Home',
          component: () => import(/* webpackChunkName: "demo" */ './views/Home')
        },
        {
          path: '/Result-Upload',
          name: 'Result-Upload',
          component: () => import(/* webpackChunkName: "demo" */ './views/ResultUploding')
        },
        {
          path: '/profile',
          name: 'profile',
          component: () => import(/* webpackChunkName: "demo" */ './views/UserProfile.vue')
        },
        {
          path: '/student-Registering',
          name: 'student-Registering',
          component: () => import(/* webpackChunkName: "demo" */ './views/Maps.vue')
        },
        {
          path: '/tables',
          name: 'tables',
          component: () => import(/* webpackChunkName: "demo" */ './views/Tables.vue')
        }
      ]
    },
    {
      path: '/',
      redirect: 'login',
      component: AuthLayout,
      children: [
        {
          path: '/AdminLogin',
          name: 'login1',
          component: () => import(/* webpackChunkName: "demo" */ './views/Login.vue')
        },
        {
          path: '/login',
          name: 'login',
          component: () => import(/* webpackChunkName: "demo" */ './views/StudentLogin.vue')
        },
        {
          path: '/register',
          name: 'register',
          component: () => import(/* webpackChunkName: "demo" */ './views/Register.vue')
        }
      ]
    }
  ]
})
