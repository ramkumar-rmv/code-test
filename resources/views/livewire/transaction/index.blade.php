<div class="max-w-xl mx-auto p-4 bg-white shadow rounded-2xl space-y-4">


    @if (!$isApprover)
    <div class="flex justify-end">
    <a href="{{ route('transactions.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Create Transaction</a>
    </div>
    @endif
    @if (session()->has('success'))
        <div class="text-green-600 text-sm">
            {{ session('success') }}
        </div>
    @endif
    <table class="min-w-full bg-white rounded shadow">
        <thead class="bg-gray-100 text-left text-sm font-medium text-gray-700">
            <tr>
                <th class="px-4 py-2">#</th>
                <th class="px-4 py-2">Summary</th>
                <th class="px-4 py-2">Amount</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Attachment</th>
                <th class="px-4 py-2">Date</th>
                @if ($isApprover)
                    <th class="px-4 py-2">Actions</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $index => $transaction)
                <tr class="border-t text-sm">
                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2">{{ $transaction->summary }}</td>
                    <td class="px-4 py-2">${{ number_format($transaction->amount, 2) }}</td>
                    <td class="px-4 py-2">
                        <span @class([
                            'px-2 py-1 rounded-full text-xs',
                            'bg-yellow-200 text-yellow-800' => $transaction->status === 'pending',
                            'bg-green-200 text-green-800' => $transaction->status === 'approved',
                            'bg-red-200 text-red-800' => $transaction->status === 'rejected',
                        ])>
                            {{ ucfirst($transaction->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-2 text-xs">
                        @if ($transaction->file_attachment)
                            <a href="{{ asset('storage/' . $transaction->file_attachment) }}" target="_blank" class="text-blue-600 underline">
                                View
                            </a>
                        @else
                            <span class="text-gray-500">None</span>
                        @endif
                    </td>
                    <td class="px-4 py-2 text-xs text-gray-600">
                        {{ $transaction->created_at->format('M d, Y') }}
                    </td>
                    @if ($isApprover)
                        <td class="px-4 py-2 space-x-1">
                            @if ($transaction->status === 'pending')
                                <button wire:click="approve({{ $transaction->id }})"
                                    class="bg-green-500 hover:bg-green-600 text-white text-xs px-3 py-1 rounded">
                                    Approve
                                </button>
                                <button wire:click="reject({{ $transaction->id }})"
                                    class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1 rounded">
                                    Reject
                                </button>
                            @else
                                <span class="text-gray-500 text-xs">N/A</span>
                            @endif
                        </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-4 py-6 text-center text-gray-500 text-sm">
                        No transactions found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div>
        {{ $transactions->links() }}
    </div>
</div>
