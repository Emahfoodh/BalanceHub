<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Singletons\AccountManager;
use Ramsey\Uuid\Uuid;


class AccountController extends Controller
{
    public function show($accountId)
    {
        if (!Uuid::isValid($accountId)) {
            return response()->json(['error' => 'account_id missing or has incorrect type'], 400);
        }

        $accountManager = AccountManager::getInstance();
        $account = $accountManager->getAccount($accountId);

        if (!$account) {
            return response()->json(['error' => 'Account not found'], 404);
        }

        return response()->json($account, 200);
    }
}
