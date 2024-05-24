<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'profile' => 'https://img.freepik.com/premium-vector/man-support-icon-flat-vector-service-help-marketing-personal_98396-64301.jpg',
    'name' => 'John Doe',
    'email' => 'johndoe23@gmail.com',
    'value' => '0',
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'profile' => 'https://img.freepik.com/premium-vector/man-support-icon-flat-vector-service-help-marketing-personal_98396-64301.jpg',
    'name' => 'John Doe',
    'email' => 'johndoe23@gmail.com',
    'value' => '0',
]); ?>
<?php foreach (array_filter(([
    'profile' => 'https://img.freepik.com/premium-vector/man-support-icon-flat-vector-service-help-marketing-personal_98396-64301.jpg',
    'name' => 'John Doe',
    'email' => 'johndoe23@gmail.com',
    'value' => '0',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div
    class="flex flex-wrap items-center shadow-[0_0px_8px_-3px_rgba(6,81,237,0.3)] rounded-lg w-full px-4 py-4">
    <img src='<?php echo e($profile); ?>' class="w-10 h-10 rounded-full" />
    <div class="ml-4 flex-1">
        <p class="text-sm text-black font-semibold"><?php echo e($name); ?></p>
        <p class="text-xs text-gray-500 mt-0.5"><?php echo e($email); ?></p>
    </div>
    <p class="font-sans text-lg font-semibold"><?php echo e($value); ?></p>
</div><?php /**PATH C:\laragon\www\quizwatch\resources\views/components/cards/user.blade.php ENDPATH**/ ?>