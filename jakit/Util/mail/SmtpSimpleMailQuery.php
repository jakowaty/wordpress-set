<?php declare(strict_types = 1);

namespace Jak\Wordpress\Util\Mail;

/*
 * Jakit Wordpress Theme
 * Author: Piotr Be <herbalist@herbalist.hekko24.pl>
 */

use Jak\Wordpress\Util\Query;

class SmtpSimpleMailQuery implements Query
{
    public const ERROR_CODES = [
        10 => 'LOGIC NO SUBJECT OR NO MESSAGE',
        20 => 'SUBJECT DID NOT PASS VALIDATION',
        30 => 'RECIPIENT ADDRESS INVALID ACCORDING TO RFC822',
        40 => 'SENDING MAIL FAILED'
    ];

    public $errorCode;

    /**
     * @var string
     */
    private $message;

    /**
     * @var string
     */
    private $subject;

    /**
     * SmtpSimpleMailQuery constructor.
     * @param string $subject
     * @param string $message
     */
    public function __construct(string $subject, string $message)
    {
        $this->subject = $subject;
        $this->message = $message;
    }

    /**
     * @param string $who
     * @return bool
     */
    public function query(string $who): bool
    {
        if (!$this->subject || !$this->message) {
            $this->errorCode = 10;
            return false;
        }

        if (!self::validateSubject($this->subject)) {
            $this->errorCode = 20;
            return false;
        }

        if (!\filter_var($who, \FILTER_VALIDATE_EMAIL)) {
            $this->errorCode = 30;
            return false;
        }

        $body = self::prepareMessageBody($this->message);
        $result = \mail($who, $this->subject, $body);

        if (!$result) {
            $this->errorCode = 40;
        }

        return $result;
    }

    /**
     * @param null|string $message
     * @return $this|string
     */
    public function message(?string $message)
    {
        if ($message === null) {
            return $this->message;
        }

        $this->message = $message;

        return $this;
    }

    /**
     * @param null|string $subject
     * @return $this|string
     */
    public function subject(?string $subject)
    {
        if ($subject === null) {
            return $this->subject;
        }

        $this->subject = $subject;

        return $this;
    }

    /**
     * @param string $msg
     * @return string
     */
    private static function prepareMessageBody(string $msg): string
    {
        if (\mb_strlen($msg) > 500) {
            $msg = \mb_substr($msg, 0, 500);
        }

        $msg = \trim($msg);
        $msg = \htmlspecialchars($msg, \ENT_QUOTES, 'UTF-8', false);
        $msg = \str_split($msg, 68);
        $msg = \implode("\r\n", $msg);

        return $msg;
    }

    /**
     * @param string $subject
     * @return bool
     */
    private static function validateSubject(string $subject): bool
    {
        $subjectLen = \mb_strlen($subject);

        if ($subjectLen > 100 || $subjectLen < 3) {
            return false;
        }

        return \mb_ereg_match('[a-zA-Z\s\d._\-\?\!:]+', $subject);
    }
}