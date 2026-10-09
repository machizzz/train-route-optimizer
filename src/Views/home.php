<!DOCTYPE html>
<html lang="pl">
<head>

    <meta charset="UTF-8">

    <title>Optymalizator Tras Kolejowych</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<div class="container mt-5">
    <h1 class="mb-4">Zaplanuj podróż</h1>

    <!-- Formularz w stylu karty -->
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

    <!-- Tabela wyników -->
    <?php if ($routes !== null): ?>
        <h2 class="mb-3">Wyniki wyszukiwania:</h2>
        
        <?php if (count($routes) > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover table-bordered shadow-sm">
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
        <?php else: ?>
            <div class="alert alert-warning" role="alert">
                Niestety, nie znaleziono żadnych bezpośrednich połączeń na wybranej trasie.
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
</html>