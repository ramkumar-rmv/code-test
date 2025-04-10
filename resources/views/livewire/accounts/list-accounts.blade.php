<div class="p-4">

    <table class="min-w-full table-auto border border-gray-300 text-sm">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-2 py-1">Account Number</th>
                <th class="border px-2 py-1">Account Name</th>
                <th class="border px-2 py-1">Tags</th>
                <th class="border px-2 py-1">Status</th>
                <th class="border px-2 py-1">Created At</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($accounts as $account)
                <tr>
                    <td class="border px-2 py-1">{{ $account->account_number }}</td>
                    <td class="border px-2 py-1">{{ $account->account_name }}</td>
                    <td class="border px-2 py-1">
                        {{ implode(', ', array_filter([$account->tag1, $account->tag2, $account->tag3, $account->tag4])) }}
                    </td>
                    <td class="border px-2 py-1">{{ ucfirst($account->status) }}</td>
                    <td class="border px-2 py-1">{{ $account->created_at->format('Y-m-d') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-2 text-gray-500">No accounts found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $accounts->links() }}
    </div>
</div>
