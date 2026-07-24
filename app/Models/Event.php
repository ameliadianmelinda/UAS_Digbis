<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    protected $fillable = [
        'category_id', 'partner_id', 'title', 'description', 'date',
        'location', 'price', 'stock', 'poster_path', 'status'
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    // Menandakan atribut: 1 Event harus terpaut pada satu wujud Kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    protected static function booted()
    {
        static::deleting(function ($event) {
            if ($event->poster_path) {
                try {
                    Storage::disk('public')->delete($event->poster_path);
                } catch (\Exception $e) {
                }
            }
        });
    }
}

