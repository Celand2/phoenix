[1mdiff --git a/app/Models/User.php b/app/Models/User.php[m
[1mindex ac2e28f..9c831aa 100644[m
[1m--- a/app/Models/User.php[m
[1m+++ b/app/Models/User.php[m
[36m@@ -22,6 +22,9 @@[m [mclass User extends Authenticatable[m
         'referred_by',[m
         'status',[m
         'role',[m
[32m+[m[32m        'preferred_payment_method_id',[m
[32m+[m[32m        'preferred_currency',[m
[32m+[m[32m        'preferred_rate',[m
         'balance_invested',[m
         'balance_gains',[m
     ];[m
[36m@@ -36,6 +39,7 @@[m [mclass User extends Authenticatable[m
     protected $casts = [[m
         'email_verified_at' => 'datetime',[m
         'password' => 'hashed',[m
[32m+[m[32m        'preferred_rate' => 'decimal:6',[m
         'balance_invested' => 'decimal:2',[m
         'balance_gains' => 'decimal:2',[m
     ];[m
[36m@@ -69,6 +73,11 @@[m [mpublic function withdrawals()[m
         return $this->hasMany(Withdrawal::class);[m
     }[m
 [m
[32m+[m[32m    public function preferredPaymentMethod()[m
[32m+[m[32m    {[m
[32m+[m[32m        return $this->belongsTo(PaymentMethod::class, 'preferred_payment_method_id');[m
[32m+[m[32m    }[m
[32m+[m
     // Claims[m
     public function tradeClaims()[m
     {[m
[36m@@ -86,4 +95,4 @@[m [mpublic function notifications()[m
     {[m
         return $this->hasMany(Notification::class);[m
     }[m
[31m-}[m
\ No newline at end of file[m
[32m+[m[32m}[m
