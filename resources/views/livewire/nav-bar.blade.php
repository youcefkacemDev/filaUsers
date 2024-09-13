<div>
    {{-- Success is as dangerous as failure. --}}
    <nav class="bg-white border-gray-200 dark:bg-gray-900">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="/" wire:navigate class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="{{ asset('images/operating-system-97851_1920.png') }}" class="h-8" alt="Flowbite Logo" />
                <span
                    class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">{{ config('app.name') }}</span>
            </a>
            <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                @auth
                    <div class="flex items-center gap-4">
                        <img class="w-10 h-10 rounded-full" src="https://api.dicebear.com/9.x/bottts/jpg" alt="">
                        <div class="font-medium dark:text-white">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
                        </div>
                        <div>
                            <button wire:click='logout'
                                class="bg-blue-300 hover:bg-blue-500 active:bg-blue-700 transition-all text-white font-bold text-lg py-2 px-4 ml-10 rounded"><svg
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                                </svg>
                            </button>
                        </div>
                    </div>
                @endauth
                @guest
                    <button x-data x-on:click="$dispatch('open_modal', {name:'login'})" type="button"
                        class="text-white bg-blue-700 hover:bg-blue-800 mx-2 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-sm px-4 py-2 transition-all font-bold text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Login</button>
                    <button x-data x-on:click="$dispatch('open_modal', {name:'register'})" type="button"
                        class="text-white bg-blue-700 hover:bg-blue-800 mx-2 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-sm px-4 py-2 transition-all font-bold text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Register</button>
                @endguest
                <button data-collapse-toggle="navbar-cta" type="button"
                    class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                    aria-controls="navbar-cta" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 17 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 1h15M1 7h15M1 13h15" />
                    </svg>
                </button>
            </div>
            <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-cta">
                <ul
                    class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                    <li>
                        <a href="#"
                            class="block py-2 px-3 md:p-0 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:dark:text-blue-500"
                            aria-current="page">Home</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block py-2 px-3 md:p-0 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">About</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block py-2 px-3 md:p-0 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Services</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block py-2 px-3 md:p-0 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div>
        <x-register-modal title="Register" name="register">
            @slot('body')
                <form>
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="first_name" class="block mb-2 text-lg font-bold text-black">Name</label>
                            <input wire:model.live='name' type="text" id="first_name"
                                class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                                placeholder="John" />
                            @error('name')
                                <span class="text-sm text-red-500 mt-3">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="email" class="block mb-2 text-lg font-bold text-black">Email
                                address</label>
                            <input wire:model.live='email' type="email" id="email"
                                class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                                placeholder="john.doe@company.com" />
                            @error('email')
                                <span class="text-sm text-red-500 mt-3">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-6">
                        <label for="password" class="block mb-2 text-lg font-bold text-black">Password</label>
                        <input wire:model.live='password_confirmation' type="password" id="password"
                            name="password_confirmation"
                            class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            placeholder="•••••••••" />
                        @error('password_confirmation')
                            <span class="text-sm text-red-500 mt-3">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="password_confirmation" class="block mb-2 text-lg font-bold text-black">Confirm
                            password</label>
                        <input wire:model.live='password' type="password" id="password_confirmation" name="password"
                            class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            placeholder="•••••••••" />
                        @error('password')
                            <span class="text-sm text-red-500 mt-3">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" wire:click.prevent="create"
                        class="text-white bg-sky-700 hover:bg-sky-800 focus:ring-4 transition-all focus:outline-none focus:ring-blue-300 font-bold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Save</button>
                </form>
            @endslot
        </x-register-modal>
    </div>
    <div>
        <x-login-modal title="Login" name="login">
            @slot('body')
                <form>
                    <div>
                        <label for="email" class="block mb-2 text-lg font-bold text-black">Email
                            address</label>
                        <input wire:model='email' type="email" id="email"
                            class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            placeholder="john.doe@company.com" />
                        @error('email')
                            <span class="text-sm text-red-500 mt-3">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="password" class="block mb-2 text-lg font-bold text-black">Password</label>
                        <input wire:model='password' type="password" id="password"
                            class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            placeholder="•••••••••" />
                        @error('password')
                            <span class="text-sm text-red-500 mt-3">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" wire:click.prevent="login"
                        class="text-white bg-sky-700 hover:bg-sky-800 focus:ring-4 transition-all focus:outline-none focus:ring-blue-300 font-bold rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Save</button>
                </form>
            @endslot
        </x-login-modal>
    </div>
</div>
