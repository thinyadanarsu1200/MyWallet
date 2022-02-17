<x-backend.app title="Wallet">
  <x-slot name="icon">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
    </svg>
  </x-slot>
  <x-backend.main-panel>
    <!-- header -->
    <div class="table-header flex items-center justify-between">
      <div class="flex items-center">
        <select class="single-select" id="limit" name="limit">
          <option value="5">5</option>
          <option value="10">10</option>
          <option value="25">25</option>
          <option value="100">100</option>
        </select>
      </div>
      <x-search id="wallet-search" />
    </div>

    <div class="wallet-table"></div>
  </x-backend.main-panel>

  <x-slot name="js">
    <script>
      const search = document.querySelector('#wallet-search input');
      const wallet_table = document.querySelector('.wallet-table');
      const limit = document.querySelector('#limit');

      let direction;

      // renderTableDefault
      showTable();

      function showTable() {
        axios({
          method: 'GET',
          url: '/admin/show-wallet-list'
        }).then(res => {
          if (res) {
            wallet_table.innerHTML = res.data;
          }
        }).catch(err => {
          console.error(err);
        })
      }

      //limit
      $(document).ready(function() {
        $('#limit').on('change', function(e) {
          const val = e.target.value;
          const search_val = search.value;

          let url = `/admin/show-wallet-list?limit=${val}`;

          if (search_val) {
            url += `&search=${search_val}`;
          }

          axios({
            method: 'GET',
            url
          }).then(res => {
            if (res) {
              wallet_table.innerHTML = res.data;
            }
          }).catch(err => {
            console.error(err);
          })
        })
      })

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
      search.addEventListener('keyup', debounce(() => {
        const search_value = search.value;
        const limit_value = limit.value;
        url = `/admin/show-wallet-list?limit=${limit_value}`
        if (search_value) {
          url += `&search=${search_value}`
        }

        axios({
          method: 'GET',
          url
        }).then(res => {
          if (res) {
            wallet_table.innerHTML = res.data
          }
        }).catch(err => {
          console.error(err);
        })
      }, 300))


      // sort
      document.addEventListener('click', e => {
        if (e.target.dataset.field) {
          const old_field = document.querySelector('#old-field').value;
          const field = e.target.dataset.field;
          if (field != old_field) {
            direction = null;
          }
          direction = direction === 'asc' ? 'desc' : 'asc';
          let url = `/admin/show-wallet-list?limit=${limit.value}&field=${field}&direction=${direction}`;
          if (search.value) {
            url += `&search=${search.value}`;
          }

          axios({
            method: 'GET',
            url
          }).then(res => {
            if (!res.data) return;
            wallet_table.innerHTML = res.data;
          }).catch(err => console.error(err))
        }
      })

      //  pagination
      document.addEventListener('click', e => {
        if (e.target.classList.contains('page-link')) {
          e.preventDefault();
          if (!e.target.href) {
            return;
          }

          let url = e.target.href;

          axios({
            method: 'GET',
            url
          }).then(res => {
            wallet_table.innerHTML = res.data
          }).catch(err => {
            console.error(err);
          })

        }
      })

      window.addEventListener('reload', function() {
        if (localStorage.getItem(key)) {
          localStorage.removeItem(key);
        }
      })
    </script>
  </x-slot>
</x-backend.app>
