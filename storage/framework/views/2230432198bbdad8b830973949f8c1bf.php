<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
  'title' => '',
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
  'title' => '',
]); ?>
<?php foreach (array_filter(([
  'title' => '',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<header class='flex shadow-sm py-3 px-4 sm:px-10 bg-gradient-to-l from-blue-700 to-blue-100 lg:from-blue-100 lg:to-blue-100 font-[sans-serif] min-h-[70px] tracking-wide relative z-40 w-full'>
  <div class='flex flex-row items-center justify-between lg:gap-y-4 gap-y-6 gap-x-4 w-full'>
    <a href="javascript:void(0)">
        <img id="headerLogo" src="<?php echo e(asset('/images/logo.png')); ?>" alt="logo" class="w-36 lg:invisible"/>
    </a>
    <p class="font-sans text-gray-800 lg:text-gray-700 font-semibold text-lg lg:text-2xl"><?php echo e($title); ?></p>
    <div id="collapseMenu" class='max-lg:hidden lg:!block max-lg:before:fixed max-lg:before:bg-black max-lg:before:opacity-40 max-lg:before:inset-0 max-lg:before:z-50'>
      <button id="toggleClose" class='lg:hidden fixed top-2 right-4 z-[100] rounded-full bg-white p-3'>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 fill-black" viewBox="0 0 320.591 320.591">
          <path
            d="M30.391 318.583a30.37 30.37 0 0 1-21.56-7.288c-11.774-11.844-11.774-30.973 0-42.817L266.643 10.665c12.246-11.459 31.462-10.822 42.921 1.424 10.362 11.074 10.966 28.095 1.414 39.875L51.647 311.295a30.366 30.366 0 0 1-21.256 7.288z"
            data-original="#000000">
          </path>
          <path
            d="M287.9 318.583a30.37 30.37 0 0 1-21.257-8.806L8.83 51.963C-2.078 39.225-.595 20.055 12.143 9.146c11.369-9.736 28.136-9.736 39.504 0l259.331 257.813c12.243 11.462 12.876 30.679 1.414 42.922-.456.487-.927.958-1.414 1.414a30.368 30.368 0 0 1-23.078 7.288z"
            data-original="#000000">
          </path>
        </svg>
      </button>

    </div>

    <div class='flex items-center max-sm:ml-auto space-x-6'>
      <ul>
        <li id="profileIcon" class="relative">
          <img src="<?php echo e(asset(auth()->user()->profile)); ?>" alt="" class="h-8 w-8 cursor-pointer rounded-full">
          <div id="profileMenu" class="hidden bg-white z-20 shadow-md py-6 px-6 sm:min-w-[320px] max-sm:min-w-[250px] absolute right-0 top-10">
            <h6 class="font-semibold text-[15px]"><?php echo e(auth()->user()->name); ?></h6>
            <p class="text-sm text-gray-500 mt-1">Profile Menu</p>
            <hr class="border-b-0 my-4" />
            <ul class="space-y-1.5">
              <li><a href='/account' class="text-sm text-gray-500 hover:text-black">Account Settings</a></li>
              <li><a href='javascript:void(0)' class="text-sm text-gray-500 hover:text-black">Privacy Settings</a></li>
            </ul>
            <hr class="border-b-0 my-4" />
            <a href="/logout" class="bg-transparent border-2 border-gray-300 hover:border-black rounded px-4 py-2.5 mt-4 text-sm text-black font-semibold">
              LOGOUT
            </a>
          </div>
        </li>
      </ul>

      <button id="toggleOpen" class='lg:hidden ml-7'>
        <svg class="w-7 h-7" fill="#000" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd"
            d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
            clip-rule="evenodd">
          </path>
        </svg>
      </button>
    </div>
  </div>
</header>

<script>
    var toggleOpen = document.getElementById('toggleOpen');
    var toggleClose = document.getElementById('toggleClose');
    var sidebarMenu = document.getElementById('sidebar');
    var headerLogo = document.getElementById('headerLogo');

    function handleClick() {
        if (sidebarMenu.classList.contains('hidden')) {
            sidebarMenu.classList.remove('hidden');
            sidebarMenu.classList.add('fixed');
            headerLogo.classList.add('hidden');
        } else {
            headerLogo.classList.remove('fixed');
            sidebarMenu.classList.add('hidden');
            headerLogo.classList.remove('hidden');
        }
    }

    toggleOpen.addEventListener('click', handleClick);
    toggleClose.addEventListener('click', handleClick);

    var profileIcon = document.getElementById('profileIcon');
    var profileMenu = document.getElementById('profileMenu');

    profileIcon.addEventListener('click', function(){
        if (profileMenu.classList.contains('hidden')) {
        profileMenu.classList.remove('hidden');
        } else {
        profileMenu.classList.add('hidden');
        }
    });
</script><?php /**PATH C:\laragon\www\quizwatch\resources\views/components/header.blade.php ENDPATH**/ ?>