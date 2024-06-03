
import { useAuthStore } from '@/stores/auth.store';

const API_AUTH_URL = 'http://localhost:16080/api/auth/';


export function useAuthService() {

  function isLoggedIn() {
    return useAuthStore().isLoggedIn;
  }

  function getUser() {
    return useAuthStore().getUser;
  }
  function getHeaders(): Headers{
    const headers = new Headers();
    headers.set('Content-Type', 'application/json');
    return headers;
  }

  function getAuthHeader(): Headers {
    const user = JSON.parse(localStorage.getItem('user') || '""');
    const headers = new Headers();
    if (user && user.accessToken) {
      headers.set('Authorization', 'Bearer ' + user.accessToken.access_token);
    }
    return headers;
  }

  function login(credentials: ICredentials) {

    return fetch(API_AUTH_URL + 'login', {
      method: 'POST',
      headers: getHeaders(),
      body: JSON.stringify({
        email: credentials.email,
        password: credentials.password
      })
    })
      .then((response) => response.json())
      .then((data) => {
        console.log(data)
        if (data.token && data.user) {
          data.user.accessToken = data.token;
          localStorage.setItem('user', JSON.stringify(data.user));
        }
        useAuthStore().loginSuccess(data.user);
        return data;
      }).catch((error) => {
        useAuthStore().loginFailure();
        console.log(error);
      });
  }

  function logout() {
    useAuthStore().logout();
    localStorage.removeItem('user');
  }

  function register(user: IUser) {
    console.log(user);
    return fetch(API_AUTH_URL + `register`, {
      method: 'POST',
      headers: getHeaders(),
      body: JSON.stringify(user)
    }).then((response) => {
      console.log(response);
      return response.json();
    }).catch((error) => {
      console.log(error);
    })
  }

  return {
    login,
    logout,
    register,
    isLoggedIn,
    getUser,
    getAuthHeader,
  }
}