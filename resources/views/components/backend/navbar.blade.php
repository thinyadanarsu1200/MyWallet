<!-- Navbar Start -->
<nav class="bg-white shadow-sm">
  <div class="relative mx-auto flex items-center justify-between h-16 px-3 md:px-4" style="max-width: 1500px;">
    <!-- Mobile Menu Icon -->
    <div class="mobile-menu cursor-pointer text-gray-600">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
      </svg>
    </div>
    <!-- Search -->
    <x-search class="md:flex" />
    <div class="flex items-center">
      <button type="button" class="p-1 rounded-full text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-indigo-500 focus:ring-white">
        <!-- Heroicon name: outline/bell -->
        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
      </button>

      <!-- Profile dropdown -->
      <x-dropdown2 class="ml-0 md:ml-3">
        <x-slot name="trigger">
          <button type="button"
            class="flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500">
            @if (!auth()->guard('admin')->user()->image)
              <img class="min-w-max rounded-full"
                src="https://ui-avatars.com/api/?format=svg&rounded=true&size=35&name={{ auth()->guard('admin')->user()->name }}" alt="">
            @else
              <img src="{{ auth()->guard('admin')->user()->profileImage() }}"
                data-image_path="{{ auth()->guard('admin')->user()->image }}"
                class="w-full h-full object-cover" />
            @endif
          </button>
        </x-slot>

        <x-dropdown2-link href="#">Your Profile</x-dropdown2-link>
        <x-dropdown2-link href="#">Setting</x-dropdown2-link>
        <x-dropdown2-link href="/logout" class="sign-out-btn">Sign Out</x-dropdown2-link>
      </x-dropdown2>
    </div>
  </div>
</nav><!-- Navbar End -->
