<x-backend.app title="User Management">
  <x-slot name="icon">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
    </svg>
  </x-slot>

  <x-backend.main-panel>
    <div>
      <a href="{{ route('admin.user.create') }}" class="btn-primary mb-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
          <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z" />
        </svg>
        Create User
      </a>
    </div>
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
      <x-search id="user-search" />
    </div>

    <div class="user-table"></div>
  </x-backend.main-panel>

  <x-slot name="js">
    <script>
      const search = document.querySelector('#user-search input');
      const user_table = document.querySelector('.user-table');
      const page_links = document.querySelectorAll('.page-link');
      const limit = document.querySelector('#limit');
      const local_checks = document.querySelectorAll('.local-check');
      const count = document.querySelector('.count');
      const remove_all = document.querySelector('.remove-all');
      const delete_selected = document.querySelector('.delete-selected');
      const archieve = document.querySelector('.archieve');
      const selected = document.querySelector('.selected');

      let direction;
      let users_id = [];

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

      const sweet_alert_delete_setting = {
        ...sweet_alert_setting,
        title: "Title",
        text: 'Once you delete , you will not get back!!!',
        confirmButtonText: 'DELETE',
        customClass: {
          confirmButton: 'swal2-delete-btn',
        }
      }
      // renderTableDefault
      showTable();

      function showTable() {
        axios({
          method: 'GET',
          url: '/admin/show-user-list'
        }).then(res => {
          if (res) {
            user_table.innerHTML = res.data;
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

          let url = `/admin/show-user-list?limit=${val}`;

          if (search_val) {
            url += `&search=${search_val}`;
          }

          if (users_id) {
            url += `&users_id=${users_id}`;
          }

          axios({
            method: 'GET',
            url
          }).then(res => {
            if (res) {
              user_table.innerHTML = res.data;
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
        url = `/admin/show-user-list?limit=${limit_value}`
        if (search_value) {
          url += `&search=${search_value}`
        }

        if (users_id) {
          url += `&users_id=${users_id}`;
        }

        axios({
          method: 'GET',
          url
        }).then(res => {
          if (res) {
            user_table.innerHTML = res.data
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
          let url = `/admin/show-user-list?limit=${limit.value}&field=${field}&direction=${direction}`;
          if (search.value) {
            url += `&search=${search.value}`;
          }
          if (users_id) {
            url += `&users_id=${users_id}`
          }
          axios({
            method: 'GET',
            url
          }).then(res => {
            if (!res.data) return;
            user_table.innerHTML = res.data;
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

          if (users_id) {
            url += `&users_id=${users_id}`;
          }

          axios({
            method: 'GET',
            url
          }).then(res => {
            user_table.innerHTML = res.data
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
              users_id = users_id.filter((id) => {
                return id != local_check.dataset.id;
              })
            });

            renderOptionBar();
          } else {
            //global checked is true
            if (global_check.checked) {
              local_checks.forEach(local_check => {
                local_check.checked = true;
                users_id.push(local_check.dataset.id);
                renderOptionBar();
              })
            } else {
              //global check is false
              local_checks.forEach(local_check => {
                if (local_check.checked) {
                  users_id = users_id.filter((id) => {
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
          const selected_users_id = [];
          if (e.target.checked) {
            users_id.push(e.target.dataset.id);
          } else {
            users_id = users_id.filter(id => id != e.target.dataset.id);
          }
          renderOptionBar();
          local_checks.forEach(local_check => {
            if (local_check.checked) {
              selected_users_id.push(local_check.dataset.id);
            }
          });
          if (selected_users_id.length > 0 && selected_users_id.length !== local_checks.length) {
            global_check.classList.add('remove-check');
          } else if (selected_users_id.length <= 0) {
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
        users_id = [];
        global_check.checked = false;
        global_check.classList.remove('remove-check');
        local_checks.forEach(local_check => local_check.checked = false);
        selected.classList.remove('active');
      })


      // options selected delete btn
      delete_selected.addEventListener('click', e => {
        sweet_alert_delete_setting.title = `Are you sure to delete ${users_id.length} selected records?`;
        Swal.fire(sweet_alert_delete_setting).then((result) => {
          if (result.isConfirmed) {
            axios({
              method: 'DELETE',
              url: `/admin/delete-selected-user/${users_id}`
            }).then(res => {
              if (res.data) {
                users_id = [];
                showTable();
                selected.classList.remove('active');
                Swal.fire(
                  res.data.status,
                  res.data.message,
                  'success'
                )
              }
            })
          }
        }).catch(err => {
          console.error(err);
        })
        const local_checks = document.querySelectorAll('.local-check');
        const selected_users_id = [];
        local_checks.forEach(checkbox => {
          checkbox.checked && selected_users_id.push(checkbox.dataset.id);
        })
      })

      //delete-one
      document.addEventListener('click', e => {
        if (e.target.classList.contains('delete-one')) {
          const delete_id = e.target.dataset.id;
          const delete_name = e.target.dataset.name;

          deleteOne(delete_id);
          const local_checks = document.querySelectorAll('.local-check');
          const selected_users_id = [];
          local_checks.forEach(checkbox => {
            checkbox.checked && selected_users_id.push(checkbox.dataset.id);
          })
        }
      })

      //delete-one-dropdown
      document.addEventListener('click', e => {
        if (e.target.classList.contains('delete-one-dropdown')) {
          const delete_id = e.target.dataset.id;
          const delete_name = e.target.dataset.name;

          deleteOne(delete_id, delete_name);
          const local_checks = document.querySelectorAll('.local-check');
          const selected_users_id = [];
          local_checks.forEach(checkbox => {
            checkbox.checked && selected_users_id.push(checkbox.dataset.id);
          })
        }
      })


      // options selected archive btn
      archieve.addEventListener('click', e => {
        console.log('archive');
      })

      function renderOptionBar() {
        const selected = document.querySelector('.selected');

        if (users_id.length) {
          selected.classList.add('active');
          count.innerHTML = users_id.length;
        } else {
          selected.classList.remove('active');
        }
      }

      function deleteOne(delete_id, delete_name) {
        sweet_alert_delete_setting.title = `Are you sure to delete ${delete_name}'s record?`;
        Swal.fire(sweet_alert_delete_setting).then((result) => {
          if (result.isConfirmed) {
            axios({
              method: 'DELETE',
              url: `/admin/user/${delete_id}`
            }).then(res => {
              if (res.data) {
                users_id = [];
                showTable();
                selected.classList.remove('active');
                Swal.fire(
                  res.data.status,
                  res.data.message,
                  'success'
                )
              }
            })
          }
        }).catch(err => {
          console.error(err);
        })
      }
    </script>
  </x-slot>
</x-backend.app>
