<?php
namespace POYT\ReminderScheduler\Service;

use POYT\ReminderScheduler\Entity;
use DateTime;

class Schedule extends AbstractService
{
    protected static $repositoryName = 'POYT\ReminderScheduler\Entity\Schedule';
    
    protected static $nodeRepositoryName = 'POYT\ReminderScheduler\Entity\Schedule\Node';
    
    protected $nodeRepository;
    
    public function getNode(Entity\Schedule $schedule, $date = null)
    {
        if(!($date instanceof DateTime)) {
            $date = new DateTime;
        }
        
        $query = $this->getNodeQueryBuilder()
            ->field('schedule')->equals($schedule->getId())
            ->field('startDate')->lte($date)
            ->getQuery();
        
        $node = $query->getSingleResult();
        
        return $node;
    }
    
    public function getNodeRepository() {
        if(!$this->nodeRepository) {
            $this->nodeRepository = $this->getRepository(static::$nodeRepositoryName);
        }
        return $this->nodeRepository;
    }
    
    public function setNodeRepository($nodeRepository) {
        $this->nodeRepository = $nodeRepository;
        return $this;
    }
    
    public function getNodeQueryBuilder()
    {
        return $this->getQueryBuilder(static::$nodeRepositoryName);
    }
}
