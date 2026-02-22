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
            <?php echo e(_('Dashboard')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <span class="text-gray-900 dark:text-gray-100"><?php echo e($title); ?></span>
                </div>

                <div
                    class="p-8 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 text-gray-100 text-2xl">
                    <strong>
                        <p class="text-white p-4">
                            Aantal afspraken gemaakt:
                            <?php if(!empty($aantalAfspraken) && $aantalAfspraken > 0): ?>
                                <span
                                    style="display: inline-block; width: 40px; height: 40px; border-radius: 50%; background: #4F46E5; color: #fff; text-align: center; line-height: 40px; font-weight: bold; margin-left: 10px;">
                                    <?php echo e($aantalAfspraken); ?>

                                </span>
                            <?php else: ?>
                                <span
                                    style="display: inline-block; width: 40px; height: 40px; border-radius: 50%; background: #ffa600ff; color: #fff; text-align: center; line-height: 40px; font-weight: bold; margin-left: 10px;">
                                    0
                                </span>
                                <span style="margin-left: 10px; color: #ffa600ff;">
                                    er zijn nog geen afspraken gemaakt
                                </span>
                            <?php endif; ?>
                        </p>
                    </strong>
                    <br>
                </div>
                <div
                    class="p-8 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 text-gray-100 text-2xl">
                    <strong>
                        <p class="text-white p-4">
                            Omzet tot nu toe:
                            <?php if(!empty($omzet) && $omzet[0]->TotaleOmzet > 0): ?>
                                €<?php echo e($omzet[0]->TotaleOmzet); ?>

                            <?php else: ?>
                                <span
                                    style="display: inline-block; width: 40px; height: 40px; border-radius: 50%; background: #ffa600ff; color: #fff; text-align: center; line-height: 40px; font-weight: bold; margin-left: 10px;">
                                    0
                                </span>
                                <span style="margin-left: 10px; color: #ffa600ff;">
                                    er is nog geen omzet gegenereerd
                                </span>
                            <?php endif; ?>
                        </p>
                    </strong>
                    <br>
                </div>
                <div class="p-8 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <strong>
                        <p class="text-white p-4 text-2xl">
                            Meest voorkomende behandelingen:
                        </p>
                    </strong>
                    <?php if(!empty($voorkomendeBehandelingen) && count($voorkomendeBehandelingen) > 0): ?>
                        <div class="p-4 text-white">
                            <?php $__currentLoopData = $voorkomendeBehandelingen; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $behandeling): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="py-3 px-2 border-b border-gray-700 flex justify-between items-center text-2xl">
                                    <span><?php echo e($behandeling->Behandelingtype); ?></span>
                                    <span class="bg-indigo-600 text-white px-3 py-1 rounded-full text-lg">
                                        <?php echo e($behandeling->AantalUitgevoerd); ?>

                                    </span>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="p-4 text-white">
                            <span style="color: #ffa600ff;">
                                Er zijn nog geen behandelingen uitgevoerd
                            </span>
                        </div>
                    <?php endif; ?>
                    <br>
                </div>
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
<?php endif; ?><?php /**PATH /home/hamid/phpprojecten/SmilePro/resources/views/praktijkmanagement/index.blade.php ENDPATH**/ ?>