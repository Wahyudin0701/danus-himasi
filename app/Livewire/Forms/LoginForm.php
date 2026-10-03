<?php

namespace App\Livewire\Forms;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Form;

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

        if (! Auth::attempt($this->only(['nim', 'password']), $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'form.nim' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());

        $user = Auth::user();

        // Admin can always login — no period restriction
        if ($user->role !== 'admin') {
            $activePeriode = \App\Models\Periode::active();

            if (!$activePeriode || $user->periode_id !== $activePeriode->id) {
                Auth::logout();
                throw ValidationException::withMessages([
                    'form.nim' => 'Akun Anda tidak aktif pada periode kepengurusan saat ini (' .
                                  ($activePeriode ? $activePeriode->name : 'belum ada periode aktif') .
                                  '). Hubungi administrator.',
                ]);
            }
        }

        \App\Models\ActivityLog::create([
            'user_id'     => $user->id,
            'action'      => 'LOGIN',
            'description' => $user->name . ' berhasil masuk (login) ke sistem.',
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
