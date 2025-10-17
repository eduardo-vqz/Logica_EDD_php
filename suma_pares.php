<?php
$resultado = null;
$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entrada = trim($_POST['numeros'] ?? '');
    if ($entrada === '') {
        $errores[] = 'Ingrese una lista de enteros separados por coma.';
    } else {
        $partes = array_map('trim', explode(',', $entrada));
        foreach ($partes as $i => $p) {
            if (!preg_match('/^[+-]?\d+$/', $p)) {
                $errores[] = "Valor no entero en la posición ".($i+1).": «".htmlspecialchars($p)."».";
            }
        }
        if (!$errores) {
            $suma = 0;
            foreach ($partes as $p) {
                $n = (int)$p;
                if ($n % 2 === 0) $suma += $n;
            }
            $resultado = $suma;
        }
    }
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Suma de Números Pares</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="Css/styles.css">
</head>
<body>
  <div class="container">
    <div class="center">
      <h1>2) Suma de Números Pares</h1>
      <a class="btn secondary inline" href="index.html">Volver</a>
    </div>
    <p class="muted">Ingrese enteros separados por coma; se sumarán los pares.</p>

    <div class="card">
      <form method="post" novalidate>
        <label for="numeros">Enteros (ej: 2, 7, 8, 10, 3):</label>
        <input type="text" id="numeros" name="numeros"
          value="<?= isset($_POST['numeros']) ? htmlspecialchars($_POST['numeros']) : '2, 7, 8, 10, 3' ?>">

        <div class="form-actions">
          <button class="btn" type="submit">Procesar</button>
          <a class="btn secondary" href="suma_pares.php">Limpiar</a>
        </div>
      </form>

      <?php if ($errores): ?>
        <div class="alert error">
          <strong>Errores:</strong>
          <ul><?php foreach ($errores as $e): ?><li><?= $e ?></li><?php endforeach; ?></ul>
        </div>
      <?php endif; ?>

      <?php if ($resultado !== null && !$errores): ?>
        <div class="alert success">
          <strong>Resultado:</strong>
          <p>La suma de números pares es: <code><?= htmlspecialchars((string)$resultado) ?></code></p>
        </div>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
