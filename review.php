<?php

     namespace App\Models;

     use Illuminate\Database\Eloquent\Factories\HasFactory;
     use Illuminate\Database\Eloquent\Model;

     class Review extends Model
     {
         use HasFactory;

         protected $fillable = ['reviewable_id', 'reviewable_type', 'rating', 'comment'];

         public function reviewable()
         {
             return $this->morphTo();
         }
     }