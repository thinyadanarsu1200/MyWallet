<nav class="bg-white shadow-sm">
  <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
    <div class="relative flex items-center justify-between h-16">
      <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
        <!-- Mobile menu button-->
        <!--
          Icon when menu is closed.
          Heroicon name: outline/menu
          Menu open: "hidden", Menu closed: "block"
        -->
        <!--
          Icon when menu is open.
          Heroicon name: outline/x
          Menu open: "block", Menu closed: "hidden"
        -->
        <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </div>
      <div class="flex-1 flex items-start justify-center sm:items-stretch sm:justify-start">
        <div class="flex items-center text-xl font-bold text-gray-500">
          <a href="/">Magic Pay</a>
        </div>
        <div class="hidden sm:block sm:ml-6">
          <div class="flex space-x-4 h-16">
            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
            <x-frontend.nav-link href="/" active="{{ request()->is('/') }}">Home</x-frontend.nav-link>

            <x-frontend.nav-link href="#">Wallet</x-frontend.nav-link>

            <x-frontend.nav-link href="#">Transaction</x-frontend.nav-link>

            <x-frontend.nav-link href="#">Profile</x-frontend.nav-link>
          </div>
        </div>
      </div>
      <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
        <button type="button" class="p-1 rounded-full text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-indigo-500 focus:ring-white">
          <!-- Heroicon name: outline/bell -->
          <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
          </svg>
        </button>

        <!-- Profile dropdown -->
        <x-dropdown2>
          <x-slot name="trigger">
            <button type="button"
              class="flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500"
              id="user-menu-button"
              aria-expanded="false" aria-haspopup="true">
              <span class="sr-only">Open user menu</span>
              <img class="h-8 w-8 rounded-full"
                src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
            </button>
          </x-slot>
          <x-dropdown2-link href="#">Your Profile</x-dropdown2-link>
          <x-dropdown2-link href="#">Setting</x-dropdown2-link>
          <x-dropdown2-link href="/logout" class="sign-out-btn">Sign Out</x-dropdown2-link>
        </x-dropdown2>
      </div>
    </div>
  </div>
</nav>
