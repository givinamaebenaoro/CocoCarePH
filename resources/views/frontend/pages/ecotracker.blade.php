@extends('frontend.layouts.master')
@section('title', 'Eco-Tracker')
@section('main-content')

    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{ route('home') }}">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0)">Eco-Tracker</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

<!-- Start Eco-Tracker -->
<section class="tracker section">
    <div class="container">
        <div class="row">

            <!-- Image and User Name Form -->
            <div class="col-12 text-center">
                <form class="form user-form">
                    <div class="greetings-image-container">
                        <div class="greetings">
                            @if (Auth::check())
                                <h1>Hi, <span>{{ Auth::user()->name }}!</span> Let's Help Our Ecosystem.</h1>
                            @else
                                <h1>Hi, Guest! Let's Help Our Ecosystem.</h1>
                            @endif
                        </div>
                        <div class="image-container">
                            <img src="{{asset('backend/img/2.png')}}" alt="Your Image" class="eco-image">
                        </div>
                    </div>
                </form>
            </div>

          <!-- Survey Form -->
            <div class="col-lg-6 col-12">
                <form class="form" method="POST" action="{{ route('ecotracker.store') }}">
                    @csrf
                    <div class="tracker-form">
                        <div class="row">
                            <div class="col-sm-12">
                                <h3>Join the movement towards a greener planet!</h3>
                                <h6>By using this daily tracker, you can become an eco-ambassador of the Earth and receive a CocoCarePH product! Complete this form every day for 30 consecutive days to earn your reward.</h6>
                                <div class="checkbox-label">
                                        <div class="form-group">
                                            <label><input name="task[]" type="checkbox" value="task1"> Use
                                                water wisely in the morning: Take shorter showers and turn off
                                                the faucet while brushing your teeth.</label>
                                        </div>
                                        <div class="form-group">
                                            <label><input name="task[]" type="checkbox" value="task2"> Use
                                                alternative transportation methods: Take public transportation,
                                                carpool, or bike to work or school.</label>
                                        </div>
                                        <div class="form-group">
                                            <label><input name="task[]" type="checkbox" value="task3"> Use
                                                energy-efficient appliances and lights at work or school: Turn
                                                off electronics when not in use.</label>
                                        </div>
                                        <div class="form-group">
                                            <label><input name="task[]" type="checkbox" value="task4"> Use
                                                reusable containers and utensils for meals: Opt for locally
                                                sourced or plant-based food options.</label>
                                        </div>
                                        <div class="form-group">
                                            <label><input name="task[]" type="checkbox" value="task5"> Use
                                                breaks to participate in community clean-ups: Help keep public
                                                spaces litter-free.</label>
                                        </div>
                                        <div class="form-group">
                                            <label><input name="task[]" type="checkbox" value="task6"> Use
                                                separate bins for recycling and composting at home: Reduce waste
                                                and promote recycling.</label>
                                        </div>
                                        <div class="form-group">
                                            <label><input name="task[]" type="checkbox" value="task7"> Use
                                                your evening to educate yourself and others: Watch documentaries
                                                or read articles on environmental issues.</label>
                                        </div>
                                        <div class="form-group">
                                            <label><input name="task[]" type="checkbox" value="task8"> Use
                                                energy-saving habits before bed: Turn off lights, unplug
                                                devices, and adjust the thermostat for efficiency.</label>
                                            </div>
                                            <div class="form-group">
                                                <label><input name="task[]" type="checkbox" value="task9"> Use
                                                    reusable shopping bags and avoid single-use plastics: Bring your
                                                    own bags when shopping to reduce plastic waste.</label>
                                            </div>
                                            <div class="form-group">
                                                <label><input name="task[]" type="checkbox" value="task10"> Use
                                                    water-saving techniques in the garden: Install drip irrigation
                                                    systems and collect rainwater for watering plants.</label>
                                            </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="single-widget eco-button text-center">
                        <div class="content">
                            <div class="button">
                                <button type="submit" class="btn" {{ session('form_submitted_today') ? 'disabled' : '' }}>Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
                    <!--/ End Button Widget -->
                  <!-- Chart Form -->
            <div class="col-lg-6 col-12">
                <form class="form">
                    <div class="text-center">
                        <h3>You're doing a great job in taking care of our planet.</h3>
                        <h6>Here's your progress <span>{{ Auth::user()->name }}!</span> Let's do it again tomorrow!</h6>
                        <canvas id="progressChart" width="300" height="300"></canvas>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!--/ End Eco-Tracker -->

