
import { defineStore } from 'pinia'

const user = JSON.parse(localStorage.getItem('user') || '""')
const initialState: IAUthState = user
  ? { status: { loggedIn: true }, user }
  : { status: { loggedIn: false }, user: null }

export const useAuthStore = defineStore('auth', {
  state: () => initialState,
  getters: {
    getUser: (state) => state.user,
    isLoggedIn: (state) => state.status.loggedIn,
  },
  actions: {
    loginSuccess(user: IUser) {
      this.status.loggedIn = true
      this.user = user
    },
    loginFailure() {
      this.status.loggedIn = false
      this.user = null
    },
    logout() {
      this.status.loggedIn = false
      this.user = null
    },
    registerSuccess() {
      this.status.loggedIn = false
    },
    registerFailure() {
      this.status.loggedIn = false
    }
  }

});
