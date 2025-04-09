<?php

namespace App\Livewire\Transaction;

use Livewire\Component;
use App\Models\Transaction;
use App\Models\User;
use Livewire\WithFileUploads;
use App\Notifications\NewTransactionNotification;

class Create extends Component
{
    use WithFileUploads;

    public $summary;
    public $amount;
    public $file_attachment;

    protected $rules = [
        'summary' => 'required|string|max:255',
        'amount' => 'required|numeric|min:0',
        'file_attachment' => 'nullable|file|max:2048', // max 2MB
    ];

    public function mount()
    {
        if (!auth()->user()->can('create', \App\Models\Transaction::class)) {
            abort(403);
        }
    }

    public function submit()
    {
        $this->validate();

        $filePath = $this->file_attachment
            ? $this->file_attachment->store('attachments', 'public')
            : null;

        $transaction = Transaction::create([
            'summary' => $this->summary,
            'amount' => $this->amount,
            'file_attachment' => $filePath,
            'status' => 'pending',
            'user_id' => auth()->user()->id,
        ]);

        $approvers = User::whereHas('roles', fn($q) => $q->where('name', 'Approver'))->get();
        foreach ($approvers as $approver) {
            $approver->notify(new NewTransactionNotification($transaction));
        }

        session()->flash('success', 'Transaction submitted successfully!');
        $this->reset(['summary', 'amount', 'file_attachment']);
        return redirect()->route('transactions.index');
    }

    public function render()
    {
        return view('livewire.transaction.create');
    }
}
