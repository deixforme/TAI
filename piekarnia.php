<?php
$mysqli = @mysqli_connect("localhost", "root", "", "piekarnia");
if (!$mysqli) { die("Błąd połączenia z bazą danych."); }

$rodzaje = [];
$q2 = "SELECT DISTINCT Rodzaj FROM wyroby ORDER BY Rodzaj DESC;";
if ($res = mysqli_query($mysqli, $q2)) {
  while ($row = mysqli_fetch_row($res)) { $rodzaje[] = $row[0]; }
  mysqli_free_result($res);
}

$wybrane_rodzaj = isset($_POST['rodzaj']) ? $_POST['rodzaj'] : null;
$wyniki = [];
if ($wybrane_rodzaj22 !== null && $wybrane_rodzaj !== "") {
  $rodzajEsc = mysqli_real_escape_string($mysqli, $wybrane_rodzaj);
  $q1 = "SELECT Rodzaj, Nazwa, Gramatura, Cena FROM wyroby WHERE Rodzaj = '$rodzajEsc';";
  if ($res = mysqli_query($mysqli, $q1)) {
    while ($row = mysqli_fetch_row($res)) { $wyniki[] = $row; }
    mysqli_free_result($res);
  }
}
mysqli_close($mysqli);

$akapit = "Gorąco Polecam. Smaki z piekarni to sieć piekarnio-kawiarni z lokalami na terenie całej Polski. Znajdziesz nas w dużych i średnich miastach: w biurowcach, galeriach handlowych, dworcach, osiedlach mieszkaniowych.";
?>
<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="utf-8">
<title>GORĄCO POLECAM</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>
<img src="wypieki.png" alt="Produkty naszej piekarni" class="tlo">
<nav>
  <a href="kw1.png" target="_blank">KWERENDA1</a>
  <a href="kw2.png" target="_blank">KWERENDA2</a>
  <a href="kw3.png" target="_blank">KWERENDA3</a>
  <a href="kw4.png" target="_blank">KWERENDA4</a>
</nav>
<header>
  <h1>WITAMY</h1>
  <h4>NA STRONIE GORĄCO POLECAM</h4>
  <p><?php echo $akapit; ?></p>
</header>
<main>
  <h4>Wybierz rodzaj wypieków:</h4>
  <form method="POST" action="piekarnia.php" class="formularz">
    <select name="rodzaj">
      <option value="">-- wybierz --</option>
      <?php foreach ($rodzaje as $rodzaj): ?>
        <option value="<?php echo htmlspecialchars($rodzaj); ?>" <?php echo ($wybrane_rodzaj===$rodzaj)?'selected':''; ?>>
          <?php echo htmlspecialchars($rodzaj); ?>
        </option>
      <?php endforeach; ?>
    </select>
    <button type="submit">Wybierz</button>
  </form>
  <table>
    <tr><th>Rodzaj</th><th>Nazwa</th><th>Gramatura kg</th><th>Cena zl</th></tr>
    <?php if (!empty($wyniki)): foreach ($wyniki as $w): ?>
      <tr>
        <td><?php echo htmlspecialchars($w[0]); ?></td>
        <td><?php echo htmlspecialchars($w[1]); ?></td>
        <td><?php echo htmlspecialchars($w[2]); ?></td>
        <td><?php echo htmlspecialchars(number_format($w[3], 2)); ?></td>
      </tr>
    <?php endforeach; endif; ?>
  </table>
</main>
<footer>
  <p><strong>AUTOR:</strong> Denys Dembitskyi</p>
  <p><strong>Data:</strong> 18.04.2026</p>
</footer>
</body>
</html>
