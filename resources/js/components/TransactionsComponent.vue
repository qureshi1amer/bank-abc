<template>
    <div>
        <h2>Outwards History</h2>
        <table v-if="outwards.length" class="table">
            <thead>
            <tr>
                <th scope="col">From Account</th>
                <th scope="col">To Account</th>
                <th scope="col">Amount</th>
                <th scope="col">Date</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="transaction in outwards" :key="transaction.id">
                <td>{{ transaction.sender_name }}</td>
                <td>{{ transaction.receiver_name }}</td>
                <td>${{ transaction.amount }}</td>
                <td>{{ new Date(transaction.created_at).toLocaleString() }}</td>
            </tr>
            </tbody>
        </table>
        <p v-else> No transactions found.</p>
        <h2>Inward History</h2>
        <table v-if="inwards.length" class="table">
            <thead>
            <tr>
                <th scope="col">From Account</th>
                <th scope="col">To Account</th>
                <th scope="col">Amount</th>
                <th scope="col">Date</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="transaction in inwards" :key="transaction.id">
                <td>{{ transaction.sender_name }}</td>
                <td>{{ transaction.receiver_name }}</td>
                <td>${{ transaction.amount }}</td>
                <td>{{ new Date(transaction.created_at).toLocaleString() }}</td>
            </tr>
            </tbody>
        </table>
        <p v-else> No transactions found.</p>
    </div>
</template>

<script>
import api from '../axios.js';

export default {
    data() {
        return {
            inwards: [],
            outwards: []
        };
    },
    async created() {
        try {
            const response = await api.get('v1/transactions');
            this.inwards = response.data.data.inwards;
            this.outwards = response.data.data.outwards;
        }
        catch (error) {
            console.error('Error fetching transactions:', error);
        }
    }
};
</script>

