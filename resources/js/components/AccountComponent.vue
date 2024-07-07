<template>
    <div>
        <h2>Account Details</h2>
        <div v-if="account">
            <p><strong>Account Title:</strong> {{ account.name }}</p>
            <p><strong>Account Number:</strong> {{ account.id }}</p>
            <p><strong>Balance:</strong> ${{ account.balance }}</p>
        </div>
    </div>
</template>

<script>
import api from '../axios.js'; // Adjust the path accordingly

export default {
    data() {
        return {
            account: null
        };
    },
    async created() {
        try {
            const response = await api.get('v1/account');
            this.account = response.data.data;
            console.log( this.account.balance)
        } catch (error) {
            console.error('Error fetching account details:', error);
        }
    }
};
</script>
