<?php $__env->startSection('header', 'Manajemen Pengguna'); ?>

<?php $__env->startSection('content'); ?>
    <div class="bg-white shadow-md rounded-lg">
        <?php if(session('status')): ?>
            <div class="px-6 pt-4">
                <div class="rounded-md bg-green-50 p-3 text-sm text-green-800">
                    <?php echo e(session('status')); ?>

                </div>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="px-6 pt-4">
                <div class="rounded-md bg-red-50 p-3 text-sm text-red-800">
                    <?php echo e(session('error')); ?>

                </div>
            </div>
        <?php endif; ?>

        <div class="flex items-center justify-between px-6 py-4">
            <h2 class="text-sm font-semibold text-gray-800">Daftar Pengguna</h2>
            <a href="<?php echo e(route('admin.users.create')); ?>" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                Tambah Pengguna
            </a>
        </div>

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Avatar
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Nama
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Email
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Role
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Desa
                    </th>
                    <th scope="col" class="relative px-6 py-3">
                        <span class="sr-only">Edit</span>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="h-10 w-10 rounded-full overflow-hidden bg-gray-200 flex items-center justify-center">
                                <?php if($user->avatar_path): ?>
                                    <img src="<?php echo e(asset('storage/' . $user->avatar_path)); ?>" alt="<?php echo e($user->name); ?>" class="h-full w-full object-cover">
                                <?php else: ?>
                                    <span class="text-xs font-semibold text-gray-600">
                                        <?php echo e(strtoupper(mb_substr($user->name, 0, 2, 'UTF-8'))); ?>

                                    </span>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900"><?php echo e($user->name); ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900"><?php echo e($user->email); ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php
                                $roleLabel = $user->role === 'admin' ? 'Admin' : ($user->role === 'village_admin' ? 'Admin Desa' : 'Pemilik Potensi');
                                $roleColor = $user->role === 'admin'
                                    ? 'bg-indigo-100 text-indigo-800'
                                    : ($user->role === 'village_admin'
                                        ? 'bg-amber-100 text-amber-800'
                                        : 'bg-gray-100 text-gray-800');
                            ?>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo e($roleColor); ?>">
                                <?php echo e($roleLabel); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                <?php echo e(optional($user->village)->village_name ?? '-'); ?>

                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="inline-flex items-center space-x-2">
                                <a href="<?php echo e(route('admin.users.edit', $user)); ?>" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                <form action="<?php echo e(route('admin.users.destroy', $user)); ?>" method="POST" onsubmit="return confirm('Hapus pengguna ini?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                            Tidak ada pengguna yang ditemukan.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="px-6 py-4">
            <?php echo e($users->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sidara\laravel\resources\views/admin/users/index.blade.php ENDPATH**/ ?>