<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Listing extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'title',
        'user_id',
        'tags',
        'company',
        'location',
        'email',
        'website',
        'logo',
        'description'
    ];


    public function scopeFilter($query, array $filters) {
        if($filters['tag'] ?? false) {
            $query->where('tags', 'like', '%'.request('tag').'%');
        }

        if($filters['search'] ?? false) {
            $query->where('title', 'like', '%'.request('search').'%')
            ->orWhere('description', 'like', '%'.request('search').'%')
            ->orWhere('tags', 'like', '%'.request('search').'%')
            ;
        }
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

}
