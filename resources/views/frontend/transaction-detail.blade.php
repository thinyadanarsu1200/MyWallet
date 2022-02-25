<x-app title="Transaction Detail">
  <x-card>
    <h1>Transaction Detail</h1>
    <x-card>
      <div class="flex flex-col items-center justify-center">
        <img src="{{ asset('images/money-transaction.png') }}" alt="" class="w-40 h-40 mb-3">
        @if ($transaction->type == 1)
          <span class="text-green-500"> +{{ $transaction->amount }} <small>MMK</small></span>
        @elseif($transaction->type == 2)
          <span class="text-red-500"> -{{ $transaction->amount }} <small>MMK</small></span>
        @endif
      </div>
    </x-card>
  </x-card>
</x-app>
