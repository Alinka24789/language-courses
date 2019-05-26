// @see https://developers.hubspot.com/docs/overview
import axios from 'axios';
import get from 'lodash.get';
import router from '../routes';

axios.defaults.baseURL = '/api/v1';

// Map 'data' prop after each response
axios.interceptors.response.use(
    response => {
      if (response.status < 300) {
        return response.data.data;
      }
      return response;
    },
    error => {
      const status = get(error, 'response.status');
      if (status === 403 || status === 401) {
        removeAuthToken();
        window.localStorage.removeItem('token');
        router.push('/signin');
      }
      return Promise.reject(error);
    }
);

export const setAuthToken = token =>
    (axios.defaults.headers.common['Authorization'] = `Bearer ${token}`);

export const removeAuthToken = () =>
    (axios.defaults.headers.common['Authorization'] = '');

export const login = (email, password) =>
    axios.post('/login', {
      email,
      password
    })
        .then(resp => {
          const { token } = resp;
          window.localStorage.setItem('token', token);
          setAuthToken(token);
        });


export const getLanguages = () =>
    axios.get('/languages');

export const getLevels = () =>
    axios.get('/courses/levels');

export const getCourses = (page = 1, perPage = 10, orderBy = 'name', orderType = 'asc', languageId = 0, level = 0, text = '') => {
  let params = `page=${page}&total=${perPage}`;
  if (languageId) params = `${params}&languageId=${languageId}`;
  if (level) params = `${params}&level=${level}`;
  if (text) params = `${params}&text=${text}`;
  if (orderBy) params = `${params}&orderBy=${orderBy}`;
  if (orderType) params = `${params}&orderType=${orderType}`;
  return axios.get(  `/courses?${params}`);
};

