<?php
$resultado = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $texto = $_POST['texto'] ?? '';
    $texto = str_replace(["\r\n", "\r"], "\n", $texto);

    // Soporte UTF-8: dividir en caracteres Unicode
    $chars = preg_split('//u', $texto, -1, PREG_SPLIT_NO_EMPTY);
    if ($chars !== false) {
        $conteo = array_count_values($chars);
        ksort($conteo, SORT_NATURAL);
        $resultado = $conteo;
    } else {
        $resultado = [];
    }
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Frecuencia de Caracteres</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="Css/styles.css">
</head>
<body>
  <div class="container">
    <div class="center">
      <h1>3) Frecuencia de Caracteres</h1>
      <a class="btn secondary inline" href="index.html">Volver</a>
    </div>
    <p class="muted">Ingresa un texto; se calculará la frecuencia de cada carácter (soporta tildes y emojis).</p>

    <div class="card">
      <form method="post">
        <label for="texto">Texto:</label>
        <textarea id="texto" name="texto" placeholder="Escribe aquí..."><?= isset($_POST['texto']) ? htmlspecialchars($_POST['texto']) : 'programar' ?></textarea>

        <div class="form-actions">
          <button class="btn" type="submit">Procesar</button>
          <a class="btn secondary" href="frecuencia_caracteres.php">Limpiar</a>
        </div>
      </form>

      <?php if ($resultado !== null): ?>
        <h3 class="spaced">Resultado</h3>
        <?php if (empty($resultado)): ?>
          <div class="alert error"><em>No hay caracteres que contar.</em></div>
        <?php else: ?>
          <div class="spaced">
            <table>
              <thead><tr><th>Carácter</th><th>Frecuencia</th></tr></thead>
              <tbody>
              <?php foreach ($resultado as $car => $freq): ?>
                <tr>
                  <td><code><?= htmlspecialchars($car) ?></code></td>
                  <td><?= (int)$freq ?></td>
                </tr>
              <?php endforeach; ?>
              </tbody>
            </table>
            <p class="muted">Total de caracteres: <?= array_sum($resultado) ?></p>
          </div>
        <?php endif; ?>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
