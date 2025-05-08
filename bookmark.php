<?php

     namespace App\Models;

     use Illuminate\Database\Eloquent\Factories\HasFactory;
     use Illuminate\Database\Eloquent\Model;

     class Bookmark extends Model
     {
         use HasFactory;

         protected $fillable = ['session_id', 'destination_id'];

         public function destination()
         {
             return $this->belongsTo(Destination::class);
         }
     }