<?php
namespace POYT\ReminderScheduleR\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

use Doctrine\ORM\EntityManager;

abstract class AbstractService
{
    use ServiceLocatorAwareTrait;
    
    protected static $repositoryName = '';

    protected $entityManager;
    
    protected $repository;
    
    public function getEntityManager() {
        if(!$this->entityManager) {
            $this->entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }
        return $this->entityManager;
    }
    
    public function setEntityManager(EntityManager $entityManager) {
        $this->entityManager = $entityManager;
        return $this;
    }
    
    public function getRepository($repositoryName = null) {
        if(!$this->repository) {
            $this->repository = $this->getEntityManager()->getRepository($repositoryName?:static::$repositoryName);
        }
        return $this->repository;
    }
    
    public function setRepository($repository) {
        $this->repository = $repository;
        return $this;
    }
    
    public function getQueryBuilder($repositoryName = null)
    {
        return $this->getEntityManager()->createQueryBuilder($repositoryName?:static::$repositoryName);
    }
}
