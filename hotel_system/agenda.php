<?php
class DisplayCal
{
    public $day;
    public $month;
    public $year;
    public $timestamp;
    private $prevYearNav;
    private $nextYearNav;
    private $prevYear;
    private $nextYear;
    private $prevMonth;
    private $nextMonth;
    private $dayOfMonth;
    private $fullMonth;
    private $noMonth;
    private $firstDayTimeStamp;
    private $dateArray;
    private $firstDay;
    private $lengthMonth;
    private $totalSlots;
    private $endSlots;
    private $addToEnd;
    private $gridLength;
    private $displayHTML;
 
    public function __construct($d = 0, $m = 0, $y = 0){
 
            if($d == 0){
                $this->day = date("j");
            }else{
                $this->day = $d;
            }
            if($m == 0){
                $this->month = date("n");
            }else{
                $this->month = $m;
            }
 
            if($y == 0){
                $this->year = date("Y");
            }else{
                $this->year = $y;
            }
            ########## build values #############
            $this->prevYearNav= $this->year -1;
            $this->nextYearNav= $this->year + 1;
            $this->prevYear= $this->year;
            $this->nextYear= $this->year;
            $this->prevMonth= $this->month-1;
            $this->nextMonth= $this->month+1;
            if ($this->prevMonth == 0 ) {
                $this->prevMonth= 12;
                $this->prevYear = $this->year - 1;
            }
            if ($this->nextMonth == 13 ) {
                 $this->nextMonth = 1;
                 $this->nextYear = $this->year + 1;
            }
 
            $this->timestamp = mktime(0,0,0,$this->month,$this->day,$this->year);
            $this->dayOfMonth = date('j',$this->timestamp);
            $this->fullMonth = date('F',$this->timestamp);
            $this->noMonth = date('n',$this->timestamp);
            $this->firstDayTimeStamp = mktime(0,0,0,$this->noMonth,1,$this->year);
            $this->dateArray = getdate($this->firstDayTimeStamp );
            $this->firstDay = $this->dateArray['wday'];
            if($this->firstDay == 0){
                $this->firstDay = 6;
            } else{
                $this->firstDay--;
            }
            $this->lengthMonth = date('t',$this->timestamp);
            $this->totalSlots = $this->firstDay + $this->lengthMonth;
            $this->totalSlots--;
            $this->endSlots = $this->totalSlots % 7;
            $this->addToEnd = 7 - $this->endSlots;
            $this->gridLength = $this->totalSlots + $this->addToEnd;
 
    }
 
    public function displayCal(){
 
        $this->displayHTML = "<table>";
        $this->displayHTML .= "<tr><td colspan=\"7\" class=\"center\">{$this->fullMonth} - {$this->year}</td></tr>";
        $this->displayHTML .= "<tr class=\"mainCal\"><td>Mo</td><td>Tu</td><td>We</td><td>Th</td><td>Fr</td><td>Sa</td><td>Su</td></tr>";
 
        for ($i=0; $i<$this->gridLength; $i++) {
            if(($i % 7) == 0 ){
                $this->displayHTML .=  "<tr>";
            }
            if($i < $this->firstDay || ($i) > ($this->totalSlots)){
                $this->displayHTML .=  "<td>-</td>";
            }else{
                if(($i - $this->firstDay + 1) == $this->day){
                    $this->displayHTML .=  "<td><a href='detailAgenda.php?datum=$this->year-$this->month-$i'><span class=\"pickedDay\">". ($i - $this->firstDay + 1) . "</span></a></td>";
                } else{
                    if(($i % 7) == 6){
                        $this->displayHTML .=  "<td class=\"sun\"><a href='detailAgenda.php?datum=$this->year-$this->month-$i'>". ($i - $this->firstDay + 1) . "<a/></td>" ;
                        }else{
                        $this->displayHTML .=  "<td><a href='detailAgenda.php?datum=$this->year-$this->month-$i'>". ($i - $this->firstDay + 1) . "</a></td>";
                    }
                }
            }
            if(($i % 7) == 6 ){
                $this->displayHTML .=  "</tr>";
            }
        }
 
        $this->displayHTML .= "<tr class=\"mainCal\">";
        $this->displayHTML .= "<td><a href=\"{$_SERVER['PHP_SELF']}?month={$this->month}&year={$this->prevYearNav}\">&lt;</a></td>";
        $this->displayHTML .= "<td colspan=\"5\">Years</td>";
        $this->displayHTML .= "<td><a href=\"{$_SERVER['PHP_SELF']}?month={$this->month}&year={$this->nextYearNav}\">&gt;</a></td>";
        $this->displayHTML .= "</tr>";
        $this->displayHTML .= "<tr class=\"mainCal\">";
        $this->displayHTML .= "<td><a href=\"{$_SERVER['PHP_SELF']}?month={$this->prevMonth}&year={$this->prevYear}\">&lt;</a></td>";
        $this->displayHTML .= "<td colspan=\"5\">Months</td>";
        $this->displayHTML .= "<td><a href=\"{$_SERVER['PHP_SELF']}?month={$this->nextMonth}&year={$this->nextYear}\">&gt;</a></td>";
        $this->displayHTML .= "</tr></table>";
 
        return $this->displayHTML;
 
    }
 
}
?>