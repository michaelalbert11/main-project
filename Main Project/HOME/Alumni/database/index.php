<?php

include("conn.php");
include("graph.php");

$batch = false;
$b2017 = false;
$b2016 = false;
$b2015 = false;
$b2014 = false;
$b2013 = false;
$b2011 = false;
$other = false;

$batYr;
$ot = "";
$start;
$end;

if(isset($_GET['b2017'])) {
    $batch = true;
    $b2017 = true;
}
if(isset($_GET['b2016'])) {
    $batch = true;
    $b2016 = true;
}
if(isset($_GET['b2015'])) {
    $batch = true;
    $b2015 = true;
}
if(isset($_GET['b2014'])) {
    $batch = true;
    $b2014 = true;
}
if(isset($_GET['b2013'])) {
    $batch = true;
    $b2013 = true;
}
if(isset($_GET['b2011'])) {
    $batch = true;
    $b2011 = true;
}
if(isset($_GET['other'])) {
    $batch = true;
    $other = true;
}
if(isset($_GET['back'])) {
    $batch = false;
    $b2017 = false;
    $b2016 = false;
    $b2015 = false;
    $b2014 = false;
    $b2013 = false;
}

function batch($yr, $ot) {
    include("conn.php");
    $sql = "SELECT * FROM alumni WHERE BatchUG = '$yr' $ot ORDER BY WorkLocation DESC";
    $res = $con -> query($sql);
    return $res;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <div id="head">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#091B81" fill-opacity="1"
                d="M0,160L80,186.7C160,213,320,267,480,272C640,277,800,235,960,229.3C1120,224,1280,256,1360,272L1440,288L1440,0L1360,0C1280,0,1120,0,960,0C800,0,640,0,480,0C320,0,160,0,80,0L0,0Z">
            </path>
        </svg>
        <img id="logo" src="bhclogo.png" />
        <div class="clg">
            <p>BISHOP HEBER COLLEGE</p>
            <span>AUTONOMUS</span>
        </div>

    </div>
    <div class="main">
        <div class="title">

            <div>
                <p>DEPARTMENT OF COMPUTER SCIENCE</p>
                <P>ALUMNI DATABASE</P>
            </div>

        </div>
        <?php if ($batch == false) {  ?>
        <div class="btns">
            <a href="index.php?b2017=true">2017 - 2020</a>
            <a href="index.php?b2016=true">2016 - 2019</a>
            <a href="index.php?b2015=true">2015 - 2018</a>
            <a href="index.php?b2014=true">2014 - 2017</a>
            <a href="index.php?b2013=true">2013 - 2016</a>
            <a href="index.php?b2011=true">2011 - 2014</a>
            <a href="index.php?other=true">O T H E R S</a>
        </div>
        <?php } ?>

        <?php if ($batch == true) {  ?>
        <div class="cont">
            <?php
            if($b2017 == true) $batYr = "2017 - 2020";
            if($b2016 == true) $batYr = "2016 - 2019";
            if($b2015 == true) $batYr = "2015 -2018";
            if($b2014 == true) $batYr = "2014 - 2017";
            if($b2013 == true) $batYr = "2013 - 2016";
            if($b2011 == true) $batYr = "2011 - 2014";
            if($other == true) {
                include("conn.php");
                if($con -> connect_error) {
                die("NO..");
            }
    
            $sql = "SELECT * FROM alumni WHERE BatchUG IS NULL ORDER BY WorkLocation DESC";
            $nres = $con -> query($sql);
            }
            if ($other == false) {
                $nres = batch($batYr, $ot);
                $start = substr($batYr, 0,5);
                $end = substr($batYr, 7);
            }
            ?>
            <div class="batch">
                <h2><?php if($other==false) echo $start ?></h2>
                <h2><?php if($other==false) echo $end ?></h2>
            </div>
            <?php while($nrow = $nres -> fetch_assoc()) { ?>

            <div class="table">

                <div class="t-cont">
                    <div class="field">
                        <p id="name"><?php echo $nrow['Name'] ?></p>
                    </div>
                    <div class="field">
                        <img src="gm.png" />
                        <p><?php echo $nrow['Email'] ?></p>
                    </div>
                    <div class="field">
                        <?php if ($nrow['Organization'] != null) { ?>
                        <img src="com.png" />
                        <?php } ?>
                        <p><?php echo $nrow['Organization'] ?></p>
                    </div>
                    <div class="field">
                        <?php if ($nrow['WorkLocation'] != null) { ?>
                        <img src="loc.png" />
                        <?php } ?>
                        <p><?php echo $nrow['WorkLocation'] ?></p>
                    </div>
                    <div class="field">
                        <img src="ph.png" />
                        <p><?php echo $nrow['Mobile'] ?></p>
                    </div>
                </div>
            </div>
            <?php } ?>

        </div>
        <a class="back" href="index.php?back=true">B A C K</a>
        <?php } ?>

        <?php if ($batch == false) { ?>
        <div class="ch-cont">
            <div>
                <div id="chart"></div>
            </div>
            <div>
                <div id="chart2"></div>
            </div>
        </div>
        <?php  } ?>
    </div>
</body>
<style>
.back {
    padding: 20px;
    margin: 20px;
    font-size: 13px;
    font-family: Verdana, Geneva, Tahoma, sans-serif;
    font-weight: 550;
    background: linear-gradient(90deg, #03a9f4, #f441a5, #ffeb3b, #03a9f4);
    background-size: 400%;
    border-radius: 30px;
    cursor: pointer;
    color: white;
}

.batch {
    width: 90vw;
    display: flex;
    justify-content: space-between;
    color: lightgray;
    font-size: 22px;
    font-weight: 700;
    font-family: Verdana, Geneva, Tahoma, sans-serif;
    margin-top: -90px;
    pointer-events: none;
}

@media(max-width: 600px) {
    .batch {
        margin-top: -10px;
    }

    .ch-cont {
        width: 100vw;
    }
}

.ch-cont {
    width: 90vw;
    display: flex;
    flex-wrap: wrap;
    margin: 30px 0;
}

.ch-cont>div {
    min-width: 250px;
    flex: 1;
    padding: 20px;
    margin: 10px;
}

.ch-cont>div:first-child {
    border: 1px solid #257AE9;
    border-radius: 10px;
    box-shadow: 0 0 7px 2px #257AE9;
}

.ch-cont>div:last-child {
    border: 1px solid #F53FBE;
    border-radius: 10px;
    box-shadow: 0 0 7px 2px #F53FBE;
}

#chart {
    flex: 1;
    height: 400px;
}

#chart2 {
    flex: 1;
    height: 400px;
}
</style>

