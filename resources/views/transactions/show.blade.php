<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Transaction Details</h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-md mx-auto p-4 bg-white shadow rounded-2xl space-y-4">
            <p><strong>Summary:</strong> {{ $transaction->summary }}</p>
            <p><strong>Amount:</strong> ${{ number_format($transaction->amount, 2) }}</p>
            <p><strong>Status:</strong> {{ ucfirst($transaction->status) }}</p>

            @if ($transaction->file_attachment)
                <p class="mt-2">
                    <strong>Attachment:</strong>
                    <a href="{{ asset('storage/' . $transaction->file_attachment) }}" target="_blank" class="text-blue-600 underline">
                        View File
                    </a>
                </p>
            @endif

            <a href="{{ route('dashboard') }}" class="inline-block mt-4 text-blue-500 hover:underline">← Back to Dashboard</a>
        </div>
    </div>
</x-app-layout>
