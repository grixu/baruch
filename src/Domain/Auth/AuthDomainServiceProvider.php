<?php

namespace Domain\Auth;

use Domain\Auth\Models\Congregation;
use Domain\Auth\Models\Group;
use Domain\Auth\Models\Invitation;
use Domain\Auth\Policies\CongregationPolicy;
use Domain\Auth\Policies\GroupPolicy;
use Domain\Auth\Policies\InvitationPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthDomainServiceProvider extends ServiceProvider
{
    protected $policies = [
        Congregation::class => CongregationPolicy::class,
        Invitation::class => InvitationPolicy::class,
        Group::class => GroupPolicy::class
    ];

    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            return $user->hasRole('super_admin') ? true : null;
        });
    }
}
