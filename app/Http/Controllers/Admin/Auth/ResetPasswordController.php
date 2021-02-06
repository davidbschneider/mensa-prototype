<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Actions\Fortify\ResetUserPassword;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    /**
     * Where to redirect admins after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::ADMIN_HOME;

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $token
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showResetForm($token = null)
    {
        if($this->validateToken($token))
        {
            return view('admin.auth.passwords.reset')
                ->withToken($token);
        } else {
            return redirect(route('admin.password.request'));
        }
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:admins,email',
            'password' => 'required',
        ]);
        if(DB::table(config('auth.passwords.admins.table'))->where([
            ['email', '=', $request->get('email')],
            ['token', '=', $request->get('token')]
        ])->count())
        {
            (new ResetUserPassword())->reset(
                Admin::where('email', $request->get('email'))->first(),
                $request->all()
            );
            return redirect(route('admin.login'));
        } else {

        }
    }

    protected function validateToken($token)
    {
        return 0 < DB::table(config('auth.passwords.admins.table'))
            ->where('token', $token)->count();
    }
}
