<template>
    <div>
        <h2>Register</h2>
        <form @submit.prevent="register">
            <div>
                <label for="name">Name:</label>
                <input type="text" v-model="name" required>
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" v-model="email" required>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" v-model="password" required>
            </div>
            <div>
                <label for="password_confirmation">Confirm Password:</label>
                <input type="password" v-model="password_confirmation" required>
            </div>
            <button type="submit">Register</button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            name: '',
            email: '',
            password: '',
            password_confirmation: ''
        };
    },
    methods: {
        async register() {
            try {
                await this.$store.dispatch('register', {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation
                });
                this.$router.push('/');
            } catch (error) {
                alert('Registration failed');
                console.error('Error registering:', error);
            }
        }
    }
};
</script>
