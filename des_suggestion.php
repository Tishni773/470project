<?php

     namespace App\Models;

     use Illuminate\Database\Eloquent\Factories\HasFactory;
     use Illuminate\Database\Eloquent\Model;

     class Destination extends Model
     {
         use HasFactory;

         protected $fillable = ['name', 'location', 'average_rating'];

         public function activities()
         {
             return $this->hasMany(Activity::class);
         }

         public function reviews()
         {
             return $this->morphMany(Review::class, 'reviewable');
         }

         public function bookmarks()
         {
             return $this->hasMany(Bookmark::class);
         }
     }