
import { useAuthService } from './auth.service';

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;

export type QuotesResponse = {
  quotes: string[];
}

// QuotesResponse type guard
const isQuotesResponse = (data: any): data is QuotesResponse => {
  return typeof data === 'object' &&
    data.quotes instanceof Array &&
    data.quotes.every((quote: any) => typeof quote === 'string');
}

export function useQuotesService() {

  async function getQuotes(): Promise<QuotesResponse> {
    const response = await fetch(API_BASE_URL + 'quotes', {
      method: 'GET',
      headers: useAuthService().getAuthHeader()
    });
    const data = await response.json();
    if( !isQuotesResponse(data) )
      throw new Error('Invalid quotes response');
    return data;
  }

  async function refreshQuotes() : Promise<QuotesResponse>{
    const response = await fetch(API_BASE_URL + 'quotes/refresh', {
      method: 'PUT',
      headers: useAuthService().getAuthHeader()
    });
    const data = await response.json();
    if( !isQuotesResponse(data) )
      throw new Error('Invalid quotes response');
    return data;
  }

  return {
    getQuotes,
    refreshQuotes,
  }
}