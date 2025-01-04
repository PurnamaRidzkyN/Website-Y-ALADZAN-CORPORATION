<div class="antialiased bg-[#1A2634]">
    <nav class="bg-[#1A2634] border-b border-gray-600 px-4 py-2.5 fixed left-0 right-0 top-0 z-50">
      <div class="flex flex-wrap justify-between items-center">
        <div class="flex justify-start items-center">
          <button
            data-drawer-target="drawer-navigation"
            data-drawer-toggle="drawer-navigation"
            aria-controls="drawer-navigation"
            class="p-2 mr-2 text-[#A0AEC0] rounded-lg cursor-pointer md:hidden hover:text-white hover:bg-[#003366] focus:bg-[#003366] focus:ring-2 focus:ring-[#003366]"
          >
            <svg
              aria-hidden="true"
              class="w-6 h-6"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fill-rule="evenodd"
                d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                clip-rule="evenodd"
              ></path>
            </svg>
          </button>
          <a href="#" class="flex items-center justify-between mr-4">
            <img
              src="https://flowbite.s3.amazonaws.com/logo.svg"
              class="mr-3 h-8"
              alt="Flowbite Logo"
            />
            <span class="self-center text-2xl font-semibold whitespace-nowrap text-[#E1E1E6]">Flowbite</span>
          </a>
        </div>
        <div class="flex items-center">
          <!-- Notifications -->
          <button
            type="button"
            class="p-2 mr-1 text-[#A0AEC0] rounded-lg hover:text-white hover:bg-[#003366] focus:ring-4 focus:ring-[#003366]"
          >
            <span class="sr-only">View notifications</span>
            <svg
              aria-hidden="true"
              class="w-6 h-6"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"
              ></path>
            </svg>
          </button>
          <!-- User Profile -->
          <button
            type="button"
            class="flex mx-3 text-sm bg-[#003366] rounded-full focus:ring-4 focus:ring-[#003366]"
            id="user-menu-button"
            aria-expanded="false"
            data-dropdown-toggle="dropdown"
          >
            <span class="sr-only">Open user menu</span>
            <img
              class="w-8 h-8 rounded-full"
              src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/michael-gough.png"
              alt="user photo"
            />
          </button>
          <!-- Dropdown menu -->
          <div
            class="hidden z-50 my-4 w-56 text-base list-none bg-[#1A2634] rounded divide-y divide-gray-600 shadow"
            id="dropdown"
          >
            <div class="py-3 px-4">
              <span class="block text-sm font-semibold text-[#E1E1E6]">Neil Sims</span>
              <span class="block text-sm text-[#A0AEC0] truncate">name@flowbite.com</span>
            </div>
            <ul class="py-1 text-[#A0AEC0]" aria-labelledby="dropdown">
              <li>
                <a
                  href="#"
                  class="block py-2 px-4 text-sm hover:bg-[#003366] hover:text-white"
                  >My profile</a
                >
              </li>
              <li>
                <a
                  href="#"
                  class="block py-2 px-4 text-sm hover:bg-[#003366] hover:text-white"
                  >Log out</a
                >
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>

    <!-- Sidebar -->
    <aside
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-14 transition-transform -translate-x-full bg-[#1A2634] text-[#E1E1E6] border-r border-gray-200 md:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
    aria-label="Sidenav"
    id="drawer-navigation"
  >
    <div class="overflow-y-auto py-5 px-3 h-full bg-[#1A2634]">
      <form action="#" method="GET" class="md:hidden mb-2">
        <div class="relative">
          <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
            <svg
              class="w-5 h-5 text-[#A0AEC0] dark:text-gray-400 hover:text-white transition duration-200"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
              ></path>
            </svg>
          </div>
        </div>
      </form>
      <ul class="space-y-2">
        <li>
          <a
            href="#"
            class="flex items-center p-2 text-base font-medium rounded-lg transition duration-75 group hover:bg-[#003366] hover:text-white"
          >
            <svg
              aria-hidden="true"
              class="w-6 h-6 text-[#A0AEC0] transition duration-75 group-hover:text-white"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
              <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
            </svg>
            <span class="ml-3">Home</span>
          </a>
        </li>
        <li>
          <button
            type="button"
            class="flex items-center p-2 w-full text-base font-medium rounded-lg transition duration-75 group hover:bg-[#003366] hover:text-white"
            aria-controls="dropdown-pages"
            data-collapse-toggle="dropdown-pages"
          >
            <svg
              aria-hidden="true"
              class="flex-shrink-0 w-6 h-6 text-[#A0AEC0] transition duration-75 group-hover:text-white"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fill-rule="evenodd"
                d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                clip-rule="evenodd"
              ></path>
            </svg>
            <span class="flex-1 ml-3 text-left whitespace-nowrap">Transaksi</span>
            <svg
              aria-hidden="true"
              class="w-6 h-6"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                clip-rule="evenodd"
              ></path>
            </svg>
          </button>
          
        </li>
        <li>
          <button
            type="button"
            class="flex items-center p-2 w-full text-base font-medium rounded-lg transition duration-75 group hover:bg-[#003366] hover:text-white"
            aria-controls="dropdown-sales"
            data-collapse-toggle="dropdown-sales"
          >
            <svg
              aria-hidden="true"
              class="flex-shrink-0 w-6 h-6 text-[#A0AEC0] transition duration-75 group-hover:text-white"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fill-rule="evenodd"
                d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z"
                clip-rule="evenodd"
              ></path>
            </svg>
            <span class="flex-1 ml-3 text-left whitespace-nowrap">Pengeluaran</span>
            <svg
              aria-hidden="true"
              class="w-6 h-6"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                clip-rule="evenodd"
              ></path>
            </svg>
          </button>
          
        </li>
        <li>
          <button
            type="button"
            class="flex items-center p-2 w-full text-base font-medium rounded-lg transition duration-75 group hover:bg-[#003366] hover:text-white"
            aria-controls="dropdown-authentication"
            data-collapse-toggle="dropdown-authentication"
          >
            <svg
              aria-hidden="true"
              class="flex-shrink-0 w-6 h-6 text-[#A0AEC0] transition duration-75 group-hover:text-white"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fill-rule="evenodd"
                d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                clip-rule="evenodd"
              ></path>
            </svg>
            <span class="flex-1 ml-3 text-left whitespace-nowrap">Kelola Data</span>
            <svg
              aria-hidden="true"
              class="w-6 h-6"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                clip-rule="evenodd"
              ></path>
            </svg>
          </button>
          
        </li>
      </ul>
    </div>
  </aside>
  
    <main class="p-4 md:ml-64 h-auto pt-20">
      
    </main>
  </div>