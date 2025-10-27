<?php
//******************IDPAGE*****************
$idpage = 1;

//Session check****************************
require_once __DIR__ . '/session_check.php';
require_once __DIR__ . '/../../../php/function.php';

//****************location******************
$get_active_menu = "";
$page_titre = "TrustedCargo - Dashboard";
$page_small_detail = "Version 1.0";
$page_location = "Accueil";

// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    header("Location: " . BASE_URL . "index.php?page=login");
    exit;
}

$user = get_user_data_by_username($bdd, $_SESSION['my_username']);

// Récupération des données pour le dashboard
$total_shipments = get_total_shipments($bdd);
$monthly_shipments = get_monthly_shipments($bdd);
$total_customers = get_total_customers($bdd);
$recent_shipments = get_recent_shipments($bdd, 5);
$monthly_shipments_data = get_monthly_shipments_chart($bdd);
$shipments_by_destination = get_shipments_by_destination($bdd);
$destination_stats = get_destination_stats($bdd);
$top_customers = get_top_customers($bdd, 5);

// Préparation des données pour les graphiques
$chart_labels = [];
$chart_data = [];
$chart_colors = ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796'];

foreach ($monthly_shipments_data as $data) {
    $month_name = date('M', mktime(0, 0, 0, $data['month'], 1));
    $chart_labels[] = $month_name . ' ' . $data['year'];
    $chart_data[] = intval($data['shipments_count']);
}

$pie_labels = [];
$pie_data = [];
$pie_colors = [];

foreach ($shipments_by_destination as $index => $destination) {
    $pie_labels[] = $destination['destination'];
    $pie_data[] = intval($destination['count']);
    $pie_colors[] = $chart_colors[$index % count($chart_colors)];
}

if (isset($_GET['close']) && $_GET['close'] == "ok") {
    $_SESSION['mi_m_profile'] = "NA";
    $_SESSION['my_m_user'] = "NA";
    $_SESSION['my_m_membre'] = "NA";
    $_SESSION['my_m_lock'] = "NA";
    $success = "yes";
    $success_message = "Tous les sous dossiers actifs ont été fermés";
}
?>
<!DOCTYPE html>
<html lang="en">

<?php include_once __DIR__ . '/../../layouts/head.php'; ?>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include_once __DIR__ . '/../../layouts/sidebar.php'; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include_once __DIR__ . '/../../layouts/topbar.php'; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard TrustedCargo</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                            <i class="fas fa-download fa-sm text-white-50"></i> Générer Rapport
                        </a>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Total Expéditions -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Expéditions</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_shipments ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-shipping-fast fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Expéditions Ce Mois -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Expéditions Ce Mois</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $monthly_shipments ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Clients -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Total Clients</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_customers ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Destinations Actives -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Destinations Actives</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($shipments_by_destination) ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-map-marker-alt fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Area Chart - Expéditions Mensuelles -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Évolution des Expéditions Mensuelles</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="shipmentsChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pie Chart - Par Destination -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Expéditions par Destination</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="destinationPieChart"></canvas>
                                    </div>
                                    <div class="mt-4 text-center small">
                                        <?php foreach($shipments_by_destination as $index => $destination): ?>
                                            <span class="mr-2 d-block">
                                                <i class="fas fa-circle" style="color: <?= $pie_colors[$index] ?>"></i> 
                                                <?= $destination['destination'] ?> (<?= $destination['count'] ?>)
                                            </span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Deuxième ligne de contenu -->
                    <div class="row">

                        <!-- Expéditions Récentes -->
                        <div class="col-lg-6 mb-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Expéditions Récentes</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Référence</th>
                                                    <th>Client</th>
                                                    <th>Destination</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($recent_shipments as $shipment): ?>
                                                    <tr>
                                                        <td>
                                                            <strong><?= htmlspecialchars($shipment['tracking_reference']) ?></strong>
                                                        </td>
                                                        <td><?= htmlspecialchars($shipment['customer_name'] ?? 'N/A') ?></td>
                                                        <td>
                                                            <span class="badge badge-info"><?= $shipment['destination'] ?></span>
                                                        </td>
                                                        <td><?= date('d/m/Y', strtotime($shipment['created_at'])) ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Top Clients -->
                        <div class="col-lg-6 mb-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Top 5 Clients</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Client</th>
                                                    <th>Téléphone</th>
                                                    <th>Expéditions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($top_customers as $customer): ?>
                                                    <tr>
                                                        <td>
                                                            <strong><?= htmlspecialchars($customer['full_name'] ?? 'N/A') ?></strong>
                                                            <?php if(!empty($customer['email'])): ?>
                                                                <br><small class="text-muted"><?= htmlspecialchars($customer['email']) ?></small>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td><?= htmlspecialchars($customer['phone'] ?? 'N/A') ?></td>
                                                        <td>
                                                            <span class="badge badge-primary"><?= $customer['total_shipments'] ?></span>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Statistiques par Destination -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Statistiques par Destination</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Destination</th>
                                                    <th>Total Expéditions</th>
                                                    <th>Première Expédition</th>
                                                    <th>Dernière Expédition</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($destination_stats as $stat): ?>
                                                    <tr>
                                                        <td>
                                                            <strong><?= $stat['destination'] ?></strong>
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-primary badge-pill"><?= $stat['total_shipments'] ?></span>
                                                        </td>
                                                        <td><?= $stat['first_shipment'] ? date('d/m/Y', strtotime($stat['first_shipment'])) : 'N/A' ?></td>
                                                        <td><?= $stat['last_shipment'] ? date('d/m/Y', strtotime($stat['last_shipment'])) : 'N/A' ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include_once __DIR__ . '/../../layouts/footer.php'; ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <?php include_once __DIR__ . '/../../layouts/logout.php'; ?>

    <?php include_once __DIR__ . '/../../layouts/script.php'; ?>

    <!-- Scripts pour les graphiques -->
    <script>
    // Graphique des expéditions mensuelles
    var ctx = document.getElementById("shipmentsChart");
    var shipmentsChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode($chart_labels) ?>,
            datasets: [{
                label: "Nombre d'expéditions",
                lineTension: 0.3,
                backgroundColor: "rgba(78, 115, 223, 0.05)",
                borderColor: "rgba(78, 115, 223, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                pointBorderColor: "rgba(78, 115, 223, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: <?= json_encode($chart_data) ?>,
            }],
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                xAxes: [{
                    gridLines: {
                        display: false
                    }
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        callback: function(value, index, values) {
                            return value.toLocaleString();
                        }
                    }
                }]
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        return 'Expéditions: ' + tooltipItem.yLabel.toLocaleString();
                    }
                }
            }
        }
    });

    // Graphique circulaire des destinations
    var ctx2 = document.getElementById("destinationPieChart");
    var destinationPieChart = new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: <?= json_encode($pie_labels) ?>,
            datasets: [{
                data: <?= json_encode($pie_data) ?>,
                backgroundColor: <?= json_encode($pie_colors) ?>,
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
                callbacks: {
                    label: function(tooltipItem, data) {
                        var dataset = data.datasets[tooltipItem.datasetIndex];
                        var total = dataset.data.reduce(function(previousValue, currentValue) {
                            return previousValue + currentValue;
                        });
                        var currentValue = dataset.data[tooltipItem.index];
                        var percentage = Math.floor(((currentValue/total) * 100)+0.5);
                        return data.labels[tooltipItem.index] + ': ' + currentValue + ' (' + percentage + '%)';
                    }
                }
            },
            cutoutPercentage: 80,
        },
    });
    </script>

</body>
</html>