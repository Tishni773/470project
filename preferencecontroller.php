<?php

     namespace App\Http\Controllers;

     use App\Models\Bookmark;
     use App\Models\UserPreference;
     use Illuminate\Http\Request;

     class PreferenceController extends Controller
     {
         public function setBudget(Request $request)
         {
             $request->validate([
                 'session_id' => 'required|string',
                 'min_budget' => 'required|numeric|min:0',
                 'max_budget' => 'required|numeric|gte:min_budget',
             ]);

             $preference = UserPreference::updateOrCreate(
                 ['session_id' => $request->session_id],
                 [
                     'min_budget' => $request->min_budget,
                     'max_budget' => $request->max_budget,
                 ]
             );

             return response()->json(['message' => 'Budget updated', 'preference' => $preference], 200);
         }

         public function addBookmark(Request $request)
         {
             $request->validate([
                 'session_id' => 'required|string',
                 'destination_id' => 'required|exists:destinations,id',
             ]);

             $bookmark = Bookmark::create([
                 'session_id' => $request->session_id,
                 'destination_id' => $request->destination_id,
             ]);

             return response()->json(['message' => 'Bookmark added', 'bookmark' => $bookmark], 201);
         }

         public function removeBookmark(Request $request)
         {
             $request->validate([
                 'session_id' => 'required|string',
                 'destination_id' => 'required|exists:destinations,id',
             ]);

             $bookmark = Bookmark::where('session_id', $request->session_id)
                 ->where('destination_id', $request->destination_id)
                 ->first();

             if ($bookmark) {
                 $bookmark->delete();
                 return response()->json(['message' => 'Bookmark removed'], 200);
             }

             return response()->json(['message' => 'Bookmark not found'], 404);
         }

         public function getPreferences(Request $request)
         {
             $request->validate([
                 'session_id' => 'required|string',
             ]);

             $preference = UserPreference::where('session_id', $request->session_id)->first();
             $bookmarks = Bookmark::where('session_id', $request->session_id)->with('destination')->get();

             return response()->json([
                 'budget' => $preference,
                 'bookmarks' => $bookmarks,
             ], 200);
         }
     }