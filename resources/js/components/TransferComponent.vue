<template>
    <div>
        <h2>Transfer Money</h2>
        <form @submit.prevent="transfer">
            <div>
                <label for="to_account_id">Recipient Account ID:</label>
                <input type="text" v-model="to_account_id" required>
            </div>
            <div>
                <label for="amount">Amount:</label>
                <input type="number" v-model="amount" required>
            </div>
            <button type="submit">Transfer</button>
        </form>
    </div>
</template>

<script>
import api from '../axios.js';

export default {
    data() {
        return {
            to_account_id: '',
            amount: 0
        };
    },
    methods: {
        async transfer() {
            try {
                const response = await api.post('v1/transfer', {
                    to_account_id: this.to_account_id,
                    amount: this.amount
                });
                alert(response.data.message);
            } catch (error) {
                console.error('Error transferring money:', error);
                alert(error.response.data.message);
            }
        }
    }
};
</script>
