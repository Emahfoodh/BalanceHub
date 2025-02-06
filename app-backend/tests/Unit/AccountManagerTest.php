<?php

namespace Tests\Unit;

use App\Singletons\AccountManager;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class AccountManagerTest extends TestCase
{
    public function testSetAccount()
    {
        $accountId = Uuid::uuid4()->toString();
        $manager = AccountManager::getInstance();
        $manager->setAccount($accountId, 100);

        $account = $manager->getAccount($accountId);
        $this->assertEquals(100, $account['balance']);
    }

    public function testAddTransaction()
    {
        $accountId = Uuid::uuid4()->toString();
        $manager = AccountManager::getInstance();
        $manager->setAccount($accountId, 100);

        $transaction = $manager->addTransaction($accountId, 50);
        $this->assertEquals(150, $transaction['balance']);
    }

    public function testInvalidAccountId()
    {
        $this->expectException(\InvalidArgumentException::class);
        $manager = AccountManager::getInstance();
        $manager->setAccount('invalid-uuid');
    }

    public function testInvalidAmount()
    {
        $this->expectException(\InvalidArgumentException::class);
        $accountId = Uuid::uuid4()->toString();
        $manager = AccountManager::getInstance();
        $manager->setAccount($accountId, 100);

        $manager->addTransaction($accountId, 'not-an-integer');
    }
}