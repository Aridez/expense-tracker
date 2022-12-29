<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Redirect;

class AccountController extends Controller
{
    /**
     * Show the form to register a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('resources.accounts.create');
    }

    /**
     * Store a newly created user and log in.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * Display the user's profile form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function edit(Request $request)
    {
        return view('resources.accounts.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => ['string', 'max:255'],
            //'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
        ]);

        auth()->user()->update($validated);

        if (auth()->user()->isDirty('email')) {
            auth()->user()->email_verified_at = null;
        }

        auth()->user()->save();

        return Redirect::route('accounts.edit')->withSuccess('The action was completed succesfully');
    }
}
