<?php
namespace POYT\ReminderScheduler\Entity;

use Zend\Stdlib\Hydrator\ClassMethods;

abstract class AbstractEntity
{
    protected $hydrator;
    
    public function getHydrator() {
        if(!$this->hydrator) {
            $hydrator = new ClassMethods;
            $this->hydrator = $hydrator;
        }
        return $this->hydrator;
    }
    
    public function setHydrator($hydrator) {
        $this->hydrator = $hydrator;
        return $this;
    }
}
