<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['floor', 'aisle', 'shelf_number'])]
class Location extends Model
{
    public function bookCopies(): HasMany
    {
        return $this->hasMany(BookCopy::class);
    }

    public function getFullPathAttribute(): string
    {
        return "Lantai {$this->floor}, Lorong {$this->aisle}, Rak {$this->shelf_number}";
    }
}
