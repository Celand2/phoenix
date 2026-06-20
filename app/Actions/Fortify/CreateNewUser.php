<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    private const WELCOME_NOTIFICATION_TITLE = 'Bienvenue chez Phoenix Traders';
    private const WELCOME_NOTIFICATION_BODY = 'Votre compte a été créé avec succès. Bienvenue dans notre communauté de trading !';
    private const WELCOME_NOTIFICATION_TYPE = 'welcome';

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     *
     * @throws ValidationException
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'phone' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'referrer_code' => ['nullable', 'string', 'max:255', Rule::exists(User::class, 'referral_code')],
            'password' => $this->passwordRules(),
        ])->validate();

        $referrer = null;

        if (! empty($input['referrer_code'])) {
            $referrer = User::where('referral_code', $input['referrer_code'])->first();
        }

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'phone' => $input['phone'],
            'country' => $input['country'],
            'referral_code' => $this->generateReferralCode(),
            'referred_by' => $referrer?->id,
            'password' => Hash::make($input['password']),
        ]);

        app(\App\Services\NotificationService::class)->send(
            $user,
            self::WELCOME_NOTIFICATION_TITLE,
            self::WELCOME_NOTIFICATION_BODY,
            self::WELCOME_NOTIFICATION_TYPE
        );

        if ($referrer) {
            app(\App\Services\NotificationService::class)->send(
                $referrer,
                'Nouveau Filleul',
                "{$user->name} vient de s'inscrire avec votre code de parrainage.",
                'new_referral'
            );
        }

        app(\App\Services\AdminNotificationService::class)->notifyAdmins(
            'Nouvel Utilisateur',
            "Un nouvel utilisateur s'est inscrit : {$user->name} ({$user->email}).",
            'new_user'
        );

        return $user;
    }

    private function generateReferralCode(): string
    {
        do {
            $code = Str::upper(Str::random(8));
        } while (User::where('referral_code', $code)->exists());

        return $code;
    }
}
