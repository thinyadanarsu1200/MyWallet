@props(['user'])

<div class="profile-page relative">
  <input type="file" name="cover_image" id="choose-cover-image" hidden>
  <div class="cover-img w-full h-60 bg-red-300 rounded-md relative overflow-hidden cursor-pointer" id="preview-cover-image">
    @if ($user->cover_image)
      <img src="{{ $user->coverImage() }}" alt="" class="absolute w-full h-full object-cover" id="preview-cover-image" data-image_path="{{ $user->cover_image }}">
    @else
      <img src="{{ asset('images/default-cover-photo.jpg') }}" alt="" class="absolute w-full h-full object-cover">
    @endif
  </div>

  @if (request()->is('profile/edit'))
    <input type="text" hidden id="remove-cover-file-image" name="remove-cover">
    <div class="cursor-pointer edit-cover-img-btn flex justify-center items-center bg-white shadow-xl">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd"
          d="M4 5a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-1.586a1 1 0 01-.707-.293l-1.121-1.121A2 2 0 0011.172 3H8.828a2 2 0 00-1.414.586L6.293 4.707A1 1 0 015.586 5H4zm6 9a3 3 0 100-6 3 3 0 000 6z"
          clip-rule="evenodd" />
      </svg>
      <x-dropdown2>
        <x-slot name="trigger">
          <span class="text-black text-xs">Edit cover photo</span>
        </x-slot>
        <x-dropdown2-link>
          @if ($user->cover_image)
            <x-dropdown2-link href="#" class="flex items-center" data-modal-toggle="view-profile-modal">
              <img src="{{ asset('images/view-profile.png') }}" alt="" class="cover">
              View cover photo
            </x-dropdown2-link>
          @endif
          <x-dropdown2-link class="flex items-center" id="update-cover-photo">
            <img src="{{ asset('images/update-profile.png') }}" alt="" class="cover">
            Update cover photo
          </x-dropdown2-link>
          <div id="remove-cover-photo">
            <x-dropdown2-link href="#" class="flex items-center">
              <img src="{{ asset('images/trash.png') }}" alt="" class="cover">
              Remove cover photo
            </x-dropdown2-link>
          </div>

        </x-dropdown2-link>
      </x-dropdown2>
    </div>
  @endif


  <!-- Main modal -->
  <div id="view-profile-modal" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed right-0 left-0 top-4 z-50 justify-center items-center h-modal md:h-full md:inset-0">
    <div class="relative px-4 w-full max-w-2xl h-full md:h-auto">
      <!-- Modal content -->
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700 overflow-hidden">
        <!-- Modal header -->
        <div class="flex justify-between items-start px-5 py-2 rounded-t border-b dark:border-gray-600">
          <h3 class="text-xl font-semibold text-gray-900 lg:text-xl dark:text-white">
            Cover photo
          </h3>
          <button type="button"
            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
            data-modal-toggle="view-profile-modal">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd"
                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                clip-rule="evenodd"></path>
            </svg>
          </button>
        </div>
        <!-- Modal body -->
        <div class="w-full h-full">
          <img src="{{ $user->coverImage() }}" alt="" class="w-full h-full object-cover">
        </div>
      </div>
    </div>
  </div>
  <input type="file" hidden id="choose-image" name="image">
  <div class="relative overflow-hidden profile-img  flex items-center justify-center m-shadow bg-white" id="preview-image">
    @if (!$user->image)
      <svg id="default-profile" class="inline-block h-full w-full rounded-full overflow-hidden text-gray-300" fill="currentColor" viewBox="0 0 24 24">
        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
      </svg>
    @else
      {{-- Cross --}}
      @if (request()->is('profile/edit'))
        <div class="absolute cross flex justify-center items-center" id="cross-btn">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 pointer-events-none text-gray-500" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
              clip-rule="evenodd" />
          </svg>
        </div>
      @endif
      <img src="{{ $user->profileImage() }}" alt="" class="inline-block h-full w-full rounded-full overflow-hidden text-gray-300 cursor-pointer" id="profile-image">
    @endif
  </div>

  <div class="ml-36">
    <p class="font-bold text-gray-800">{{ $user->name }}</p>
    <p class="text-gray-500">{{ $user->email }}</p>
  </div>
</div>
