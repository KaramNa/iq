<!DOCTYPE html>
<html>
<head>
    <title>IQ Certificate</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        .container {
            max-width: 600px;
        }
        .badge {
            font-size: 1.5rem;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h1 class="card-title text-center mb-5">IQ Certificate</h1>
            <div class="row mb-5">
                <div class="col-sm-6">
                    <p class="mb-0">Name:</p>
                    <h4 class="font-weight-bold">{{ $name }}</h4>
                </div>
                <div class="col-sm-6">
                    <p class="mb-0">IQ Score:</p>
                    <h4 class="font-weight-bold"><span class="badge badge-primary">{{ $score }}</span></h4>
                </div>
            </div>
            <div class="text-center">
                <img src="{{ $image }}" alt="IQ Certificate">
            </div>
        </div>
    </div>
</div>
</body>
</html>
