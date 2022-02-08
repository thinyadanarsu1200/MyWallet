<x-backend.app title="Admin User Management">
  <x-slot name="icon">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
        <div class="selected flex items-center">
          <div class="remove-all ml-5 mr-3 bg-slate-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-orange-500 hover:text-orange-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6" />
            </svg>
          </div>
          <div class="delete-selected mr-3 bg-slate-200 ">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 hover:text-red-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
          </div>
          <div class="archieve mr-5 bg-slate-200 ">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 hover:text-blue-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
            </svg>
          </div>
          <div class="text-gray-400">
            <span class="count mr-1"></span>selected
          </div>
        </div>
      </div>
      <x-search id="admin-search" />
    </div>

    <div class="admin-table"></div>
  </x-backend.main-panel>

  <x-slot name="js">
    <script>
      const search = document.querySelector('#admin-search input');
      const admin_table = document.querySelector('.admin-table');
      const page_links = document.querySelectorAll('.page-link');
      const limit = document.querySelector('#limit');
      const local_checks = document.querySelectorAll('.local-check');
      const count = document.querySelector('.count');
      const remove_all = document.querySelector('.remove-all');
      const delete_selected = document.querySelector('.delete-selected');
      const archieve = document.querySelector('.archieve');
      const selected = document.querySelector('.selected');

      let direction;
      let admins_id = [];

      const sweet_alert_setting = {
        title: "Title",
        text: "description",
        confirmButtonText: "OK",
        cancelButtonText: "Cancel",
        showCancelButton: true,
        reverseButtons: true,
        focusConfirm: false,
        customClass: {
          confirmButton: ''
        }
      }
      // renderTableDefault
      showTable();

      function showTable() {
        axios({
          method: 'GET',
          url: '/admin/show-admin-list'
        }).then(res => {
          if (res) {
            admin_table.innerHTML = res.data;
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

          let url = `/admin/show-admin-list?limit=${val}`;

          if (search_val) {
            url += `&search=${search_val}`;
          }

          if (admins_id) {
            url += `&admins_id=${admins_id}`;
          }

          axios({
            method: 'GET',
            url
          }).then(res => {
            if (res) {
              admin_table.innerHTML = res.data;
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
        url = `/admin/show-admin-list?limit=${limit_value}`
        if (search_value) {
          url += `&search=${search_value}`
        }

        if (admins_id) {
          url += `&admins_id=${admins_id}`;
        }

        axios({
          method: 'GET',
          url
        }).then(res => {
          if (res) {
            admin_table.innerHTML = res.data
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
          let url = `/admin/show-admin-list?limit=${limit.value}&field=${field}&direction=${direction}`;
          if (search.value) {
            url += `&search=${search.value}`;
          }
          if (admins_id) {
            url += `&admins_id=${admins_id}`
          }
          axios({
            method: 'GET',
            url
          }).then(res => {
            if (!res.data) return;
            admin_table.innerHTML = res.data;
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

          if (admins_id) {
            url += `&admins_id=${admins_id}`;
          }

          axios({
            method: 'GET',
            url
          }).then(res => {
            admin_table.innerHTML = res.data
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

      //checkbox
      document.addEventListener('click', function(e) {
        const global_check = document.querySelector('#global-check');
        const local_checks = document.querySelectorAll('.local-check');
        const selected_count = document.querySelector('count');
        //global check
        if (e.target.classList.contains('global-check')) {
          //global check contains remove class
          if (global_check.classList.contains('remove-check')) {
            global_check.checked = false;
            global_check.classList.remove('remove-check');

            local_checks.forEach(local_check => {
              local_check.checked = false;
              admins_id = admins_id.filter((id) => {
                return id != local_check.dataset.id;
              })
            });

            renderOptionBar();
          } else {
            //global checked is true
            if (global_check.checked) {
              local_checks.forEach(local_check => {
                local_check.checked = true;
                admins_id.push(local_check.dataset.id);
                renderOptionBar();
              })
            } else {
              //global check is false
              local_checks.forEach(local_check => {
                if (local_check.checked) {
                  admins_id = admins_id.filter((id) => {
                    return id != local_check.dataset.id;
                  })
                }
                local_check.checked = false;
              });
              renderOptionBar();
            }
          }
        }

        // local checkbox
        if (e.target.classList.contains('local-check')) {
          const selected_admins_id = [];
          if (e.target.checked) {
            admins_id.push(e.target.dataset.id);
          } else {
            admins_id = admins_id.filter(id => id != e.target.dataset.id);
          }
          renderOptionBar();
          local_checks.forEach(local_check => {
            if (local_check.checked) {
              selected_admins_id.push(local_check.dataset.id);
            }
          });
          if (selected_admins_id.length > 0 && selected_admins_id.length !== local_checks.length) {
            global_check.classList.add('remove-check');
          } else if (selected_admins_id.length <= 0) {
            global_check.classList.remove('remove-check');
            global_check.checked = false;
          } else {
            global_check.classList.remove('remove-check');
            global_check.checked = true;
          }
        }

      })

      // options selected unselected btn
      remove_all.addEventListener('click', e => {
        const global_check = document.querySelector('#global-check');
        const local_checks = document.querySelectorAll('.local-check');
        admins_id = [];
        global_check.checked = false;
        global_check.classList.remove('remove-check');
        local_checks.forEach(local_check => local_check.checked = false);
        selected.classList.remove('active');
      })

      // options selected delete btn
      delete_selected.addEventListener('click', e => {
        sweet_alert_setting.title = `Are you sure to delete ${admins_id.length} selected records?`;
        sweet_alert_setting.text = 'Once you delete , you will not get back!!!';
        sweet_alert_setting.confirmButtonText = 'Delete';
        sweet_alert_setting.customClass.confirmButton = 'swal2-delete-btn';
        Swal.fire(sweet_alert_setting).then((result) => {
          if (result.isConfirmed) {
            axios({
              method: 'DELETE',
              url: `/admin/delete-selected-admin-user/${admins_id}`
            }).then(res => {
              if (res.data) {
                admins_id = [];
                showTable();
                selected.classList.remove('active');
                Swal.fire(
                  'Deleted!',
                  res.data,
                  'success'
                )
              }
            })
          }
        }).catch(err => {
          console.error(err);
        })
        const local_checks = document.querySelectorAll('.local-check');
        const selected_admins_id = [];
        local_checks.forEach(checkbox => {
          checkbox.checked && selected_admins_id.push(checkbox.dataset.id);
        })
      })

      // options selected archive btn
      archieve.addEventListener('click', e => {
        console.log('archive');
      })

      function renderOptionBar() {
        const selected = document.querySelector('.selected');

        if (admins_id.length) {
          selected.classList.add('active');
          count.innerHTML = admins_id.length;
        } else {
          selected.classList.remove('active');
        }
      }
    </script>
  </x-slot>
</x-backend.app>
