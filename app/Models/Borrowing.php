<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Borrowing extends Model
{
    protected $fillable = [
        'member_id',
        'borrow_date',
        'due_date',
        'return_date',
        'status',
    ];

    protected $casts = [
        'borrow_date' => 'date',
        'due_date' => 'date',
        'return_date' => 'date',
    ];

    // Relasi ke anggota
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    // Relasi ke detail peminjaman
    public function details(): HasMany
    {
        return $this->hasMany(BorrowingDetail::class);
    }
}
