<template>
    <div>
        <h2>Login</h2>
        <form @submit.prevent="login">
            <div>
                <label for="email">Email:</label>
                <input type="email" v-model="email" required>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" v-model="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            email: '',
            password: ''
        };
    },
    methods: {
        async login() {
            try {
                await this.$store.dispatch('login', {
                    email: this.email,
                    password: this.password
                });
                this.$router.push('/');
            } catch (error) {
                alert('Invalid credentials');
                console.error('Error logging in:', error);
            }
        }
    }
};
</script>
