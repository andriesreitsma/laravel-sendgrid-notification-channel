<?php

declare(strict_types=1);

namespace Konstruktiv\SendGridNotificationChannel\Messages;

use SendGrid\Mail\Attachment;
use SendGrid\Mail\From;
use SendGrid\Mail\ReplyTo;
use SendGrid\Mail\Subject;
use SendGrid\Mail\Substitution;
use SendGrid\Mail\To;
use SendGrid\Mail\TypeException;


class SendGridMessage
{
    /**
     * The "from" for the message.
     *
     * @var From
     */
    public From $from;

    /**
     * The "reply-to" for the message.
     *
     * @var ReplyTo
     */
    public ReplyTo $replyTo;

    /**
     * The "tos" for the message.
     *
     * @var array[To]
     */
    public array $tos = [];

    /**
     * The "subject" for the message.
     *
     * @var Subject
     */
    public Subject $subject;

    /**
     * The SendGrid Template ID for the message.
     *
     * @var string
     */
    public string $templateId;

    /**
     * The "payload" for the message.
     *
     * @var array|Substitution[]
     */
    public array $payload = [];

    /**
     * The SendGrid Attachment for the message.
     *
     * @var Attachment
     */
    public Attachment $attachment;

    /**
     * Create a new SendGrid channel instance.
     *
     * @param string $templateId
     * @return void
     */

    public function __construct(string $templateId)
    {
        $this->templateId = $templateId;
    }

    /**
     * Set the "from".
     *
     * @param string $email
     * @param string $name
     * @return $this
     * @throws TypeException
     */
    public function from(string $email, string $name): SendGridMessage
    {
        $this->from = new From($email, $name);
        return $this;
    }

    /**
     * @param string $email
     * @param string $name
     * @return $this
     * @throws TypeException
     */
    public function replyTo(string $email, string $name): SendGridMessage
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
     * @throws TypeException
     */
    public function to(string $email, string $name, array $data = []): SendGridMessage
    {
        $this->tos = array_merge($this->tos, [new To($email, $name, $data)]);
        return $this;
    }

    /**
     * Set the "subject".
     *
     * @param string $subject
     * @return $this
     * @throws TypeException
     */
    public function subject(string $subject): SendGridMessage
    {
        $this->subject = new Subject($subject);
        return $this;
    }

    /**
     * Set the "payload".
     *
     * @param array $payload
     * @return $this
     */
    public function payload(array $payload): SendGridMessage
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
     * @throws TypeException
     */
    public function attachment(string $content , string $mimeType, string $filename): SendGridMessage
    {
        $this->attachment = new Attachment(
            $content,
            $mimeType,
            $filename
        );
        return $this;
    }
}
