<?php

namespace App\Services;

use App\Models\Periodicity;
use App\Models\Transaction;
use App\Models\UpcomingTransaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Collection;

class TransactionService
{

    /**
     * Explicit delaration of the DB laravel facade
     *
     * @var Connection
     */
    protected $DB;

    /**
     * Constructor
     *
     * @param  Connection $DB
     * @return void
     */
    public function __construct(Connection $DB)
    {
        $this->DB = $DB;
    }

    /**
     * If the transaction date is future, create an upcoming transaction
     * If the transaction date is past, create a new transaction and check for periodicity in order to create an upcoming transaction
     *
     * @param  Carbon $date
     * @param  string $description
     * @param  float $amount
     * @param  Periodicity|null $periodicity
     * @param  Carbon|null $repeat_until
     * @param  User $user
     * @return void
     */
    public function addTransaction(Carbon $date, string $description, float $amount, Periodicity|null $periodicity, Carbon|null $repeat_until, User $user)
    {
        $upcomingTransaction = null;
        $transaction = null;
        if ($date->gt(Carbon::now()->endOfDay())) {
            $upcomingTransaction = [
                'date' => $date,
                'original_date' => $date,
                'description' => $description,
                'amount' => $amount,
                'repeat_until' => $repeat_until,
                'periodicity_id' => $periodicity->id,
                'user_id' => $user->id
            ];
        } else {
            $transaction = [
                'description' => $description,
                'date' => $date,
                'amount' => $amount,
                'user_id' => $user->id
            ];

            $next_date = $periodicity->findNextDate(Carbon::now(), $date);

            if ($periodicity->id != Periodicity::NONE && $next_date->lte($repeat_until)) {
                $upcomingTransaction = [
                    'date' => $periodicity->findNextDate(Carbon::now(), $date),
                    'original_date' => $date,
                    'description' => $description,
                    'amount' => $amount,
                    'repeat_until' => $repeat_until,
                    'periodicity_id' => $periodicity->id,
                    'user_id' => $user->id
                ];
            }
        }

        $this->DB->transaction(function () use ($transaction, $upcomingTransaction) {
            if ($transaction) {
                Transaction::create($transaction);
            }
            if ($upcomingTransaction) {
                UpcomingTransaction::create($upcomingTransaction);
            }
        });
    }


    /**
     * Processes the upcoming transactions in the platform, transforming them into transactions once their due date is done and scheduling the next upcoming transactions if they are recurring
     *
     * @param  Carbon $date
     * @return void
     */
    public function processUpcomingTransactions(Carbon $date, int $limit = 10)
    {
        $upcomingTransactions = UpcomingTransaction::whereDate('date', '<=', $date)->limit($limit)->get();
        $this->DB->transaction(function () use ($upcomingTransactions) {
            foreach ($upcomingTransactions as $upcomingTransaction) {
                Transaction::create([
                    'date' => $upcomingTransaction->date,
                    'description' => $upcomingTransaction->description,
                    'amount' => $upcomingTransaction->amount,
                    'user_id' => $upcomingTransaction->user_id
                ]);
                $upcomingTransaction->reschedule();
            }
        });
    }
}
