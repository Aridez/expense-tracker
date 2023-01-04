<?php

namespace App\Models;

use App\Filters\PaginationFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'description',
        'date',
        'amount',
        'user_id'
    ];

    /**
     * Return a filtered collection of transactions
     *
     * @param  Builder $query
     * @return Collection
     */
    public static function filter(Builder $query, Request $request):Collection {
        return app(Pipeline::class)
            ->send($query)
            ->through([
                new PaginationFilter($request->page, $request->limit)
                //new PaginationFilter($this->request->page, $this->request->limit),
            ])
            ->thenReturn()
            ->get();
    }
}