<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script>
<?php if($data == true) { ?>
var chart = new CanvasJS.Chart("chart", {
    animationEnabled: true,
    exportEnabled: true,
    theme: "light2", // "light1", "light2", "dark1", "dark2"
    title: {
        text: "Work Location",
        fontColor: "#257AE9"
    },
    axisY: {
        title: "no.of alumnae",
        interlacedColor: "#F06CDA60",
        gridColor: "#F53FBE",
        labelFontSize: 14,
        labelFontColor: "#428FF3"
    },
    axisX: {
        title: "cities",
        labelFontSize: 14,
        labelFontColor: "#F53FBE"
    },
    data: [{
        fillOpacity: .3,
        color: "#428FF3",
        type: "column", //change type to bar, line, area, pie, etc 
        indexLabelFontSize: 13,
        indexLabel: "{label}",
        yValueFormatString: "#,##0",
        dataPoints: <?php print_r(json_encode($dataPoints, JSON_NUMERIC_CHECK)); ?>
    }]
});
// yValueFormatString: "#,##0\"%\""
chart.render();


var chart2 = new CanvasJS.Chart("chart2", {
    animationEnabled: true,
    exportEnabled: true,
    theme: "light2", // "light1", "light2", "dark1", "dark2"
    title: {
        text: "Organization",
        fontColor: "#F53FBE"
    },
    axisY: {
        title: "no.of alumnae",
        interlacedColor: "#F06CDA60",
        gridColor: "#F53FBE",
        labelFontSize: 14,
        labelFontColor: "#428FF3"
    },
    axisX: {
        title: "Organization",
        labelFontSize: 14,
        labelFontColor: "#F53FBE"
    },
    data: [{
        fillOpacity: .5,
        risingColor: "#F79B8E",
        type: "pie", //change type to bar, line, area, pie, etc 
        indexLabelFontSize: 13,
        indexLabel: "{label}",
        yValueFormatString: "#,##0",
        dataPoints: <?php print_r(json_encode($dataPoints2, JSON_NUMERIC_CHECK)); ?>
    }]
});
// yValueFormatString: "#,##0\"%\""
chart2.render();
<?php } ?>
</script>

</html>