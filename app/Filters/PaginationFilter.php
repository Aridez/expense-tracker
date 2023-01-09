<?php

namespace App\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PaginationFilter
{

    protected int $page;
    protected int $limit;


    /**
     * Constructor
     *
     * @param  int $page
     * @param  int $limit
     * @return void
     */
    public function __construct(int $page, int $limit)
    {
        $this->page = $page;
        $this->limit = $limit;
    }

    /**
     * Add pagination to the query
     *
     * @param  Builder $query
     * @param  Closure $next
     * @return Closure
     */
    public function handle(Builder $query, Closure $next)
    {
        $offset = ($this->page - 1) * $this->limit;

        $query->skip($offset)->take($this->limit + 1);

        return $next($query);
    }
}
