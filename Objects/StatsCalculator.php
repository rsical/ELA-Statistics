<?php

class StatsCalculator{

    //an array containing grades
    private $gradeArr;

    //constructor
    public function StatsCalculator($_gradeArr){
        $gradeArr = $_gradeArr;
    }

    //setter for grades array
    public function setGradeArr($_gradeArr){
        $gradeArr=$_gradeArr;
    }


    //calculates the standard deviartion
    public function standardDeviation(){
        $num_of_elements = count($arr);

        $variance = 0.0;

        // calculating mean using array_sum() method
        $average = array_sum($arr)/$num_of_elements;

        foreach($arr as $i){
            // sum of squares of differences between
                        // all numbers and means.
            $variance += pow(($i - $average), 2);
        }

        return (float)sqrt($variance/$num_of_elements);

    }

    //calculate the median
    public function median(){
        sort($gradeArr);
        $count = count($gradeArr); //total numbers in array
        $midNumber = floor(($count-1)/2); // find the middle value, or the lowest middle value
        if($count % 2) { // odd number, middle is the median
            $median = $gradeArr[$midNumber];
        } else { // even number, calculate avg of 2 medians
            $low = $gradeArr[$midNumber];
            $high = $gradeArr[$midNumber+1];
            $median = (($low+$high)/2);
        }
        return $median;

    }

    //calculate the mode
    public function mode(){
        $values = array();
        foreach ($gradeArr as $v) {
          if (isset($values[$v])) {
            $values[$v] ++;
          } else {
            $values[$v] = 1;  // counter of appearance
          }
        }
        arsort($values);  // sort the array by values, in non-ascending order.
        $modes = array();
        $x = $values[key($values)]; // get the most appeared counter
        reset($values);
        foreach ($values as $key => $v) {
          if ($v == $x) {   // if there are multiple 'most'
            $modes[] = $key;  // push to the modes array
          } else {
            break;
          }
        }
        return $modes;

    }




}

?>