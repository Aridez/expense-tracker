<?php

namespace App\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class OrderByFilter
{

    protected string $column;
    protected string $direction;


    /**
     * Constructor taking direction 'asc' as default following MySQL convention
     *
     * @param  string $column
     * @param  string $direction
     * @return void
     */
    public function __construct(string $column, string $direction = 'asc')
    {
        $this->column = $column;
        $this->direction = $direction;
    }

    /**
     * Order the query results
     *
     * @param  Builder $query
     * @param  Closure $next
     * @return Closure
     */
    public function handle(Builder $query, Closure $next)
    {
        $query->orderBy($this->column, $this->direction);

        return $next($query);
    }
}
