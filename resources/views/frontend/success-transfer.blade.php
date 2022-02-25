<x-app title="Confirm Success">
  <x-card>
    <div class="flex flex-col justify-center items-center">
      <div class="flex flex-col justify-center items-center mb-5">
        <img src="{{ asset('images/success-transfer.png') }}" alt="" class="w-20 h-20 mb-3">
        <span class="text-green-500">Payment successful</span>
      </div>
      <div class="flex flex-col justify-center items-center mb-5">
        <span class="text-gray-500">{{ $receive_user }}</span>
        <span>{{ number_format($amount) }}</span>
      </div>
      <a href="/" class="btn-primary">Back To Home</a>
    </div>
  </x-card>
</x-app>
