<?php $__env->startSection('header', 'Edit Produk'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white p-6 rounded-lg shadow-md">
    <form action="<?php echo e(route('admin.potentials.update', $potential)); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        
        <div class="space-y-8">
            <!-- Bagian Informasi Dasar -->
            <div>
                <h3 class="text-lg font-medium leading-6 text-gray-900">Informasi Dasar</h3>
                <p class="mt-1 text-sm text-gray-500">Informasi umum mengenai produk atau potensi desa.</p>
                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Judul -->
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                        <input type="text" name="title" id="title" value="<?php echo e(old('title', $potential->title)); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                        <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Desa -->
                    <div>
                        <label for="village_id" class="block text-sm font-medium text-gray-700">Desa</label>
                        <select name="village_id" id="village_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                            <?php $__currentLoopData = $villages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $village): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($village->id); ?>" <?php echo e(old('village_id', $potential->village_id) == $village->id ? 'selected' : ''); ?>><?php echo e($village->village_name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['village_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Status Verifikasi -->
                    <div>
                        <label for="verification_status" class="block text-sm font-medium text-gray-700">Status Verifikasi</label>
                        <select name="verification_status" id="verification_status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="pending" <?php echo e(old('verification_status', $potential->verification_status) == 'pending' ? 'selected' : ''); ?>>Pending</option>
                            <option value="verified" <?php echo e(old('verification_status', $potential->verification_status) == 'verified' ? 'selected' : ''); ?>>Verified</option>
                            <option value="rejected" <?php echo e(old('verification_status', $potential->verification_status) == 'rejected' ? 'selected' : ''); ?>>Rejected</option>
                        </select>
                        <?php $__errorArgs = ['verification_status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Deskripsi -->
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"><?php echo e(old('description', $potential->description)); ?></textarea>
                        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-200"></div>

            <!-- Bagian Detail Kontak & Harga -->
            <div>
                <h3 class="text-lg font-medium leading-6 text-gray-900">Kontak & Harga</h3>
                <p class="mt-1 text-sm text-gray-500">Detail untuk menghubungi penjual dan informasi harga.</p>
                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nomor WhatsApp -->
                    <div>
                        <label for="whatsapp_number" class="block text-sm font-medium text-gray-700">Nomor WhatsApp</label>
                        <input type="text" name="whatsapp_number" id="whatsapp_number" value="<?php echo e(old('whatsapp_number', $potential->whatsapp_number)); ?>" placeholder="Contoh: 6281234567890" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <?php $__errorArgs = ['whatsapp_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Rentang Harga -->
                    <div>
                        <label for="price_range" class="block text-sm font-medium text-gray-700">Rentang Harga</label>
                        <input type="text" name="price_range" id="price_range" value="<?php echo e(old('price_range', $potential->price_range)); ?>" placeholder="Contoh: Rp 50.000 - Rp 200.000" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <?php $__errorArgs = ['price_range'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-200"></div>

            <!-- Bagian Lokasi -->
            <div>
                <h3 class="text-lg font-medium leading-6 text-gray-900">Lokasi</h3>
                <p class="mt-1 text-sm text-gray-500">Informasi alamat dan koordinat geografis.</p>
                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Alamat Lokasi -->
                    <div class="md:col-span-2">
                        <label for="location_address" class="block text-sm font-medium text-gray-700">Alamat Lokasi</label>
                        <input type="text" name="location_address" id="location_address" value="<?php echo e(old('location_address', $potential->location_address)); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <?php $__errorArgs = ['location_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Latitude -->
                    <div>
                        <label for="latitude" class="block text-sm font-medium text-gray-700">Latitude</label>
                        <input type="text" name="latitude" id="latitude" value="<?php echo e(old('latitude', $potential->latitude)); ?>" placeholder="Contoh: -8.409518" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <?php $__errorArgs = ['latitude'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Longitude -->
                    <div>
                        <label for="longitude" class="block text-sm font-medium text-gray-700">Longitude</label>
                        <input type="text" name="longitude" id="longitude" value="<?php echo e(old('longitude', $potential->longitude)); ?>" placeholder="Contoh: 115.188919" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <?php $__errorArgs = ['longitude'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-200"></div>

            <!-- Bagian Pengelolaan Gambar -->
            <div>
                <h3 class="text-lg font-medium leading-6 text-gray-900">Pengelolaan Gambar</h3>
                <p class="mt-1 text-sm text-gray-500">Lihat, hapus, atau tambahkan gambar baru untuk potensi ini.</p>
                
                <!-- Tampilan Gambar yang Ada -->
                <div class="mt-6">
                    <h4 class="text-md font-medium text-gray-800">Gambar Saat Ini</h4>
                    <div class="mt-4 grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                        <?php if($potential->images): ?>
                            <?php $__empty_1 = true; $__currentLoopData = $potential->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imagePath): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="relative group">
                                    <img src="<?php echo e(asset('storage/' . $imagePath)); ?>" alt="Gambar Potensi" class="w-full h-32 object-cover rounded-lg">
                                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        
                                        <span class="text-white text-xs">Hapus (WIP)</span>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <p class="text-sm text-gray-500 md:col-span-4">Belum ada gambar yang diunggah.</p>
                            <?php endif; ?>
                        <?php else: ?>
                            <p class="text-sm text-gray-500 md:col-span-4">Belum ada gambar yang diunggah.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Form Upload Gambar Baru -->
                <div class="mt-6">
                    <label for="images" class="block text-sm font-medium text-gray-700">Tambah Gambar Baru</label>
                    <input type="file" name="images[]" id="images" multiple class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    <p class="mt-2 text-xs text-gray-500">Anda bisa memilih lebih dari satu file.</p>
                    <?php $__errorArgs = ['images.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
        </div>

        <div class="mt-8 pt-5 border-t border-gray-200 flex justify-end">
            <a href="<?php echo e(route('admin.potentials.index')); ?>" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md mr-2 hover:bg-gray-300">Batal</a>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Simpan Perubahan</button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const deleteUrl = this.getAttribute('data-delete-url');
                if (confirm('Apakah Anda yakin ingin menghapus gambar ini?')) {
                    let form = document.createElement('form');
                    form.action = deleteUrl;
                    form.method = 'POST';

                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    form.innerHTML = `
                        <input type="hidden" name="_token" value="${csrfToken}">
                        <input type="hidden" name="_method" value="DELETE">
                    `;
                    
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sidara\laravel\resources\views/admin/potentials/edit.blade.php ENDPATH**/ ?>