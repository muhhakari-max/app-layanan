<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NumberSequence extends Model
{
    use HasFactory;

    protected $fillable = [
        'prefix',
        'period',
        'last_number',
    ];

    protected function casts(): array
    {
        return [
            'last_number' => 'integer',
        ];
    }

    /**
     * Generate the next formatted ticket/reference number with row locking.
     * Must be called within a database transaction.
     */
    public static function generateNextNumber(string $prefix, ?string $period = null, int $digits = 5): string
    {
        $period = $period ?? now()->format('Ym');

        $sequence = static::lockForUpdate()->firstOrCreate(
            ['prefix' => $prefix, 'period' => $period],
            ['last_number' => 0]
        );

        $sequence->increment('last_number');

        return sprintf('%s-%s-%0'.$digits.'d', $prefix, $period, $sequence->last_number);
    }
}
