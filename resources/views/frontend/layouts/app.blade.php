<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ $title ?? 'Fore Pay' }}</title>

  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

  {{-- Fontawesome --}}
  <script src="https://kit.fontawesome.com/e4fdbc0c51.js" crossorigin="anonymous"></script>


  {{-- Flowbite --}}
  <link rel="stylesheet" href="https://unpkg.com/flowbite@1.3.3/dist/flowbite.min.css" />

  {{-- Tailwind Css --}}
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  {{-- <script src="https://cdn.tailwindcss.com"></script> --}}


  {{-- custom css --}}
  <link rel="stylesheet" href="{{ asset('css/frontend/style.css') }}">

  {{ $css ?? null }}
</head>

<body class="bg-gray-100">
  {{-- Navbar --}}
  <x-frontend.navbar />


  {{-- Main Content --}}
  <main class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 mt-4">
    {{ $slot ?? null }}
  </main>

  {{-- Bottom app bar --}}
  <x-frontend.footer />

  {{-- Flowbite --}}
  <script src="https://unpkg.com/flowbite@1.3.3/dist/flowbite.js"></script>


  <script src="{{ asset('js/app.js') }}"></script>

  {{-- Custom Js --}}
  <script>
    const sign_out_btn = document.querySelector('.sign-out-btn');
    sign_out_btn.addEventListener('click', e => {
      e.preventDefault();
      axios({
          method: 'POST',
          url: '/logout',
        }).then(res => {
          if (res.data) {
            window.location.replace('/login');
          }
        })
        .catch(err => console.error(err));
    })
  </script>

  {{ $js ?? null }}
</body>

</html>
