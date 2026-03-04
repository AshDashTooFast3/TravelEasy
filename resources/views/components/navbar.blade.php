@vite(['resources/css/app.css', 'resources/js/app.js'])

<nav class="relative dark:bg-gray-800 border-b border-white/10 dark:text-white">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
        <div class="relative flex h-16 items-center justify-between">

            {{-- Mobile menu button --}}
            <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                <button type="button" id="mobile-menu-button" aria-controls="mobile-menu" aria-expanded="false"
                    onclick="toggleMobileMenu()"
                    class="relative inline-flex items-center justify-center rounded-md p-2 dark:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                    <span class="absolute -inset-0.5"></span>
                    <span class="sr-only">Open main menu</span>

                    {{-- Hamburger icon --}}
                    <svg id="icon-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                        aria-hidden="true" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>

                    {{-- Close icon --}}
                    <svg id="icon-close" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                        aria-hidden="true" class="size-6 hidden">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Logo + Desktop nav links --}}
            <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                <div class="flex items-center gap-6">
                    <a href="/" class="flex-shrink-0">
                        <x-application-logo class="h-8 w-auto fill-current text-gray-500" />
                    </a>

                    {{-- Desktop links --}}
                    <div class="hidden sm:flex items-center gap-3">
                        <a href="/"
                            class="rounded-md px-3 py-2 text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-900">
                            Home
                        </a>
                        <a href="/reis"
                            class="rounded-md px-3 py-2 text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-900">
                            Reis
                        </a>
                    </div>
                </div>
            </div>

            {{-- Right side: auth buttons --}}
            <div class="hidden sm:ml-6 sm:flex sm:items-center">
                @guest
                    <a href="{{ route('login') }}"
                        class="rounded-md px-3 py-2 text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-900">
                        Inloggen
                    </a>
                    <a href="{{ route('register') }}"
                        class="rounded-md px-3 py-2 text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-900">
                        Registreren
                    </a>
                @else
                    <form method="POST" action="{{ route('logout') }}" class="mb-0">
                        @csrf
                        <button type="submit"
                            class="rounded-md px-3 py-2 text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-900">
                            Uitloggen
                        </button>
                    </form>
                @endguest
        </div>
    </div>

    {{-- Mobile menu --}}
    <div id="mobile-menu" class="hidden sm:hidden border-t border-white/10">
        <div class="space-y-1 px-2 pt-2 pb-3">
            <a href="/"
                class="block rounded-md px-3 py-2 text-base font-medium hover:bg-gray-100 dark:hover:bg-gray-900">
                Home
            </a>
            <a href="{{route('reis.index')}}"
                class="block rounded-md px-3 py-2 text-base font-medium hover:bg-gray-100 dark:hover:bg-gray-900">
                Reis
            </a>
            @guest
                <a href="{{ route('login') }}"
                    class="block rounded-md px-3 py-2 text-base font-medium hover:bg-gray-100 dark:hover:bg-gray-900">
                    Inloggen
                </a>
                <a href="{{ route('register') }}"
                    class="block rounded-md px-3 py-2 text-base font-medium hover:bg-gray-100 dark:hover:bg-gray-900">
                    Registreren
                </a>
            @else
                <form method="POST" action="{{ route('logout') }}" class="mb-0">
                    @csrf
                    <button type="submit"
                        class="block w-full text-left rounded-md px-3 py-2 text-base font-medium hover:bg-gray-100 dark:hover:bg-gray-900">
                        Uitloggen
                    </button>
                </form>
            @endguest
        </div>
    </div>
</nav>

<script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        const button = document.getElementById('mobile-menu-button');
        const iconOpen = document.getElementById('icon-open');
        const iconClose = document.getElementById('icon-close');

        const isOpen = !menu.classList.contains('hidden');

        menu.classList.toggle('hidden', isOpen);
        button.setAttribute('aria-expanded', String(!isOpen));
        iconOpen.classList.toggle('hidden', !isOpen);
        iconClose.classList.toggle('hidden', isOpen);
    }
</script>