<?php
namespace POYT\ReminderScheduler\Service;

use POYT\ReminderScheduler\Entity;

use Jobby;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class Job extends AbstractService
{
    protected $jobby;
    
    protected $defaultJobConfig = array();

    public function createJob()
    {
        $job = new Entity\Job;
        $hydrator = $job->getHydrator();
        
        $job = $hydrator->hydrate($this->getDefaultJobConfig(), $job);
        
        return $job;
    }
    
    public function extractJob(Entity\Job $job)
    {
        $hydrator = $job->getHydrator();
        
        $data = $hydrator->extract($job);
        
        return $data;
    }
    
    public function getJobby() {
        if(!$this->jobby) {
            $this->jobby = new Jobby\Jobby;
        }
        return $this->jobby;
    }
    
    public function setJobby(Jobby\Jobby $jobby) {
        $this->jobby = $jobby;
        return $this;
    }
    
    public function getDefaultJobConfig() {
        if(empty($this->defaultJobConfig)) {
            $jobby = new Jobby\Jobby;
            $config = $jobby->getDefaultConfig();
            unset($config['recipients']);
            unset($config['runOnHost']);
            
            $this->defaultJobConfig = $config;
        }
        return $this->defaultJobConfig;
    }
    
    public function setDefaultJobConfig($defaultJobConfig) {
        $this->defaultJobConfig = $defaultJobConfig;
        return $this;
    }
}
