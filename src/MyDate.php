<?php

class MyDate {

    public static function diff($start, $end) {
        
        /**
         * Getting Day, Month, Year in intiger format
         */
        $startDate = array_map('intval', explode('/', $start));
        $endDate = array_map('intval', explode('/', $end));

        $startD = self::rDown( self::fCalc($startDate[2], $startDate[1] , $startDate[0]) );
        $endD = self::rDown( self::fCalc($endDate[2],   $endDate[1] , $endDate[0]) );
            
        /**
         * Calculate the differance in the days
         */
        if($endD > $startD){
            $numberOfDays = self::rDown($endD-$startD);
        }else{
            $numberOfDays = self::rDown($startD-$endD);
        }

        return (object) array(
                    'years' => self::rDown($numberOfDays/365),
                    'months' => self::rDown($numberOfDays/30),
                    'days' => $numberOfDays,
                    'total_days' => null,
                    'invert' => null
        );
    }
    
    private function fCalc($dd, $mm, $yyyy){
        
        /**
         * The source of the formulas. 
         * https://en.wikipedia.org/wiki/Julian_day
         */
        
        /**
         * a = [14-month / 12]
         */
        $a = self::rDown( (14 - $mm) / 12 );
        
        /**
         * y = year + 4800 - a
         */
        $y = $yyyy + 4800 - $a;
        
        /**
         * m = mounth + 12a - 3
         */
        $m = $mm + (12*$a) - 3;

        /**
         *  day + [153m+2/5] + 365y + [y/4] - [y/100] + [y/400] - 32045  
         */
        return $dd + ( ( (153*$m) + 2 )/5 ) + (365*$y) + ($y/4) - ($y/100) + ($y/400) - 32045;

    }
    
    private function rDown($val){
        return (int) explode('.',$val)[0];
    }

}

 
/*
    echo '<pre>' . print_r(MyDate::diff('2014/01/01', '2000/01/01'),1). '</pre>';
    echo '<pre>' . print_r(MyDate::diff('2014/01/01', '2000/01/01')->days,1). '</pre>';
    echo '<pre>' . print_r(MyDate::diff('2013/12/31', '2014/01/01')->days,1). '</pre>';
    echo '<pre>' . print_r(MyDate::diff('2015/01/01', '2016/01/01')->days,1). '</pre>';
*/