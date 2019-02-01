<?php

$monthsList = array(
  ".01." => "января",
  ".02." => "февраля",
  ".03." => "марта",
  ".04." => "апреля",
  ".05." => "мая",
  ".06." => "июня",
  ".07." => "июля",
  ".08." => "августа",
  ".09." => "сентября",
  ".10." => "октября",
  ".11." => "ноября",
  ".12." => "декабря"
);

function convertEngDateToRussian(string $date) {

    global $monthsList;

    $date = date('j.m.Y H:i', $date);
    $mD = date(".m.");
    return $russianDate = str_replace($mD, " ".$monthsList[$mD]." ", $date);

}
