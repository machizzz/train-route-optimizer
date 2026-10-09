<!DOCTYPE html>
<html lang="pl">
<head>

    <meta charset="UTF-8">

    <title>Optymalizator Tras Kolejowych</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    
    body {
        background: linear-gradient(135deg, #f6f8fd 0%, #f1f5f9 100%);
        min-height: 100vh;
        color: #2c3e50;
    }

    
    h1, h2 {
        font-weight: 800;
        letter-spacing: -0.5px;
        color: #1e293b;
    }

    
    .card {
        border: none !important;
        border-radius: 24px !important;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.04) !important;
        background: rgba(255, 255, 255, 0.85) !important;
        backdrop-filter: blur(10px);
    }

    
    .form-select {
        border-radius: 12px;
        border: 2px solid #e2e8f0;
        padding: 0.75rem 1rem;
        box-shadow: none !important;
        transition: all 0.3s ease;
    }
    
    .form-select:focus {
        border-color: #3b82f6;
        background-color: #f8fafc;
    }

    
    .btn {
        border-radius: 12px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
    }

    .btn-outline-secondary {
        background: #f1f5f9;
        color: #64748b;
    }

    .btn-outline-secondary:hover {
        background: #e2e8f0;
        color: #0f172a;
        transform: translateY(-2px);
    }

    
    .table-responsive {
        background: white;
        border-radius: 20px;
        padding: 10px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.03);
    }

    
    table.table {
        margin-bottom: 0;
        border-color: #f1f5f9;
    }
    
    .table-dark, .table-secondary {
        background-color: transparent !important;
    }
    
    .table-dark th, .table-secondary th {
        background-color: #f8fafc !important;
        color: #64748b !important;
        font-weight: 600;
        border-bottom: 2px solid #e2e8f0;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    .badge {
        padding: 0.6em 1em;
        border-radius: 10px;
        font-weight: 600;
    }
</style>

</head>
<div class="container mt-5">
    <h1 class="mb-4">Zaplanuj podróż</h1>

    <div class="card shadow-sm mb-5">
        <div class="card-body">
<form action="" method="GET" class="row g-3 align-items-end">
    <div class="col-md-4">
        <label for="start" class="form-label">Wybierz stację początkową:</label>
        <select name="start" id="start" class="form-select">
            <?php foreach ($stations as $station): ?>
                <option value="<?= $station['id'] ?>" <?= (isset($_GET['start']) && $_GET['start'] == $station['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($station['name']) ?> (<?= htmlspecialchars($station['country']) ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-md-4">
        <label for="end" class="form-label">Wybierz stację końcową:</label>
        <select name="end" id="end" class="form-select">
            <?php foreach ($stations as $station): ?>
                <option value="<?= $station['id'] ?>" <?= (isset($_GET['end']) && $_GET['end'] == $station['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($station['name']) ?> (<?= htmlspecialchars($station['country']) ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-md-4 d-flex gap-2">
        <button type="submit" class="btn btn-primary w-100">Szukaj tras</button>
        <a href="index.php" class="btn btn-outline-secondary w-100">Wyczyść</a>
    </div>
</form>
        </div>
    </div>

    <?php if ($routes !== null): ?>
        
        <?php if (count($routes) > 0): ?>

            <h2 class="mb-3">Bezpośrednie trasy:</h2>
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>Stacja początkowa</th>
                            <th>Stacja końcowa</th>
                            <th>Czas odjazdu</th>
                            <th>Czas przyjazdu</th>
                            <th>Cena biletu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($routes as $route): ?>
                            <tr>
                                <td><?= htmlspecialchars($route['start_station_name']) ?></td>
                                <td><?= htmlspecialchars($route['end_station_name']) ?></td>
                                <td><?= htmlspecialchars($route['departure_time']) ?></td>
                                <td><?= htmlspecialchars($route['arrival_time']) ?></td>
                                <td><strong><?= htmlspecialchars($route['price']) ?> PLN</strong></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php elseif ($transferRoutes !== null && count($transferRoutes) > 0): ?>

            <h2 class="mb-3">Trasy z jedną przesiadką:</h2>
<div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead class="table-secondary">
                        <tr>
                            <th>Start</th>
                            <th>Odjazd (Etap 1)</th>
                            <th>Przyjazd (Etap 1)</th>
                            <th>Stacja przesiadkowa</th>
                            <th>Czas na przesiadkę</th>
                            <th>Odjazd (Etap 2)</th>
                            <th>Przyjazd (Etap 2)</th>
                            <th>Koniec</th>
                            <th>Łączna cena</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transferRoutes as $route): ?>
                            <tr>
                                <td><?= htmlspecialchars($route['start_station_name']) ?></td>
                                <td><?= htmlspecialchars($route['leg1_departure']) ?></td>
                                <td><?= htmlspecialchars($route['leg1_arrival']) ?></td>
                                <td><strong><?= htmlspecialchars($route['transfer_station_name']) ?></strong></td>
                                <td><span class="badge bg-info text-dark fs-6"><?= htmlspecialchars($route['transfer_time']) ?></span></td>
                                <td><?= htmlspecialchars($route['leg2_departure']) ?></td>
                                <td><?= htmlspecialchars($route['leg2_arrival']) ?></td>
                                <td><?= htmlspecialchars($route['end_station_name']) ?></td>
                                <td><strong><?= htmlspecialchars($route['total_price']) ?> PLN</strong></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php else: ?>
            <!-- Brak jakichkolwiek tras -->
            <div class="alert alert-warning" role="alert">
                Niestety, nie znaleziono żadnych połączeń (ani bezpośrednich, ani z przesiadką) na wybranej trasie.
            </div>
        <?php endif; ?>

    <?php endif; ?>
</div>
</html>