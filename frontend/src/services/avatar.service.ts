
import { useAuthService } from './auth.service';

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;

export type AvatarResponse = {
  avatarUrl: string;
}

// AvatarResponse type guard
const isAvatarResponse = (data: any): data is AvatarResponse => {
  return typeof data === 'object' &&
    typeof data.avatarUrl === 'string';
}

export function useAvatarService() {

  async function getAvatar(): Promise<AvatarResponse> {
    const response = await fetch(API_BASE_URL + 'avatar', {
      method: 'GET',
      headers: useAuthService().getAuthHeader()
    });
    const data = await response.json();
    if( !isAvatarResponse(data) )
      throw new Error('Invalid avatar response');
    return data;
  }

  return {
    getAvatar,
  }
}