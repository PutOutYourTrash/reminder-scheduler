<?php
namespace POYT\ReminderScheduler\Controller;

use \DateTime;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ConsoleModel;

use Zend\Console\Exception as ConsoleException;

use POYT\ReminderScheduler\Entity;

class Schedule extends AbstractController {
    protected $scheduleService;

    public function projectAction()
    {
        $scheduleService = $this->getScheduleService();
		$view = new ConsoleModel();
		
		$scheduleId = $this->params('schedule_id');
		$schedule = $scheduleService->getById($scheduleId);
		if(!$schedule) {
		    throw new ConsoleException('Specified schedule does not exist');
		}
		
		$startDate = new DateTime($this->params('start_date'));
		$endDate = ($endDate = $this->params('end_date'))?
		    new DateTime($endDate)
		    :(clone $startDate)->add(new DateInterval('P1M'));
		
		$projection = $scheduleService->projectSchedule($schedule, $startDate, $endDate);
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
}
