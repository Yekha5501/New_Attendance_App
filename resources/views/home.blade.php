@extends('layouts.app')

@section('content')

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
        <div class="col-md-4">@livewire('total-students-card')</div>
        <div class="col-md-4">@livewire('total-worship-sessions')</div>
        <div class="col-md-4">@livewire('attendance-percentage')</div>
    </div>
    <div class="row">
        <div class="col-md-8">@livewire('attendance-graph')</div>
        <div class="col-md-4">@livewire('donut-chart')</div>
    </div>
</div>
</body>
@endsection
