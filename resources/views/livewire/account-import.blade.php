<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Import Accounts (Excel/CSV)</h2>

    @if (!empty($successMessage))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ $successMessage }}
        </div>
    @endif

    @if (!empty($errorMessage))
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            {{ $errorMessage }}
        </div>
    @endif

    @if (!empty($failedRows))
        <div class="mt-4">
            <h3 class="text-sm font-bold text-red-600 mb-2">Rows with Issues:</h3>
            <ul class="space-y-2 text-sm">
                @foreach ($failedRows as $fail)
                    <li class="bg-red-50 border border-red-200 p-2 rounded">
                        <strong>Row:</strong> {{ json_encode($fail['row']) }}<br>
                        <strong>Error:</strong> {{ $fail['message'] }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif


    <form wire:submit.prevent="import">
        <div class="mb-4">
            <input type="file" wire:model="file" class="w-full p-2 border rounded" required>
            @error('file') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 disabled:opacity-50"
            wire:loading.attr="disabled">
            Upload
        </button>
    </form>
</div>
