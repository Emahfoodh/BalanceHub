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
    async fetchTransactions() {
      try {
        const response = await fetch('http://localhost:8000/api/transactions');
        if (!response.ok) throw new Error('Failed to fetch transactions');

        const data = await response.json();
        this.transactions = data.map(transaction => ({
          transactionId: transaction.transaction_id,
          accountId: transaction.account_id,
          amount: transaction.amount,
          balance: transaction.balance,
          createdAt: transaction.created_at
        })).reverse();
      } catch (error) {
        console.error('Error fetching transactions:', error);
      }
    },
    addTransaction(transactionData) {
      const newTransaction = {
        transactionId: transactionData.transaction_id,
        accountId: transactionData.account_id,
        amount: Number(transactionData.amount),
        balance: transactionData.balance,
        createdAt: transactionData.created_at
      };
      this.transactions.unshift(newTransaction);
    }
  },
  mounted() {
    this.fetchTransactions();
  }
};
</script>
