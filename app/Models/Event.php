<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\Review;
use App\Models\Transaction;

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

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function soldTicketsCount(): int
    {
        return $this->transactions()
            ->whereIn('status', ['settlement', 'success'])
            ->count();
    }

    public function averageRating(): float
    {
        return round((float) $this->reviews()->avg('rating'), 1);
    }

    public function reviewsCount(): int
    {
        return $this->reviews()->count();
    }

    public function pendingReservationsCount(): int
    {
        $expirationTime = now()->subMinutes(Transaction::PENDING_EXPIRY_MINUTES);

        return $this->transactions()
            ->where('status', Transaction::STATUS_PENDING)
            ->where('created_at', '>', $expirationTime)
            ->count();
    }

    public function availableTicketsCount(): int
    {
        return max($this->stock - $this->soldTicketsCount() - $this->pendingReservationsCount(), 0);
    }

    public function isSoldOut(): bool
    {
        return $this->availableTicketsCount() <= 0;
    }

    public function getPosterUrlAttribute(): string
    {
        if ($this->poster_path) {
            if (file_exists(public_path($this->poster_path))) {
                return asset($this->poster_path);
            }

            if (Storage::disk('public')->exists($this->poster_path)) {
                return asset('storage/' . ltrim($this->poster_path, '/'));
            }
        }

        return 'https://placehold.co/200x200?text=No+Image';
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

