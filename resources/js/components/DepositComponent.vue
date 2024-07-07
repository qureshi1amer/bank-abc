<template>
    <div>
        <h2>Deposit Balance</h2>
        <form @submit.prevent="submitDeposit">
            <div class="form-group">
                <label for="amount">Amount:</label>
                <input
                    type="number"
                    id="amount"
                    v-model="amount"
                    class="form-control"
                    required
                    min="0.01"
                    step="0.01"
                />
            </div>
            <button type="submit" class="btn btn-primary">Deposit</button>
        </form>
        <p v-if="message" :class="{'text-success': success, 'text-danger': !success}">{{ message }}</p>
    </div>
</template>

<script>
import api from '../axios.js';

export default {
    data() {
        return {
            amount: null,
            message: '',
            success: false
        };
    },
    methods: {
        async submitDeposit() {
            try {
                const response = await api.post('v1/deposit', { amount: this.amount });
                this.message = response.data.message;
                this.success = true;
                this.amount = null; // Reset the amount input field
            } catch (error) {
                this.message = error.response.data.message || 'An error occurred.';
                this.success = false;
            }
        }
    }
};
</script>

