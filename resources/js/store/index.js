import { createStore } from 'vuex';
import api from '../axios.js';

const store = createStore({
    state: {
        token: localStorage.getItem('token') || '',
    },
    mutations: {
        setToken(state, token) {
            state.token = token;
            localStorage.setItem('token', token);
            api.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        },
        clearAuthData(state) {
            state.token = '';
            localStorage.removeItem('token');
            delete api.defaults.headers.common['Authorization'];
        }
    },
    actions: {
        async login({ commit }, authData) {
            const response = await api.post('v1/login', authData);
            commit('setToken', response.data.data.token);
        },

        async register({ commit }, authData) {
            const response = await api.post('v1/register', authData);
            commit('setToken', response.data.data.token);
        },
        logout({ commit }) {
            commit('clearAuthData');
        }
    },
    getters: {
        isAuthenticated(state) {
            return !!state.token;
        }
    }
});

export default store;
