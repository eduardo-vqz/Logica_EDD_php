<?php
// Procesamiento
$resultado = null;
$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entrada = trim($_POST['numeros'] ?? '');
    if ($entrada === '') {
        $errores[] = 'Ingrese una lista de números separados por coma.';
    } else {
        $partes = array_map('trim', explode(',', $entrada));
        foreach ($partes as $i => $p) {
            if ($p === '' || !preg_match('/^[+-]?\d+(\.\d+)?$/', $p)) {
                $errores[] = "Valor inválido en la posición ".($i+1).": «".htmlspecialchars($p)."».";
            }
        }
        if (!$errores) {
            $resultado = array_reverse($partes);
        }
    }
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Lista Invertida</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="Css/styles.css">
</head>
<body>
  <div class="container">
    <div class="center">
      <h1>1) Lista Invertida</h1>
      <a class="btn secondary inline" href="index.html">Volver</a>
    </div>
    <p class="muted">Ingrese números separados por coma y obtenga la lista en orden inverso.</p>

    <div class="card">
      <form method="post" novalidate>
        <label for="numeros">Números (ej: 1, 2, 3, 4, 5):</label>
        <input type="text" id="numeros" name="numeros"
          value="<?= isset($_POST['numeros']) ? htmlspecialchars($_POST['numeros']) : '1, 2, 3, 4, 5' ?>">

        <div class="form-actions">
          <button class="btn" type="submit">Procesar</button>
          <a class="btn secondary" href="lista_invertida.php">Limpiar</a>
        </div>
      </form>

      <?php if ($errores): ?>
        <div class="alert error">
          <strong>Errores:</strong>
          <ul>
            <?php foreach ($errores as $e): ?><li><?= $e ?></li><?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <?php if ($resultado !== null): ?>
        <div class="alert success">
          <strong>Resultado (invertida):</strong>
          <pre><?php print_r($resultado); ?></pre>
        </div>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
