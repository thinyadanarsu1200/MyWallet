<x-app title="Transfer Page">
  <x-card>
    <div class="flex items-center">
      <a href="{{ route('profile') }}" class="mr-20">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4  cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
      </a>
      <p>Transfer Money</p>
    </div>
    <div class="flex justify-center items-center">
      <img src="{{ asset('images/transfer.png') }}" alt="" class="change-password transfer-image">
    </div>
    <div>
      <form action="{{ route('change-password-action', auth()->id()) }}" method="POST">
        @csrf
        <div class="grid grid-cols-6 gap-3 mb-2 relative">
          <div class="col-span-6 sm:col-span-3">
            <label for="phone" class="form-label">To:</label>
            <input type="password" name="phone" id="phone" autocomplete="given-password"
              class="form-control error @error('phone') error @enderror">
            @error('phone')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>

          {{-- <div class="loader absolute"></div> --}}
          <svg xmlns="http://www.w3.org/2000/svg" class="absolute error-icon text-red-500 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" id="error-icon">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
          </svg>


          <div class="col-span-6 sm:col-span-3 mb-2">
            <label for="amount" class="form-label">Amount</label>
            <input type="password" name="password" id="amount" autocomplete="amount"
              class="form-control @error('amount') error @enderror">
            @error('amount')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>

        </div>
        <div class="flex justify-end mt-3">
          <a href="{{ route('profile') }}" class="btn mr-4">Cancel</a>
          <button type="submit" class="btn-primary">Continue</button>
        </div>
      </form>
    </div>
  </x-card>

  <x-slot name="js">
    <script>
      const error = document.querySelector('.error');

      if (error) {
        document.querySelector('#error-icon').classList.add('error-icon');
      }
    </script>
  </x-slot>
</x-app>
