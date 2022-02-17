<x-app title="Profile" class="bg-white">

  <div class="profile-page relative">
    <div class="cover-img w-full h-60 bg-red-300 rounded-md relative overflow-hidden cursor-pointer" id="preview-cover-image">
      <img src="{{ asset('images/default-cover-photo.jpg') }}" alt="" class="absolute w-full h-full object-cover">
      <input type="file" id="choose-cover-image" hidden>
    </div>
    <button class="edit-cover-img-btn flex justify-center items-center bg-white shadow-xl">
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
          <x-dropdown2-link href="#" class="flex items-center" data-modal-toggle="view-profile-modal">
            <img src="{{ asset('images/view-profile.png') }}" alt="" class="cover">
            View cover photo
          </x-dropdown2-link>
          <x-dropdown2-link href="#" class="flex items-center" id="update-cover-photo" id="update-cover-photo">
            <img src="{{ asset('images/update-profile.png') }}" alt="" class="cover">
            Update cover photo
          </x-dropdown2-link>
          <x-dropdown2-link href="#" class="flex items-center">
            <img src="{{ asset('images/trash.png') }}" alt="" class="cover">
            Remove cover photo
          </x-dropdown2-link>
        </x-dropdown2-link>
      </x-dropdown2>
    </button>

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
            <img src="{{ asset('images/default-cover-photo.jpg') }}" alt="" class="w-full h-full object-cover">
          </div>
        </div>
      </div>
    </div>

    <input type="file" hidden id="choose-image">
    <div class="relative overflow-hidden profile-img  flex items-center justify-center m-shadow bg-white" id="preview-image">
      @if (!$user->image)
        <svg id="default-profile" class="inline-block h-full w-full rounded-full overflow-hidden text-gray-300" fill="currentColor" viewBox="0 0 24 24">
          <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
      @else
        {{-- Cross --}}
        <div class="absolute cross flex justify-center items-center" id="cross-btn">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 pointer-events-none text-gray-500" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
              clip-rule="evenodd" />
          </svg>
        </div>
        <img src="{{ $user->profileImage() }}" alt="" class="inline-block h-full w-full rounded-full overflow-hidden text-gray-300 cursor-pointer" id="profile-image">
      @endif
    </div>
    <div class="upload-profile-btn bg-white">
      hi
    </div>

    <div class="ml-36">
      <p class="font-bold text-gray-800">{{ $user->name }}</p>
      <p class="text-gray-500">{{ $user->email }}</p>
    </div>
  </div>

  <x-slot name="js">
    <script>
      const preview_image = document.querySelector('#preview-image');
      const choose_image = document.querySelector('#choose-image');
      const preview_cover_image = document.querySelector('#preview-cover-image');
      const choose_cover_image = document.querySelector('#choose-cover-image');
      const update_cover_photo = document.querySelector('#update-cover-photo');

      preview_image.addEventListener('click', function(e) {
        choose_image.click();
      });

      preview_cover_image.addEventListener('click', function(e) {
        choose_cover_image.click();
      })

      update_cover_photo.addEventListener('click', function(e) {
        choose_cover_image.click();
      })

      // To choose profile image
      choose_image.addEventListener('change', function(e) {
        var files = e.target.files;
        if (!files) return;

        preview_image.innerHTML = '';

        for (let i = 0; i < files.length; i++) {
          const file = files[i];
          const imgEle = document.createElement('img');
          const divEle = document.createElement('div');

          divEle.className = 'absolute cross flex justify-center items-center'
          divEle.innerHTML = `
          <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 object-cover pointer-events-none text-gray-500" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
              clip-rule="evenodd" />
          </svg>
          `;

          imgEle.className = 'inline-block h-full w-full rounded-full overflow-hidden text-gray-300 cursor-pointer';
          imgEle.src = URL.createObjectURL(file);
          console.log(imgEle);

          preview_image.appendChild(divEle);
          preview_image.appendChild(imgEle);
        }
      })

      choose_cover_image.addEventListener('change', function(e) {
        const files = e.target.files;
        if (!files) return;
        preview_cover_image.innerHTML = '';
        for (let i = 0; i < files.length; i++) {
          const file = files[i];

          const coverEle = document.createElement('img');
          coverEle.src = URL.createObjectURL(file);
          coverEle.className = 'absolute w-full h-full object-cover';

          preview_cover_image.appendChild(coverEle);
        }
      })

      document.addEventListener('click', function(e) {
        if (e.target.classList.contains('cross')) {
          choose_image.click = false;
          choose_image.value = "";
          preview_image.innerHTML = "";
          preview_image.innerHTML = `
          <svg id="default-profile" class="inline-block h-full w-full rounded-full overflow-hidden text-gray-300" fill="currentColor" viewBox="0 0 24 24">
          <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
          `
        }

        if (e.target.classList.contains('default-profile')) {
          choose_image.click = true;
          choose_image.click();
        }
      })
    </script>
  </x-slot>
</x-app>
