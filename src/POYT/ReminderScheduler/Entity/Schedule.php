<?php
namespace POYT\ReminderScheduler\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Schedule
 *
 * @ORM\Entity
 */
class Schedule extends AbstractEntity
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $name;
    
    /**
     * @var array
     * @ORM\OneToMany(targetEntity="POYT\ReminderScheduler\Entity\Schedule\Node", mappedBy="schedule", fetch="EAGER", orphanRemoval=true)
     * @ORM\OrderBy({"startDate" = "ASC"})
     */
    protected $nodes = array();
    
    public function getId() {
        return $this->id;
    }
    
    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function setName($name) {
        $this->name = $name;
        return $this;
    }
    
    public function getNodes() {
        return $this->nodes;
    }
    
    public function setNodes($nodes) {
        $this->nodes = $nodes;
        return $this;
    }
    
    public function addNode($node) {
        $this->nodes[] = $node;
        return $this;
    }
}
