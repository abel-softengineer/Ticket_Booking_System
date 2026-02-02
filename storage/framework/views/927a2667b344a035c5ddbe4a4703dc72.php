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
                Jegyvásárlás: <?php echo e($event->title); ?>

            </h2>
         <?php $__env->endSlot(); ?>

        <div class="py-12">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <div class="mb-8 p-6 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">Esemény részletei</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
        <p class="text-sm text-gray-600 dark:text-gray-400">Esemény címe</p>
        <p class="text-gray-800 dark:text-gray-200 font-semibold"><?php echo e($event->title); ?></p>
    </div>

    <div>
        <p class="text-sm text-gray-600 dark:text-gray-400">Esemény leírása</p>
        <p class="text-gray-800 dark:text-gray-200 font-semibold"><?php echo e($event->description); ?></p>
    </div>

    <div>
        <p class="text-sm text-gray-600 dark:text-gray-400">Időpont</p>
        <p class="text-gray-800 dark:text-gray-200 font-medium"><?php echo e($event->event_date_at->format('Y. m. d. H:i')); ?></p>
    </div>

    <div>
        <p class="text-sm text-gray-600 dark:text-gray-400">Jegyvásárlás kezdete</p>
        <p class="text-gray-800 dark:text-gray-200 font-medium"><?php echo e($event->sale_start_at->format('Y. m. d. H:i')); ?></p>
    </div>

    <div>
        <p class="text-sm text-gray-600 dark:text-gray-400">Jegyvásárlás vége</p>
        <p class="text-gray-800 dark:text-gray-200 font-medium"><?php echo e($event->sale_end_at->format('Y. m. d. H:i')); ?></p>
    </div>

    <div>
        <p class="text-sm text-gray-600 dark:text-gray-400">Ár típusa</p>
        <p class="text-gray-800 dark:text-gray-200 font-medium">
            <?php echo e($event->is_dynamic_price ? 'Dinamikus árazás' : 'Fix árazás'); ?>

        </p>
    </div>

    <div>
        <p class="text-sm text-gray-600 dark:text-gray-400">Maximális jegy/fő</p>
        <p class="text-gray-800 dark:text-gray-200 font-medium"><?php echo e($event->max_number_allowed); ?> db</p>
    </div>
                    </div>
                </div>

                <div class="mb-6">
                    <?php
                        $alreadyBought = $event->tickets()->where('user_id', auth()->id())->count();
                        $remainingTickets = max($event->max_number_allowed - $alreadyBought, 0);
                    ?>
                    
                    <p class="text-gray-700 dark:text-gray-300 mb-2">
                        Már megvásárolt jegyek: <span class="font-semibold"><?php echo e($alreadyBought); ?> db</span>
                    </p>
                    <p class="text-gray-700 dark:text-gray-300 mb-2">
                        Még vásárolható jegyek száma: <span class="font-semibold"><?php echo e($remainingTickets); ?> db</span>
                    </p>
                    
                    <?php if($remainingTickets == 0): ?>
                        <p class="text-red-500 font-semibold">Elérte a maximálisan vásárolható jegyek számát!</p>
                    <?php endif; ?>
                </div>

                <?php if($remainingTickets > 0): ?>
                <form method="POST" action="<?php echo e(route('tickets.store')); ?>">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="event_id" value="<?php echo e($event->id); ?>">
                    
                    <?php
                    $allseats = Seat::all();
                    $bookedSeatsCount = $event->tickets()->count();
                    $totalSeats = $allseats->count();
                    ?>

                    <h4 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Ülőhelyek kiválasztása</h4>
                    

                   <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 mb-6">
                    <?php $__currentLoopData = $allseats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $isBooked = $seat->tickets()->where('event_id', $event->id)->exists();

                            if ($event->is_dynamic_price && !$isBooked) {
                                $daysUntil = max($event->event_date_at->diffInDays(now()), 1);
                                $occupancy = $totalSeats > 0 ? $bookedSeatsCount / $totalSeats : 0;
                                $price = number_format($seat->base_price * (1 + (1 - $daysUntil / 30)) * (1 + $occupancy), 2);
                            } else {
                                $price = number_format($seat->base_price, 2);
                            }
                        ?>

                        <label class="seat-card block p-4 rounded-xl border shadow-md transition
                            <?php echo e($isBooked 
                                ? 'bg-red-400 text-red-700 cursor-not-allowed pointer-events-none seat-booked'
                                : 'bg-green-100 text-white hover:bg-green-200 cursor-pointer'); ?>">
                            <input type="checkbox" name="seat_ids[]" value="<?php echo e($seat->id); ?>"
                                <?php echo e($isBooked ? 'disabled' : ''); ?>

                                class="hidden">

                            <div class="text-lg font-bold"><?php echo e($seat->seat_number); ?></div>
                            <div class="text-sm mt-2"><?php echo e($price); ?> Ft</div>
                        </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>



                    <button type="submit" class="mt-6 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                        Jegyek vásárlása
                    </button>
                </form>
                <?php endif; ?>
            </div>
        </div>

<script>
document.querySelectorAll('.seat-card input[type="checkbox"]').forEach(checkbox => {
    checkbox.addEventListener('change', () => {
        const label = checkbox.closest('.seat-card');
        if (label.classList.contains('seat-booked')) return;

        const remaining = <?php echo e($remainingTickets); ?>;
        const selectedCount = document.querySelectorAll('input[name="seat_ids[]"]:checked').length;

        if (checkbox.checked && selectedCount > remaining) {
            checkbox.checked = false;
            return;
        }

        if (checkbox.checked) {
            label.classList.remove('text-white');
            label.classList.add('text-gray-700');
        } else {
            label.classList.remove('text-gray-700');
            label.classList.add('text-white');
        }

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
<?php endif; ?><?php /**PATH /home/abel/Documents/school/szerveroldali/ticketing-system/resources/views/events/show.blade.php ENDPATH**/ ?>