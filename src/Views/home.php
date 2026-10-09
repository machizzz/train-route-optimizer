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
<form action="" method="GET" class="row g-3">

    <div id="stops-container" class="col-12">
        

        <div class="row g-3 align-items-end mb-2 stop-row">
            <div class="col-md-10">
                <label class="form-label stop-label">Przystanek 1:</label>
                <select name="stops[]" class="form-select">
                    <?php foreach ($stations as $station): ?>
                        <option value="<?= $station['id'] ?>"><?= htmlspecialchars($station['name']) ?> (<?= htmlspecialchars($station['country']) ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>


        <div class="row g-3 align-items-end mb-2 stop-row">
            <div class="col-md-10">
                <label class="form-label stop-label">Przystanek 2:</label>
                <select name="stops[]" class="form-select">
                    <?php foreach ($stations as $station): ?>
                        <option value="<?= $station['id'] ?>"><?= htmlspecialchars($station['name']) ?> (<?= htmlspecialchars($station['country']) ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        
    </div>


    <div class="col-12 mt-4">
        <div class="d-flex gap-2">
            <button type="button" id="add-stop-btn" class="btn btn-outline-primary">+ Dodaj kolejny przystanek</button>
            <button type="submit" class="btn btn-primary flex-grow-1">Szukaj całej trasy</button>
            <a href="index.php" class="btn btn-outline-secondary">Wyczyść</a>
        </div>
    </div>
</form>

<script>
    document.getElementById('add-stop-btn').addEventListener('click', function() {
        const container = document.getElementById('stops-container');
        const rows = container.getElementsByClassName('stop-row');
        const newStopNumber = rows.length + 1;

        const newRow = rows[0].cloneNode(true);
        newRow.querySelector('.stop-label').textContent = 'Przystanek ' + newStopNumber + ':';
        container.appendChild(newRow);
    });
</script>

        </div>
    </div>

<!-- Sekcja wyników -->
    <?php if ($searchPerformed): ?>
        <h2 class="mb-3 mt-4">Plan Twojej podróży:</h2>

        <?php if (!empty($journeySegments)): ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead class="table-secondary">
                        <tr>
                            <th>Typ odcinka</th>
                            <th>Od</th>
                            <th>Do</th>
                            <th>Godziny</th>
                            <th>Cena</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($journeySegments as $segment): ?>
                            <?php if ($segment['type'] === 'direct'): ?>
                                <tr>
                                    <td><span class="badge bg-success">Bezpośredni</span></td>
                                    <td><?= htmlspecialchars($segment['data']['start_station_name']) ?></td>
                                    <td><?= htmlspecialchars($segment['data']['end_station_name']) ?></td>
                                    <td><?= htmlspecialchars($segment['data']['departure_time']) ?> → <?= htmlspecialchars($segment['data']['arrival_time']) ?></td>
                                    <td><strong><?= htmlspecialchars($segment['data']['price']) ?> PLN</strong></td>
                                </tr>
                            <?php elseif ($segment['type'] === 'transfer'): ?>
                                <tr>
                                    <td><span class="badge bg-warning text-dark">Przesiadka (<?= htmlspecialchars($segment['data']['transfer_station_name']) ?>)</span></td>
                                    <td><?= htmlspecialchars($segment['data']['start_station_name']) ?></td>
                                    <td><?= htmlspecialchars($segment['data']['end_station_name']) ?></td>
                                    <td><?= htmlspecialchars($segment['data']['leg1_departure']) ?> → <?= htmlspecialchars($segment['data']['leg2_arrival']) ?></td>
                                    <td><strong><?= htmlspecialchars($segment['data']['total_price']) ?> PLN</strong></td>
                                </tr>
                            <?php else: ?>
                                <tr>
                                    <td><span class="badge bg-danger">Brak połączenia</span></td>
                                    <td colspan="4" class="text-muted">Nie znaleziono trasy między wybranymi przystankami w tym odcinku.</td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="alert alert-info mt-3 text-end">
                <h4 class="mb-0">Łączny koszt podróży: <strong><?= $totalPrice ?> PLN</strong></h4>
            </div>

        <?php else: ?>
            <div class="alert alert-warning" role="alert">
                Wprowadź co najmniej dwa różne przystanki, aby zaplanować podróż.
            </div>
        <?php endif; ?>

    <?php endif; ?>
</div>
</html>