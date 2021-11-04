<?php

declare(strict_types=1);

namespace Konstruktiv\SendGridNotificationChannel\Channels;

use Exception;
use Illuminate\Notifications\Notification;
use Konstruktiv\SendGridNotificationChannel\Messages\SendGridMessage;
use SendGrid;
use SendGrid\Mail\BccSettings;
use SendGrid\Mail\BypassListManagement;
use SendGrid\Mail\Footer;
use SendGrid\Mail\Mail;
use SendGrid\Mail\MailSettings;
use SendGrid\Mail\SandBoxMode;
use SendGrid\Mail\SpamCheck;
use SendGrid\Response;

class SendGridChannel
{

    /**
     * The SendGrid client instance.
     *
     * @var SendGrid
     */
    protected SendGrid $sendGrid;

    /**
     * The SendGrid bcc_settings variable
     *
     * @var BccSettings|bool
     */
    protected $bcc_settings;

    /**
     * The SendGrid bypass_list_management variable
     *
     * @var BypassListManagement|bool
     */
    protected $bypass_list_management;

    /**
     * The SendGrid footer variable
     *
     * @var Footer|bool
     */
    protected $footer;

    /**
     * The SendGrid sandbox_mode variable
     *
     * @var SandBoxMode|bool
     */
    protected $sandbox_mode;

    /**
     * The SendGrid spamcheck variable
     *
     * @var SpamCheck|bool
     */
    protected $spam_check;

    /**
     * Create a new SendGrid channel instance.
     *
     * @param SendGrid $sendGrid
     */
    public function __construct(\SendGrid $sendGrid)
    {
        $this->sendGrid = $sendGrid;
        $this->bcc_settings = config('sendgrid.bcc_settings');
        $this->bypass_list_management = config('sendgrid.bypass_list_management');
        $this->footer = config('sendgrid.footer');
        $this->sandbox_mode = config('sendgrid.sandbox_mode');
        $this->spam_check = config('sendgrid.spam_check');
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param Notification $notification
     *
     * @return Response
     * @throws SendGrid\Mail\TypeException
     * @throws Exception
     */
    public function send($notifiable, Notification $notification): Response
    {
        if (! method_exists($notification, 'toSendGrid')) {
            throw new Exception('You must implement toSendGrid in the notification class for SendGrid channel.');
        }

        /**
         * @var SendGridMessage $message
         */
        $message = $notification->toSendGrid($notifiable);

        if (! $message instanceof SendGridMessage) {
            throw new Exception('Not an valid instance of SendGridMessage found');
        }

        $email = new Mail(
            $message->from,
            $message->tos
        );

        $email->setTemplateId($message->templateId);

        if(isset($message->attachment)) {
            $email->addAttachment($message->attachment);
        }

        if($message->payload) {
            $email->addDynamicTemplateDatas($message->payload);
        }

        $email->setMailSettings(
            new MailSettings(
                $this->bcc_settings,
                $this->bypass_list_management,
                $this->footer,
                $this->sandbox_mode,
                $this->spam_check
            )
        );

        $response = $this->sendGrid->send(
            $email
        );

        if(!in_array($response->statusCode(),[200,202])) {
            throw new Exception($response->body());
        }

        return $response;

    }

}
