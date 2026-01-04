<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'location',
        'price',
        'image',
        'status',
        'user_id',
        'category_id'
    ];
    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function registrations()
    {
        return $this->hasMany(Pendaftaran::class);
    }
}
