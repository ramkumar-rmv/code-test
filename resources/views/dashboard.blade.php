<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p>Welcome, {{ auth()->user()->name }}!</p>
                    <h2 class="text-lg font-semibold mb-2">Notifications:</h2>
                    @foreach (auth()->user()->unreadNotifications as $note)
                        <div class="p-2 bg-green-50 border rounded mb-2">
                            <p class="text-sm">
                                Your transaction <strong>{{ $note->data['summary'] }}</strong> was
                                <span class="font-semibold text-{{ $note->data['status'] === 'approved' ? 'green' : 'red' }}-600">
                                    {{ ucfirst($note->data['status']) }}
                                </span>.
                            </p>
                            <a href="{{ route('transactions.show', ['transaction' => $note->data['id'], 'notification' => $note->id]) }}"
                                class="text-blue-600 text-xs underline">View Transaction</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
