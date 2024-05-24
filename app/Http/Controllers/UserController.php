<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required',
                'password' => 'required',
            ],
            [
                'email.required' => 'Email is required',
                'password.required' => 'Password is required',
            ]
        );
        if ($validator->fails()) {
            foreach ($validator->messages()->all() as $message) {
                flash()->addError($message);
            }
            return back()->withInput();
        }

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        $remember = $request->get('remember') ? true : false;
        if (Auth::attempt($credentials, $remember = $remember)) {
            $request->session()->regenerate();
            flash()->addInfo('Welcome back ' . Auth::user()->name . '!');
            return redirect()->intended('/');
        }

        return back()->withInput();
    }

    public function logout(Request $request)
    {
        if (!Auth::check()) {
            flash()->addError('You are not logged in.');
            return redirect('/');
        }
        $name = Auth::user()->name;
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        flash()->addInfo('See you again ' . $name . '!');
        return redirect()->intended('/');
    }

    public function register(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|confirmed',
            ],
            [
                'name.required' => 'Name is required',
                'email.required' => 'Email is required',
                'email.email' => 'Invalid email format',
                'email.unique' => 'Email address already in use',
                'password.required' => 'Password is required',
                'password.confirmed' => 'Passwords does not match',
            ]
        );
        if ($validator->fails()) {
            foreach ($validator->messages()->all() as $message) {
                flash()->addError($message);
            }
            return back()->withInput();
        }

        $user_form = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'profile' => '/images/profiles/1.jpg',
        ];

        $user = User::create($user_form);
        Auth::login($user);
        flash()->addInfo('Registration completed');
        return redirect('/');
    }

    public function update(Request $request)
    {
        if (!Auth::check()) {
            flash()->addError('Please login first');
            return redirect('/login');
        }

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users')->ignore(Auth::id()),
                ],
                'profile' => 'required'
            ],
            [
                'name.required' => 'Name is required',
                'email.required' => 'Email is required',
                'email.email' => 'Invalid email format',
                'email.unique' => 'Email address already in use',
                'profile.required' => 'Profile is required'
            ]
        );

        if ($validator->fails()) {
            foreach ($validator->messages()->all() as $message) {
                flash()->addError($message);
            }
            return back()->withInput();
        }

        /** @var \App\Models\User|\Illuminate\Contracts\Auth\Authenticatable $user */
        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->profile = parse_url($request->profile, PHP_URL_PATH);
        $user->save();

        flash()->addSuccess('User info updated successfully');
        return back();
    }

    public function getProfileImageLinks(Request $request)
    {
        $profiles = [
            '/images/profiles/1.jpg',
            '/images/profiles/2.jpg',
            '/images/profiles/3.jpg',
            '/images/profiles/4.jpg',
            '/images/profiles/5.jpg',
            '/images/profiles/6.jpg',
            '/images/profiles/7.jpg',
            '/images/profiles/8.jpg',
            '/images/profiles/9.jpg',
            '/images/profiles/10.jpg',
            '/images/profiles/11.jpg',
        ];

        return response()->json([
            'message' => 'Section fetched successfully',
            'images' => $profiles
        ]);
    }

    public function resetPassword(Request $request)
    {
        if (!Auth::check()) {
            flash()->addError('Please login first');
            return redirect('/login');
        }

        $validator = Validator::make(
            $request->all(),
            [
                'current_password' => 'required|current_password',
                'password' => 'required|confirmed',
            ],
            [
                'current_password.required' => 'Current password is required',
                'current_password.current_password' => 'Incorrect password',
                'password.required' => 'Password is required',
                'password.confirmed' => 'Passwords do not match'
            ]
        );

        if ($validator->fails()) {
            foreach ($validator->messages()->all() as $message) {
                flash()->addError($message);
            }
            return back()->withInput();
        }

        /** @var \App\Models\User|\Illuminate\Contracts\Auth\Authenticatable $user */
        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->save();

        flash()->addSuccess('Password changed successfully');
        return back();
    }
}
