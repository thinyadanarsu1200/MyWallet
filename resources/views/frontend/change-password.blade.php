<x-app title="Change Password">
  <x-card>
    <div class="flex items-center">
      <a href="{{ route('profile') }}" class="mr-20">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4  cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
      </a>
      <p>Update Password</p>
    </div>
    <div class="flex justify-center items-center">
      <img src="{{ asset('images/change-password.png') }}" alt="" class="change-password password-image">
    </div>
    <div>
      <form action="{{ route('change-password-action', auth()->id()) }}" method="POST">
        @csrf
        <div class="grid grid-cols-6 gap-3 mb-2">
          <div class="col-span-6 sm:col-span-3">
            <label for="current_password" class="form-label">Current password</label>
            <input type="password" name="current_password" id="current_password" autocomplete="given-password"
              class="form-control @error('current_password') error @enderror">
            @error('current_password')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="col-span-6 sm:col-span-3 mb-2">
            <label for="new_password" class="form-label">New Password</label>
            <input type="password" name="password" id="new_password" autocomplete="new_password"
              class="form-control @error('password') error @enderror">
            @error('password')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="col-span-6 sm:col-span-6 mb-2">
            <label for="password_confirmation" class="form-label">Confirm New Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="password_confirmation"
              class="form-control @error('password_confirmation') error @enderror">
            @error('password_confirmation')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>

        </div>
        <div class="flex justify-end mt-3">
          <button type="submit" class="btn-primary">Save Changes</button>
        </div>
      </form>
    </div>
  </x-card>
</x-app>
