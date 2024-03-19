import { defineStore } from 'pinia'

export const useAuthStore = defineStore('user', {
    state: () => ({
        token: localStorage.getItem('token') || null,
        user: JSON.parse(localStorage.getItem('user')) || null,
    }),
    getters: {
        userData: (state) => state.user
    },
    actions: {
        setUserData(data) {
            this.token = data.token
            this.user = data.user

            localStorage.setItem('token', this.token)
            localStorage.setItem('user', JSON.stringify(this.user))
        },
        clearUserData() {
            this.token = null
            this.user = null
            localStorage.clear()
        }
    }
});