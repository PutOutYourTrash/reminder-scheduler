<?php
namespace POYT\ReminderScheduler\Entity\Schedule\Projection;

use POYT\ReminderScheduler\Entity\AbstractEntity;
use POYT\ReminderScheduler\Entity\Schedule\Node;

use DateTime;

class Date extends AbstractEntity
{
    const INDEX_FORMAT = 'Y-m-d';

    protected $date;
    
    protected $node;
    
    public function getDate() {
        if(!$this->date) {
            $date = new DateTime;
        }
        return $this->date;
    }
    
    public function setDate(DateTime $date) {
        $this->date = $date;
        return $this;
    }
    
    public function getNode() {
        return $this->node;
    }
    
    public function setNode(Node $node) {
        $this->node = $node;
        return $this;
    }
}
