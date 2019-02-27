<?php include 'StatsCalculator.php';?>

<?php include 'ExamGrader.php';?>





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

echo "<br>";
echo "<br>";


$examGrader=new ExamGrader;


$studentPercentage=$examGrader->getStudentExamScore(30,40);
$isSatisfactory=$examGrader->isSatisfactory($studentPercentage);
$classPassRate=$examGrader->getClassPassRate(array(10,30,20,40,31,22),40,6);


echo $studentPercentage;
echo "<br>";
echo var_dump($isSatisfactory);
echo "<br>";
echo $classPassRate;
echo "<br>";
echo var_dump($examGrader->isSatisfactory($classPassRate));







?>