@endsection
@push('styles')
<style>
    /* Eco-Tracker Styles */
    .tracker.section {
        padding: 60px 0;
        background-color: #fffefe;
        position: relative;
        overflow: hidden;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
    }

    .form {
        background: #ffffff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        position: relative;
        z-index: 1;
        margin-bottom: 20px;
    }

    .tracker-form .form-group {
        margin-bottom: 20px;
    }

    .tracker.section h1 {
        margin-bottom: 20px;
        color: #404140;
    }
    .tracker.section h1 span {
        margin-bottom: 20px;
        font-style: italic;
        color: #118d47;
    }
    .tracker.section h4,
    .tracker.section h3 {
        color: #16571b;
    }
    .tracker.section h6 {
        margin-top: 10px;
        margin-bottom: 10px;
        font-style: italic;
        color: #323332;
        font-weight: 500;
        font-size: 15px;
    }
    .greetings-image-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #fff;
        padding: 10px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .greetings {
        flex: 1;
        text-align: left;
        padding-right: 20px;
    }

    .image-container {
        flex: 0 0 100px;
    }

    .tracker.section img.eco-image {
        max-width: 100px;
        height: auto;
    }

    .checkbox-label {
        margin-top: 20px;
    }

    .checkbox-label label {
        display: flex;
        align-items: center;
        font-weight: 500;
        margin-bottom: 10px;
        cursor: pointer;
        color: #000000;
    }

    .checkbox-label input[type="checkbox"] {
        margin-right: 10px;
        width: 18px;
        height: 18px;
    }

    .eco-button .btn {
        background-color: #00a651;
        color: #fff;
        padding: 12px 30px;
        border: none;
        border-radius: 4px;
        font-size: 18px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .eco-button .btn:disabled {
        background-color: #aaa;
        cursor: not-allowed;
    }

    .eco-button .btn:hover:not(:disabled) {
        background-color: #008f3e;
    }

    /* Background Circles */
    .tracker.section::before,
    .tracker.section::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        background: rgba(0, 143, 62, 0.2);
    }

    .tracker.section::before {
        width: 400px;
        height: 400px;
        top: -100px;
        left: -100px;
    }

    .tracker.section::after {
        width: 300px;
        height: 300px;
        bottom: -150px;
        right: -150px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .form {
            padding: 20px;
        }

        .eco-button .btn {
            padding: 10px 20px;
            font-size: 16px;
        }

        .col-lg-6 {
            flex: 0 0 100%;
            max-width: 100%;
        }

        .greetings-image-container {
            flex-direction: column;
            align-items: center;
        }

        .greetings {
            text-align: center;
            padding-right: 0;
            margin-bottom: 10px;
        }

        .tracker.section img.eco-image {
            margin-bottom: 10px;
        }

        .tracker.section h1 {
            font-size: 24px;
        }

        .tracker.section::before,
        .tracker.section::after {
            display: none;
        }
    }
</style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const progressCount = {{ $progressCount ?? 0 }};
            const progressPercentage = Math.round((progressCount / 30) * 100);
            const consecutiveDays = {{ $consecutiveDays ?? 0 }};
            const consecutiveDaysPercentage = Math.round((consecutiveDays / 30) * 100);

            const ctx = document.getElementById('progressChart').getContext('2d');
            const progressChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Progress', 'Remaining', 'Consecutive Days'],
                    datasets: [{
                        data: [progressPercentage, 100 - progressPercentage, consecutiveDaysPercentage],
                        backgroundColor: ['#5F7F67', '#F78E6E', '#132440'],
                        hoverBackgroundColor: ['#445B4A', '#AD6751', '#0A1322'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    let label = context.label || '';

                                    if (label) {
                                        label += ': ';
                                    }
                                    label += context.raw + '%';
                                    return label;
                                }
                            }
                        }
                    },
                    animation: {
                        animateScale: true,
                        animateRotate: true
                    }
                }
            });
        });
    </script>

    <script src="{{ asset('frontend/js/nice-select/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('frontend/js/select2/js/select2.min.js') }}"></script>
@endpush
