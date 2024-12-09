

<?php $__env->startSection('content'); ?>

<head>
    <!-- Other head content -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <style>
        /* Custom CSS for spacing on small screens */
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: -0.5rem; /* Adjust this value to control spacing between columns */
        }
        .col-md-4,
        .col-md-8 {
            padding: 0.5rem; /* Adjust this value to control spacing between columns */
            box-sizing: border-box;
        }
        @media (max-width: 768px) {
            .col-md-4,
            .col-md-8 {
                width: 100%;
                margin-bottom: 1rem; /* Space between stacked columns on small screens */
            }
        }
        @media (min-width: 769px) {
            .col-md-4 {
                flex: 1 0 33.3333%; /* 3 columns of equal width on medium screens */
            }
            .col-md-8 {
                flex: 1 0 66.6666%; /* 2 columns with 2/3 width on medium screens */
            }
        }
    </style>
</head>

<body style="padding-top: 6rem;">
    

<div class="mx-auto bg-gray-200  px-12" >
    <div class="row mb-4">
        <div class="col-md-4"><?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('total-students-card')->html();
} elseif ($_instance->childHasBeenRendered('IqTw813')) {
    $componentId = $_instance->getRenderedChildComponentId('IqTw813');
    $componentTag = $_instance->getRenderedChildComponentTagName('IqTw813');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('IqTw813');
} else {
    $response = \Livewire\Livewire::mount('total-students-card');
    $html = $response->html();
    $_instance->logRenderedChild('IqTw813', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?></div>
        <div class="col-md-4"><?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('total-worship-sessions')->html();
} elseif ($_instance->childHasBeenRendered('nvQ49dZ')) {
    $componentId = $_instance->getRenderedChildComponentId('nvQ49dZ');
    $componentTag = $_instance->getRenderedChildComponentTagName('nvQ49dZ');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('nvQ49dZ');
} else {
    $response = \Livewire\Livewire::mount('total-worship-sessions');
    $html = $response->html();
    $_instance->logRenderedChild('nvQ49dZ', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?></div>
        <div class="col-md-4"><?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('attendance-percentage')->html();
} elseif ($_instance->childHasBeenRendered('naUvvlt')) {
    $componentId = $_instance->getRenderedChildComponentId('naUvvlt');
    $componentTag = $_instance->getRenderedChildComponentTagName('naUvvlt');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('naUvvlt');
} else {
    $response = \Livewire\Livewire::mount('attendance-percentage');
    $html = $response->html();
    $_instance->logRenderedChild('naUvvlt', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?></div>
    </div>
    <div class="row">
        <div class="col-md-8"><?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('attendance-graph')->html();
} elseif ($_instance->childHasBeenRendered('ZIAqOor')) {
    $componentId = $_instance->getRenderedChildComponentId('ZIAqOor');
    $componentTag = $_instance->getRenderedChildComponentTagName('ZIAqOor');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('ZIAqOor');
} else {
    $response = \Livewire\Livewire::mount('attendance-graph');
    $html = $response->html();
    $_instance->logRenderedChild('ZIAqOor', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?></div>
        <div class="col-md-4"><?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('donut-chart')->html();
} elseif ($_instance->childHasBeenRendered('tLoL1dj')) {
    $componentId = $_instance->getRenderedChildComponentId('tLoL1dj');
    $componentTag = $_instance->getRenderedChildComponentTagName('tLoL1dj');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('tLoL1dj');
} else {
    $response = \Livewire\Livewire::mount('donut-chart');
    $html = $response->html();
    $_instance->logRenderedChild('tLoL1dj', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?></div>
    </div>
</div>
</body>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\New_Attendance_App\resources\views/home.blade.php ENDPATH**/ ?>