<!-- table -->
<div
  class="my-4 overflow-hidden overflow-x-auto scrollbar-thin scrollbar-thumb-slate-300 scrollbar-track-gray-100 scrollbar-thumb-rounded-full scrollbar-track-rounded-full shadow rounded-lg">
  <input type="hidden" id="old-field" value="{{ $field }}">
  <input type="hidden" id="direction" value="{{ $direction }}">
  <table class="w-full divide-y divide-gray-200">
    <thead class="bg-gray-100">
      <tr>
        <th scope="col" data-field="name" class="cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
          <div class="flex">
            @php
              $remove_icon = array_intersect($admins->pluck('id')->toArray(), $admins_id) && array_diff($admins->pluck('id')->toArray(), $admins_id) ? 'remove-check' : '';
              $check_icon = array_intersect($admins->pluck('id')->toArray(), $admins_id) && !count(array_diff($admins->pluck('id')->toArray(), $admins_id)) ? 'checked' : '';
            @endphp
            <input type="checkbox" id="global-check" {{ $check_icon }}
              class="{{ $remove_icon }} mr-3 rounded-sm global-check bg-gray-100" />
            <span data-field="name" class="cursor-pointer flex-1 pl-3">Name</span>
            <div data-field="name" class="flex cursor-pointer">
              <svg xmlns="http://www.w3.org/2000/svg" class="pointer-events-none h-3 w-3 -mr-1 text-sm {{ $field === 'name' && $direction === 'asc' ? 'text-gray-700' : 'text-gray-300' }}"
                viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd" d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z"
                  clip-rule="evenodd" />
              </svg>
              <svg xmlns="http://www.w3.org/2000/svg" class="pointer-events-none h-3 w-3 {{ $field === 'name' && $direction === 'desc' ? 'text-gray-700' : 'text-gray-300' }}" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd" d="M14.707 12.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 14.586V3a1 1 0 012 0v11.586l2.293-2.293a1 1 0 011.414 0z"
                  clip-rule="evenodd" />
              </svg>
            </div>
          </div>
          {{-- <div class="flex">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 {{ $field == 'name' && $direction == 'asc' ? 'text-gray-500' : 'text-gray-200' }}" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 {{ $field == 'name' && $direction == 'desc' ? 'text-gray-500' : 'text-gray-200' }}" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
            </svg>
          </div> --}}
        </th>
        <th scope="col" data-field="phone" class="flex justify-between cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
          <span data-field="phone" class="flex-1 cursor-pointer">Phone</span>
          <div data-field="phone" class="flex items-center cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" class="pointer-events-none h-3 w-3 -mr-1 text-sm {{ $field === 'phone' && $direction === 'asc' ? 'text-gray-700' : 'text-gray-300' }}"
              viewBox="0 0 20 20"
              fill="currentColor">
              <path fill-rule="evenodd" d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z"
                clip-rule="evenodd" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" class="pointer-events-none h-3 w-3 {{ $field === 'phone' && $direction === 'desc' ? 'text-gray-700' : 'text-gray-300' }}" viewBox="0 0 20 20"
              fill="currentColor">
              <path fill-rule="evenodd" d="M14.707 12.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 14.586V3a1 1 0 012 0v11.586l2.293-2.293a1 1 0 011.414 0z"
                clip-rule="evenodd" />
            </svg>
          </div>
        </th>
        <th scope="col" data-field="status" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
          IP
        </th>
        <th scope="col" data-field="role" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
          User Agent
        </th>
        <th scope="col" class="relative px-6 py-3">
          <span class="sr-only">Edit</span>
        </th>
      </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
      @foreach ($admins as $admin)
        <tr class="bg-white even:bg-gray-100">
          <td class="px-6 py-4 whitespace-nowrap">
            <div class="flex items-center">
              <div class="flex items-center">
                <input data-id="{{ $admin->id }}" {{ in_array($admin->id, $admins_id) ? 'checked' : '' }} type="checkbox" class="local-check rounded-sm bg-gray-100 mr-4">
              </div>
              @php
                if ($loop->last || $loop->count - 1 == $loop->iteration) {
                    $position = '-top-32';
                }
              @endphp
              <x-dropdown2 class="ml-0 lg:hidden" direction="left" position="{{ $position ?? '' }}">
                <x-slot name="trigger">
                  <button id="action-btn" type="button"
                    class="hover:text-gray-500 focus:outline-none mr-3 text-gray-400 flex items-center justify-center cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 pointer-events-none" viewBox="0 0 20 20" fill="currentColor">
                      <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                    </svg>
                  </button>
                </x-slot>
                <x-dropdown2-link href="{{ route('admin.admin-user.edit', $admin->id) }}">Edit</x-dropdown2-link>
                <x-dropdown2-link href="#">View</x-dropdown2-link>
                <x-dropdown2-link href="#" class="delete-one-dropdown" data-id="{{ $admin->id }}" data-name="{{ $admin->name }}">Delete</x-dropdown2-link>
              </x-dropdown2>
              <div class="h-10 w-10 overflow-hidden rounded-full">
                @if (!$admin->image)
                  <img class="min-w-max rounded-full"
                    src="https://ui-avatars.com/api/?format=svg&rounded=true&size=35&name={{ $admin->name }}" alt="">
                @else
                  <img src="{{ $admin->profileImage() }}"
                    data-image_path="{{ $admin->image }}"
                    class="w-full h-full object-cover" />
                @endif
              </div>
              <div class="ml-4">
                <div class="text-sm font-medium text-gray-900">
                  {{ $admin->name }}
                </div>
                <div class="text-sm text-gray-500">
                  {{ $admin->email }}
                </div>
              </div>
            </div>
          </td>
          <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm text-gray-900">{{ $admin->phone }}</div>
          </td>
          @if ($admin->ip)
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm text-gray-900">{{ $admin->ip }}</div>
            </td>
          @else
            <td class="px-6 py-4 whitespace-nowrap">
              <span class="text-center text-xs text-gray-400 tracking-wide">No ip yet!</span>
            </td>
          @endif
          <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm text-gray-900">
              @php
                $agent->setUserAgent($admin->user_agent);
                $device = $agent->device();
                $platform = $agent->platform();
                $browser = $agent->browser();
              @endphp
              @if ($admin->user_agent)
                <div class="border border-gray-200 shadow rounded-md overflow-hidden overflow-x-auto">
                  <table class="w-full  divide-y divide-gray-200">
                    <thead class="bg-gray-100 border-b border-gray-200">
                      <tr>
                        <th class="cursor-pointer whitespace-nowrap px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Device</th>
                        <th class="cursor-pointer whitespace-nowrap px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Platform</th>
                        <th class="cursor-pointer whitespace-nowrap px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Browser</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr class="bg-white even:bg-gray-100">
                        <td class="px-3 py-2 whitespace-nowrap">{{ $device }}</td>
                        <td class="px-3 py-2 whitespace-nowrap">{{ $platform }}</td>
                        <td class="px-3 py-2 whitespace-nowrap">{{ $browser }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              @else
                <span class="text-center text-xs text-gray-400 tracking-wide">No user agent yet!</span>
              @endif
            </div>
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
            <div class="flex items-center justify-end flex-nowrap gap-x-1">
              <a href="{{ route('admin.admin-user.edit', $admin->id) }}" class="text-indigo-600 hover:text-indigo-900 flex items-center mr-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
              </a>
              <a href="#" class="text-yellow-600 hover:text-yellow-900 flex items-center mr-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
              </a>
              <button class="text-red-600 hover:text-red-900 flex items-center mr-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="delete-one h-4 w-4" data-id="{{ $admin->id }}" data-name="{{ $admin->name }}" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
              </button>
            </div>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

{{-- Pagination (footer) --}}
<div>
  {{ $admins->links('vendor.pagination.custom-pagination') }}
</div>
