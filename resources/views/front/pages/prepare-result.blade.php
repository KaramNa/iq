@extends('layouts.app')
@section('meta')
    <meta name="robots" content="noindex, nofollow" />
@stop
@section('content')

    <div class="container py-10 " style="min-height:70vh">

        <div class="shadow-lg p-4 center col-md-8 mx-auto">

            <h1>{{ trans('Preparing Test Results') }}</h1>
            <!-- Spinner element -->
            <div class="spinner"></div>
            <!-- List of test categories -->
            <ul id="test-categories" class="mt-4 p-0">
                <x-li-checkmark-animation :text="trans('Visual Perception')"/>
                <x-li-checkmark-animation :text="trans('Abstract Reasoning')"/>
                <x-li-checkmark-animation :text="trans('Pattern Recognition')"/>
                <x-li-checkmark-animation :text="trans('Spatial Orientation')"/>
                <x-li-checkmark-animation :text="trans('Analytical Thinking')"/>
            </ul>
        </div>
    </div>

    <style>
        .spinner {
            border: 16px solid #f3f3f3;
            border-top: 16px solid #229654;
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
            margin: 30px 0;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        .list-group-item.enabled {
            color: #229654;
        }

        .center {
            display: flex;
            flex-direction: column;
            align-items: center;
            /*justify-content: center;*/
            /*min-height: 100vh;*/
        }


        /* custom styles */
        .circle-container {
            width: 30px;
            height: 30px;
            position: relative;
        }

        .animate-checkmark {
            width: 100%;
            height: 100%;
            background-color: lightgray;
            border-radius: 50%;
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1;
            animation: circle-grow 2s forwards;
        }

        .check {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
        }

        .animate-path {
            stroke: green;
            stroke-width: 2.5;
            fill: none;
            stroke-dasharray: 36;
            stroke-dashoffset: 36;
            stroke-linecap: round;
            animation: dash 2s forwards;
            -webkit-animation: dash 2s forwards;
        }

        @keyframes circle-grow {
            to {
                transform: scale(1);
                opacity: 0;
            }
        }

        @keyframes dash {
            to {
                stroke-dashoffset: 0;
            }
        }

        @-webkit-keyframes dash {
            to {
                stroke-dashoffset: 0;
            }
        }
    </style>

@endsection
@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            setTimeout(function () {
                window.location.href = '{{ route('test.result', $slug) }}';
            }, 13000);
            document.querySelectorAll("#test-categories .list-group-item").forEach(function (item, index) {
                setTimeout(function () {
                    item.classList.remove("disabled");
                    item.classList.add("enabled");
                    item.firstElementChild.firstElementChild.classList.add("animate-checkmark");
                    item.firstElementChild.lastElementChild.firstElementChild.classList.add("animate-path");
                }, (index + 1) * 2500);
            });
        });
    </script>
@endsection
