
import { useAuthStore } from '@/stores/auth.store';

const AUTH_BASE_URL = import.meta.env.VITE_AUTH_BASE_URL;


export function useAuthService() {

  function isLoggedIn(): boolean {
    return useAuthStore().isLoggedIn;
  }

  function getUser(): IUser | null {
    return useAuthStore().getUser;
  }
  function getHeaders(): Headers {
    const headers = new Headers();
    headers.set('Content-Type', 'application/json');
    return headers;
  }

  function getAuthHeader(): Headers {
    const user = JSON.parse(localStorage.getItem('user') || '""');
    const headers = getHeaders();
    if (user && user.accessToken) {
      headers.set('Authorization', 'Bearer ' + user.accessToken);
    }
    return headers;
  }

  async function login(credentials: ICredentials) {
    try {
      const response = await fetch(AUTH_BASE_URL + 'login', {
        method: 'POST',
        headers: getHeaders(),
        body: JSON.stringify({
          email: credentials.email,
          password: credentials.password
        })
      });
      const data = await response.json();
      const accessToken = data?.token;
      if (!accessToken)
        throw new Error('Missing access token');
      // get the middle part of the token and Base64 decode it
      const payload = JSON.parse(atob(accessToken.split('.')[1]));
      payload.user.accessToken = data.token;
      localStorage.setItem('user', JSON.stringify(payload.user));
      useAuthStore().loginSuccess(payload.user);
      return data;
    } catch (error) {
      useAuthStore().loginFailure();
      console.error(error);
    }
  }

  function logout(): void {
    useAuthStore().logout();
    localStorage.removeItem('user');
  }

  async function register(user: IUser) {
    try {
      const response = await fetch(AUTH_BASE_URL + `register`, {
        method: 'POST',
        headers: getHeaders(),
        body: JSON.stringify(user)
      });
      console.log(response);
      return await response.json();
    } catch (error) {
      console.error(error);
    }
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