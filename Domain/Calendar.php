<?php


/**
 * Calendar.php
 * 
 * Manages date stuff around the quarter system for ArtsCorps
 * 
 * @since Sep 22, 2006
 * @author Jesse Snyder at NPower Seattle (www.npowerseattle.org)
 * @package NPowerSeattle_ArtsCorp_Domain
 */
class ArtsCorps_Domain_Calendar {
    const SPRING_START = 3;
    const SUMMER_START = 6;
    const FALL_START = 9;
    const WINTER_START = 12;
    private $day;
    private $month;
    private $year;
    
    public function __construct() {
        $this->year = (int) date('Y');
        $this->month = (int) date('n');
        $this->day = (int) date('j');
    }
    private function isWinter() {
        return ($this->month == self::WINTER_START or  $this->month < self::SPRING_START);
    }
    
    private function isSpring() {
        return ($this->month >= self::SPRING_START and $this->month < self::SUMMER_START);
    }
    
    private function isSummer() {
        return ($this->month >= self::SUMMER_START and $this->month < self::FALL_START);
    }
    
    private function isFall() {
        return ($this->month >= self::FALL_START and $this->month < self::WINTER_START);
    }

    public function currentQuarterString() {
        if ($this->isWinter()) {
            return 'Winter ' . $this->year;
        }
        if ($this->isSpring()) {
            return 'Spring ' . $this->year;
        }
        if ($this->isSummer()) {
            return 'Summer ' . $this->year;
        }               
        return 'Fall ' . $this->year; 
    } 

    public function nextQuarterString() {
        if ($this->isWinter()) {
            return 'Spring ' . $this->year;
        }
        if ($this->isSpring()) {
            return 'Summer ' . $this->year;
        }
        if ($this->isSummer()) {
            return 'Fall ' . $this->year;
        }               
        return 'Winter ' . ($this->year + 1); 
    }    
    
    public function currentQuarterStartStamp() {
        if (preg_match('/^Spring/', $this->currentQuarterString())) {
            return mktime(0, 0, 0, self::SPRING_START, 1, $this->year);
        } 
        if (preg_match('/^Summer/', $this->currentQuarterString())) {
            return mktime(0, 0, 0, self::SUMMER_START, 1, $this->year);            
        } 
        if (preg_match('/^Fall/', $this->currentQuarterString())) {
            return mktime(0, 0, 0, self::FALL_START, 1, $this->year);
        }                        
        else {
            return mktime(0, 0, 0, self::WINTER_START, 1, $this->year);
        }
    }
    
    public function currentQuarterEndStamp() {
        if ($this->isSpring()) {
            return mktime(0, 0, 0, 5, 31, $this->year);
        } 
        if ($this->isSummer()) {
            return mktime(0, 0, 0, 8, 31, $this->year);            
        } 
        if ($this->isFall()) {
            return mktime(0, 0, 0, 11, 31, $this->year);
        }                        
        else {
            return mktime(0, 0, 0, 2, 28, $this->year);
        }        
    }
    
    public function nextQuarterStartStamp() {
        if ($this->isSpring()) {
            return mktime(0, 0, 0, self::SUMMER_START, 1, $this->year);
        } 
        if ($this->isSummer()) {
            return mktime(0, 0, 0, self::FALL_START, 1, $this->year);            
        } 
        if ($this->isFall()) {
            return mktime(0, 0, 0, self::WINTER_START, 1, $this->year);
        }                        
        if ($this->isWinter()) {
            if ($this->month == 12) {    
                return mktime(0, 0, 0, self::SPRING_START, 1, $this->year + 1);
            }
            return mktime(0,0,0, self::SPRING_START, 1, $this->year);
        }       
    }
    
    public function nextQuarterEndStamp() {
        if ($this->isWinter()) {
            return mktime(0, 0, 0, 5, 31, $this->year);
        } 
        if ($this->isSpring()) {
            return mktime(0, 0, 0, 8, 31, $this->year);            
        } 
        if ($this->isSummer()) {
            return mktime(0, 0, 0, 11, 31, $this->year);
        }                        
        else {
            return mktime(0, 0, 0, 2, 28, $this->year + 1);
        }           
    }
    
    public function currentQuarterStartDateTime() {
        $stamp = $this->currentQuarterStartStamp();
        return date('c', $stamp);
    }
    public function currentQuarterEndDateTime() {
        $stamp = $this->currentQuarterEndStamp();
        return date('c', $stamp);
    }
    public function nextQuarterStartDateTime() {
        $stamp = $this->nextQuarterStartStamp();
        return date('c', $stamp);
    }
    public function nextQuarterEndDateTime() {
        $stamp = $this->nextQuarterEndStamp();
        return date('c', $stamp);
    } 
    
    public function todayDateTime() {
        $stamp = mktime(0, 0, 0, $this->month, $this->day, $this->year);
        
        return date('c', $stamp);
    }   
    
    public function beginningOfDayDateTime() {        
        $stamp = mktime(0, 0, 0, $this->month, $this->day, $this->year);
        $oneDay = 60 * 60 * 24;
        $beginningOfDay = $stamp - $oneDay;

        return date('Y-m-d', $beginningOfDay);
    }
}    
?>
