<?php
session_start();
require_once __DIR__ . '/../../includes/translation.php';
include_once(__DIR__ . "/../../../php/function.php");
require __DIR__ . '/../../../config/debug.php';
require_once __DIR__ . '/../../controllers/ParcelController.php';

$controller = new ParcelController();

$hasTrackingParam = array_key_exists('tracking_number', $_GET);
$trackingNumber = trim($_GET['tracking_number'] ?? '');
$trackingData = null;
$error = null;

if ($trackingNumber === '') {
    if ($hasTrackingParam) {
        $error = t('tracking_result_missing');
    }
} else {
    $trackingData = $controller->getTrackingDataByReference($trackingNumber);
    if (!$trackingData) {
        $error = t('tracking_result_not_found');
    }
}

$customer = $trackingData['customer'] ?? null;
$shipments = $trackingData['shipments'] ?? [];
$searchedTracking = $trackingData['searched_tracking'] ?? $trackingNumber;
$selectedStatus = $_GET['status'] ?? 'all';
$selectedPeriod = $_GET['period'] ?? 'all';

if (!empty($shipments)) {
    $now = time();
    $shipments = array_values(array_filter($shipments, function ($shipment) use ($selectedStatus, $selectedPeriod, $now) {
        if ($selectedStatus !== 'all') {
            $statusCode = $shipment['status_code'] ?? null;
            if ($statusCode !== $selectedStatus) {
                return false;
            }
        }

        if ($selectedPeriod !== 'all') {
            $createdAt = $shipment['created_at'] ?? null;
            $timestamp = $createdAt ? strtotime($createdAt) : false;
            if (!$timestamp) {
                return false;
            }

            switch ($selectedPeriod) {
                case '30d':
                    $limit = strtotime('-30 days', $now);
                    break;
                case '3m':
                    $limit = strtotime('-3 months', $now);
                    break;
                case 'year':
                    $limit = strtotime('-1 year', $now);
                    break;
                default:
                    $limit = null;
            }

            if ($limit !== null && $timestamp < $limit) {
                return false;
            }
        }

        return true;
    }));
}

$lang = $_SESSION['lang'] ?? 'fr';
$statusDefinitions = $controller->getStatusDefinitions();

$formatDateTime = function ($value): string {
    if (!$value) {
        return '—';
    }
    $timestamp = strtotime($value);
    return $timestamp ? date('d/m/Y • H:i', $timestamp) : $value;
};

$getStatusLabel = function ($statusCode) use ($statusDefinitions, $lang): string {
    if (!$statusCode) {
        return '—';
    }
    if (!isset($statusDefinitions[$statusCode])) {
        return $statusCode;
    }
    return $lang === 'en'
        ? ($statusDefinitions[$statusCode]['label_en'] ?? $statusCode)
        : ($statusDefinitions[$statusCode]['label_fr'] ?? $statusCode);
};

$getBadgeClass = function ($statusCode) use ($statusDefinitions): string {
    if (!$statusCode || !isset($statusDefinitions[$statusCode])) {
        return 'info';
    }
    $badge = $statusDefinitions[$statusCode]['badge'] ?? 'info';
    $allowed = ['success', 'warning', 'danger', 'info'];
    return in_array($badge, $allowed, true) ? $badge : 'info';
};

$uppercase = function ($value): string {
    if (function_exists('mb_strtoupper')) {
        return mb_strtoupper((string)$value, 'UTF-8');
    }
    return strtoupper((string)$value);
};

$lastSyncAt = null;
foreach ($shipments as $shipment) {
    $candidate = $shipment['updated_at'] ?? $shipment['created_at'] ?? null;
    if ($candidate && ($lastSyncAt === null || strtotime($candidate) > strtotime($lastSyncAt))) {
        $lastSyncAt = $candidate;
    }
}
$lastSyncLabel = $lastSyncAt ? $formatDateTime($lastSyncAt) : '—';

$statusCounts = [
    'pending' => 0,
    'in_progress' => 0,
    'delivered' => 0,
    'cancelled' => 0
];
foreach ($shipments as $shipment) {
    $code = $shipment['status_code'] ?? null;
    if ($code && array_key_exists($code, $statusCounts)) {
        $statusCounts[$code]++;
    }
}

?>

