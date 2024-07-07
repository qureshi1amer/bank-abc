<template>
    <nav>
        <router-link v-if="!isAuthenticated" to="/login">Login</router-link>
        <router-link v-if="!isAuthenticated" to="/register">Register</router-link>
        <router-link v-if="isAuthenticated" to="/account">Account</router-link>
        <router-link v-if="isAuthenticated" to="/transactions">Transactions</router-link>
        <router-link v-if="isAuthenticated" to="/transfer">Transfer</router-link>
        <router-link v-if="isAuthenticated" to="/deposit">Deposit</router-link>
        <router-link v-if="isAuthenticated" @click.prevent="logout" to="/login">Logout</router-link>
    </nav>
    <router-view></router-view>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
    computed: {
        ...mapGetters(['isAuthenticated'])
    },
    methods: {
        logout() {
            this.$store.dispatch('logout');
            this.$router.push('/login');
        }
    }
};
</script>
