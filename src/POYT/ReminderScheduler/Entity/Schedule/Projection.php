<?php
namespace POYT\ReminderScheduler\Entity\Schedule;

use POYT\ReminderScheduler\Entity\AbstractEntity;

use DateTime;

class Projection extends AbstractEntity
{
    protected $dates = [];
    
    public function getDates() {
        return $this->dates;
    }
    
    public function setDates($dates) {
        $this->dates = $dates;
        return $this;
    }
    
    public function addDate(Projection\Date $date) {
        $this->dates[$date->getDate()->format(Projection\Date::INDEX_FORMAT)] = $date;
        return $this;
    }
    
    public function getDate(DateTime $date) {
        return isset($this->dates[$date->format(Projection\Date::INDEX_FORMAT)])?
            $this->dates[$date->format(Projection\Date::INDEX_FORMAT)]
            :null;
    }
    
    public function populateDates(DatePeriod $period) {
        foreach($period as $dateTime) {
            $date = new Projection\Date;
            $date->setDate($dateTime);
            $this->addDate($date);
        }
    }
}
