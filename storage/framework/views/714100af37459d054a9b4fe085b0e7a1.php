<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2>Ülőhely részletei: <?php echo e($seat->seat_number); ?></h2>
     <?php $__env->endSlot(); ?>

    <div class="py-6 max-w-2xl mx-auto">
        <p><strong>Ülőhely kódja:</strong> <?php echo e($seat->seat_number); ?></p>
        <p><strong>Alap ár:</strong> <?php echo e(number_format($seat->base_price)); ?> Ft</p>
        <p><strong>Eladott jegyek:</strong> <?php echo e($seat->tickets()->count()); ?></p>

        <a href="<?php echo e(route('seats.edit', $seat->id)); ?>" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">Módosítás</a>
        <a href="<?php echo e(route('seats.index')); ?>" class="px-3 py-1 bg-gray-500 text-white rounded hover:bg-gray-600">Vissza a listához</a>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH /home/abel/Documents/school/szerveroldali/ticketing-system/resources/views/seat/show.blade.php ENDPATH**/ ?>