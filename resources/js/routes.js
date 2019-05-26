import Vue from 'vue';
import Router from 'vue-router';
import App from './components/Main';
import SignIn from './components/auth/Signin';
import { setAuthToken } from './services/api';

Vue.use(Router);

export default new Router({
  mode: 'history',
  scrollBehavior() {
    return { x: 0, y: 0 };
  },
  routes: [
    {
      name: 'content-table',
      path: '/',
      component: App,
      beforeEnter: (to, from, next) => {
        const token = window.localStorage.getItem('token');
        if (token) {
          setAuthToken(token);
          next();
        } else {
          next('/signin');
        }
      }
    },
    {
      name: 'signin',
      path: '/signin',
      component: SignIn,
      beforeEnter: (to, from, next) => {
        const token = window.localStorage.getItem('token');
        if (token) {
          setAuthToken(token);
          next('/');
        } else {
          next();
        }
      }
    }
  ],
});
