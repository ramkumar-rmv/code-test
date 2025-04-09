<div class="max-w-md mx-auto p-4 bg-white shadow rounded-2xl space-y-4">
    @if (session()->has('success'))
        <div class="text-green-600 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="submit" enctype="multipart/form-data" class="space-y-4">
        <div>
            <label class="block text-sm font-medium">Summary</label>
            <input type="text" wire:model="summary" class="w-full border rounded px-3 py-2">
            @error('summary') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium">Amount</label>
            <input type="number" wire:model="amount" step="0.01" class="w-full border rounded px-3 py-2">
            @error('amount') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium">File Attachment (optional)</label>
            <input type="file" wire:model="file_attachment" class="w-full">
            @error('file_attachment') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Submit
            </button>
        </div>
    </form>
</div>
