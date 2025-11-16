<?php

namespace App\Http\Controllers\Auth;

use App\Enums\User\Status;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        public UserRepository $repository
    ) {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);

        $user = $this->repository->find($request->input($this->username()));
        if ($user && $user->status == Status::REJECTED) {
            throw ValidationException::withMessages([
                'Your account has been <span class="text-danger">rejected</span> by the administrator.'
            ]);
        }
        if ($user && $user->status == Status::PENDING) {
            throw ValidationException::withMessages([
                'Your account is <span class="text-warning">pending</span> approval by the administrator.'
            ]);
        }
    }
}
