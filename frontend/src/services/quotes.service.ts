
import { useAuthService } from './auth.service';

const API_AUTH_URL = 'http://localhost:16080/api/v1/';


export function useQuotesService() {

  function getHeaders(): Headers {
    const headers = useAuthService().getAuthHeader();
    headers.set('Content-Type', 'application/json');
    return headers;
  }

  function getQuotes() {
    return fetch(API_AUTH_URL + 'quotes', {
      method: 'GET',
      headers: getHeaders()
    })
      .then((response) => response.json())
      .then((data) => {
        console.log(data);
        return data;
      }).catch((error) => {
        console.log(error);
      });
  }

  function refreshQuotes() {
    return fetch(API_AUTH_URL + 'quotes/refresh', {
      method: 'PUT',
      headers: getHeaders()
    })
      .then((response) => response.json())
      .then((data) => {
        console.log(data);
        return data;
      }).catch((error) => {
        console.log(error);
      });
  }

  return {
    getQuotes,
    refreshQuotes,
  }
}