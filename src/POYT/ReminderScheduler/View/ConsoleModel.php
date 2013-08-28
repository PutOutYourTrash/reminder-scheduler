<?php
namespace POYT\ReminderScheduler\View;

use Zend\View\Model\ConsoleModel as PrimaryConsoleModel;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class ConsoleModel extends PrimaryConsoleModel implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
    
    protected $actualTemplate;
    
    public function getResult()
    {
        $this->result = $this->render();
        return parent::getResult();
    }
    
    public function render()
    {
        $viewManager = $this->getServiceLocator()->get('ConsoleViewManager');
        $renderer = $viewManager->getRenderer();
        if($actualTemplate = $this->getActualTemplate()) {
            $this->setTemplate($actualTemplate);
        }
        return $renderer->render($this);
    }
    
    public function getActualTemplate() {
        return $this->actualTemplate;
    }
    
    public function setActualTemplate($actualTemplate) {
        $this->actualTemplate = $actualTemplate;
        return $this;
    }
}
