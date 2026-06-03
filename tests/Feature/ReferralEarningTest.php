<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Deposit;
use App\Models\Trade;
use App\Models\User;
use App\Models\UserTrade;
use App\Services\TradeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReferralEarningTest extends TestCase
{
    use RefreshDatabase;

    public function test_referral_commissions_are_credited_correctly()
    {
        // 1. Create a chain of 4 users (User 4 -> User 3 -> User 2 -> User 1)
        $user1 = User::factory()->create(['referral_code' => 'CODE1', 'balance_gains' => 0]);
        $user2 = User::factory()->create(['referred_by' => $user1->id, 'referral_code' => 'CODE2', 'balance_gains' => 0]);
        $user3 = User::factory()->create(['referred_by' => $user2->id, 'referral_code' => 'CODE3', 'balance_gains' => 0]);
        $user4 = User::factory()->create(['referred_by' => $user3->id, 'referral_code' => 'CODE4', 'balance_gains' => 0]);

        // 2. Create Category, Trade and PaymentMethod
        $category = Category::create([
            'name' => 'Standard',
            'daily_profit_percent' => 5,
            'duration_days' => 30,
            'is_active' => true,
        ]);

        $trade = Trade::create([
            'category_id' => $category->id,
            'name' => 'Trade 100',
            'amount' => 100,
            'is_active' => true,
        ]);

        $paymentMethod = \App\Models\PaymentMethod::create([
            'name' => 'Crypto',
            'details' => '0x123',
            'is_active' => true,
        ]);

        // 3. User 4 creates a trade
        $userTrade = UserTrade::create([
            'user_id' => $user4->id,
            'trade_id' => $trade->id,
            'category_id' => $category->id,
            'amount' => 100,
            'daily_gain' => 5.00,
            'status' => 'pending',
        ]);

        $deposit = Deposit::create([
            'user_id' => $user4->id,
            'user_trade_id' => $userTrade->id,
            'amount' => 100,
            'status' => 'pending',
            'payment_method_id' => $paymentMethod->id,
            'currency' => 'USD',
        ]);

        // 4. Activate the trade via TradeService
        $tradeService = app(TradeService::class);
        $tradeService->activateTrade($deposit);

        // 5. Verify Commissions
        // Level 1: User 3 should get 5% of 100 = 5
        // Level 2: User 2 should get 3% of 100 = 3
        // Level 3: User 1 should get 1% of 100 = 1

        $user1->refresh();
        $user2->refresh();
        $user3->refresh();

        $this->assertEquals(5.00, $user3->balance_gains, 'User 3 (Level 1) should have 5 USD commission');
        $this->assertEquals(3.00, $user2->balance_gains, 'User 2 (Level 2) should have 3 USD commission');
        $this->assertEquals(1.00, $user1->balance_gains, 'User 1 (Level 3) should have 1 USD commission');

        $this->assertDatabaseHas('referrals', [
            'referrer_id' => $user3->id,
            'referred_id' => $user4->id,
            'level' => 1,
            'commission_amount' => 5.00,
            'status' => 'paid',
        ]);

        $this->assertDatabaseHas('referrals', [
            'referrer_id' => $user2->id,
            'referred_id' => $user4->id,
            'level' => 2,
            'commission_amount' => 3.00,
            'status' => 'paid',
        ]);

        $this->assertDatabaseHas('referrals', [
            'referrer_id' => $user1->id,
            'referred_id' => $user4->id,
            'level' => 3,
            'commission_amount' => 1.00,
            'status' => 'paid',
        ]);
    }
}
