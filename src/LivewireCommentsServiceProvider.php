<?php

namespace Spatie\LivewireComments;

use Illuminate\Support\Facades\Gate;
use Livewire\Livewire;
use Spatie\Comments\Livewire\CommentComponent;
use Spatie\Comments\Livewire\CommentsComponent;
use Spatie\Comments\Support\Config;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LivewireCommentsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-comments')
            ->hasViews();
    }

    public function packageBooted()
    {
        $this
            ->registerLivewireComponents()
            ->registerPolicies();
    }

    protected function registerLivewireComponents(): self
    {
        Livewire::component('comments', CommentsComponent::class);
        Livewire::component('comment', CommentComponent::class);

        return $this;
    }

    public function registerPolicies(): self
    {
        Gate::define('createComment', [Config::getCommentPolicyName(), 'create']);

        Gate::policy(Config::getCommentModelName(), Config::getCommentPolicyName());
        Gate::policy(Config::getReactionModelName(), Config::getReactionPolicyName());

        return $this;
    }
}
