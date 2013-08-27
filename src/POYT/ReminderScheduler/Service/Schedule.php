<?php
namespace POYT\ReminderScheduler\Service;

use POYT\ReminderScheduler\Entity;

use Cron\CronExpression;
use DateTime;

class Schedule extends AbstractService
{
    protected static $repositoryName = 'POYT\ReminderScheduler\Entity\Schedule';
    
    protected static $nodeRepositoryName = 'POYT\ReminderScheduler\Entity\Schedule\Node';
    
    protected $nodeRepository;
    
    protected $jobService;
    
    public function getNodeForDate(Entity\Schedule $schedule, DateTime $date = null)
    {
        if(!($date instanceof DateTime)) {
            $date = new DateTime;
        }
        
        $query = $this->getNodeQueryBuilder()
            ->field('schedule_id')->equals($schedule->getId())
            ->field('startDate')->lte($date)
            ->sort('startDate', 'desc')
            ->getQuery();
        
        $node = $query->getSingleResult();
        
        return $node;
    }
    
    public function getNodesForRange(Entity\Schedule $schedule, DateTime $startDate, DateTime $endDate)
    {
        $startNode = $this->getNodeForDate($schedule, $startDate);
        
        $query = $this->getNodeQueryBuilder()
            ->field('schedule_id')->equals($schedule->getId())
            ->field('startDate')->range($startDate, $endDate)
            ->getQuery();
        
        $nodes = $query->execute();
        
        array_unshift($nodes, $startNode); // Start date is exclusive to range
        
        return $nodes;
    }
    
    public function getJobFromNode(Entity\Schedule\Node $node)
    {
        $jobService = $this->getJobService();
        $job = $jobService->createJob();
        
        $job->setSchedule($node->getSchedule());
        
        $command = $jobService->createCommand(/* TODO: Controller selection */ null, [
            $node
        ]);
        
        $job->setCommand($command);
        
        return $job;
    }
    
    /**
     * Generates a schedule projection for a date range
     * 
     * Iterates each schedule node that overlaps the date
     * range and, forming periods of time inclusive to the
     * start date of the given node and the start date
     * of the next node.
     * The schedule projection assigns each given node to
     * each date it is due for.
     *
     * @param Entity\Schedule $schedule
     * @param DateTime $startDate
     * @param DateTime $endDate
     * @return Schedule\Projection
     */
    public function projectSchedule(Entity\Schedule $schedule, DateTime $startDate, DateTime $endDate)
    {
        $nodes = $this->getNodesForRange($schedule, $startDate, $endDate);
        
        $projection = new Schedule\Projection;
        $projection->populateDates(new DatePeriod($startDate, new DateInterval('P1D'), $endDate));
        
        foreach(array_values($nodes) as $node) {
            $nextNode = next($nodes);
            $periodStart = ($startDate > $node->getStartDate())?$startDate:$node->getStartDate();
            $periodEnd = $nextNode?$nextNode->getStartDate():$endDate;
            
            $period = new DatePeriod($periodStart, new DateInterval('P1D'), $periodEnd);
            
            $nodeExpression = CronExpression::factory($node->getSchedule());
            
            foreach($period as $periodDate) {
                $date = $projection->getDate($periodDate);
                if($nodeExpression->isDue($date->getDate())) {
                    $date->setNode($node);
                }
            }
        }
        
        return $projection;
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
    
    public function getJobService() {
        if(!$this->jobService) {
            $this->jobService = $this->getServiceLocator()->get('POYT\ReminderScheduler\Service\Job');
        }
        return $this->jobService;
    }
    
    public function setJobService($jobService) {
        $this->jobService = $jobService;
        return $this;
    }
}
