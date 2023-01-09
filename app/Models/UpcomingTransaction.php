<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UpcomingTransaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date',
        'original_date',
        'description',
        'amount',
        'repeat_until',
        'periodicity_id',
        'user_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'date',
        'original_date' => 'date'
    ];

    /**
     * An upcoming transaction may have a periodicity
     *
     * @return BelongsTo|Periodicity
     */
    public function periodicity(): BelongsTo|Periodicity
    {
        return $this->belongsTo(Periodicity::class);
    }

    /**
     * Reschedules the current transactions based on its periodicity.
     * If the new transaction date is over the repeat_until this transaction gets deleted instead.
     *
     * @return void
     */
    public function reschedule()
    {
        $new_date = $this->periodicity?->findNextDate($this->date, $this->original_date);
        if ($this->periodicity->id == Periodicity::NONE || ($this->repeat_until && $new_date?->gt($this->repeat_until))) {
            $this->delete();
        } else {
            $this->date = $new_date;
            $this->save();
        }
    }
}
