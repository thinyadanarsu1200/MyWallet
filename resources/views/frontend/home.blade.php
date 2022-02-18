<x-app title="Home">
  <x-card class="bg-theme relative flex flex-col justify-center overflow-hidden rounded-md" style="height: 120px;">
    <img src="{{ asset('images/money.png') }}" alt="" class="absolute money-image">
    <span class="text-lightblue text-xs">Total Balance</span>
    <h1 class="text-white text-2xl font-sans font-semibold">1000,000 <small class="text-xs">MMK</small></h1>
  </x-card>

  <div class="flex gap-3">
    <x-card class="mr-1 flex flex-1 flex-col justify-center items-center">
      <a href="{{ route('transfer') }}">
        <div class="icon-wrapper bg-lightgreen">
          <img src="{{ asset('images/paper-plane.png') }}" alt="" width="40px" height="40px" class="icon">
        </div>
        <p class="text-darkblue text-sm">Transfer</p>
      </a>
    </x-card>
    <x-card class="mr-1 flex flex-1 flex-col justify-center items-center">
      <div class="icon-wrapper bg-lightred">
        <img src="{{ asset('images/bag.png') }}" alt="" width="40px" height="40px" class="icon">
      </div>
      <p class="text-darkblue text-sm">Activities</p>
    </x-card>
    <x-card class="flex flex-1 flex-col justify-center items-center">
      <div class="icon-wrapper bg-lightsky">
        <img src="{{ asset('images/history.png') }}" alt="" width="40px" height="40px" class="icon">
      </div>
      <p class="text-darkblue text-sm">History</p>
    </x-card>
  </div>
  <div class="flex gap-3 mt-4">
    <x-card class="flex flex-1 h-full  items-center">
      <div class="w-6 h-6 overflow-hidden mb-2 mr-2">
        <img src="{{ asset('images/scan.png') }}" alt="">
      </div>
      <p class="text-sm text-gray-600 font-semibold">Scan & pay</p>
    </x-card>
    <x-card class="flex flex-1 h-full items-center">
      <div class="w-6 h-6 overflow-hidden mb-2 mr-2">
        <img src="{{ asset('images/qr-code.png') }}" alt="">
      </div>
      <p class="text-sm text-gray-600 font-semibold">Receive</p>
    </x-card>
  </div>

  <div>
    <x-card>
      <a href="" class="flex items-center justify-between gap-3">
        <div class="flex items-center">
          <img src="{{ asset('images/money-transaction.png') }}" alt="" class="w-6 h-6 mr-2">
          <p class="text-sm text-gray-600 font-semibold">Transition</p>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
        </svg>
      </a>
    </x-card>
  </div>
</x-app>
