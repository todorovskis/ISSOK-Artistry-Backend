<?php

use App\Http\Controllers\ArtistRegisterController;
use App\Http\Controllers\ArtistsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientRegisterController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public Routes
Route::prefix('')->group(function () {
    Route::get('artists', [ArtistsController::class, 'getAllArtists']);
    Route::post('artists/filter', [ArtistsController::class, 'filterArtistsByCategoriesAndPriceRange']);
    Route::get('artists/search', [ArtistsController::class, 'filterArtistsByPriceRange']);
    Route::get('artists/{id}', [ArtistsController::class, 'getArtistById']);
    Route::get('artists/username/{username}', [ArtistsController::class, 'getArtistByUsername']);
    Route::get('artists/portfolio/{id}', [ArtistsController::class, 'getArtistPortfolioById']);
    Route::get('categories', [CategoryController::class, 'getAllCategories']);
    Route::get('countries', [CountryController::class, 'getAllCountries']);
    Route::post('auth/authenticate-user', [LoginController::class, 'login']);
    Route::post('auth/artist/register', [ArtistRegisterController::class, 'registerArtist']);
    Route::post('auth/client/register', [ClientRegisterController::class, 'registerClient']);
});

// Authenticated Routes
Route::middleware('auth:api')->group(function () {
    Route::get('/offers', [OfferController::class, 'getAllOffers']);
    Route::get('/offers/view-offer/{offerId}', [OfferController::class, 'getOfferById']);
    Route::get('/offers/client/{username}', [OfferController::class, 'getAllOffersByClient']);
    Route::get('/offers/artist/{username}', [OfferController::class, 'getAllOffersByArtist']);
    Route::post('/offers/create', [OfferController::class, 'createOffer']);
    Route::post('/offers/update', [OfferController::class, 'updateOffer']);
    Route::post('/offers/delete', [OfferController::class, 'deleteOffer']);
    Route::post('/offers/sign-up-artist-to-offer', [OfferController::class, 'signUpArtistToOffer']);
    Route::get('/offers/view-signed-up-offers/{artistUsername}', [OfferController::class, 'viewSignedUpOffersFor']);
    Route::post('/offers/assign-artist-on-offer', [OfferController::class, 'assignArtistOnOffer']);
    Route::post('/offers/unassign-offer', [OfferController::class, 'unassignOffer']);
    Route::get('/offers/view-working-on-offers/{artistUsername}', [OfferController::class, 'viewWorkingOnOffersFor']);
    Route::post('/offers/cancel-sign-up', [OfferController::class, 'removeArtistFromOffer']);
    Route::post('/offers/content-to-offer', [OfferController::class, 'addContentToOffer']);
    Route::get('/offers/content/{id}', [OfferController::class, 'getContentForOffer']);
    Route::post('/offers/complete', [OfferController::class, 'completeOffer']);
    Route::get('/offers/search', [OfferController::class, 'filterOffersByPriceRange']);

    Route::post('/reviews/submit', [ReviewController::class, 'submitReview']);
    Route::get('/reviews/{artistId}', [ReviewController::class, 'getReviewsByArtist']);
});
