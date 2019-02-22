<?php include './Objects/StatsCalculator.php';?>


<?php

$calc= new StatsCalculator(array(1,2,3,8,2));

$std=$calc->standardDeviation();

$median=$calc->median();
$mode=$calc->mode();


echo $std;
echo "<br>";
echo $median;
echo "<br>";
//echo $mode;
echo json_encode($mode);

?>