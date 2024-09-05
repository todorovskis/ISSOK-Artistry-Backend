<?php

namespace App\Providers;

use App\Repositories\ArtistRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ClientRepository;
use App\Repositories\CountryRepository;
use App\Repositories\impl\ArtistRepositoryImpl;
use App\Repositories\impl\CategoryRepositoryImpl;
use App\Repositories\impl\ClientRepositoryImpl;
use App\Repositories\impl\CountryRepositoryImpl;
use App\Repositories\impl\OfferCategoryRepositoryImpl;
use App\Repositories\impl\OfferRepositoryImpl;
use App\Repositories\impl\ReviewRepositoryImpl;
use App\Repositories\impl\UserRepositoryImpl;
use App\Repositories\OfferCategoryRepository;
use App\Repositories\OfferRepository;
use App\Repositories\ReviewRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Providers\LaravelServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ArtistRepository::class, ArtistRepositoryImpl::class);
        $this->app->bind(CategoryRepository::class, CategoryRepositoryImpl::class);
        $this->app->bind(ClientRepository::class, ClientRepositoryImpl::class);
        $this->app->bind(CountryRepository::class, CountryRepositoryImpl::class);
        $this->app->bind(OfferCategoryRepository::class, OfferCategoryRepositoryImpl::class);
        $this->app->bind(OfferRepository::class, OfferRepositoryImpl::class);
        $this->app->bind(ReviewRepository::class, ReviewRepositoryImpl::class);
        $this->app->singleton(JWTAuth::class, function ($app) {
            return $app->make(LaravelServiceProvider::class)->getJWTAuth();
        });
        $this->app->bind(UserRepository::class, UserRepositoryImpl::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
