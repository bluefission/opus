<?php
// ApplicationBuilderSkill.php
namespace App\Business\Skills;

use BlueFission\Framework\Context;
use BlueFission\Framework\Skill\BaseSkill;
use BlueFission\Framework\Conversation\ApplicationBuilderConversation;

class ApplicationBuilderSkill extends BaseSkill
{
    protected $response;

    public function __construct()
    {
        parent::__construct('Application Builder');
    }

    public function execute(Context $context = null)
    {
        $botman = instance('botman');
        $conversation = new ApplicationBuilderConversation();
        $botman->startConversation($conversation);
        
        $this->response = "Preparing to configure your application."; // Empty response since the conversation handles the reply
    }

    public function response(): string
    {
        return (string)$this->response;
    }
}
