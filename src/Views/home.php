<!DOCTYPE html>
<html lang="pl">
<head>

    <meta charset="UTF-8">

    <title>Optymalizator Tras Kolejowych</title>

    <style>
        body { font-family: sans-serif; padding: 20px; }
        select, button { padding: 10px; margin-top: 10px; }
    </style>

</head>
<body>

    <h1>Zaplanuj podróż</h1>

    <form action="" method="GET">

        <label for="start">Wybierz stację początkową:</label><br>

        <select name="start" id="start">
             <?php foreach ($stations as $station): ?>
                 <option value="<?= $station['id'] ?>" <?= (isset($_GET['start']) && $_GET['start'] == $station['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($station['name']) ?> (<?= htmlspecialchars($station['country']) ?>)
                </option>
            <?php endforeach; ?>
        </select> <br>

        <br>

        <label for="end">Wybierz stację końcową:</label><br>

        <select name="end" id="end">
            <?php foreach ($stations as $station): ?>
             <option value="<?= $station['id'] ?>" <?= (isset($_GET['end']) && $_GET['end'] == $station['id']) ? 'selected' : '' ?>>
                 <?= htmlspecialchars($station['name']) ?> (<?= htmlspecialchars($station['country']) ?>)
             </option>
            <?php endforeach; ?>
        </select> <br>

        <button type="submit">Szukaj tras</button>

    </form>

    <hr>

<?php if ($routes !== null): ?>
    <h2>Wyniki wyszukiwania:</h2>
    
    <?php if (count($routes) > 0): ?>
        <table border="1" cellpadding="10" style="border-collapse: collapse;">
            <tr>
                <th>Stacja początkowa</th>
                <th>Stacja końcowa</th>
                <th>Czas odjazdu</th>
                <th>Czas przyjazdu</th>
                <th>Cena biletu (PLN)</th>
            </tr>

            <?php foreach ($routes as $route): ?>
                <tr>
                    <td><?= htmlspecialchars($route['price']) ?></td>
                    <td><?= htmlspecialchars($route['price']) ?></td>
                    <td><?= htmlspecialchars($route['departure_time']) ?></td>
                    <td><?= htmlspecialchars($route['arrival_time']) ?></td>
                    <td><?= htmlspecialchars($route['price']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Niestety, nie znaleziono żadnych bezpośrednich połączeń na wybranej trasie.</p>
    <?php endif; ?>
<?php endif; ?>

</body>
</html>