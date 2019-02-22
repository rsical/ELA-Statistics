<?php

//class to deal with pass rates of exams
class PassRate{

    static private $minPassRate=0.60; //60% 

    public function getClassPassRate($studentPoints, $numOfExamPoints, $numOfRespondents){
        //if array of grades:

        //else:
            /*
                passrate=
            */

        //return passrate

    }

    public function getStudentExamScore(){

    }

    //takes an exam percentage (ex: .72) and determines if satisfactory (>.60)
    public function determineIfSatisfactory($grade){
        
        if($grade>=$this->minPassRate){
            return true;
        }
        return false;
    }

}

?>