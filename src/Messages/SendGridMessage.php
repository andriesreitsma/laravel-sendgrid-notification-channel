<?php

declare(strict_types=1);

namespace Konstruktiv\SendGridNotificationChannel\Messages;

use PhpParser\Node\Scalar\String_;
use SendGrid\Mail\Attachment;
use SendGrid\Mail\Mail;
use SendGrid\Mail\ReplyTo;
use SendGrid\Mail\Subject;
use SendGrid\Mail\Substitution;
use SendGrid\Mail\To;
use SendGrid\Mail\From;


class SendGridMessage
{
    /**
     * The "from" for the message.
     *
     * @var From
     */
    public $from;

    /**
     * The "reply-to" for the message.
     *
     * @var ReplyTo
     */
    public $replyTo;

    /**
     * The "tos" for the message.
     *
     * @var array[To]
     */
    public $tos = [];

    /**
     * The "subject" for the message.
     *
     * @var string
     */
    public $subject = '';

    /**
     * The SendGrid Template ID for the message.
     *
     * @var string
     */
    public $templateId;

    /**
     * The "payload" for the message.
     *
     * @var array|Substitution[]
     */
    public $payload = [];

    /**
     * The SendGrid Attachment for the message.
     *
     * @var Attachment
     */
    public $attachment;

    /**
     * Create a new SendGrid channel instance.
     *
     * @param string $templateId
     * @return void
     */

    public function __construct($templateId)
    {
        $this->templateId = $templateId;
    }

    /**
     * Set the "from".
     *
     * @param string $email
     * @param string $name
     * @return $this
     */
    public function from($email, $name)
    {
        $this->from = new From($email, $name);
        return $this;
    }

    public function replyTo($email, $name)
    {
        $this->replyTo = new ReplyTo($email, $name);
        return $this;
    }

    /**
     * Set the "tos".
     *
     * @param string $email
     * @param string $name
     * @param array $data
     * @return $this
     */
    public function to($email, $name, $data = [])
    {
        $this->tos = array_merge($this->tos, [new To($email, $name, $data)]);
        return $this;
    }

    /**
     * Set the "subject".
     *
     * @param string $subject
     * @return $this
     */
    public function subject($subject)
    {
        $this->subject = new Subject($subject);
        return $this;
    }

    /**
     * Set the "payload".
     *
     * @param string $subject
     * @return $this
     */
    public function payload($payload)
    {
        $this->payload = $payload;

        return $this;
    }

    /**
     * Set the "attachment"
     *
     * @param string $content
     * @param string $mimeType
     * @param string $filename
     * @return $this
     */
    public function attachment(string $content , string $mimeType, string $filename) {
        $this->attachment = new Attachment(
            $content,
            $mimeType,
            $filename
        );
        return $this;
    }
}
