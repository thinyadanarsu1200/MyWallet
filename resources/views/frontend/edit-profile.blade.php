<x-app title="Edit Profile" class="bg-white">

  <form action="{{ route('update-profile') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <x-frontend.profile_cover_image :user="$user" />

    {{-- card --}}
    <x-card class="mt-5">
      <a href="{{ route('profile') }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mb-2 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
      </a>

      <div class="grid grid-cols-6 gap-3">
        <div class="col-span-6 sm:col-span-3">
          <label for="name" class="form-label">Name</label>
          <input type="text" name="name" id="name" autocomplete="given-name"
            class="form-control @error('name') error @enderror" value="{{ old('name', $user->name) }}">
          @error('name')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>

        <div class="col-span-6 sm:col-span-3">
          <label for="email" class="form-label">Email Address</label>
          <input type="text" name="email" id="email" autocomplete="email"
            class="form-control @error('email') error @enderror" value="{{ old('email', $user->email) }}">
          @error('email')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>

        <div class="col-span-6 sm:col-span-6">
          <label for="phone" class="form-label">Phone Number</label>
          <input type="number" name="phone" id="phone" autocomplete="phone"
            class="form-control @error('phone') error @enderror" value="{{ old('phone', $user->phone) }}">
          @error('phone')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>

      </div>
      <div class="flex justify-end mt-3">
        <a href="{{ route('admin.user.index') }}" class="btn mr-4">Cancel</a>
        <button type="submit" class="btn-primary">Save Changes</button>
      </div>
    </x-card>
  </form>

  <x-slot name="js">
    <script>
      const preview_image = document.querySelector('#preview-image');
      const choose_image = document.querySelector('#choose-image');
      const preview_cover_image = document.querySelector('#preview-cover-image');
      const choose_cover_image = document.querySelector('#choose-cover-image');
      const update_cover_photo = document.querySelector('#update-cover-photo');
      const remove_cover_photo = document.querySelector('#remove-cover-photo');

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

      remove_cover_photo.addEventListener('click', function(e) {
        choose_cover_image.value = '';
        preview_cover_image.innerHTML = '';
        preview_cover_image.innerHTML = `
    <img src="{{ asset('images/default-cover-photo.jpg') }}" alt="" class="absolute w-full h-full object-cover">
    `
      })
    </script>
  </x-slot>
</x-app>
