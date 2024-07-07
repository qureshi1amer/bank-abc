import axios from 'axios';
import store from './store';
// Create Axios instance
const api = axios.create({
    baseURL: '/api/',
    timeout: 10000,
});

// Request interceptor for API calls
api.interceptors.request.use(
    async (config) => {
        // Do something before request is sent
        return config;
    },
    (error) => {
        // Do something with request error
        return Promise.reject(error);
    }
);

// Response interceptor for API calls
api.interceptors.response.use(
    (response) => {
        // Any status code that lie within the range of 2xx cause this function to trigger
        // Do something with response data
        return response;
    },
    async (error) => {
        // Any status codes that falls outside the range of 2xx cause this function to trigger
        // Do something with response error
        if (error.response.status === 401) {
            // Redirect to login page or handle unauthorized access
            console.log('Unauthorized access. Redirecting to login page...');
            // Example redirect to login (replace with your actual redirect logic)
            store.dispatch('logout');

        }
        return Promise.reject(error);
    }
);

export default api;
