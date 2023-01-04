<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->merge([
            'page' => request()->page ?? 1,
            'limit' => request()->limit ?? 10,
        ]);

        $request->validate([
            'page' => ['required', 'integer', 'min:1'],
            'limit' => ['required', 'integer', 'min:1', 'max:20'],
        ]);

        $data['page'] = $request->page;
        $data['limit'] = $request->limit;
        $data['transactions'] = Transaction::filter(auth()->user()->transactions()->getQuery(), $request);

        return view('resources.transactions.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('resources.transactions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => ['required', 'string', 'max:128'],
            'date' => ['required', 'date'],
            'amount' => ['required', 'numeric', 'decimal:0,2', 'min:0'],
            'type' => ['required', 'in:earning,spending']
        ]);

        $validated['amount'] *= $validated['type'] == 'earning' ? 1 : -1;

        Transaction::create(array_merge($validated, ['user_id' => auth()->user()->id]));

        return redirect()->back()->withSuccess('The action was completed successfully.');
    }

}
