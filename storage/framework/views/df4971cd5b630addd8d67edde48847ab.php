<?php
use App\Models\Seat;
use App\Models\Ticket;
?>


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
            Jövőbeli események
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php

                    $allSeats = Seat::all();
                    $availableSeats = [];

                    foreach ($allSeats as $seat) {
                        $booked = Ticket::where('event_id', $event->id)->where('seat_id', $seat->id)->exists();
                        if (!$booked) {
                            $availableSeats[] = $seat;
                        }
                    }

                    $available = count($availableSeats);
                    $totalSeats = count($allSeats);
                    $percent = $totalSeats > 0 ? ($available / $totalSeats) * 100 : 0;
                    ?>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg transition transform hover:scale-105">
                        <img src="<?php echo e(asset('images/' . $event->cover_image)); ?>" alt="<?php echo e($event->title); ?>" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100"><?php echo e($event->title); ?></h3>
                            <p class="text-gray-600 dark:text-gray-400"><?php echo e($event->event_date_at->format('Y-m-d H:i')); ?></p>
                            
                            <p class="text-green"><?php echo e($percent); ?>%</p>
                            <div class="mt-2 w-full bg-gray-200 dark:bg-gray-700 h-4 rounded-full overflow-hidden">
                                <div class="h-4 bg-green-500 rounded-full" style="width: <?php echo e($percent); ?>%">
                                </div>
                            </div>

                            <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                                Szabad jegyek: <?php echo e($available); ?>

                            </p>

                            <a href="<?php echo e(route('events.show', $event)); ?>" class="mt-2 inline-block hover:underline font-medium text-white">
                                Részletek
                            </a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="mt-6">
                <?php echo e($events->links()); ?>

            </div>
        </div>
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
<?php /**PATH /home/abel/Documents/school/szerveroldali/ticketing-system/resources/views/events/index.blade.php ENDPATH**/ ?>