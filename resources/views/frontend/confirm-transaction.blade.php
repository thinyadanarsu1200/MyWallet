<x-app title="Confirm Transaction">
  <x-card class="p-5">
    <h1 class="mb-3 text-xl font-semibold">Confirm Transaction</h1>

    <div class="flex justify-between items-center rounded-md shadow-md p-3 mb-5">
      <div class="flex flex-col justify-center">
        <h3>{{ $user->name }}</h3>
        <p class="text-gray-400 text-sm">{{ $user->phone }}</p>
      </div>
      <div>
        @if (!$user->image)
          <img class="min-w-max rounded-full"
            src="https://ui-avatars.com/api/?format=svg&rounded=true&size=35&name={{ $user->name }}" alt="">
        @else
          <img src="{{ $user->profileImage() }}"
            data-image_path="{{ $user->image }}"
            class="user-img w-full h-full object-cover" />
        @endif
      </div>
    </div>


    <div class="flex flex-col justify-center rounded-md shadow-md p-3">
      @if ($description)
        <div class="flex justify-between mb-3">
          <h3>Description</h3>
          <p>{{ $description }}</p>
        </div>
      @endif
      <div class="flex justify-between mb-3">
        <h3>Total Amount</h3>
        <p><span class="font-semibold">{{ number_format($amount) }}</span> MMK</p>
      </div>
      <div class="flex justify-between">
        <a href="{{ route('profile') }}" class="btn mr-4 block" style="width: 50%;">Cancel</a>
        <button type="submit" class="btn-primary send" style="width: 50%;">Send</button>
      </div>
    </div>

    <form action="{{ route('transfer.send') }}" method="POST" id="send-transaction-form">
      @csrf
      <input type="hidden" name="amount" value="{{ $amount }}" />
      <input type="hidden" name="phone" value="{{ $user->phone }}" />
      <input type="hidden" name="description" value="{{ $description }}">
      <input type="hidden" name="id" value="{{ auth()->user()->id }}">
    </form>

  </x-card>
  <x-slot name="js">
    <script>
      document.querySelector('.send').addEventListener('click', function(e) {
        e.preventDefault();
        Swal.fire({
          title: "Enter Password to confirm",
          html: `
          <input type="password" id="password" class="align-left rounded-md border border-indigo-500 focus:border-indigo-500 focus:ring-inset" placeholder="Password"/>
          `,
          confirmButtonText: "Confirm",
          cancelButtonText: "Cancel",
          showCancelButton: true,
          reverseButtons: true,
          focusConfirm: false,
          customClass: {
            confirmButton: ''
          }
        }).then((result) => {
          if (result.isConfirmed) {
            axios({
              method: 'POST',
              url: '/home/transfer/checkPassword',
              data: {
                password: document.querySelector("#password").value,
                id: '{{ auth()->id() }}',
              }
            }).then(res => {
              if (!res.data) return;

              if (res.data.status == 'success') {
                document.querySelector('#send-transaction-form').submit();
              } else if (res.data.status = 'fail') {
                Swal.fire({
                  icon: 'error',
                  text: res.data.message,
                })
              }
            }).catch(err => {
              console.error(err);
            })
          }
        })
      })
    </script>
  </x-slot>
</x-app>
