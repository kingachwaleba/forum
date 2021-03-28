<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\User;
use App\Policies\PostsPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
//         'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('update-post', function ($user, $post) {
            return $user->id == $post->user_id;
        });

        Gate::define('delete-post', function ($user, $post) {
            return $user->id == $post->user_id;
        });

        Gate::define('delete-post-picture', function ($user, $post) {
            return $user->id == $post->user_id;
        });

        Gate::define('update-comment', function ($user, $comment) {
            return $user->id == $comment->user_id;
        });

        Gate::define('delete-comment', function ($user, $comment) {
            return $user->id == $comment->user_id;
        });

        Gate::define('delete-comment-picture', function ($user, $comment) {
            return $user->id == $comment->user_id;
        });

        Gate::define('update-user', function ($user, $user2) {
            return $user->id == $user2->id;
        });

        Gate::define('delete-user', function ($user, $user2) {
            return $user->id == $user2->id;
        });

        Gate::define('delete-user-picture', function ($user, $user2) {
            return $user->id == $user2->id;
        });
    }
}
