<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Отобразить представление регистрации.
     */
    public function create(): View
    {
        $departments = Department::all();

        return view('auth.register', compact('departments'));
    }

    /**
     * Обработать входящий запрос на регистрацию.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'department_id' => ['required', 'exists:departments,id'],
        ], [
            'name.required' => 'Пожалуйста, введите ваше имя.',
            'name.string' => 'Имя должно быть строкой.',
            'name.max' => 'Имя не должно превышать 255 символов.',
            'email.required' => 'Пожалуйста, введите ваш адрес электронной почты.',
            'email.string' => 'Адрес электронной почты должен быть строкой.',
            'email.lowercase' => 'Адрес электронной почты должен быть в нижнем регистре.',
            'email.email' => 'Пожалуйста, введите корректный адрес электронной почты.',
            'email.max' => 'Адрес электронной почты не должен превышать 255 символов.',
            'email.unique' => 'Этот адрес электронной почты уже занят.',
            'password.required' => 'Пожалуйста, введите пароль.',
            'password.confirmed' => 'Пароли не совпадают.',
            'department_id.required' => 'Пожалуйста, выберите отдел.',
            'department_id.exists' => 'Выбранный отдел не существует.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'department_id' => $request->department_id,
        ]);

        $user->roles()->attach(Role::where('name', 'User')->first());

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('home');
    }
}
