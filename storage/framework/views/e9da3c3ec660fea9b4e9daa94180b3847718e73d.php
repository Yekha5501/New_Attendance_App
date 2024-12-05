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
} elseif ($_instance->childHasBeenRendered('B5Vukwm')) {
    $componentId = $_instance->getRenderedChildComponentId('B5Vukwm');
    $componentTag = $_instance->getRenderedChildComponentTagName('B5Vukwm');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('B5Vukwm');
} else {
    $response = \Livewire\Livewire::mount('total-students-card');
    $html = $response->html();
    $_instance->logRenderedChild('B5Vukwm', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?></div>
        <div class="col-md-4"><?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('total-worship-sessions')->html();
} elseif ($_instance->childHasBeenRendered('8vLlGFu')) {
    $componentId = $_instance->getRenderedChildComponentId('8vLlGFu');
    $componentTag = $_instance->getRenderedChildComponentTagName('8vLlGFu');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('8vLlGFu');
} else {
    $response = \Livewire\Livewire::mount('total-worship-sessions');
    $html = $response->html();
    $_instance->logRenderedChild('8vLlGFu', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?></div>
        <div class="col-md-4"><?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('attendance-percentage')->html();
} elseif ($_instance->childHasBeenRendered('gvTdfxT')) {
    $componentId = $_instance->getRenderedChildComponentId('gvTdfxT');
    $componentTag = $_instance->getRenderedChildComponentTagName('gvTdfxT');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('gvTdfxT');
} else {
    $response = \Livewire\Livewire::mount('attendance-percentage');
    $html = $response->html();
    $_instance->logRenderedChild('gvTdfxT', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?></div>
    </div>
    <div class="row">
        <div class="col-md-8"><?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('attendance-graph')->html();
} elseif ($_instance->childHasBeenRendered('GlmevC0')) {
    $componentId = $_instance->getRenderedChildComponentId('GlmevC0');
    $componentTag = $_instance->getRenderedChildComponentTagName('GlmevC0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('GlmevC0');
} else {
    $response = \Livewire\Livewire::mount('attendance-graph');
    $html = $response->html();
    $_instance->logRenderedChild('GlmevC0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?></div>
        <div class="col-md-4"><?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('donut-chart')->html();
} elseif ($_instance->childHasBeenRendered('fHnSHd9')) {
    $componentId = $_instance->getRenderedChildComponentId('fHnSHd9');
    $componentTag = $_instance->getRenderedChildComponentTagName('fHnSHd9');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('fHnSHd9');
} else {
    $response = \Livewire\Livewire::mount('donut-chart');
    $html = $response->html();
    $_instance->logRenderedChild('fHnSHd9', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?></div>
    </div>
</div>
</body>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/1292223.cloudwaysapps.com/bwwzkatavt/public_html/resources/views/home.blade.php ENDPATH**/ ?>