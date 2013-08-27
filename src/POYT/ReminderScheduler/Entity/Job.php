<?php
namespace POYT\ReminderScheduler\Entity;

class Job extends AbstractEntity
{
    protected $recipients = array();
    
    protected $mailer;
    
    protected $smtpHost;
    
    protected $smtpPort;
    
    protected $smtpUsername;
    
    protected $smtpPassword;
    
    protected $runAs;
    
    protected $environment;
    
    protected $runOnHost;
    
    protected $output;
    
    protected $dateFormat;
    
    protected $enabled;
    
    protected $debug;
    
    protected $command;
    
    protected $schedule;
    
    public function getRecipients() {
        return $this->recipients;
    }
    
    public function setRecipients($recipients) {
        $this->recipients = $recipients;
        return $this;
    }
    
    public function addRecipient($recipient) {
        $this->recipients[] = $recipient;
        return $this;
    }
    
    public function getMailer() {
        return $this->mailer;
    }
    
    public function setMailer($mailer) {
        $this->mailer = $mailer;
        return $this;
    }
    
    public function getSmptHost() {
        return $this->smptHost;
    }
    
    public function setSmptHost($smptHost) {
        $this->smptHost = $smptHost;
        return $this;
    }
    
    public function getSmtpPort() {
        return $this->smtpPort;
    }
    
    public function setSmtpPort($smtpPort) {
        $this->smtpPort = $smtpPort;
        return $this;
    }
    
    public function getSmtpUsername() {
        return $this->smtpUsername;
    }
    
    public function setSmtpUsername($smtpUsername) {
        $this->smtpUsername = $smtpUsername;
        return $this;
    }
    
    public function getSmtpPassword() {
        return $this->smtpPassword;
    }
    
    public function setSmtpPassword($smtpPassword) {
        $this->smtpPassword = $smtpPassword;
        return $this;
    }
    
    public function getRunAs() {
        return $this->runAs;
    }
    
    public function setRunAs($runAs) {
        $this->runAs = $runAs;
        return $this;
    }
    
    public function getEnvironment() {
        return $this->environment;
    }
    
    public function setEnvironment($environment) {
        $this->environment = $environment;
        return $this;
    }
    
    public function getRunOnHost() {
        return $this->runOnHost;
    }
    
    public function setRunOnHost($runOnHost) {
        $this->runOnHost = $runOnHost;
        return $this;
    }
    
    public function getOutput() {
        return $this->output;
    }
    
    public function setOutput($output) {
        $this->output = $output;
        return $this;
    }
    
    public function getDateFormat() {
        return $this->dateFormat;
    }
    
    public function setDateFormat($dateFormat) {
        $this->dateFormat = $dateFormat;
        return $this;
    }
    
    public function getEnabled() {
        return $this->enabled;
    }
    
    public function setEnabled($enabled) {
        $this->enabled = $enabled;
        return $this;
    }
    
    public function getDebug() {
        return $this->debug;
    }
    
    public function setDebug($debug) {
        $this->debug = $debug;
        return $this;
    }
    
    public function getCommand() {
        return $this->command;
    }
    
    public function setCommand($command) {
        $this->command = $command;
        return $this;
    }
    
    public function getSchedule() {
        return $this->schedule;
    }
    
    public function setSchedule($schedule) {
        $this->schedule = $schedule;
        return $this;
    }
}
