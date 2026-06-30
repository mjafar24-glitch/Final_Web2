<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['borrowing_id', 'amount', 'late_days', 'payment_status'])]
class Fine extends Model
{
    /** @use HasFactory<\Database\Factories\FineFactory> */
    use HasFactory;

    public function borrowing(): BelongsTo
    {
        return $this->belongsTo(Borrowing::class);
    }
}
