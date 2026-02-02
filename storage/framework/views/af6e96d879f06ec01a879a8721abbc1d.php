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
            Megvásárolt jegyeim
        </h2>
     <?php $__env->endSlot(); ?>

    <?php
        $grouped = $tickets->groupBy('event_id');
    ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <?php if($tickets->isEmpty()): ?>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-gray-600 dark:text-gray-400">Még nincs megvásárolt jegyed.</p>
                </div>
            <?php else: ?>
                <?php $__currentLoopData = $grouped; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $eventId => $eventTickets): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <?php
                        $event = $eventTickets->first()->event;
                    ?>
                    
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">
                            <?php echo e($event->title); ?>

                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">
                            <?php echo e($event->event_date_at->format('Y. m. d. H:i')); ?>

                        </p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <?php $__currentLoopData = $eventTickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                    <div class="flex justify-between items-start mb-3">
                                        <div>
                                            <p class="font-semibold text-gray-800 dark:text-gray-200">
                                                <?php echo e($ticket->seat->seat_number ?? 'Ismeretlen ülőhely'); ?>

                                                                                                                            
                                            </p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                <?php echo e(number_format($ticket->price, 0, ',', ' ')); ?> Ft
                                            </p>
                                        </div>
                                        <?php if($ticket->admission_time): ?>
                                            <span class="bg-green-100 text-white text-xs px-2 py-1 rounded">
                                                Beolvasva
                                            </span>
                                        <?php else: ?>
                                            <span class="bg-yellow-100 text-white text-xs px-2 py-1 rounded">
                                                Nem beolvasva
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="bg-gray-800 p-4 rounded-lg flex flex-col items-center space-y-3">
                                         <p class="text-white text-sm tracking-widest font-mono">
                                            <?php echo e($ticket->barcode); ?>

                                        </p>
                                        <svg class="barcode" data-barcode="<?php echo e($ticket->barcode); ?>" width="150" height="50"></svg>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('.barcode').forEach(el => {
        JsBarcode(el, el.dataset.barcode, {
            format: "CODE128",
            displayValue: true,
            fontSize: 14,
            width: 2,
            height: 50
        });
    });
});
</script>



 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH /home/abel/Documents/school/szerveroldali/ticketing-system/resources/views/tickets/index.blade.php ENDPATH**/ ?>