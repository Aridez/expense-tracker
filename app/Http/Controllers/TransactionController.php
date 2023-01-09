<?php

namespace App\Http\Controllers;

use App\Models\Periodicity;
use App\Models\Transaction;
use App\Models\UpcomingTransaction;
use App\Services\TransactionService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    protected $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

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
        $data['upcomingTransactions'] = auth()->user()->upcomingTransactions;

        return view('resources.transactions.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['periodicities'] = Periodicity::all();
        return view('resources.transactions.create', $data);
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
            'type' => ['required', 'in:earning,spending'],
            'periodicity_id' => ['required', 'exists:periodicities,id'],
            'repeat_until' => ['nullable', 'after:date', 'after:today']
        ]);

        $validated['amount'] *= $validated['type'] == 'earning' ? 1 : -1;

        $this->transactionService->addTransaction(Carbon::createFromDate($validated['date']), $validated['description'], $validated['amount'], Periodicity::find($validated['periodicity_id']) ?? null, $validated['repeat_until'] ?? null, auth()->user());

        return redirect()->back()->withSuccess('The action was completed successfully.');
    }
}
