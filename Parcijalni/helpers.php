<?php


function duljinaStringa($s) {
    return "Duljina stringa: " . strlen($s);
}

function brojRijeci($s) {
    return "Broj riječi: " . str_word_count($s);
}

function brojInterpunkcija($s) {
    return "Broj interpunkcijskih znakova: " . preg_match_all("/[.!?,;:]/", $s);
}

function prvaRijecPonovi($s) {
    $words = preg_split("/\s+/", trim($s));
    $first = $words[0] ?? '';
    return "Prva riječ ponovljena: " . implode(' ', array_fill(0, count($words), $first));
}

function jeProst($n) {
    if ($n < 2) return "$n nije prost";
    for ($i = 2; $i <= sqrt($n); $i++) {
        if ($n % $i == 0) return "$n je složen";
    }
    return "$n je prost";
}

function faktorijel($n) {
    if ($n >= 10) return "Broj je prevelik za izračun faktorijela!";
    $f = 1;
    for ($i = 2; $i <= $n; $i++) $f *= $i;
    return "Faktorijel: $f";
}

function uBinarni($n) {
    return "Binarni oblik: " . decbin($n);
}
?>