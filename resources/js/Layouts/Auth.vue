<template>
  <div>
    <TransitionRoot as="template" :show="sidebarOpen">
      <Dialog as="div" class="fixed inset-0 flex z-40 md:hidden" @close="sidebarOpen = false">
        <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0"
                         enter-to="opacity-100" leave="transition-opacity ease-linear duration-300"
                         leave-from="opacity-100" leave-to="opacity-0">
          <DialogOverlay class="fixed inset-0 bg-gray-600 bg-opacity-75"/>
        </TransitionChild>
        <TransitionChild as="template" enter="transition ease-in-out duration-300 transform"
                         enter-from="-translate-x-full" enter-to="translate-x-0"
                         leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0"
                         leave-to="-translate-x-full">
          <div class="relative flex-1 flex flex-col max-w-xs w-full pt-5 pb-4 bg-gray-800">
            <TransitionChild as="template" enter="ease-in-out duration-300" enter-from="opacity-0"
                             enter-to="opacity-100" leave="ease-in-out duration-300" leave-from="opacity-100"
                             leave-to="opacity-0">
              <div class="absolute top-0 right-0 -mr-12 pt-2">
                <button type="button"
                        class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                        @click="sidebarOpen = false">
                  <span class="sr-only">Zamknij sidebar</span>
                  <XIcon class="h-6 w-6 text-white" aria-hidden="true"/>
                </button>
              </div>
            </TransitionChild>
            <div class="flex-shrink-0 flex items-center px-4">
              <img class="h-8 w-auto"
                   src="https://tailwindui.com/img/logos/workflow-logo-indigo-500-mark-white-text.svg" alt="Workflow"/>
            </div>
            <div class="mt-5 flex-1 h-0 overflow-y-auto">
              <nav class="px-3 space-y-1">
                <div v-for="(item, index) in groups" :key="`desktop-menu-group-${index}`">
                  <h3 class="text-gray-300 uppercase tracking-widest text-sm mt-3 mb-2">{{ item.label }}</h3>
                  <Link v-for="(item, index) in item.children" :key="`${item.name}-${index}`" :href="route(item.name)"
                     :class="[route().current(item.name) ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'group flex items-center px-2 py-2 text-base font-medium rounded-md']">
                    <component :is="item.icon"
                               :class="[route().current(item.name) ? 'text-gray-300' : 'text-gray-400 group-hover:text-gray-300', 'mr-4 flex-shrink-0 h-6 w-6']"
                               aria-hidden="true"/>
                    {{ item.label }}
                  </Link>
                </div>
              </nav>
            </div>
          </div>
        </TransitionChild>
        <div class="flex-shrink-0 w-14" aria-hidden="true">
          <!-- Dummy element to force sidebar to shrink to fit close icon -->
        </div>
      </Dialog>
    </TransitionRoot>

    <!-- Static sidebar for desktop -->
    <div class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0">
      <!-- Sidebar component, swap this element with another sidebar if you like -->
      <div class="flex-1 flex flex-col min-h-0 bg-gray-800">
        <div class="flex items-center h-16 flex-shrink-0 px-4 bg-gray-900">
          <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-logo-indigo-500-mark-white-text.svg"
               alt="Workflow"/>
        </div>
        <div class="flex-1 flex flex-col overflow-y-auto">
          <nav class="flex-1 px-3 py-4 space-y-1">
            <div v-for="(item, index) in groups" :key="`desktop-menu-group-${index}`">
              <h3 class="text-gray-300 uppercase tracking-widest text-sm mt-3 mb-2">{{ item.label }}</h3>
              <Link v-for="(item, index) in item.children" :key="`${item.name}-${index}`" :href="route(item.name)"
                 :class="[route().current(item.name) ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'group flex items-center px-2 py-2 text-sm font-medium rounded-md']">
                <component :is="item.icon"
                           :class="[route().current(item.name) ? 'text-gray-300' : 'text-gray-400 group-hover:text-gray-300', 'mr-3 flex-shrink-0 h-6 w-6']"
                           aria-hidden="true"/>
                {{ item.label }}
              </Link>
            </div>
          </nav>
        </div>
      </div>
    </div>
    <div class="md:pl-64 flex flex-col">
      <div class="sticky top-0 z-10 flex-shrink-0 flex h-16 bg-white shadow">
        <button type="button"
                class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 md:hidden"
                @click="sidebarOpen = true">
          <span class="sr-only">Otwórz sidebar</span>
          <MenuAlt2Icon class="h-6 w-6" aria-hidden="true"/>
        </button>
        <div class="flex-1 px-4 flex justify-between">
          <div class="flex-1 flex">
            <form class="w-full flex md:ml-0" action="#" method="GET">
              <label for="search-field" class="sr-only">Szukaj</label>
              <div class="relative w-full text-gray-400 focus-within:text-gray-600">
                <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none">
                  <SearchIcon class="h-5 w-5" aria-hidden="true"/>
                </div>
                <input id="search-field"
                       class="block w-full h-full pl-8 pr-3 py-2 border-transparent text-gray-900 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-0 focus:border-transparent sm:text-sm"
                       placeholder="Szukaj" type="search" name="search"/>
              </div>
            </form>
          </div>
          <div class="ml-4 flex items-center md:ml-6">
            <button type="button"
                    class="bg-white p-1 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              <span class="sr-only">Pokaż powiadomienia</span>
              <BellIcon class="h-6 w-6" aria-hidden="true"/>
            </button>

            <!-- Profile dropdown -->
            <Menu as="div" class="ml-3 relative">
              <div>
                <MenuButton
                  class="max-w-xs bg-white flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                  <span class="sr-only">Otwórz menu użytkownika</span>
                  <img class="h-8 w-8 rounded-full"
                       src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                       alt=""/>
                </MenuButton>
              </div>
              <transition enter-active-class="transition ease-out duration-100"
                          enter-from-class="transform opacity-0 scale-95"
                          enter-to-class="transform opacity-100 scale-100"
                          leave-active-class="transition ease-in duration-75"
                          leave-from-class="transform opacity-100 scale-100"
                          leave-to-class="transform opacity-0 scale-95">
                <MenuItems
                  class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                  <MenuItem v-for="(item,index) in userNavigation" :key="`${item.name}-${index}`" v-slot="{ active }">
                    <Link :href="route(item.name)" v-bind="item.extras"
                       :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">{{
                        item.label
                      }}</Link>
                  </MenuItem>
                </MenuItems>
              </transition>
            </Menu>
          </div>
        </div>
      </div>

      <main class="flex-1">
        <div class="py-6">
          <slot/>
        </div>
      </main>
    </div>
  </div>
