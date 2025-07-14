<x-header />

<body>

    <main class="float-start w-100">
        <x-sidebar />
        <section class="left-sections-right float-end smart-m">
            <div class="row p-0 m-0">
                <div class="col-lg-12">
                    <div class="row p-0 m-0">
                        <div class="col-lg-12 ">
                            <div class="smart-content d-flex align-items-start justify-content-between">
                                <img src="./images//Smart lou.png" alt="">
                                <div class="">
                                    <h2 class="headingh1 mb-2">Introducing Smart Lou</h2>
                                    <p class="subheading">Smart Lou is your clinics intelligent assistant — always
                                        monitoring alerts and updates across the system, so you dont have to check every
                                        page. Lou keeps you focused by showing exactly what needs your attention today.
                                        Heres what needs your attention today:</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 my-2">
                            <div class="smart-row common-shadow d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ asset('images/s-filter.svg') }}" alt="">
                                    <span class="smartInfo">{{ $expiringMedsCount }} medications expiring within 7
                                        days</span>
                                </div>
                                <div>
                                    <a href="{{ route('inventory') }}" class="common-outline-btn">View Inventory</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 my-2">
                            <div class="smart-row common-shadow d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ asset('images/s-calendar.svg') }}" alt="">
                                    <span class="smartInfo">{{ $cancelledAppointmentsCount }} cancelled appointments
                                        with no reschedule</span>
                                </div>
                                <div>
                                    <a href="{{ route('appointments.index') }}" class="common-outline-btn">View
                                        Appointments</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 my-2">
                            <div class="smart-row common-shadow d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ asset('images/s-bell.svg') }}" alt="">
                                    <span class="smartInfo">{{ $clientTaskOverdueCount }} client task overdue since last
                                        week</span>
                                </div>
                                <div>
                                    <a href="{{ route('reminder') }}" class="common-outline-btn">View
                                        Reminder</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 mt-2 mb-5">
                            <div class="smart-row common-shadow d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ asset('images/s-alam.svg') }}" alt="">
                                    <span class="smartInfo">{{ $overdueWellnessCount }} pet(s) overdue for wellness
                                        exam</span>
                                </div>
                                <div>
                                    <a href="{{ URL::to('overdue') }}" class="common-outline-btn">View Overdue
                                        Visit</a>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>




            </div>



        </section>



    </main>





</body>
<x-footer />
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


</html>