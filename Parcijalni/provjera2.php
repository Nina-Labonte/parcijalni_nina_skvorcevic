<?php
require "helpers.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


$unos = $_POST["unos"] ?? "";
$tip = $_POST["tip"] ?? "";

$rezultat = "";


if ($unos !== "" && !isset($_POST["opcija"])) {
    if (is_numeric($unos)) {
        $tip = "broj";
        $unos = ceil($unos);
        setcookie("broj", $unos, time() + 300);

        $file = "storage/brojevi.json";
        if (!file_exists($file)) file_put_contents($file, json_encode([]));
        $data = json_decode(file_get_contents($file), true);
        $data[] = $unos;
        file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
        $count = count($data);

    } else {
        $tip = "string";
        $_SESSION["tekst"] = $unos;

        $file = "storage/tekstovi.json";
        if (!file_exists($file)) file_put_contents($file, json_encode([]));
        $data = json_decode(file_get_contents($file), true);
        $data[] = $unos;
        file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
        $count = count($data);
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["opcija"])) {
    if ($tip == "string") {
        foreach ($_POST["opcija"] as $op) {
            if ($op == "duljina") echo duljinaStringa($unos) . "<br>";
            if ($op == "rijeci") echo brojRijeci($unos) . "<br>";
            if ($op == "inter") echo brojInterpunkcija($unos) . "<br>";
            if ($op == "prva") echo prvaRijecPonovi($unos) . "<br>";
        }

        
        $file = "storage/tekstovi.json";
        $data = json_decode(file_get_contents($file), true);
        $count = count($data);

    } else { 
        $op = $_POST["opcija"];
        if ($op == "prost") echo jeProst($unos) . "<br>";
        if ($op == "fakt") echo faktorijel($unos) . "<br>";
        if ($op == "bin") echo uBinarni($unos) . "<br>";

        $file = "storage/brojevi.json";
        $data = json_decode(file_get_contents($file), true);
        $count = count($data);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Forma 2</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Forma 2</h2>

<form method="POST">
    <a href="provjera1.php">Novi unos</a><br><br>

    <input type="text" value="<?= htmlspecialchars($unos) ?>" readonly><br><br>

    <?php if ($tip == "string"): ?>
        <input type="checkbox" name="opcija[]" value="duljina"> Duljina<br>
        <input type="checkbox" name="opcija[]" value="rijeci"> Broj riječi<br>
        <input type="checkbox" name="opcija[]" value="inter"> Interpunkcija<br>
        <input type="checkbox" name="opcija[]" value="prva"> Prva riječ<br>
    <?php elseif ($tip == "broj"): ?>
        <input type="radio" name="opcija" value="prost"> Prost/Složen<br>
        <input type="radio" name="opcija" value="fakt"> Faktorijel<br>
        <input type="radio" name="opcija" value="bin"> Binarni<br>
    <?php endif; ?>

    <br>
    <input type="hidden" name="unos" value="<?= htmlspecialchars($unos) ?>">
    <input type="hidden" name="tip" value="<?= $tip ?>">
    <button type="submit">Izračun</button>
</form>

<?php
if (isset($count)) {
    echo "<p>Ukupno zapisa: $count</p>";
}


setlocale(LC_TIME, 'hr_HR.UTF-8');
echo "<p>Parcijalni ispit: " . strftime("%A, %d. %B %Y u %H:%M:%S") . "</p>";
?>

</body>
</html>