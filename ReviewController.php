<?php

     namespace App\Http\Controllers;

     use App\Models\Activity;
     use App\Models\Destination;
     use App\Models\Review;
     use Illuminate\Http\Request;

     class ReviewController extends Controller
     {
         public function postReview(Request $request)
         {
             $request->validate([
                 'reviewable_type' => 'required|in:Destination,Activity',
                 'reviewable_id' => 'required|numeric',
                 'rating' => 'required|integer|min:1|max:5',
                 'comment' => 'nullable|string',
             ]);

             $reviewableType = $request->reviewable_type === 'Destination' ? Destination::class : Activity::class;

             // Check if reviewable exists
             $reviewable = $reviewableType::find($request->reviewable_id);
             if (!$reviewable) {
                 return response()->json(['message' => 'Reviewable not found'], 404);
             }

             $review = Review::create([
                 'reviewable_id' => $request->reviewable_id,
                 'reviewable_type' => $reviewableType,
                 'rating' => $request->rating,
                 'comment' => $request->comment,
             ]);

             // Update average rating
             $this->updateAverageRating($reviewable);

             return response()->json(['message' => 'Review posted', 'review' => $review], 201);
         }

         public function getReviews(Request $request)
         {
             $request->validate([
                 'reviewable_type' => 'required|in:Destination,Activity',
                 'reviewable_id' => 'required|numeric',
             ]);

             $reviewableType = $request->reviewable_type === 'Destination' ? Destination::class : Activity::class;

             $reviews = Review::where('reviewable_type', $reviewableType)
                 ->where('reviewable_id', $request->reviewable_id)
                 ->get();

             return response()->json(['reviews' => $reviews], 200);
         }

         private function updateAverageRating($reviewable)
         {
             $averageRating = $reviewable->reviews()->avg('rating');
             $reviewable->average_rating = round($averageRating, 2);
             $reviewable->save();
         }
     }