<?php

namespace App\Providers;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Builder::macro('addCanUpdate', function ($prefix) {
            /** @var Builder $this */
            $hasUpdate = hasPermission("{$prefix}_update") ? 'true' : 'false';
            return $this->addSelect(DB::raw("{$hasUpdate} as can_update"));
        });
        Builder::macro('addCanDelete', function ($prefix) {
            /** @var Builder $this */
            $hasDelete = hasPermission("{$prefix}_delete") ? 'true' : 'false';
            return $this->addSelect(DB::raw("{$hasDelete} as can_delete"));
        });
        Builder::macro('addCanApprove', function ($prefix) {
            /** @var Builder $this */
            $hasDelete = hasPermission("{$prefix}_approve") ? 'true' : 'false';
            return $this->addSelect(DB::raw("{$hasDelete} as can_approve"));
        });
        Builder::macro('addCanReject', function ($prefix) {
            /** @var Builder $this */
            $hasDelete = hasPermission("{$prefix}_reject") ? 'true' : 'false';
            return $this->addSelect(DB::raw("{$hasDelete} as can_reject"));
        });
        Builder::macro('addCanUpdateAndCanDelete', function ($prefix) {
            /** @var Builder $this */
            return $this->addCanUpdate($prefix)
                ->addCanDelete($prefix);
        });
        Builder::macro('addCanApproveAndCanReject', function ($prefix) {
            /** @var Builder $this */
            return $this->addCanApprove($prefix)
                ->addCanReject($prefix);
        });
    }
}
