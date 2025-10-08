{{-- resources/views/components/header.blade.php --}}
@props(['links' => [
    ['route' => 'home',               'label' => __('nav.home'),         'num' => '00'],
    ['route' => 'crew',               'label' => __('nav.crew'),         'num' => '01'],
    ['route' => 'destinations.show',  'params' => ['planet' => 'moon'],  'label' => __('nav.destinations'), 'num' => '02'],
    ['route' => 'technology',         'label' => __('nav.technology'),   'num' => '03'],
]])

<header class="w-full fixed top-0 left-0 right-0 z-50 bg-transparent">
  <div class="max-w-7xl mx-auto flex items-center gap-4 px-6 md:px-10 lg:px-16 py-5">

    {{-- Logo (assure-toi d’avoir /public/images/logo.svg) --}}
    <a href="{{ route('home') }}" class="shrink-0" aria-label="Space Tourism">
      <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="h-10 w-10">
    </a>

    {{-- Trait fin uniquement en ≥ lg --}}
    <div class="hidden lg:block flex-1 h-px bg-white/25 ml-2"></div>

    {{-- NAV DESKTOP/TABLET (visible md+) --}}
    <nav class="hidden md:block backdrop-blur bg-white/5 border border-white/10 text-white">
      <ul class="flex items-center gap-6 md:gap-8 px-6 md:px-10">
        @foreach ($links as $item)
          @php
            $route  = $item['route'];
            $params = $item['params'] ?? [];
            $active = request()->routeIs($route)
                      || (count($params) && url()->current() === route($route, $params));
          @endphp
          <li>
            <x-nav-link :href="route($route, $params)" :active="$active">
              <span class="hidden md:inline font-semibold tracking-widest mr-2">{{ $item['num'] }}</span>
              <span class="uppercase tracking-widest">{{ $item['label'] }}</span>
            </x-nav-link>
          </li>
        @endforeach
      </ul>
    </nav>

    {{-- Switch de langue (md+) --}}
    <div class="hidden md:flex ml-2">
      @php $loc = app()->getLocale(); @endphp
      <a href="{{ route('lang.switch','fr') }}"
         class="px-2 text-sm {{ $loc==='fr' ? 'underline' : 'opacity-70 hover:opacity-100' }}">FR</a>
      <span class="px-1 opacity-50">/</span>
      <a href="{{ route('lang.switch','en') }}"
         class="px-2 text-sm {{ $loc==='en' ? 'underline' : 'opacity-70 hover:opacity-100' }}">EN</a>
    </div>

    {{-- BOUTON BURGER (mobile uniquement) --}}
    <button id="nav-toggle"
            class="md:hidden ml-auto inline-flex items-center justify-center h-10 w-10 rounded
                   text-white/90 hover:text-white focus:outline-none focus:ring-2 focus:ring-white/40"
            aria-label="Ouvrir le menu" aria-expanded="false" aria-controls="mobile-menu">
      {{-- icône burger simple --}}
      <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16"/>
      </svg>
    </button>
  </div>

  {{-- OVERLAY + PANNEAU MOBILE (visible < md seulement) --}}
  <div id="mobile-overlay"
       class="md:hidden fixed inset-0 bg-black/60 hidden"></div>

  <nav id="mobile-menu"
       class="md:hidden fixed top-0 right-0 h-full w-72 max-w-[80%]
              backdrop-blur bg-white/5 border-l border-white/10
              transform translate-x-full transition-transform duration-300">
    <div class="flex items-center justify-between px-5 py-4 border-b border-white/10">
      <span class="uppercase tracking-widest text-white/70 text-sm">{{ config('app.name','Space Tourism') }}</span>
      <button id="nav-close" class="h-9 w-9 inline-flex items-center justify-center rounded
                                   text-white/90 hover:text-white focus:outline-none focus:ring-2 focus:ring-white/40"
              aria-label="Fermer le menu">
        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>
    </div>

    <ul class="flex flex-col gap-1 p-4">
      @foreach ($links as $item)
        @php
          $route  = $item['route'];
          $params = $item['params'] ?? [];
          $active = request()->routeIs($route)
                    || (count($params) && url()->current() === route($route, $params));
        @endphp
        <li>
          <a href="{{ route($route, $params) }}"
             class="block px-4 py-3 rounded text-white/90 hover:text-white hover:bg-white/10
                    {{ $active ? 'bg-white/10' : '' }}">
            <span class="font-semibold tracking-widest mr-2">{{ $item['num'] }}</span>
            <span class="uppercase tracking-widest">{{ $item['label'] }}</span>
          </a>
        </li>
      @endforeach

      {{-- Langue en bas du menu mobile --}}
      <li class="mt-2 border-t border-white/10"></li>
      <li class="flex gap-3 items-center px-4 pt-3">
        @php $loc = app()->getLocale(); @endphp
        <a href="{{ route('lang.switch','fr') }}"
           class="{{ $loc==='fr' ? 'underline' : 'opacity-70 hover:opacity-100' }}">FR</a>
        <span class="opacity-50">/</span>
        <a href="{{ route('lang.switch','en') }}"
           class="{{ $loc==='en' ? 'underline' : 'opacity-70 hover:opacity-100' }}">EN</a>
      </li>
    </ul>
  </nav>
</header>

{{-- JS minimal pour ouvrir/fermer le burger (pas d’alpine requis) --}}
<script>
  (function () {
    const toggle = document.getElementById('nav-toggle');
    const closeBtn = document.getElementById('nav-close');
    const menu = document.getElementById('mobile-menu');
    const overlay = document.getElementById('mobile-overlay');

    function openMenu() {
      menu.classList.remove('translate-x-full');
      overlay.classList.remove('hidden');
      toggle.setAttribute('aria-expanded', 'true');
      document.body.classList.add('overflow-hidden');
    }

    function closeMenu() {
      menu.classList.add('translate-x-full');
      overlay.classList.add('hidden');
      toggle.setAttribute('aria-expanded', 'false');
      document.body.classList.remove('overflow-hidden');
    }

    toggle && toggle.addEventListener('click', openMenu);
    closeBtn && closeBtn.addEventListener('click', closeMenu);
    overlay && overlay.addEventListener('click', closeMenu);

    // Échappement clavier
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') closeMenu();
    });
  })();
</script>
