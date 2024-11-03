<?php

namespace App\Providers;

use App\Models\Contact;
use App\Models\Todo;
use App\Models\User;
use App\Policies\TodoPolicy;
use App\Policies\UserPolicy;
use App\Providers\Guard\TokenGuard;
use App\Providers\Model\User\SimpleUserProvider;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Todo::class => TodoPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Auth::extend("token", function (Application $application, string $name, array $config) {
            $guard = new TokenGuard(Auth::createUserProvider($config["provider"]), $application->make(Request::class));
            $application->refresh('request', $guard, 'setRequest');
            return $guard;
        });

        Auth::provider("simple", function (Application $application, array $config) {
            return new SimpleUserProvider();
        });

        Gate::define("get-contact", function (User $user, Contact $contact) {
            return $user->id === $contact->user_id;
        });
        Gate::define("update-contact", function (User $user, Contact $contact) {
            return $user->id === $contact->user_id;
        });
        Gate::define("delete-contact", function (User $user, Contact $contact) {
            return $user->id === $contact->user_id;
        });
        Gate::define("create-contact", function ( User $value,) {
            if ($value->name == "admin") {
                return Response::allow();
            } else {
                return Response::deny("You are not admin.");
            }
        });
    }
}
