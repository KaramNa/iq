<!doctype html>
<html lang="{{ Config::get('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @livewireStyles
    <link rel="stylesheet" href="{{ asset('css/bootstrap-5.2.3.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cust-fonts.css') }}">
    <style>

        body, * {
            direction: {{ Config::get('app.locale') == 'ar' ? 'rtl' : 'ltr' }};
        }

        .row {
            margin: 0px;
        }

        .btn-success {
            background-color: #3bb95a !important;
            border-color: #3bb95a !important;
        }

        .btn-info, .bg-info {
            background-color: #0085c0 !important;
            color: #fff;
            border: none;
        }

        a {
            text-decoration: none;
            color: #0085c0;
        }

        .highlight-answer {
            border: 5px solid #0085c0;
        }

        @media (min-width: 750px) {
            .desktop-margin {
                margin-top: 30px !important;
            }
        }

        .col-0 {
            display: none;
        }

        @media (min-width: 992px) {
            .col-0 {
                display: flex;
                width: 8.33333333%;
            }
        }

        .question-answer-area {
            height: 278px;
        }

    </style>
</head>
<body>

{{ $slot }}
<!-- Back To Home Modal -->
<div class="modal fade" id="backToHome" tabindex="-1" aria-labelledby="backToHomeLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="backToHomeLabel">@lang('admin.you_smart')</h5>
                <button type="button" class="btn-close m-0" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @lang('admin.exit_the_test')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                    @lang('admin.resume_the_test')
                </button>
                <a href="{{ route('home') }}" class="btn btn-danger">@lang('admin.exit')</a>
            </div>
        </div>
    </div>
</div>


@yield('scripts')

@livewireScripts
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

</body>
</html>
