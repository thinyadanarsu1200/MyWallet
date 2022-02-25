<x-app title="Transaction">
  <x-card>
    <x-dropdown2>
      <x-slot name="trigger">
        <button type="button"
          class="flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500"
          aria-expanded="false" aria-haspopup="true">
          <div class="flex justify-between items-center">
            All
            <i class="fas fa-chevron-down"></i>
          </div>
        </button>
      </x-slot>

      <x-dropdown2-link href="#">Income</x-dropdown2-link>
      <x-dropdown2-link href="#">Expense</x-dropdown2-link>
    </x-dropdown2>
  </x-card>
  @foreach ($transactions as $transaction)
    <a href="{{ route('transaction.detail', $transaction->trx_id) }}">
      <x-card>
        <div class="flex justify-between items-center">
          <div class="">
            <h2>Trx id: <span class="text-theme">{{ $transaction->trx_id }}</span></h2>
            <span class="text-gray-400">
              @if ($transaction->type == 1)
                Receive from
              @elseif ($transaction->type == 2)
                Send to
              @endif
              <span class="font-semibold">{{ $transaction->source->name }}</span>
            </span>
            <p class="text-sm mt-1">{{ $transaction->created_at }}</p>
          </div>
          <div>
            @if ($transaction->type == 1)
              <p class="text-md text-red-500"> - {{ $transaction->amount }} <small>MMK</small></p>
            @elseif($transaction->type == 2)
              <p class="text-md text-green-500"> + {{ $transaction->amount }} <small>MMK</small></p>
            @endif
          </div>
        </div>
      </x-card>
    </a>
  @endforeach
</x-app>
