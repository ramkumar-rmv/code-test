<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Imports\AccountsImport;
use Maatwebsite\Excel\Facades\Excel;

class AccountImport extends Component
{
    use WithFileUploads;

    public $file;
    public $successMessage;
    public $errorMessage;
    public $failedRows = [];

    protected $rules = [
        'file' => 'required|file|mimes:xlsx,csv,xls',
    ];

    public function mount()
    {
        $this->successMessage = null;
        $this->errorMessage = null;
        $this->failedRows = [];
    }

    public function import()
    {
        $this->validate();

        $import = new AccountsImport();

        try {
            Excel::import($import, $this->file->getRealPath());

            $this->failedRows = $import->failedRows;

            $this->reset('file');
            $this->successMessage = "Accounts imported successfully.";
            $this->errorMessage = null;
        } catch (\Exception $e) {
            $this->errorMessage = "Error importing file: " . $e->getMessage();
            $this->successMessage = null;
        }
    }

    public function render()
    {
        return view('livewire.account-import');
    }
}
