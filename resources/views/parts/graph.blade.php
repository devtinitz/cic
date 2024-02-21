@push('css')
    <style>
        .dashboard-card{
            position: relative;
            height: 410px !important;
            left: 50%;
            right: 50%;
            transform: translate(-50%);
            width: 1000px !important;
        }

        .dashboard-card .card-head{
            justify-content: center !important;
        }

        #bar-chart{
            position: relative;
            height: 304px !important;
            left: 50%;
            right: 50%;
            transform: translate(-50%);
            width: 700px !important;
        }

        canvas{
            display: block;
            width: 100%;
            height: 100%;
        }
    </style>
@endpush

<!--Business Dashboard V2-->
<div class="business-dashboard company-dashboard">
    <div class="columns is-multiline">
        <div class="column is-12">
            <div class="dashboard-card">
                <div class="card-head">
                    <h3 class="dark-inverted">Présences de la semaine</h3>
                </div>
                <div id="bar-chart">
                    <canvas id="canvas" height="" width=""></canvas>
                </div>
            </div>
        </div>
        <div class="column is-12">
            <div class="dashboard-card">
                <div class="card-head">
                    <h3 class="dark-inverted">Présences de ce mois</h3>
                </div>
                <div id="bar-chart">
                    <canvas id="canvas1" height="" width=""></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@push('thesescripts')
    <!-- Charts JS-->
    <script>
        var  DAYS = ['Lun', 'Mar', 'Mer', 'Jeu', 'Vend', 'Sam', 'Dim'];
        var MOIS = ['Janv', 'Févr', 'Mars', 'Avr', 'Mai', 'Juin', 'Juill', 'Août', 'Sept', 'Oct', 'Nov', 'Dec'];

        const semaine = {{ $presence_semaine ?? '' }};
        const mois = {{ $presence_mois ?? '' }};

        var config1 = {
            type: 'line',
            data: {
                labels:DAYS,
                datasets: [{
                    label: 'Nombre de présences',
                    backgroundColor: '{{ $setting->companycolor ?? '#0d2f52' }}',
                    borderColor: '{{ $setting->companycolor ?? '#0d2f52' }}',
                    data: semaine,
                    fill: false,
                },]
            },
            options: {
                responsive: true,

                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: '{{date('M')}} / {{date('Y')}}',
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Présences',

                        },
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        };
        var config2 = {
            type: 'line',
            data: {
                labels:MOIS,
                datasets: [{
                    label: 'Nombre de présences',
                    backgroundColor: '{{ $setting->companycolor ?? '#0d2f52' }}',
                    borderColor: '{{ $setting->companycolor ?? '#0d2f52' }}',
                    data: mois,
                    fill: false,
                },]
            },
            options: {
                responsive: true,

                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: '{{date('M')}} / {{date('Y')}}',
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Présences',

                        },
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        };

        window.onload = function() {
            var ctx1 = document.getElementById('canvas').getContext('2d');
            window.myLine = new Chart(ctx1, config1);

            var ctx2 = document.getElementById('canvas1').getContext('2d');
            window.myLine = new Chart(ctx2, config2);
        };
        var colorNames = Object.keys(window.chartColors);

    </script>
@endpush