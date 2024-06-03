
declare global {

  interface ICredentials {
    email: string;
    password: string;
  }

  interface IUser {
    id?: number;
    name: string;
    password?: string;
    email: string;
    accessToken?: string;
  }

  interface IAUthState {
    status: {
      loggedIn: boolean;
    };
    user: IUser | null;
  }
}

export default {};