<!doctype html>
<html lang="<?= htmlspecialchars($lang) ?>">

<?php include(__DIR__ . '/../layouts/head.php'); ?>
<style>
    :root{
      --bg: #f7f7fb;
      --card: #ffffff;
      --card2: #f4f4ff;
      --stroke: rgba(24,24,40,.12);
      --text: #0f172a;
      --muted: rgba(15,23,42,.68);
      --muted2: rgba(15,23,42,.52);

      --brand: #6c63ff;
      --brand2:#00c2ff;

      --success:#22c55e;
      --warning:#f59e0b;
      --danger:#ef4444;
      --info:#3b82f6;

      --radius: 16px;
      --shadow: 0 18px 50px rgba(15,23,42,.08);
      --shadow2: 0 10px 30px rgba(15,23,42,.08);
    }

    *{box-sizing:border-box}
    body.tracking-result-page{
      margin:0;
      font-family: 'Open Sans', sans-serif;
      color:var(--text);
      background: linear-gradient(180deg, #f7f7fb 0%, #eef2f7 100%);
      min-height:100vh;
    }

    body.tracking-result-page h1,
    body.tracking-result-page h2,
    body.tracking-result-page h3,
    body.tracking-result-page h4{
      font-family: 'Playfair Display', serif;
    }

    body.tracking-result-page a{color:inherit; text-decoration:none}

    .tracking-result .wrap{max-width:100%; margin:0; padding:0}

    .tracking-result .page-title{
      display:flex; gap:16px; align-items:flex-end; justify-content:space-between;
      margin-bottom:18px;
    }
    .tracking-result .page-title h1{
      margin:0;
      font-size:28px;
      letter-spacing:.2px;
    }
    .tracking-result .page-title p{
      margin:6px 0 0;
      color:var(--muted);
      font-size:14px;
    }
    .tracking-result .chip{
      display:inline-flex; align-items:center; gap:8px;
      padding:10px 12px;
      border:1px solid var(--stroke);
      background:linear-gradient(180deg, rgba(255,255,255,.9), rgba(248,248,255,.6));
      border-radius:999px;
      box-shadow:var(--shadow2);
      color:var(--muted);
      font-size:13px;
      white-space:nowrap;
    }
    .tracking-result .chip .dot{
      width:8px; height:8px; border-radius:999px;
      background:linear-gradient(90deg,var(--brand),var(--brand2));
      box-shadow:0 0 0 4px rgba(124,92,255,.15);
    }

    .tracking-result .toolbar{
      display:grid;
      grid-template-columns: 1.5fr .9fr .9fr .7fr;
      gap:12px;
      padding:14px;
      border:1px solid var(--stroke);
      background:linear-gradient(180deg, rgba(255,255,255,.85), rgba(248,248,255,.6));
      border-radius:var(--radius);
      box-shadow:var(--shadow);
      margin-bottom:18px;
    }
    .tracking-result .field{display:flex; flex-direction:column; gap:6px}
    .tracking-result .label{font-size:12px; color:var(--muted2)}
    .tracking-result .input, .tracking-result .select{
      height:40px;
      border-radius:12px;
      border:1px solid rgba(15,23,42,.16);
      background:#ffffff;
      color:var(--text);
      padding:0 12px;
      outline:none;
    }
    .tracking-result .input::placeholder{color:rgba(15,23,42,.35)}
    .tracking-result .actions{
      display:flex; gap:10px; align-items:flex-end; justify-content:flex-end;
    }
    .tracking-result .btn{
      height:40px;
      border-radius:12px;
      border:1px solid rgba(15,23,42,.16);
      padding:0 14px;
      display:inline-flex; align-items:center; gap:10px;
      cursor:pointer;
      background:#ffffff;
      color:var(--text);
      transition:.15s ease;
      user-select:none;
    }
    .tracking-result .btn:hover{transform:translateY(-1px); background:#f3f4ff}
    .tracking-result .btn.primary{
      border-color:rgba(124,92,255,.35);
      background:linear-gradient(90deg, rgba(124,92,255,.9), rgba(0,212,255,.65));
      box-shadow:0 10px 25px rgba(124,92,255,.25);
    }
    .tracking-result .btn.primary:hover{filter:brightness(1.05)}
    .tracking-result .btn .icon{
      width:18px; height:18px; display:inline-block;
      border-radius:6px;
      background:rgba(15,23,42,.08);
      position:relative;
    }
    .tracking-result .btn .icon::after{
      content:"";
      position:absolute; inset:5px 6px 5px 6px;
      border:2px solid rgba(15,23,42,.75);
      border-top-color:transparent;
      border-radius:999px;
      transform:rotate(45deg);
    }

    .tracking-result .grid{
      display:grid;
      grid-template-columns: 1fr 360px;
      gap:18px;
      align-items:start;
    }

    .tracking-result .notice{
      border:1px solid var(--stroke);
      background:#ffffff;
      padding:14px;
      border-radius:14px;
      color:var(--muted);
      box-shadow:var(--shadow2);
      margin-top:14px;
    }
    .tracking-result .notice.danger{
      border-color:rgba(239,68,68,.35);
      background:#fff5f5;
      color:#b91c1c;
    }

    .tracking-result .order{
      border:1px solid var(--stroke);
      background:linear-gradient(180deg, rgba(255,255,255,.95), rgba(248,248,255,.7));
      border-radius:var(--radius);
      box-shadow:var(--shadow);
      overflow:hidden;
    }
    .tracking-result .order.is-matched{
      border-color:rgba(34,197,94,.45);
      box-shadow:0 0 0 1px rgba(34,197,94,.2), var(--shadow);
    }
    .tracking-result .order + .order{margin-top:14px}

    .tracking-result .order-header{
      padding:16px 16px 14px;
      display:flex; gap:12px;
      align-items:flex-start; justify-content:space-between;
      border-bottom:1px solid rgba(15,23,42,.08);
      background:linear-gradient(180deg, rgba(248,248,255,.8), transparent);
    }
    .tracking-result .order-left{display:flex; flex-direction:column; gap:6px}
    .tracking-result .order-id{
      display:flex; align-items:center; gap:10px; flex-wrap:wrap;
      font-weight:650;
      letter-spacing:.2px;
    }
    .tracking-result .mono{font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;}
    .tracking-result .meta{
      display:flex; gap:14px; flex-wrap:wrap;
      color:var(--muted);
      font-size:13px;
    }
    .tracking-result .meta span{display:inline-flex; gap:6px; align-items:center}
    .tracking-result .pill{
      padding:7px 10px;
      border-radius:999px;
      border:1px solid rgba(15,23,42,.14);
      background:#ffffff;
      font-size:12px;
      color:var(--muted);
    }
    .tracking-result .badge{
      padding:7px 10px;
      border-radius:999px;
      font-size:12px;
      font-weight:650;
      border:1px solid rgba(15,23,42,.18);
      background:#ffffff;
      white-space:nowrap;
      text-transform:uppercase;
      letter-spacing:.3px;
    }
    .tracking-result .badge.success{color:#0b1b0f; background:rgba(34,197,94,.95); border-color:rgba(34,197,94,.55)}
    .tracking-result .badge.warning{color:#2a1b00; background:rgba(245,158,11,.95); border-color:rgba(245,158,11,.55)}
    .tracking-result .badge.danger{color:#22060a; background:rgba(239,68,68,.95); border-color:rgba(239,68,68,.55)}
    .tracking-result .badge.info{color:#081429; background:rgba(59,130,246,.95); border-color:rgba(59,130,246,.55)}

    .tracking-result .order-body{
      padding:16px;
      display:grid;
      grid-template-columns: 1.2fr .8fr;
      gap:14px;
    }
    .tracking-result .box{
      border:1px solid rgba(15,23,42,.10);
      background:#ffffff;
      border-radius:14px;
      padding:12px;
    }
    .tracking-result .box h3{
      margin:0 0 10px;
      font-size:13px;
      color:var(--muted);
      font-weight:650;
      letter-spacing:.3px;
      text-transform:uppercase;
      font-family: 'Open Sans', sans-serif;
    }
    .tracking-result .rows{
      display:grid;
      grid-template-columns: 1fr 1fr;
      gap:10px 12px;
    }
    .tracking-result .kv{
      display:flex; flex-direction:column; gap:4px;
      min-width:0;
    }
    .tracking-result .k{font-size:12px; color:var(--muted2)}
    .tracking-result .v{font-size:13px; color:var(--text); overflow:hidden; text-overflow:ellipsis; white-space:nowrap}
    .tracking-result .v strong{font-weight:750}

    .tracking-result .timeline{display:flex; flex-direction:column; gap:10px}
    .tracking-result .timeline::before{content:none}
    .tracking-result .step{
      display:grid;
      grid-template-columns: 18px 1fr;
      gap:10px;
      align-items:flex-start;
    }
    .tracking-result .line{
      position:relative;
      width:18px; display:flex; justify-content:center;
    }
    .tracking-result .line::before{
      content:"";
      position:absolute; top:16px; bottom:-10px;
      width:2px; background:rgba(15,23,42,.12);
    }
    .tracking-result .step:last-child .line::before{display:none}
    .tracking-result .bullet{
      width:10px; height:10px; border-radius:999px; margin-top:3px;
      background:rgba(15,23,42,.15);
      border:2px solid rgba(15,23,42,.25);
      box-shadow:0 0 0 6px rgba(124,92,255,.10);
    }
    .tracking-result .step.active .bullet{
      background:linear-gradient(90deg,var(--brand),var(--brand2));
      border-color:transparent;
      box-shadow:0 0 0 6px rgba(124,92,255,.22);
    }
    .tracking-result .step .content{
      border:1px solid rgba(15,23,42,.10);
      background:#ffffff;
      border-radius:14px;
      padding:10px 10px;
    }
    .tracking-result .step .top{
      display:flex; justify-content:space-between; gap:10px; flex-wrap:wrap;
      font-size:13px;
    }
    .tracking-result .step .top .t{font-weight:650}
    .tracking-result .step .top .d{color:var(--muted); font-size:12px}
    .tracking-result .step .sub{margin-top:6px; color:var(--muted); font-size:12px}

    .tracking-result .side{
      position:sticky; top:16px;
      display:flex; flex-direction:column; gap:14px;
    }
    .tracking-result .panel{
      border:1px solid var(--stroke);
      background:linear-gradient(180deg, rgba(255,255,255,.95), rgba(248,248,255,.7));
      border-radius:var(--radius);
      box-shadow:var(--shadow);
      padding:14px;
    }
    .tracking-result .panel h2{margin:0 0 12px; font-size:14px; color:var(--muted)}
    .tracking-result .mini{
      display:flex; flex-direction:column; gap:10px;
    }
    .tracking-result .mini .item{
      display:flex; align-items:center; justify-content:space-between; gap:10px;
      padding:10px 12px;
      border:1px solid rgba(15,23,42,.10);
      background:#ffffff;
      border-radius:14px;
      transition:.15s ease;
    }
    .tracking-result .mini .item:hover{transform:translateY(-1px); background:#f3f4ff}
    .tracking-result .mini .left{display:flex; flex-direction:column; gap:4px; min-width:0}
    .tracking-result .mini .left .title{font-size:13px; font-weight:650; overflow:hidden; text-overflow:ellipsis; white-space:nowrap}
    .tracking-result .mini .left .desc{font-size:12px; color:var(--muted); overflow:hidden; text-overflow:ellipsis; white-space:nowrap}

    .tracking-result .total{
      display:flex; align-items:flex-end; justify-content:space-between; gap:10px;
      padding:12px;
      border-radius:14px;
      border:1px solid rgba(124,92,255,.25);
      background:linear-gradient(90deg, rgba(124,92,255,.20), rgba(0,212,255,.10));
    }
    .tracking-result .total .label{color:var(--muted); font-size:12px}
    .tracking-result .total .amount{font-size:18px; font-weight:800}

    @media (max-width: 980px){
      .tracking-result .grid{grid-template-columns: 1fr}
      .tracking-result .side{position:static}
      .tracking-result .toolbar{grid-template-columns: 1fr 1fr; }
      .tracking-result .actions{grid-column:1 / -1; justify-content:flex-start}
    }
    @media (max-width: 560px){
      .tracking-result .toolbar{grid-template-columns: 1fr}
      .tracking-result .order-body{grid-template-columns:1fr}
      .tracking-result .rows{grid-template-columns:1fr}
      .tracking-result .page-title{flex-direction:column; align-items:flex-start}
    }
</style>

<body class="tracking-result-page">

<?php include(__DIR__ . '/../layouts/topbar.php'); ?>
<?php include(__DIR__ . '/../layouts/menu.php'); ?>

<div class="container-fluid bg-breadcrumb">
  <div class="container text-center py-5" style="max-width:900px;">
    <h3 class="display-7 mb-4 wow fadeInDown" data-wow-delay="0.1s">
      <?= t('tracking_result_title') ?>
    </h3>
    <ol class="breadcrumb justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
      <li class="breadcrumb-item"><a href="homepage.php"><?= t('home') ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?= t('pages') ?></a></li>
      <li class="breadcrumb-item active text-black"><?= t('tracking_result_title') ?></li>
    </ol>
  </div>
</div>

<div class="container-fluid appointment py-5" id="tracking-result">
  <div class="container py-5">
    <div class="row g-5 align-items-center">
      <div class="col-lg-12 wow fadeInRight" data-wow-delay="0.4s">
        <div class="appointment-form rounded p-5 tracking-result">
          <div class="wrap">
            <div class="page-title">
              <div>
                <h1><?= t('tracking_result_title') ?></h1>
                <p><?= t('tracking_result_subtitle') ?></p>
              </div>
              <div class="chip"><span class="dot"></span> <?= t('tracking_result_last_sync') ?> : <?= htmlspecialchars($lastSyncLabel) ?></div>
            </div>

            <form aria-label="Filtres" method="get" action="tracking-result.php">
              <div class="form-intro bg-light rounded-4 p-4 mb-4 d-flex flex-wrap align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                  <div class="pill pill-primary"><?= t('tracking_parcel') ?></div>
                  <div class="text-muted small">
                    <span class="me-3"><i class="fa fa-check-circle text-success me-1"></i><?= t('tracking_result_tracking_label') ?></span>
                    <span class="me-3"><i class="fa fa-check-circle text-success me-1"></i><?= t('tracking_filter_status') ?></span>
                    <span><i class="fa fa-check-circle text-success me-1"></i><?= t('tracking_result_status_history') ?></span>
                  </div>
                </div>
                <div class="chip-badge">
                  <i class="fa fa-bolt me-2"></i><?= t('communication_card_tracking_highlight') ?>
                </div>
              </div>

              <div class="toolbar">
                <div class="field">
                  <div class="label"><?= t('tracking_filter_search') ?></div>
                  <input class="input" name="tracking_number" placeholder="<?= t('tracking_placeholder') ?>"
                         value="<?= htmlspecialchars($trackingNumber) ?>" />
                </div>
                <div class="field">
                  <div class="label"><?= t('tracking_filter_status') ?></div>
                  <select class="select" name="status">
                    <option value="all" <?= $selectedStatus === 'all' ? 'selected' : '' ?>><?= t('tracking_filter_all') ?></option>
                    <option value="pending" <?= $selectedStatus === 'pending' ? 'selected' : '' ?>><?= t('tracking_filter_pending') ?></option>
                    <option value="in_progress" <?= $selectedStatus === 'in_progress' ? 'selected' : '' ?>><?= t('tracking_filter_in_progress') ?></option>
                    <option value="delivered" <?= $selectedStatus === 'delivered' ? 'selected' : '' ?>><?= t('tracking_filter_delivered') ?></option>
                    <option value="cancelled" <?= $selectedStatus === 'cancelled' ? 'selected' : '' ?>><?= t('tracking_filter_cancelled') ?></option>
                  </select>
                </div>
                <div class="field">
                  <div class="label"><?= t('tracking_filter_period') ?></div>
                  <select class="select" name="period">
                    <option value="30d" <?= $selectedPeriod === '30d' ? 'selected' : '' ?>><?= t('tracking_filter_30_days') ?></option>
                    <option value="3m" <?= $selectedPeriod === '3m' ? 'selected' : '' ?>><?= t('tracking_filter_3_months') ?></option>
                    <option value="year" <?= $selectedPeriod === 'year' ? 'selected' : '' ?>><?= t('tracking_filter_year') ?></option>
                    <option value="all" <?= $selectedPeriod === 'all' ? 'selected' : '' ?>><?= t('tracking_filter_all_time') ?></option>
                  </select>
                </div>
                <div class="actions">
                  <a class="btn" href="tracking-result.php"><span class="icon"></span> <?= t('tracking_filter_reset') ?></a>
                  <button class="btn primary" type="submit"><?= t('tracking_filter_apply') ?></button>
                </div>
              </div>
            </form>

            <?php if (!empty($error)): ?>
              <div class="notice danger"><?= htmlspecialchars($error) ?></div>
            <?php elseif (!$trackingData): ?>
              <div class="notice"><?= t('tracking_result_prompt') ?></div>
            <?php else: ?>
              <div class="grid">
        <main>
          <?php if (empty($shipments)): ?>
            <div class="notice"><?= t('tracking_result_no_shipments') ?></div>
          <?php else: ?>
            <?php foreach ($shipments as $shipment): ?>
              <?php
              $history = $controller->getShipmentStatusHistory($shipment['id']);
              $isMatched = ($shipment['tracking_reference'] ?? '') === $searchedTracking;
              $statusLabel = $getStatusLabel($shipment['status_code'] ?? '');
              $badgeClass = $getBadgeClass($shipment['status_code'] ?? '');
              ?>
              <article class="order <?= $isMatched ? 'is-matched' : '' ?>">
                <header class="order-header">
                  <div class="order-left">
                    <div class="order-id">
                      <span><?= t('tracking_order_label') ?></span>
                      <span class="mono">#<?= htmlspecialchars($shipment['tracking_reference'] ?? '-') ?></span>
                      <?php if (!empty($customer['customer_id'])): ?>
                        <span class="pill"><?= t('tracking_result_customer_id') ?> : <?= htmlspecialchars($customer['customer_id']) ?></span>
                      <?php endif; ?>
                    </div>
                    <div class="meta">
                      <span>📅 <span><?= t('created_at_label') ?> : <?= htmlspecialchars($formatDateTime($shipment['created_at'] ?? null)) ?></span></span>
                      <span>🚚 <span><?= t('destination_label') ?> : <?= htmlspecialchars($shipment['destination'] ?? '-') ?></span></span>
                      <span>🧭 <span><?= t('origin_label') ?> : <?= htmlspecialchars($shipment['origin'] ?? '-') ?></span></span>
                    </div>
                  </div>
                  <div class="badge <?= $badgeClass ?>"><?= htmlspecialchars($uppercase($statusLabel)) ?></div>
                </header>

                <div class="order-body">
                  <section class="box">
                    <h3><?= t('tracking_result_details') ?></h3>
                    <div class="rows">
                      <div class="kv">
                        <div class="k"><?= t('full_name') ?></div>
                        <div class="v"><strong><?= htmlspecialchars($customer['full_name'] ?? '-') ?></strong></div>
                      </div>
                      <div class="kv">
                        <div class="k"><?= t('email') ?></div>
                        <div class="v"><?= htmlspecialchars($customer['email'] ?? '-') ?></div>
                      </div>
                      <div class="kv">
                        <div class="k"><?= t('phone') ?></div>
                        <div class="v"><?= htmlspecialchars($customer['phone'] ?? '-') ?></div>
                      </div>
                      <div class="kv">
                        <div class="k"><?= t('tracking_result_tracking_label') ?></div>
                        <div class="v mono"><?= htmlspecialchars($shipment['tracking_reference'] ?? '-') ?></div>
                      </div>
                      <div class="kv">
                        <div class="k"><?= t('updated_at_label') ?></div>
                        <div class="v"><?= htmlspecialchars($formatDateTime($shipment['updated_at'] ?? null)) ?></div>
                      </div>
                      <div class="kv">
                        <div class="k"><?= t('description_label') ?></div>
                        <div class="v"><?= htmlspecialchars($shipment['description'] ?: '-') ?></div>
                      </div>
                      <div class="kv">
                        <div class="k"><?= t('comment_label') ?></div>
                        <div class="v"><?= htmlspecialchars($shipment['comment'] ?: '-') ?></div>
                      </div>
                      <div class="kv">
                        <div class="k"><?= t('address') ?></div>
                        <div class="v"><?= htmlspecialchars($customer['address'] ?? '-') ?></div>
                      </div>
                    </div>
                  </section>

                  <section class="box">
                    <h3><?= t('tracking_result_status_history') ?></h3>
                    <div class="timeline">
                      <?php if (!empty($history)): ?>
                        <?php foreach ($history as $index => $event): ?>
                          <?php
                          $eventLabel = $getStatusLabel($event['status_code'] ?? '');
                          $eventDate = $formatDateTime($event['created_at'] ?? null);
                          $note = $event['notes'] ?? '';
                          if ($note === '' && !empty($event['created_by_name'])) {
                              $note = t('tracking_result_by') . ' ' . $event['created_by_name'];
                          }
                          if ($note === '') {
                              $note = t('tracking_result_status_update');
                          }
                          ?>
                          <div class="step <?= $index === 0 ? 'active' : '' ?>">
                            <div class="line"><span class="bullet"></span></div>
                            <div class="content">
                              <div class="top"><span class="t"><?= htmlspecialchars($eventLabel) ?></span><span class="d"><?= htmlspecialchars($eventDate) ?></span></div>
                            </div>
                          </div>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <div class="step active">
                          <div class="line"><span class="bullet"></span></div>
                          <div class="content">
                            <div class="top"><span class="t"><?= t('tracking_result_no_history') ?></span><span class="d">—</span></div>
                         
                          </div>
                        </div>
                      <?php endif; ?>
                    </div>
                  </section>
                </div>
              </article>
            <?php endforeach; ?>
          <?php endif; ?>
        </main>

        <aside class="side">
          <section class="panel">
            <h2><?= t('tracking_result_summary_title') ?></h2>
            <div class="total">
              <div>
                <div class="label"><?= t('tracking_result_total_shipments') ?></div>
                <div class="muted" style="color:var(--muted); font-size:12px; margin-top:4px;"><?= t('tracking_result_period_all') ?></div>
              </div>
              <div class="amount"><?= count($shipments) ?></div>
            </div>
            <div style="height:12px"></div>
            <div class="mini">
              <div class="item">
                <div class="left">
                  <div class="title"><?= t('tracking_filter_pending') ?></div>
                  <div class="desc"><?= t('tracking_summary_pending_desc') ?></div>
                </div>
                <span class="badge warning"><?= $statusCounts['pending'] ?></span>
              </div>
              <div class="item">
                <div class="left">
                  <div class="title"><?= t('tracking_filter_in_progress') ?></div>
                  <div class="desc"><?= t('tracking_summary_in_progress_desc') ?></div>
                </div>
                <span class="badge info"><?= $statusCounts['in_progress'] ?></span>
              </div>
              <div class="item">
                <div class="left">
                  <div class="title"><?= t('tracking_filter_delivered') ?></div>
                  <div class="desc"><?= t('tracking_summary_delivered_desc') ?></div>
                </div>
                <span class="badge success"><?= $statusCounts['delivered'] ?></span>
              </div>
              <div class="item">
                <div class="left">
                  <div class="title"><?= t('tracking_filter_cancelled') ?></div>
                  <div class="desc"><?= t('tracking_summary_cancelled_desc') ?></div>
                </div>
                <span class="badge danger"><?= $statusCounts['cancelled'] ?></span>
              </div>
            </div>
          </section>

          <section class="panel">
            <h2><?= t('tracking_result_quick_actions') ?></h2>
            <div class="mini">
              <a class="item" href="homepage.php#tracking">
                <div class="left">
                  <div class="title"><?= t('tracking_result_action_new_tracking') ?></div>
                  <div class="desc"><?= t('tracking_result_action_new_tracking_desc') ?></div>
                </div>
                <span class="pill"><?= t('tracking_filter_apply') ?></span>
              </a>
              <a class="item" href="contact.php">
                <div class="left">
                  <div class="title"><?= t('tracking_result_action_contact') ?></div>
                  <div class="desc"><?= t('tracking_result_action_contact_desc') ?></div>
                </div>
                <span class="pill"><?= t('tracking_result_action_contact_short') ?></span>
              </a>
            </div>
          </section>
        </aside>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include(__DIR__ . '/../layouts/footer.php'); ?>
<a href="#" class="btn btn-primary btn-lg-square back-to-top"><i class="fa fa-arrow-up"></i></a>
<?php include(__DIR__ . '/../layouts/js.php'); ?>

</body>
</html>
