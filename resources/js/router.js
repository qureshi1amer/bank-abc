import { createRouter, createWebHistory } from 'vue-router';
import store from './store';
import LoginComponent from './components/LoginComponent.vue';
import RegisterComponent from './components/RegisterComponent.vue';
import AccountComponent from './components/AccountComponent.vue';
import TransactionsComponent from './components/TransactionsComponent.vue';
import TransferComponent from './components/TransferComponent.vue';
import DepositComponent from './components/DepositComponent.vue';

const routes = [
    {path: '/', component: AccountComponent ,meta: { requiresAuth: true }},
    {path: '/login', component: LoginComponent , meta: { requiresGuest: true }},
    {path: '/register', component: RegisterComponent ,meta: { requiresGuest: true  }},
    {path: '/account', component: AccountComponent ,meta: { requiresAuth: true }},
    {path: '/transactions', component: TransactionsComponent ,meta: { requiresAuth: true }},
    {path: '/transfer', component: TransferComponent ,meta: { requiresAuth: true }},
    {path: '/deposit', component: DepositComponent ,meta: { requiresAuth: true }}

];
const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !store.getters.isAuthenticated) {
        next('/login');
    } else if (to.meta.requiresGuest && store.getters.isAuthenticated) {
        next('/');
    } else {
        next();
    }
});
export default router;
