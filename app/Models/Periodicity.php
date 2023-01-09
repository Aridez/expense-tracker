<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periodicity extends Model
{
    use HasFactory;

    const NONE = 1;
    const DAILY = 2;
    const WEEKLY = 3;
    const MONTHLY = 4;
    const YEARLY = 5;


    /**
     * Indicate that this model does not have created_at and updated_at fields
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Finds the next date fitting a certain periodicity based on a $original date with the sarting point set at the $from date
     *
     * @param  mixed $from      Starting point to look for the next fitting date
     * @param  mixed $original  The original date when the periodicity started
     * @return Carbon
     */
    public function findNextDate(Carbon $from, Carbon $original): ?Carbon
    {
        switch ($this->id) {
            case Periodicity::NONE:
                return null;
            case Periodicity::DAILY:
                return $from->addDay();
            case Periodicity::WEEKLY:
                return $from->next($original->format('l'));
            case Periodicity::MONTHLY:
                // Get the same day number on the current month without overflowing
                $day_in_month = $from->copy()->setUnitNoOverflow('day', $original->format('d'), 'month');
                // Check if we can find a future date on the current month, otherwise use the next month
                return $day_in_month->format('d') > $from->format('d') ? $day_in_month : $day_in_month->addMonthNoOverflow();
            case Periodicity::YEARLY:
                // Get the same month as $date and then set the day without overflow to obtain the equivalent in year
                $day_in_year = $from->copy()->setMonth($original->format('m'))->setUnitNoOverflow('day', $original->format('d'), 'month');
                // Check if the day already passed in the current year, create it if it didn't
                return $day_in_year->gt($from) ? $day_in_year : $day_in_year->addYearNoOverflow();
        }
    }
}
