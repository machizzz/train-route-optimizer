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
                <option value="<?= $station['id'] ?>">
                    <?= htmlspecialchars($station['name']) ?> (<?= htmlspecialchars($station['country']) ?>)
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Szukaj tras</button>
    </form>
</body>
</html>