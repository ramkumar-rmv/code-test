<?php

namespace App\Livewire\Transaction;

use Livewire\Component;
use App\Models\Transaction;
use App\Notifications\TransactionStatusUpdated;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    public $isApprover;

    protected $paginationTheme = 'tailwind';

    public function mount()
    {
        $this->isApprover = Auth::user()->hasRole('approver');
    }

    public function approve($id)
    {
        if (!$this->isApprover) {
            return;
        }

        $transaction = Transaction::findOrFail($id);
        $transaction->status = 'approved';
        $transaction->save();

        $transaction->user->notify(new TransactionStatusUpdated($transaction));
    }

    public function reject($id)
    {
        if (!$this->isApprover) {
            return;
        }

        $transaction = Transaction::findOrFail($id);
        $transaction->status = 'rejected';
        $transaction->save();

        $transaction->user->notify(new TransactionStatusUpdated($transaction));
    }


    public function render()
    {
        $query = Transaction::query();

        if (!$this->isApprover) {
            $query->where('user_id', Auth::id());
        }

        $transactions = $query->latest()->paginate(10);

        return view('livewire.transaction.index', [
            'transactions' => $transactions
        ]);
    }
}
