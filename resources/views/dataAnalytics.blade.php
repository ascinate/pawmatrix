<x-header />

<body>

    <main class="float-start w-100">
        <x-sidebar />
        <section class="left-sections-right float-end">
            <div class="row p-0 m-0">
                <div class="col-lg-12">
                    <div class="row p-0 m-0">
                        <div class="col-lg-12 ">
                            <div class="d-flex align-items-center justify-content-between">
                                <h2 class="headingh1">Data Analytics</h2>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="data-top-card">
                        <div>
                            <h6 class="data-color-gray">Revenue This Week</h6>
                            <div class="d-flex aligns-items-center justify-content-between">
                                <div>
                                    <p class="data-card-price">$5,200</p>
                                    <p class="d-flex align-items-center"><span class="data-card00 d-flex g-2"><img
                                                src="{{ asset('images/up-arrow.svg') }}" alt="">&nbsp;40%</span><span
                                            class="data-card01">vs last week</span></p>
                                </div>
                                <div>
                                    <img src="{{ asset('images/g-chart.png') }}" alt="" class="imgchart01">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="data-top-card">
                        <div>
                            <h6 class="data-color-gray">Revenue This Week</h6>
                            <div class="d-flex aligns-items-center justify-content-between">
                                <div>
                                    <p class="data-card-price">$5,200</p>
                                    <p class="d-flex align-items-center"><span class="data-card00 d-flex g-2"><img
                                                src="{{ asset('images/up-arrow.svg') }}" alt="">&nbsp;40%</span><span
                                            class="data-card01">vs last week</span></p>
                                </div>
                                <div>
                                    <img src="{{ asset('images/g-chart.png') }}" alt="" class="imgchart01">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="data-top-card">
                        <div>
                            <h6 class="data-color-gray">Revenue This Week</h6>
                            <div class="d-flex aligns-items-center justify-content-between">
                                <div>
                                    <p class="data-card-price">$5,200</p>
                                    <p class="d-flex align-items-center"><span class="data-card00 d-flex g-2 c-red"><img
                                                src="{{ asset('images/down-arrow.svg') }}" alt="">&nbsp;40%</span><span
                                            class="data-card01">vs last year</span></p>
                                </div>
                                <div>
                                    <img src="{{ asset('images/r-chart.png') }}" alt="" class="imgchart01">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row my-4">
                    <div class="col-lg-8 ">
                        <div class="divbox">
                            <div class="chart-card">
                                <div class="chart-header">
                                    <h5 class="fw-semibold mb-0">Total Appointments</h5>

                                    <form method="GET" action="{{ route('analytics') }}">
                                        <select name="year" class="form-select-data w-auto"
                                            onchange="this.form.submit()">
                                            @foreach ($availableYears as $yr)
                                            <option value="{{ $yr }}" {{ $year == $yr ? 'selected' : '' }}>{{ $yr }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </form>
                                </div>
 <!-- <pre>{{ json_encode($appointmentsByMonth, JSON_PRETTY_PRINT) }}</pre> -->
                                <div id="chartdiv" style="height: 300px;"></div>
                            </div>

                        </div>

                    </div>
                    <div class="col-lg-4">
                        <div class="divbox">
                            <div class="chart-card right-card">
                                <h5 class="data-analytics-right-head">New patients this month</h5>
                                <div class="data-analytics-right">
                                    <p>new patients</p>
                                    <p class="card-num">{{ $newPatientsCount }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </section>
    </main>





</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-XR5QoDN+YyA7PvKjqYkLgTjKkIvBPDRHdR2EUqgNLo+goAqACyMP+cIk/FWjjfLy" crossorigin="anonymous">
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-XR5QoDN+YyA7PvKjqYkLgTjKkIvBPDRHdR2EUqgNLo+goAqACyMP+cIk/FWjjfLy" crossorigin="anonymous">
</script>



<script>
$(document).ready(function() {
    new DataTable('#example', {
        responsive: true,
        searching: false,
        lengthChange: false
    });
});
</script>

<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

@if (isset($appointmentsByMonth))
<script>
    am5.ready(function () {
        var root = am5.Root.new("chartdiv");
        root.setThemes([am5themes_Animated.new(root)]);

        var chart = root.container.children.push(
            am5xy.XYChart.new(root, {
                panX: false,
                panY: false,
                layout: root.verticalLayout
            })
        );

        // X Axis
        var xAxis = chart.xAxes.push(
            am5xy.CategoryAxis.new(root, {
                categoryField: "monthLabel", // this matches your controller field
                renderer: am5xy.AxisRendererX.new(root, {
                    minGridDistance: 30
                })
            })
        );

        // Y Axis
        var yAxis = chart.yAxes.push(
            am5xy.ValueAxis.new(root, {
                renderer: am5xy.AxisRendererY.new(root, {})
            })
        );

        // Series
        var series = chart.series.push(
            am5xy.LineSeries.new(root, {
                name: "Appointments",
                xAxis: xAxis,
                yAxis: yAxis,
                valueYField: "appointments",
                categoryXField: "monthLabel",
                tooltip: am5.Tooltip.new(root, {
                    labelText: "{valueY} appointments\n{categoryX}"
                }),
                stroke: am5.color(0x3e3a88),
                fill: am5.color(0x3e3a88)
            })
        );

        series.strokes.template.setAll({ strokeWidth: 2 });
        series.fills.template.setAll({ fillOpacity: 0.2, visible: true });

        chart.set("cursor", am5xy.XYCursor.new(root, {
            behavior: "none",
            xAxis: xAxis
        }));

        // Use Laravel-provided JSON data
        const data = @json($appointmentsByMonth);
        xAxis.data.setAll(data);
        series.data.setAll(data);

        series.appear(1000);
        chart.appear(1000, 100);
    });
</script>
@endif

<x-footer />

</html>