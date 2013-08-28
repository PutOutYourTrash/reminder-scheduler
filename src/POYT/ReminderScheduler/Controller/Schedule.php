<?php
namespace POYT\ReminderScheduler\Controller;

use POYT\ReminderScheduler\View\ConsoleModel;

use DateTime;
use DateInterval;
use Zend\Mvc\Controller\AbstractActionController;

use Zend\Console\Exception as ConsoleException;

use POYT\ReminderScheduler\Entity;

class Schedule extends AbstractController {
    protected $scheduleService;
    
    public function createAction()
    {
        $scheduleService = $this->getScheduleService();
		$view = $this->getConsoleModel();
		
		$name = $this->params('name');
		$schedule = $scheduleService->create($name);
		
		$view->setResult($schedule->getId());
		
		return $view;
    }
    
    public function addNodeAction()
    {
        $scheduleService = $this->getScheduleService();
		$view = $this->getConsoleModel();
		
		$schedule = $this->getScheduleFromParam();
		
		$startDate = new DateTime($this->params('start_date'));
		$expression = $this->params('expression');
		
		$node = $scheduleService->createNode($schedule, $startDate, $expression);
		
		$view->setResult($node->getId());
		
		return $view;
    }
    
    public function removeNodeAction()
    {
        $scheduleService = $this->getScheduleService();
		$view = $this->getConsoleModel();
		
		$node = $this->getNodeFromParam();
		$scheduleService->removeNode($node);
    }

    public function projectAction()
    {
        $scheduleService = $this->getScheduleService();
		$view = $this->getConsoleModel();
		$view->setActualTemplate('scheduler/schedule/project');
		
		$schedule = $this->getScheduleFromParam();
		
		$startDate = new DateTime($this->params('start_date'));
		if($endDate = $this->params('end_date')) {
		    $endDate = new DateTime($endDate);
		} else {
		    $endDate = clone $startDate;
		    $endDate->add(new DateInterval('P1M'));
		}
		
		$projection = $scheduleService->project($schedule, $startDate, $endDate);
		$view->projection = $projection;
		
		return $view;
    }
    
    public function getScheduleFromParam($required = true, $paramName = 'schedule_id')
    {
        $scheduleService = $this->getScheduleService();
    
        $scheduleId = $this->params($paramName);
		$schedule = $scheduleService->getById($scheduleId);
		if(!$schedule && $required) {
		    throw new ConsoleException\InvalidArgumentException('Specified schedule does not exist');
		}
		
		return $schedule;
    }
    
    public function getNodeFromParam($required = true, $paramName = 'node_id')
    {
        $scheduleService = $this->getScheduleService();
        
        $nodeId = $this->params($paramName);
        $node = $scheduleService->getNodeById($nodeId);
        if(!$node && $required) {
            throw new ConsoleException\InvalidArgumentException('Specified schedule node does not exist');
        }
        
        return $node;
    }
    
    public function getScheduleService() {
        if(!$this->scheduleService) {
            $scheduleService = $this->getServiceLocator()->get('POYT\ReminderScheduler\Service\Schedule');
            $this->scheduleService = $scheduleService;
        }
        return $this->scheduleService;
    }
    
    public function setScheduleService($scheduleService) {
        $this->scheduleService = $scheduleService;
        return $this;
    }
    
    public function getConsoleModel()
    {
        $model = new ConsoleModel;
        $model->setServiceLocator($this->getServiceLocator());
        
        return $model;
    }
}
