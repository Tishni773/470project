<?php

     namespace App\Models;

     use Illuminate\Database\Eloquent\Factories\HasFactory;
     use Illuminate\Database\Eloquent\Model;

     class Activity extends Model
     {
         use HasFactory;

         protected $fillable = ['name', 'destination_id', 'price', 'average_rating'];

         public function destination()
         {
             return $this->belongsTo(Destination::class);
         }

         public function reviews()
         {
             return $this->morphMany(Review::class, 'reviewable');
         }
     }