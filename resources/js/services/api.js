// @see https://developers.hubspot.com/docs/overview
import axios from 'axios';
import get from 'lodash.get';
import router from '../routes';

// Map 'data' prop after each response
axios.interceptors.response.use(
    response => {
      if (response.status < 300) {
        console.log(response);
        return response.data;
      }
      return response;
    },
    error => {
      const status = get(error, 'response.status');
      if (status === 403) {
        removeAuthToken();
        window.localStorage.removeItem('token');
        router.push('/login');
      }
      return Promise.reject(error);
    }
);

export const setAuthToken = token =>
    (axios.defaults.headers.common['Authorization'] = `Bearer ${token}`);

export const removeAuthToken = () =>
    (axios.defaults.headers.common['Authorization'] = '');

export const login = (email, password) =>
    axios.post('/api/v1/login', {
      email,
      password
    });
