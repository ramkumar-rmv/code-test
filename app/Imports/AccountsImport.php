<?php

namespace App\Imports;

use Throwable;
use App\Models\Account;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class AccountsImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    public $failedRows;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if (!$row['account_number'] || !$row['account_name']) {
                continue;
            }

            // Skip if duplicate
            if (Account::where('account_number', $row['account_number'])->exists()) {
                $this->failedRows[] = [
                    'row' => $row,
                    'message' => 'Duplicate account number'
                ];
                continue;
            }

            Account::create([
                'account_number'    => $row['account_number'],
                'tag1'              => $row['tag1'],
                'tag2'              => $row['tag2'],
                'tag3'              => $row['tag3'],
                'tag4'              => $row['tag4'],
                'account_name'      => $row['account_name'],
                'product_category'  => $row['product_category'],
                'product_type'      => $row['product_type'],
                'activation_date'   => Carbon::createFromFormat('Y-m-d', $row['activation_date'])->format('Y-m-d'),
                'status'            => $row['status'],
                'party_id'          => $row['party_id'],
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'account_number' => 'required',
            'account_name'   => 'required|string',
        ];
    }

    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            $this->failedRows[] = [
                'row' => $failure->values(),
                'message' => implode(', ', $failure->errors())
            ];
        }
    }
}
