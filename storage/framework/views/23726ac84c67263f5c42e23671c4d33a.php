<?php $__env->startSection('title', 'Grade Assessment'); ?>

<?php $__env->startSection('content'); ?>

<h3 class="text-xl font-bold text-black"><?php echo e($answer->assessment->classroom->name); ?></h3>
<p class="text-md font-semibold text-gray-700"><?php echo e($answer->assessment->classroom->code); ?></p>

<div class="mt-6 flex flex-col space-y-3">
    <div class="flex flex-col md:flex-row justify-between items-center">
        <p class="font-sans text-xl font-semibold text-gray-800"><?php echo e($answer->assessment->title); ?></p>
        <div class="flex flex-row space-x-4 mt-2 md:mt-0">
            <button type="button" id="gradeAssessment"
                class="flex flex-row items-center px-2.5 lg:px-6 py-2.5 rounded text-white text-sm tracking-wider font-semibold border-none outline-none bg-green-600 hover:bg-green-700 active:bg-green-600">
                Grade assessment
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" class="h-6 w-6 ml-2 inline fill-white">
                    <path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/>
                </svg>
            </button>
        </div>
    </div>
    <div class="flex flex-row justify-between items-center">
        <p class="font-sams text-lg text-gray-700 font-semibold"><?php echo e($answer->assessment->created_at->format('F j, Y')); ?></p>
        <p class="font-sans text-xl font-semibold text-gray-700">Score: <?php echo e($answer->score); ?> / <?php echo e($answer->assessment->total); ?></p>
    </div>
    <p class="font-sams text-md text-gray-700"><?php echo e($answer->assessment->description); ?></p>
</div>

<div class="flex flex-col justify-between min-w-96 max-w-screen-md min-h-screen mx-auto mt-6 p-4 border border-gray-400 rounded-md shadow-lg">
    <form id="fields" class="flex flex-col">
        <?php $__currentLoopData = json_decode($answer->data); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $node): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($node->type == 'instruction'): ?>
            <fieldset data-type="<?php echo e($node->type); ?>" data-text="<?php echo e($node->text); ?>" data-score="<?php echo e($node->score); ?>" data-options="<?php echo e($node->options); ?>">
                <p class="font-sans text-lg font-semibold">Instruction: <?php echo e($node->text); ?></p>
            </fieldset>
        <?php elseif($node->type == 'shortText'): ?>
            <fieldset data-type="<?php echo e($node->type); ?>" data-text="<?php echo e($node->text); ?>" data-score="<?php echo e($node->score); ?>" data-options="<?php echo e($node->options); ?>">
                <p for="" class="font-sans text-md font-base"><?php echo e($node->text); ?></p>
                <p class="mt-1 text-sm font-sans"><?php echo e($node->score); ?> points</p>
                <input type="text" placeholder="Enter your answer" value="<?php echo e(trim($node->answer)); ?>" readonly
                class="mt-2 px-4 py-1.5 text-sm rounded-md bg-white border border-gray-400 w-full outline-blue-500 md:w-1/2"/>
            </fieldset>
        <?php elseif($node->type == 'longText'): ?>
            <fieldset data-type="<?php echo e($node->type); ?>" data-text="<?php echo e($node->text); ?>" data-score="<?php echo e($node->score); ?>" data-options="<?php echo e($node->options); ?>">
                <p for="" class="font-sans text-md font-base"><?php echo e($node->text); ?></p>
                <p class="mt-1 text-sm font-sans"><?php echo e($node->score); ?> points</p>
                <textarea placeholder="Enter your answer" readonly class="mt-2 px-4 py-1.5 text-sm rounded-md bg-white border border-gray-400 w-full outline-blue-500 md:w-1/2"><?php echo e(trim($node->answer)); ?></textarea>
            </fieldset>
        <?php elseif($node->type == 'radio'): ?>
            <fieldset data-type="<?php echo e($node->type); ?>" data-text="<?php echo e($node->text); ?>" data-score="<?php echo e($node->score); ?>" data-options="<?php echo e($node->options); ?>">
                <p for="" class="font-sans text-md font-base"><?php echo e($node->text); ?></p>
                <p class="mt-1 text-sm font-sans"><?php echo e($node->score); ?> points</p>
                <?php $__currentLoopData = explode(',', $node->options); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="mt-2 flex flex-row items-center space-x-3">
                        <input type="radio" name="<?php echo e($node->text); ?>" value="<?php echo e($option); ?>" <?php echo e($node->answer == $option ? "checked" : "disabled"); ?>>
                        <label for="" class="font-sans text-base font-normal text-gray-700"><?php echo e($option); ?></label>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </fieldset>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </form>
</div>


<?php if (isset($component)) { $__componentOriginalcc4e32376fcf0833a47dab8b99d2e2c9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcc4e32376fcf0833a47dab8b99d2e2c9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modals.gradeassessment','data' => ['id' => ''.e($answer->id).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modals.gradeassessment'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => ''.e($answer->id).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcc4e32376fcf0833a47dab8b99d2e2c9)): ?>
<?php $attributes = $__attributesOriginalcc4e32376fcf0833a47dab8b99d2e2c9; ?>
<?php unset($__attributesOriginalcc4e32376fcf0833a47dab8b99d2e2c9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcc4e32376fcf0833a47dab8b99d2e2c9)): ?>
<?php $component = $__componentOriginalcc4e32376fcf0833a47dab8b99d2e2c9; ?>
<?php unset($__componentOriginalcc4e32376fcf0833a47dab8b99d2e2c9); ?>
<?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\quizwatch\resources\views/assessment_grade.blade.php ENDPATH**/ ?>