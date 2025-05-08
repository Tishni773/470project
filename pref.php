<?php

     namespace App\Models;

     use Illuminate\Database\Eloquent\Factories\HasFactory;
     use Illuminate\Database\Eloquent\Model;

     class UserPreference extends Model
     {
         use HasFactory;

         protected $fillable = ['session_id', 'min_budget', 'max_budget'];
     }