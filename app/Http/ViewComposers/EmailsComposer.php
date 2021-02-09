<?php namespace App\Http\ViewComposers;


use CodedCell\Repository\Message\MessageInterface;
use CodedCell\Repository\Settings\SettingsInterface;
use Illuminate\Contracts\View\View;
use Input;

class EmailsComposer
{

    /**
     * @var SettingsInterface
     */
    private $setting;
    /**
     * @var MessageInterface
     */
    private $message;

    public function __construct(MessageInterface $message)
    {
        $this->message = $message;
    }

    public function compose(View $view)
    {
        $emails = $this->message->getSentEmails();
        $view->with('emails', $emails);
        $view->with('emailsCount', $emails->count());

    }


}