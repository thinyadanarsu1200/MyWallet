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
      <form action="{{ route('transfer-action') }}" method="POST">
        @csrf
        <div class="grid grid-cols-6 gap-3 mb-2">
          <div class="col-span-6 sm:col-span-3">
            <label for="phone" class="form-label">To: <span class="text-theme text-lg" id="phone-owner-name"></span></label>
            <div class="phone">
              <input type="text" name="phone" id="phone" autocomplete="off"
                class="form-control  @error('phone') error @enderror" value="{{ old('phone') }}">
              <div class="loader" id="loader"></div>
              <div class="error-icon" id="error-icon">
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute text-red-500 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" id="error-icon">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
              </div>
              <div class="tick-icon" id="tick-icon">
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute text-green-500 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
              </div>
            </div>

            @error('phone')
              <p class="text-red-500 text-xs mt-1 error-message">{{ $message }}</p>
            @enderror
          </div>

          <div class="col-span-6 sm:col-span-3 mb-2">
            <label for="amount" class="form-label">Amount</label>
            <input type="number" name="amount" id="amount" autocomplete="off"
              class="form-control @error('amount') error @enderror" value="{{ old('amount') }}">
            @error('amount')
              <p class="text-red-500 text-xs mt-1 error-message">{{ $message }}</p>
            @enderror
          </div>


          <div class="col-span-6 sm:col-span-3 mb-2">

            <label for="toggle" class="flex relative items-center mb-4 cursor-pointer">
              <input type="checkbox" id="toggle" class="sr-only">
              <div class="toggle w-11 h-6 bg-gray-200 rounded-full border border-gray-200 toggle-bg dark:bg-gray-700 dark:border-gray-600"></div>
              <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Description (Optional)</span>
            </label>

            <div class="description">
              <label for="description" class="form-label">Description</label>
              <textarea name="description" id="description" autocomplete="off"
                class="form-control @error('description') error @enderror">{{ old('description') }}</textarea>
              @error('description')
                <p class="text-red-500 text-xs mt-1 error-message">{{ $message }}</p>
              @enderror
            </div>
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
      const error_icon = document.querySelector('#error-icon');
      const tick_icon = document.querySelector('#tick-icon');
      const loader = document.querySelector('#loader');
      const phone = document.querySelector('#phone');
      const amount = document.querySelector('#amount');
      const phone_owner_name = document.querySelector('#phone-owner-name');
      const error_message = document.querySelector('.error-message');
      const toggle = document.querySelector('#toggle');
      const description = document.querySelector('.description');

      const session_status = "{{ session('status') }}"
      const session_message = "{{ session('message') }}"
      const description_status = "{{ session('description-status') }}"


      const debounce = (fn, delay) => {
        let id;
        return () => {
          if (id) clearTimeout(id);
          id = setTimeout(() => {
            fn();
          }, delay);
        }
      }

      //search
      phone.addEventListener('keyup', debounce(searchUser, 500))

      function searchUser() {
        const phone_number = phone.value;
        tick_icon.classList.remove('active');
        loader.classList.add('active');

        if (error_message) error_message.style.display = "none";

        axios({
          method: 'GET',
          url: `/home/transfer/search-transfer-phone?phone=${phone_number}`
        }).then(res => {
          if (res.data) {
            if (res.data.length < 1) {
              tick_icon.classList.remove('active');
              loader.classList.remove('active');
              error_icon.classList.add('active');
              phone.classList.add('error');
              phone.classList.remove('correct');
              phone_owner_name.innerHTML = "There is no user found";
              phone_owner_name.style.color = "red";
              phone_owner_name.style.fontSize = "15px";
            } else if (res.data[0] !== "{{ auth()->user()->name }}") {
              loader.classList.remove('active');
              error_icon.classList.remove('active');
              tick_icon.classList.add('active');
              phone.classList.remove('error');
              phone.classList.add('correct');
              phone.style.outline = "none";
              phone_owner_name.innerHTML = `( ${res.data[0]} )`;
              phone_owner_name.style.color = "green";
              phone_owner_name.style.fontSize = "16px";
            } else {
              tick_icon.classList.remove('active');
              loader.classList.remove('active');
              error_icon.classList.add('active');
              phone.classList.add('error');
              phone.classList.remove('correct');
              phone_owner_name.innerHTML = "You cannot transfer your account";
              phone_owner_name.style.color = "red";
              phone_owner_name.style.fontSize = "15px";
            }
          } else {
            phone.classList.remove('error');
            phone.classList.remove('correct');
            loader.classList.remove('active');
            error_icon.classList.remove('active');
            phone_owner_name.innerHTML = " ";
          }
        }).catch(err => {
          console.error(err);
        })
      }

      document.addEventListener('DOMContentLoaded', function() {
        if (session_status == 'success') {
          tick_icon.classList.add('active');
          phone.classList.add('correct');
          phone_owner_name.innerHTML = session_message;
          phone_owner_name.style.color = "green";
          phone_owner_name.style.fontSize = "16px";
        }

        if (session_status == 'fail') {
          error_icon.classList.add('active');
          phone.classList.add('error');
          phone_owner_name.innerHTML = session_message;
          phone_owner_name.style.color = "red";
          phone_owner_name.style.fontSize = "15px";
        }

        if (description_status) {
          toggle.checked = true;
          description.classList.add('show');
        }

      })

      amount.addEventListener('keyup', function() {
        if (error_message) error_message.style.display = "none";
      })

      // toggle description
      toggle.addEventListener('click', function(e) {
        if (e.target.checked) {
          description.classList.add('show');
        } else {
          description.classList.remove('show');
        }
      })
    </script>
  </x-slot>
</x-app>
