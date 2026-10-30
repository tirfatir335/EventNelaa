<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    /**
     * Email pengirim (from)
     */
    public string $fromEmail  = 'eventnelapolinela@gmail.com';
    public string $fromName   = 'EventNela';
    public string $recipients = '';

    /**
     * The "user agent"
     */
    public string $userAgent = 'CodeIgniter';

    /**
     * Protocol: mail, sendmail, smtp
     */
    public string $protocol = 'smtp';

    /**
     * Server path to Sendmail
     */
    public string $mailPath = '/usr/sbin/sendmail';

    /**
     * SMTP Server Hostname
     */
    public string $SMTPHost = 'smtp.gmail.com';

    /**
     * SMTP Username (Gmail EventNela)
     */
    public string $SMTPUser = 'eventnelapolinela@gmail.com';

    /**
     * SMTP Password (APP PASSWORD Gmail, 16 digit)
     */
    public string $SMTPPass = 'zjlm vzot tqbu syvf';

    /**
     * SMTP Port
     *  - 465 (SSL)
     *  - 587 (TLS)
     */
    public int $SMTPPort = 587;

    /**
     * SMTP Timeout (detik)
     */
    public int $SMTPTimeout = 15;

    /**
     * Enable persistent SMTP connections
     */
    public bool $SMTPKeepAlive = false;

    /**
     * SMTP Encryption:
     *  - 'ssl' untuk port 465
     *  - 'tls' untuk port 587
     */
    public string $SMTPCrypto = 'tls';

    /**
     * Type of mail: 'text' or 'html'
     */
    public string $mailType = 'html';

    /**
     * Character set
     */
    public string $charset = 'UTF-8';

    /**
     * Enable word-wrap
     */
    public bool $wordWrap = true;

    /**
     * Newline character
     */
    public string $CRLF = "\r\n";
    public string $newline = "\r\n";

    /**
     * Email Priority
     */
    public int $priority = 3;

    /**
     * Validate email address
     */
    public bool $validate = false;

    /**
     * BCC Batch Mode
     */
    public bool $BCCBatchMode = false;
    public int $BCCBatchSize = 200;

    /**
     * DSN
     */
    public bool $DSN = false;
}