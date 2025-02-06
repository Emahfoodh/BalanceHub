<template>
  <div class="min-h-screen bg-gray-100 py-6 flex flex-col justify-center sm:py-12">
    <div class="relative py-3 sm:max-w-xl sm:mx-auto">
      <div class="relative px-4 py-10 bg-white shadow-lg sm:rounded-3xl sm:p-20">
        <h1 class="text-2xl font-semibold mb-6 text-center">Accounting App</h1>
        <TransactionForm @transaction-submitted="addTransaction" />
        <TransactionList :transactions="transactions" />
      </div>
    </div>
  </div>
</template>

<script>
import TransactionForm from './components/TransactionForm.vue';
import TransactionList from './components/TransactionList.vue';

export default {
  components: {
    TransactionForm,
    TransactionList,
  },
  data() {
    return {
      transactions: [],
    };
  },
  methods: {
    addTransaction(transactionData) {
      // Validate incoming transaction data
      if (
        typeof transactionData.accountId !== 'string' ||
        transactionData.accountId.trim() === '' ||
        isNaN(transactionData.amount)
      ) {
        alert('Invalid transaction data. Account ID must be a valid string, and amount must be a valid number.');
        return;
      }

      // Add the transaction to the list
      const newTransaction = {
        accountId: transactionData.accountId,
        amount: Number(transactionData.amount), // Ensure amount is a number
        balance: this.calculateBalance(transactionData.accountId, transactionData.amount),
      };
      this.transactions.unshift(newTransaction);
    },
    calculateBalance(accountId, amount) {
      // Find the latest balance for this account
      const lastTransaction = this.transactions.find(t => t.accountId === accountId);
      const currentBalance = lastTransaction ? lastTransaction.balance : 0;
      return currentBalance + Number(amount);
    },
  },
};
</script>
