<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Laravel')); ?> - Admin</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <!-- Styles -->
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">

    <!-- Scripts -->
    <script src="<?php echo e(asset('js/app.js')); ?>" defer></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
 </head>
 <body class="font-sans antialiased" style="background-color:#8ecae6; font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">
 
    <div x-data="{ sidebarOpen: false }" class="flex h-screen" style="background-color:#8ecae6;">
        <!-- Sidebar -->
        <div :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false" class="fixed z-20 inset-0 bg-black opacity-50 transition-opacity lg:hidden"></div>

        <div :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="fixed z-30 inset-y-0 left-0 w-64 transition duration-300 transform overflow-y-auto lg:translate-x-0 lg:static lg:inset-0" style="background-color:#023047;">
            <div class="flex items-center justify-center mt-8">
                <div class="flex items-center">
                    <img src="<?php echo e(asset('logo.jpeg')); ?>" alt="Logo Sidara" class="h-8 w-8 rounded-full object-cover mr-2 bg-white">
                    <span class="text-white text-2xl font-semibold">Admin Sidara</span>
                </div>
            </div>

            <nav class="mt-10">
                <a class="flex items-center mt-4 py-2 px-6 text-white bg-white bg-opacity-10" href="<?php echo e(route('admin.dashboard')); ?>">
                    <i class="fas fa-tachometer-alt" style="color:#ffb703;"></i>
                    <span class="mx-3">Dashboard</span>
                </a>

                <a class="flex items-center mt-4 py-2 px-6 text-gray-100 hover:bg-white hover:bg-opacity-10 hover:text-white" href="<?php echo e(route('admin.potentials.index')); ?>">
                    <i class="fas fa-box-open" style="color:#fb8500;"></i>
                    <span class="mx-3">Potensi Desa</span>
                </a>

                <a class="flex items-center mt-4 py-2 px-6 text-gray-100 hover:bg-white hover:bg-opacity-10 hover:text-white" href="<?php echo e(route('admin.users.index')); ?>">
                    <i class="fas fa-users" style="color:#fb8500;"></i>
                    <span class="mx-3">Pengguna</span>
                </a>
            </nav>
        </div>

        <!-- Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Topbar -->
            <header class="flex justify-between items-center py-4 px-6 bg-white border-b-4" style="border-bottom-color:#ffb703;">
                <div class="flex items-center">
                    <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </button>
                </div>

                <?php
                    $user = Auth::user();
                    $role = $user->role ?? null;
                    $roleLabel = 'Pengguna';
                    $roleClass = 'bg-gray-100 text-gray-700';

                    if ($role === 'admin') {
                        $roleLabel = 'Admin';
                        $roleClass = 'bg-blue-100 text-blue-800';
                    } elseif ($role === 'village_admin') {
                        $roleLabel = 'Admin Desa';
                        $roleClass = 'bg-green-100 text-green-800';
                    } elseif ($role === 'owner') {
                        $roleLabel = 'Pemilik Potensi';
                        $roleClass = 'bg-yellow-100 text-yellow-800';
                    }
                ?>

                <div class="flex items-center space-x-4">
                    <a href="<?php echo e(route('admin.potentials.create')); ?>" class="hidden sm:inline-flex items-center px-3 py-2 rounded-md text-xs font-semibold text-white shadow-sm" style="background-color:#219ebc;">
                        <i class="fas fa-plus mr-1.5 text-xs"></i>
                        <span>Potensi Desa</span>
                    </a>

                    <span class="hidden sm:inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold <?php echo e($roleClass); ?>">
                        <?php echo e($roleLabel); ?>

                    </span>

                    <div x-data="{ dropdownOpen: false }" class="relative">
                        <button @click="dropdownOpen = ! dropdownOpen" class="relative block h-8 w-8 rounded-full overflow-hidden shadow focus:outline-none border-2" style="border-color:#219ebc;">
                            <?php if($user && $user->avatar_path): ?>
                                <img src="<?php echo e(asset('storage/' . $user->avatar_path)); ?>" alt="<?php echo e($user->name); ?>" class="h-full w-full object-cover">
                            <?php else: ?>
                                <span class="flex h-full w-full items-center justify-center bg-gray-200 text-xs font-semibold text-gray-700">
                                    <?php echo e(strtoupper(mb_substr($user->name, 0, 2, 'UTF-8'))); ?>

                                </span>
                            <?php endif; ?>
                        </button>

                        <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 h-full w-full z-10"></div>

                        <div x-show="dropdownOpen" class="absolute right-0 mt-2 w-48 bg-white rounded-md overflow-hidden shadow-xl z-10">
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block px-4 py-2 text-sm text-gray-700 hover:text-white" style="background-color:#ffb703;">Logout</a>
                            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                <?php echo csrf_field(); ?>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto" style="background-color:#8ecae6;">
                <div class="container mx-auto px-6 py-8">
                    <h3 class="text-gray-900 text-3xl font-semibold"><?php echo $__env->yieldContent('header'); ?></h3>
                    
                    <div class="mt-4 p-4">
                        <?php echo $__env->yieldContent('content'); ?>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\sidara\laravel\resources\views/layouts/admin.blade.php ENDPATH**/ ?>