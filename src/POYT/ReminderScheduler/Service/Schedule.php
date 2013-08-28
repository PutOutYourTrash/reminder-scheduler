<?php
namespace POYT\ReminderScheduler\Service;

use POYT\ReminderScheduler\Entity;

use Cron\CronExpression;
use DateTime;
use DatePeriod;
use DateInterval;

use Doctrine\Common\Collections;

class Schedule extends AbstractService
{
    protected static $repositoryName = 'POYT\ReminderScheduler\Entity\Schedule';
    
    protected static $nodeRepositoryName = 'POYT\ReminderScheduler\Entity\Schedule\Node';
    
    protected $nodeRepository;
    
    protected $jobService;
    
    public function create($name)
    {
        $entityManager = $this->getEntityManager();
        
        $schedule = new Entity\Schedule;
        $schedule->setName($name);
        
        $entityManager->persist($schedule);
        $entityManager->flush();
        
        return $schedule;
    }
    
    public function getById($id)
    {
        $schedule = $this->getRepository()->findOneById($id);
        
        return $schedule;
    }
    
    public function createNode(Entity\Schedule $schedule, DateTime $startDate, $expression)
    {
        $entityManager = $this->getEntityManager();
        
        $node = new Entity\Schedule\Node;
        $node->setSchedule($schedule);
        $node->setStartDate($startDate);
        $node->setExpression($expression);
        
        $entityManager->persist($node);
        $entityManager->flush();
        
        return $node;
    }
    
    public function removeNode(Entity\Schedule\Node $node)
    {
        $entityManager = $this->getEntityManager();
        
        $entityManager->remove($node);
        return $entityManager->flush();
    }
    
    public function getNodeById($id)
    {
        $node = $this->getNodeRepository()->findOneById($id);
        
        return $node;
    }
    
    public function getNodeForDate(Entity\Schedule $schedule, DateTime $date = null)
    {
        if(!($date instanceof DateTime)) {
            $date = new DateTime;
        }
        
        $nodes = $schedule->getNodes();
        
        $expressionBuilder = new Collections\ExpressionBuilder;
        $expression = $expressionBuilder->lte('startDate', $date);
        $criteria = new Collections\Criteria($expression);
        $criteria->orderBy([
            'startDate' => 'desc'
        ]);
        
        $node = $nodes->matching($criteria)->first();
        
        return $node;
    }
    
    public function getNodesForRange(Entity\Schedule $schedule, DateTime $startDate, DateTime $endDate)
    {        
        $nodes = $schedule->getNodes();
        
        $expressionBuilder = new Collections\ExpressionBuilder;
        $expression = $expressionBuilder->andX(
            $expressionBuilder->gte('startDate', $startDate),
            $expressionBuilder->lte('startDate', $endDate)
        );
        $criteria = new Collections\Criteria($expression);
        
        $nodes = $nodes->matching($criteria);
        
        if($startNode = $this->getNodeForDate($schedule, $startDate)) {
            $nodes->set(-1, $startNode); // Start date is exclusive to range
        }
        
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
     * of the next node, assigns each given node to
     * each date it is due for.
     *
     * @param Entity\Schedule $schedule
     * @param DateTime $startDate
     * @param DateTime $endDate
     * @return Schedule\Projection
     */
    public function project(Entity\Schedule $schedule, DateTime $startDate, DateTime $endDate)
    {
        $nodes = $this->getNodesForRange($schedule, $startDate, $endDate);
        
        $projection = new Entity\Schedule\Projection;
        $projection->populateDates(new DatePeriod($startDate, new DateInterval('P1D'), $endDate));
        
        foreach(array_values($nodes->toArray()) as $node) {
            $nextNode = next($nodes);
            $periodStart = ($startDate > $node->getStartDate())?$startDate:$node->getStartDate();
            $periodEnd = $nextNode?$nextNode->getStartDate():$endDate;
            
            $period = new DatePeriod($periodStart, new DateInterval('P1D'), $periodEnd);
            
            $nodeExpression = CronExpression::factory($node->getExpression());
            
            foreach($period as $periodDate) {
                $date = $projection->getDate($periodDate);
                if($date && $nodeExpression->isDue($date->getDate())) {
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
