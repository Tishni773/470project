<?php

  use App\Http\Controllers\PreferenceController;
  use App\Http\Controllers\RecommendationController;
  use App\Http\Controllers\ReviewController;
  use Illuminate\Support\Facades\Route;

  Route::get('/', function () {
      return redirect()->route('preferences');
  });

  // Preferences (Feature 1)
  Route::get('/preferences', [PreferenceController::class, 'showPreferences'])->name('preferences');
  Route::post('/preferences/budget', [PreferenceController::class, 'setBudget'])->name('preferences.budget');
  Route::post('/preferences/bookmarks', [PreferenceController::class, 'addBookmark'])->name('preferences.bookmark.add');
  Route::post('/preferences/bookmarks/remove', [PreferenceController::class, 'removeBookmark'])->name('preferences.bookmark.remove');

  // Recommendations (Feature 2)
  Route::get('/recommendations', [RecommendationController::class, 'showRecommendations'])->name('recommendations');

  // Reviews (Features 3 & 4)
  Route::get('/reviews/{type}/{id}', [ReviewController::class, 'showReviews'])->name('reviews.show');
  Route::post('/reviews', [ReviewController::class, 'postReview'])->name('reviews.store');