<template>
    <form @submit.prevent="submitTransaction" class="max-w-md mx-auto p-6 bg-white shadow-lg rounded-lg">
        <div class="space-y-4">
            <div>
                <label for="accountId" class="block text-sm font-medium text-gray-700">Account ID</label>
                <input id="accountId" v-model="accountId" type="text" required data-type="account-id"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    placeholder="Enter account ID" />
            </div>
            <div>
                <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                <input id="amount" v-model="amount" type="number" required data-type="amount"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    placeholder="Enter amount" />
            </div>
            <button type="submit" data-type="transaction-submit"
                class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Submit Transaction
            </button>
        </div>
    </form>
</template>

<script>
export default {
    data() {
        return {
            accountId: '',
            amount: '',
        };
    },
    methods: {
        submitTransaction() {
            // Validate accountId (ensure it's a valid UUID)
            const uuidRegex =
                /^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i;
            if (!uuidRegex.test(this.accountId)) {
                alert('Invalid Account ID. Must be a valid UUID.');
                return;
            }

            // Validate amount (ensure it's a valid number)
            if (isNaN(this.amount) || this.amount === '') {
                alert('Amount must be a valid number.');
                return;
            }

            // Emit the transaction data if valid
            this.$emit('transaction-submitted', {
                accountId: this.accountId,
                amount: Number(this.amount), // Ensure amount is a number
            });

            // Reset form fields
            this.accountId = '';
            this.amount = '';
        },

    },
};
</script>