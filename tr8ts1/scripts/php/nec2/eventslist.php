<?php
function printAsterisk($beginyear, $endyear) { 
  if ($beginyear != NULL and $endyear != NULL) {
    return '*';
  }
  else {
    return '';
  }
}
function dateFormatCallback($keyArray, $format, $dbRow) {
  $months = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octobre", "noviembre", "diciembre");

  #Beginning month, day and year
  $beginmonth = $dbRow['b_month'];
  $beginday = $dbRow['b_day'];
  $beginyear = $dbRow['b_year'];

  #ending month, day and year
  $endmonth = $dbRow['e_month'];
  $endday = $dbRow['e_day'];
  $endyear = $dbRow['e_year'];

  $dateString = "";

  $de = ' de ';
  $space = ' ' ;
  $dash = ' - ';
  $asterisk = '*';
  #there are three basic rules.

  #1. If the month, day, and years are both equal, only print the beginning day, month (and year if year is not null)
  if ($beginmonth==$endmonth and $beginday==$endday and $beginyear==$endyear) {
    $dateString = $beginday . $de . $months[$beginmonth];
    if ($beginyear != NULL) {
      $dateString = $dateString . $space .  $beginyear;
    }
  }

  #2. If the years are the same, months are the same, but the days are different, print the day range, month, then year (if not null)
  else if ($beginyear == $endyear and $beginmonth == $endmonth and $beginday!=$endday) {
    $dateString = $beginday . $dash . $endday . $de . $months[$beginmonth];
    if ($beginyear != NULL) {
      $dateString = $dateString . $space .  $beginyear . $asterisk;
    }
  }

  #3. If the all three are different, print the entire range. The years should not be null.
  else if ($beginday!=$endday and $beginmonth!=$endmonth) {
    $dateString = $beginday . $de . $months[$beginmonth] . $dash . $endday . $de . $months[$endmonth] . $space . $endyear . printAsterisk($beginyear, $endyear);
  }

  else {
    $dateString = $beginday . $de . $months[$beginmonth];
    if ($beginyear != NULL) {
      $dateString = $dateString . $space . $beginyear;
    }
    $dateString = $dateString . $dash;
    $dateString = $dateString . $endday . $de . $months[$endmonth];
    if ($endyear != NULL) {
      $dateString = $dateString . $space . $endyear . printAsterisk($beginyear, $endyear);
    }
  }
  $keyArray['formatted_date'] =  $dateString;

  return GI_Subtemplate::toString($keyArray, $format, "##");
 }
 
?>
