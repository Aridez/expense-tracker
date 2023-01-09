<?php

namespace App\Console\Commands;

use App\Models\UpcomingTransaction;
use App\Services\TransactionService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ProcessUpcomingTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transactions:process {--date=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Processes the upcoming transactions of the application, transferring them to the transaction table once their date is due.';

    /**
     * The service used to manage transactions
     *
     * @var TransactionService
     */
    protected $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        parent::__construct();
        $this->transactionService = $transactionService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date = $this->option('date') ? Carbon::createFromDate($this->option('date')) : Carbon::now();
        $this->transactionService->processUpcomingTransactions($date);
    }
}
