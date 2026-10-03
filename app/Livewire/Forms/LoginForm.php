<?php

namespace App\Livewire\Forms;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\User;
use App\Models\Periode;

class LoginForm extends Form
{
    #[Validate('required|string')]
    public string $nim = '';

    #[Validate('required|string')]
    public string $password = '';

    #[Validate('boolean')]
    public bool $remember = false;

    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        // Find candidate users with this NIM.
        // Prioritize the user from the ACTIVE periode so that someone who
        // is a member in both an old and a new periode always logs into
        // the new (active) one first.
        $activePeriodeId = optional(Periode::active())->id;

        $candidates = User::where('nim', $this->nim)
            ->orderByRaw("CASE WHEN periode_id = ? THEN 0 ELSE 1 END", [$activePeriodeId])
            ->orderBy('id')
            ->get();

        $authenticatedUser = null;
        foreach ($candidates as $candidate) {
            if (Hash::check($this->password, $candidate->password)) {
                $authenticatedUser = $candidate;
                break;
            }
        }

        if (!$authenticatedUser) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'form.nim' => trans('auth.failed'),
            ]);
        }

        // Manually log in the correct user record
        Auth::login($authenticatedUser, $this->remember);
        RateLimiter::clear($this->throttleKey());

        \App\Models\ActivityLog::create([
            'user_id'     => $authenticatedUser->id,
            'action'      => 'LOGIN',
            'description' => $authenticatedUser->name . ' berhasil masuk (login) ke sistem.',
            'ip_address'  => request()->ip()
        ]);
    }

    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'form.nim' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->nim).'|'.request()->ip());
    }
}