</template>

<script>
import {ref} from 'vue'
import {
  Dialog,
  DialogOverlay,
  Menu,
  MenuButton,
  MenuItem,
  MenuItems,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue'
import { Link } from '@inertiajs/inertia-vue3';
import BellIcon from '~icons/heroicons-outline/bell'
import HomeIcon from '~icons/heroicons-outline/home'
import MenuAlt2Icon from '~icons/heroicons-outline/menu-alt-2'
import UsersIcon from '~icons/heroicons-outline/bell'
import SearchIcon from '~icons/heroicons-outline/search'
import XIcon from '~icons/heroicons-outline/x'

const groups = [
  {
    label: 'Moja strefa',
    children: [
      {label: 'Dashboard', name: 'dashboard', icon: HomeIcon},
    ]
  },
  {
    label: 'Zbór',
    children: [
      {label: 'Tablica ogłoszeń', name: 'other', icon: UsersIcon},
      {label: 'Grupy', name: 'other', icon: UsersIcon},
      {label: 'Użytkownicy', name: 'other', icon: UsersIcon},
    ]
  },
  {
    label: 'Sala Królestwa',
    children: [
      {label: 'Konserwacja', name: 'other', icon: UsersIcon},
    ]
  }
]

const userNavigation = [
  {label: 'Twój profil', name: 'dashboard'},
  {label: 'Ustawienia', name: 'dashboard'},
  {label: 'Wyloguj się', name: 'logout', extras: { method: 'post' }},
]

export default {
  components: {
    Dialog,
    DialogOverlay,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    TransitionChild,
    TransitionRoot,
    BellIcon,
    MenuAlt2Icon,
    SearchIcon,
    XIcon,
    Link,
  },
  setup() {
    const sidebarOpen = ref(false)

    return {
      groups,
      userNavigation,
      sidebarOpen,
    }
  },
}
</script>
