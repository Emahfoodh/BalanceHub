<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Singletons\AccountManager;
use Ramsey\Uuid\Uuid;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        if (!$request->isJson()) {
            return response()->json(['error' => 'Unsupported Media Type'], 415);
        }

        $request->validate([
            'account_id' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        $accountManager = AccountManager::getInstance();

        try {
            $transaction = $accountManager->addTransaction(
                $request->input('account_id'),
                $request->input('amount')
            );
            // $accounts = $accountManager->getAccounts();

            return response()->json($transaction, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function show($transactionId)
    {
        if (!Uuid::isValid($transactionId)) {
            return response()->json(['error' => 'transaction_id missing or has incorrect type'], 400);
        }

        $accountManager = AccountManager::getInstance();

        $transaction = $accountManager->getTransactionById($transactionId);

        

        if ($transaction) {
            return response()->json($transaction, 200);
        }

        return response()->json(['error' => 'Transaction not found'], 404);
    }

    public function index()
    {
        $accountManager = AccountManager::getInstance();

        $accounts = $accountManager->getAccounts();
        $allTransactions = [];

        foreach ($accounts as $accountId => $account) {
            $transactions = $accountManager->getAccountTransactions($accountId);
            foreach ($transactions as $transaction) {
                $allTransactions[] = $transaction;
            }
        }

        return response()->json($allTransactions, 200);
    }

}
