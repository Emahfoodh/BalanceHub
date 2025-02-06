<template>
    <div class="max-w-md mx-auto mt-8">
        <h2 class="text-xl font-semibold mb-4">Transaction History</h2>
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <ul class="divide-y divide-gray-200">
                <li v-for="(transaction, index) in transactions" :key="index" :data-type="'transaction'"
                    :data-account-id="transaction.accountId" :data-amount="transaction.amount"
                    :data-balance="transaction.balance" class="px-4 py-4 sm:px-6 hover:bg-gray-50">
                    <div class="flex items-center justify-between space-x-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <svg v-if="transaction.amount >= 0" class="h-6 w-6 text-green-500" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                </svg>
                                <svg v-else class="h-6 w-6 text-red-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">
                                    Account ID: {{ transaction.accountId }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    Amount: {{ transaction.amount }}
                                </div>
                            </div>
                        </div>
                        <div v-if="index === 0 || transaction.accountId !== transactions[index - 1].accountId"
                            class="text-sm text-gray-900">
                            Balance: {{ transaction.balance }}
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        transactions: Array,
    },
};
</script>

<style scoped>
.space-x-4 > * + * {
    margin-left: 1rem;
}
</style>
