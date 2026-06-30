<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['member_id', 'book_id', 'allocated_copy_id', 'request_date', 'expiry_date', 'status'])]
class Reservation extends Model
{
    /** @use HasFactory<\Database\Factories\ReservationFactory> */
    use HasFactory;

    protected $casts = [
        'request_date' => 'datetime',
        'expiry_date' => 'datetime',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function allocatedCopy(): BelongsTo
    {
        return $this->belongsTo(BookCopy::class, 'allocated_copy_id');
    }
}
