<header class="main-header bg-yellow py-3 fixed w-full z-50">

  <div class="container xl:px-0 px-4 h-full">
    <div class="flex flex-row items-center h-full">

      <a href="/">
        <img class="w-48 sm:w-64" src="/wp-content/themes/mcwaffleiron/src/images/logo-horiz-new.png" alt="Classic Events Catering Horizontal Logo" title="Classic Events Catering Horizontal Logo">
      </a>

      <div class="xl:inline-block hidden ml-auto">
        {!!
          wp_nav_menu([
            'theme_location' => 'primary_navigation',
            'menu_class' => 'nav list-reset',
            'container' => 'nav',
            'container_class' => 'ml-auto'
          ])
        !!}
      </div>

      <button class="open-mobile-menu hamburger hamburger--collapse xl:hidden inline-block block ml-auto" type="button">
        <span class="hamburger-box">
          <span class="hamburger-inner"></span>
        </span>
      </button>

    </div>
  </div>

  <div class="mobile-menu fixed bg-yellow w-screen h-screen invisible opacity-0">
    <div class="inner-mobile-menu py-3">
      {!!
        wp_nav_menu([
          'theme_location' => 'primary_navigation',
          'menu_class' => 'nav list-reset',
          'container' => 'nav',
        ])
      !!}
    </div>
  </div>

</header>
