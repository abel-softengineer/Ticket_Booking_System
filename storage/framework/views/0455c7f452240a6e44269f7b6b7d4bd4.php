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
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Admin Board
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-white">
            <p>Összes esemény: <?php echo e($totalevents); ?></p>
            <p>Összes eladott jegy: <?php echo e($totaltickets); ?></p>
            <p>Összbevétel: <?php echo e(number_format($totalrevenue, 2)); ?> Ft</p>

            <h3 class="mt-4 font-semibold">Top 3 kedvelt ülőhely</h3>
            <ul>
                <?php $__currentLoopData = $topseats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>Ülőhely: <?php echo e($seat->seat->seat_number); ?> - Eladott jegyek: <?php echo e($seat->count_sold); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>

            <h3 class="mt-4 font-semibold">Események</h3>
            <table class="min-w-full mt-2">
                <thead>
                    <tr>
                        <th>Esemény</th>
                        <th>Eladott jegyek</th>
                        <th>Szabad jegyek</th>
                        <th>Bevétel</th>
                    </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($event->title); ?></td>
                        <td><?php echo e($event->tickets_count); ?></td>
                        <td><?php echo e($event->max_number_allowed - $event->tickets_count); ?></td>
                        <td><?php echo e(number_format($event->tickets->sum('price'), 2)); ?> Ft</td>
                        <td class="flex space-x-2">

                              <a href="<?php echo e(route('events.edit', $event->id)); ?>" 
                                class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                    Módosítás
                                </a>


                            <form action="<?php echo e(route('events.destroy', $event->id)); ?>" 
                                method="POST"
                                onsubmit="return confirm('Biztosan törölni szeretnéd az eseményt?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" 
                                        class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                    Törlés
                                </button>
                            </form>
                                


                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

            <div class="mt-6 mb-4">
            <a href="<?php echo e(route('events.create')); ?>" 
            class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                Új esemény létrehozása
            </a>

            <a href="<?php echo e(route('seats.create')); ?>" 
            class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                Új ülés létrehozása
            </a>

            </div>

            <div class="mt-4">
                <?php echo e($events->links()); ?>

            </div>

        </div>
    </div>

<h3 class="mt-8 font-semibold text-white">Ülőhelyek</h3>
<div class="overflow-x-auto mt-2">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-800">
            <tr>
                <th class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">Ülőhely szám</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">Eladott jegyek</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">Műveletek</th>
            </tr>
        </thead>
        <tbody class="bg-gray-900 divide-y divide-gray-700">
            <?php $__currentLoopData = $seats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td class="px-4 py-2 text-white"><?php echo e($seat->seat_number); ?></td>
                <td class="px-4 py-2 text-white"><?php echo e($seat->tickets()->count()); ?></td>
                <td class="px-4 py-2 flex space-x-2">
                    <a href="<?php echo e(route('seats.edit', $seat->id)); ?>" 
                       class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                        Módosítás
                    </a>
                    <form action="<?php echo e(route('seats.destroy', $seat->id)); ?>" method="POST" onsubmit="return confirm('Biztosan törölni szeretnéd ezt az ülőhelyet?');">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                            Törlés
                        </button>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
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
<?php /**PATH /home/abel/Documents/school/szerveroldali/ticketing-system/resources/views/adminboard/index.blade.php ENDPATH**/ ?>