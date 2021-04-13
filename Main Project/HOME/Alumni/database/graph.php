<?php

include("conn.php");
$data = false;

$sql = "SELECT WorkLocation,COUNT(WorkLocation) AS count FROM alumni GROUP BY WorkLocation";
$res = $con -> query($sql);

$chn = 0;
$tri = 0;
$ban = 0;
$mys = 0;
$cbe = 0;
while ($row = $res -> fetch_assoc()) {
    $row['WorkLocation'];
    $count = $row['count'];
    $city = strtolower(substr($row['WorkLocation'], 0,2));
    if ($city == 'tr') $tri += $count;
    if ($city == 'ti') $tri += $count;
    if ($city == 'ba') $ban += $count;
    if ($city == 'be') $ban += $count;
    if ($city == 'co') $cbe += $count;
    if ($city == 'my') $mys += $count;
    if ($city == 'ch') $chn += $count;
}

$dataPoints = array(
    array("label" => "Chennai", "y" => $chn),
    array("label" => "Bangalore", "y" => $ban),
    array("label" => "Trichy", "y" => $tri),
    array("label" => "Mysore", "y" => $mys),
    array("label" => "Coimbatore", "y" => $cbe),
);


$sql2 = "SELECT Organization,COUNT(Organization) AS count FROM alumni GROUP BY Organization";
$res2 = $con -> query($sql2);

$tcs = 0;
$cts = 0;
$del = 0;
$ome = 0;
$ibm = 0;
$inf = 0;
while ($row2 = $res2 -> fetch_assoc()) {
    $row2['Organization'];
    $count2 = $row2['count'];
    $org = strtolower(substr($row2['Organization'], 0,2));
    if ($org == 'tc') $tcs += $count2;
    if ($org == 'ta') $tcs += $count2;
    if ($org == 'co') $cts += $count2;
    if ($org == 'ct') $cts += $count2;
    if ($org == 'ib') $ibm += $count2;
    if ($org == 'in') $inf += $count2;
    if ($org == 'de') $del += $count2;
    if ($org == 'om') $ome += $count2;
}
$dataPoints2 = array(
    array("label" => "TCS", "y" => $tcs),
    array("label" => "CTS", "y" => $cts),
    array("label" => "Omega Health Care", "y" => $ome),
    array("label" => "Deloitte", "y" => $del),
    array("label" => "IBM", "y" => $ibm),
    array("label" => "Infosys", "y" => $inf)
);

if ($dataPoints2) $data = true;
?>