<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Destination;
use App\Models\Bookmark;
use App\Models\UserPreference;
use Illuminate\Http\Request;

class RecommendationController extends Controller
{
    public function getRecommendations(Request $request)
    {
        $sessionId = $request->query('session_id') ?? $request->input('session_id');

        $request->validate([
            'session_id' => 'required|string',
        ], [
            'session_id.required' => 'The session_id parameter is required.',
        ]);

        $bookmarkedDestinationIds = Bookmark::where('session_id', $sessionId)->pluck('destination_id');

        $preference = UserPreference::where('session_id', $sessionId)->first();

        // Get destinations
        $destinationsQuery = Destination::query();
        if ($bookmarkedDestinationIds->isNotEmpty()) {
            $destinationsQuery->whereIn('id', $bookmarkedDestinationIds);
        }
        $destinationsQuery->orWhere('average_rating', '>=', 4); // High-rated destinations
        $destinations = $destinationsQuery->orderBy('average_rating', 'desc')->get();

        // Get activities within budget
        $activitiesQuery = Activity::query();
        if ($bookmarkedDestinationIds->isNotEmpty()) {
            $activitiesQuery->whereIn('destination_id', $bookmarkedDestinationIds);
        }
        $activitiesQuery->orWhere('average_rating', '>=', 4);

        if ($preference && $preference->min_budget && $preference->max_budget) {
            $activitiesQuery->whereBetween('price', [$preference->min_budget, $preference->max_budget]);
        }

        $activities = $activitiesQuery->orderBy('average_rating', 'desc')->get();

        return response()->json([
            'destinations' => $destinations,
            'activities' => $activities,
        ], 200);
    }
}