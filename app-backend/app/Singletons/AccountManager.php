<?php

namespace App\Singletons;

use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Cache;

class AccountManager
{
    private static $instance = null;

    private function __construct()
    {
        // Private constructor to prevent direct instantiation
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function setAccount($accountId, $balance = 0)
    {
        if (!Uuid::isValid($accountId)) {
            throw new \InvalidArgumentException("Account ID must be a valid UUIDv4.");
        }

        $accounts = Cache::get('accounts', []);

        if (!isset($accounts[$accountId])) {
            $accounts[$accountId] = [
                'balance' => $balance,
                'account_id' => $accountId,
                'transactions' => []
            ];
            Cache::put('accounts', $accounts, 14400);
        }

        return $this;
    }

    public function getAccount($accountId)
    {
        $accounts = Cache::get('accounts', []);
        return $accounts[$accountId] ?? null;
    }

    public function addTransaction($accountId, $amount)
    {
        if (!is_int($amount)) {
            throw new \InvalidArgumentException("Amount must be an integer.");
        }

        $accounts = Cache::get('accounts', []);
        if (!isset($accounts[$accountId])) {
            $this->setAccount($accountId);
            $accounts = Cache::get('accounts', []);
        }

        $accounts[$accountId]['balance'] += $amount;

        $transactionId = Uuid::uuid4()->toString();

        $transaction = [
            'transaction_id' => $transactionId,
            'account_id' => $accountId,
            'amount' => $amount,
            'balance' => $accounts[$accountId]['balance'],
            'created_at' => date('Y-m-d H:i:s')
        ];

        $accounts[$accountId]['transactions'][$transactionId] = $transaction;

        Cache::put('accounts', $accounts, 14400);

        return $transaction;
    }

    public function getTransaction($accountId, $transactionId)
    {
        $accounts = Cache::get('accounts', []);
        return $accounts[$accountId]['transactions'][$transactionId] ?? null;
    }

    public function getTransactionById($transactionId)
    {
        $accounts = Cache::get('accounts', []);
        foreach ($accounts as $account) {
            if (isset($account['transactions'][$transactionId])) {
                return $account['transactions'][$transactionId];
            }
        }
        return null;
    }

    public function getAccountTransactions($accountId)
    {
        $accounts = Cache::get('accounts', []);
        $transactions = $accounts[$accountId]['transactions'] ?? [];
        usort($transactions, function ($a, $b) {
            return strtotime($a['created_at']) - strtotime($b['created_at']);
        });
        return $transactions;
    }

    public function getBalance($accountId)
    {
        $accounts = Cache::get('accounts', []);
        return $accounts[$accountId]['balance'] ?? null;
    }

    public function getAccounts()
    {
        return Cache::get('accounts', []);
    }
}