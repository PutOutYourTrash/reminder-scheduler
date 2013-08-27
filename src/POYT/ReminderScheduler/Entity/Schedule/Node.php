<?php
namespace POYT\ReminderScheduler\Entity\Schedule;

use POYT\ReminderScheduler\Entity\AbstractEntity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Node
 *
 * @ORM\Entity
 */
class Node extends AbstractEntity
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    
    /**
     * @var Schedule
     * @ORM\OneToOne(targetEntity="POYT\ReminderScheduler\Entity\Schedule", orphanRemoval=true, fetch="EAGER")
     * @ORM\JoinColumn(name="schedule_id", referencedColumnName="id")
     */
    protected $schedule;
    
    /**
     * @var string
     * @ORM\Column(type="date")
     */
    protected $startDate;
    
    /**
     * Cron format schedule
     * 
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    protected $schedule;
    
    public function getId() {
        return $this->id;
    }
    
    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    
    public function getSchedule() {
        return $this->schedule;
    }
    
    public function setSchedule(Schedule $schedule) {
        $this->schedule = $schedule;
        return $this;
    }
    
    public function getStartDate() {
        return $this->startDate;
    }
    
    public function setStartDate($startDate) {
        $this->startDate = $startDate;
        return $this;
    }
}
