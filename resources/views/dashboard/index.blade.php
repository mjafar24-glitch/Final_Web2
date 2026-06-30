<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="row">
        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-6">
            <div class="card info-card sales-card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-muted fw-bold">Total Judul Buku</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-primary text-white" style="width: 50px; height: 50px; font-size: 24px;">
                            <i class='bx bx-book-alt'></i>
                        </div>
                        <div class="ps-3">
                            <h3 class="fw-bold mb-0 text-primary">{{ number_format($totalBooks) }}</h3>
                            <span class="text-muted small pt-2 ps-1">Judul</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-4 col-md-6">
            <div class="card info-card sales-card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-muted fw-bold">Total Eksemplar</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-info text-white" style="width: 50px; height: 50px; font-size: 24px;">
                            <i class='bx bx-copy-alt'></i>
                        </div>
                        <div class="ps-3">
                            <h3 class="fw-bold mb-0 text-info">{{ number_format($totalCopies) }}</h3>
                            <span class="text-muted small pt-2 ps-1">Buku Fisik</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-4 col-md-6">
            <div class="card info-card sales-card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-muted fw-bold">Anggota Aktif</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-success text-white" style="width: 50px; height: 50px; font-size: 24px;">
                            <i class='bx bx-group'></i>
                        </div>
                        <div class="ps-3">
                            <h3 class="fw-bold mb-0 text-success">{{ number_format($activeMembers) }}</h3>
                            <span class="text-muted small pt-2 ps-1">Orang</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-6 col-md-6">
            <div class="card info-card sales-card shadow-sm border-start border-4 border-warning">
                <div class="card-body">
                    <h5 class="card-title text-muted fw-bold">Peminjaman (Bulan Ini)</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-warning text-white" style="width: 60px; height: 60px; font-size: 28px;">
                            <i class='bx bx-transfer'></i>
                        </div>
                        <div class="ps-3">
                            <h2 class="fw-bold mb-0 text-warning">{{ number_format($borrowingsThisMonth) }}</h2>
                            <span class="text-muted small pt-2 ps-1">Transaksi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-6 col-md-12">
            <div class="card info-card sales-card shadow-sm border-start border-4 border-danger">
                <div class="card-body">
                    <h5 class="card-title text-muted fw-bold">Total Pendapatan Denda</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-danger text-white" style="width: 60px; height: 60px; font-size: 28px;">
                            <i class='bx bx-wallet'></i>
                        </div>
                        <div class="ps-3">
                            <h2 class="fw-bold mb-0 text-danger">Rp {{ number_format($totalFinesPaid, 0, ',', '.') }}</h2>
                            <span class="text-muted small pt-2 ps-1">Lunas</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Chart -->
    <div class="row mt-3">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold mb-4">Statistik Peminjaman (6 Bulan Terakhir)</h5>
                    
                    <!-- Line Chart -->
                    <div id="reportsChart"></div>

                    <script>
                        document.addEventListener("DOMContentLoaded", () => {
                            new ApexCharts(document.querySelector("#reportsChart"), {
                                series: [{
                                    name: 'Peminjaman',
                                    data: {!! json_encode($chartData) !!}
                                }],
                                chart: {
                                    height: 350,
                                    type: 'area',
                                    toolbar: {
                                        show: false
                                    },
                                },
                                markers: {
                                    size: 4
                                },
                                colors: ['#4154f1'],
                                fill: {
                                    type: "gradient",
                                    gradient: {
                                        shadeIntensity: 1,
                                        opacityFrom: 0.3,
                                        opacityTo: 0.4,
                                        stops: [0, 90, 100]
                                    }
                                },
                                dataLabels: {
                                    enabled: false
                                },
                                stroke: {
                                    curve: 'smooth',
                                    width: 2
                                },
                                xaxis: {
                                    categories: {!! json_encode($chartLabels) !!},
                                },
                                tooltip: {
                                    x: {
                                        format: 'dd/MM/yy HH:mm'
                                    },
                                }
                            }).render();
                        });
                    </script>
                    <!-- End Line Chart -->

                </div>
            </div>
        </div>
    </div>
</x-app>
