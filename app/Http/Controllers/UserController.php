<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', User::class);

        return view('users.index', [
            'usersCount' => User::count(),
        ]);
    }

    public function create(): View
    {
        $this->authorize('create', User::class);

        return view('users.create', [
            'events' => Event::query()->orderBy('name')->get(),
        ]);
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $this->authorize('create', User::class);

        $user = User::create([
            'username' => $request->username,
            'full_name' => $request->full_name,
            'password' => $request->password,
            'access_create_users' => $request->boolean('access_create_users'),
            'access_manage_events' => $request->boolean('access_manage_events'),
            'access_record_attendees' => $request->boolean('access_record_attendees'),
        ]);

        $user->events()->sync($request->input('event_ids', []));

        return redirect()->route('users.index')->with('status', 'user-saved');
    }

    public function show(User $user): View
    {
        $this->authorize('view', $user);

        $user->load('events');

        return view('users.show', compact('user'));
    }

    public function edit(User $user): View
    {
        $this->authorize('update', $user);

        $user->load('events');

        return view('users.edit', [
            'user' => $user,
            'events' => Event::query()->orderBy('name')->get(),
        ]);
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $this->authorize('update', $user);

        $data = [
            'username' => $request->username,
            'full_name' => $request->full_name,
            'access_create_users' => $request->boolean('access_create_users'),
            'access_manage_events' => $request->boolean('access_manage_events'),
            'access_record_attendees' => $request->boolean('access_record_attendees'),
        ];

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $user->update($data);
        $user->events()->sync($request->input('event_ids', []));

        return redirect()->route('users.index')->with('status', 'user-saved');
    }

    public function destroy(User $user): RedirectResponse
    {
        $this->authorize('delete', $user);

        $user->delete();

        return redirect()->route('users.index')->with('status', 'user-deleted');
    }
}
