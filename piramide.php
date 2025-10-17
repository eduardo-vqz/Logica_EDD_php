<?php
$resultado = null;
$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $filas = $_POST['filas'] ?? '';
    $simbolo = $_POST['simbolo'] ?? '*';

    if ($filas === '' || !ctype_digit($filas) || (int)$filas < 1 || (int)$filas > 50) {
        $errores[] = 'Ingrese un número de filas entero entre 1 y 50.';
    }
    if ($simbolo === '') {
        $simbolo = '*';
    } elseif (mb_strlen($simbolo, 'UTF-8') > 2) {
        $errores[] = 'Use 1 símbolo (máximo 2 bytes UTF-8).';
    }

    if (!$errores) {
        $n = (int)$filas;
        $lineas = [];
        for ($i = 1; $i <= $n; $i++) {
            $espacios = $n - $i;
            $asteriscos = (2 * $i) - 1;
            $lineas[] = str_repeat(' ', $espacios) . str_repeat($simbolo, $asteriscos);
        }
        $resultado = implode("\n", $lineas);
    }
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Pirámide (Bucles Anidados)</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="Css/styles.css">
</head>
<body>
  <div class="container">
    <div class="center">
      <h1>4) Pirámide (Bucles Anidados)</h1>
      <a class="btn secondary inline" href="index.html">Volver</a>
    </div>
    <p class="muted">Genera una pirámide centrada usando bucles anidados.</p>

    <div class="card">
      <form method="post" novalidate>
        <label for="filas">Filas (1–50):</label>
        <input type="number" id="filas" name="filas" min="1" max="50"
          value="<?= isset($_POST['filas']) ? htmlspecialchars((string)$_POST['filas']) : '5' ?>">

        <label for="simbolo">Símbolo (opcional, por defecto *):</label>
        <input type="text" id="simbolo" name="simbolo" maxlength="2"
          value="<?= isset($_POST['simbolo']) ? htmlspecialchars($_POST['simbolo']) : '*' ?>">

        <div class="form-actions">
          <button class="btn" type="submit">Procesar</button>
          <a class="btn secondary" href="piramide.php">Limpiar</a>
        </div>
      </form>

      <?php if ($errores): ?>
        <div class="alert error">
          <strong>Errores:</strong>
          <ul><?php foreach ($errores as $e): ?><li><?= $e ?></li><?php endforeach; ?></ul>
        </div>
      <?php endif; ?>

      <?php if ($resultado !== null && !$errores): ?>
        <h3 class="spaced">Resultado</h3>
        <pre><?= htmlspecialchars($resultado) ?></pre>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
