<?php


namespace IntecPhp\Model;

/**
 * Wrapper para envio de emails
 * @author intec
 */
class EmailWrapper
{
    private $projectIdentifier;
    private $smtpServer;
    private $smtpPort;
    private $ssl;
    private $authEmail;
    private $authPass;
    private $fromName;
    private $fromEmail;
    private $toName;
    private $toEmail;
    private $addBcc;
    private $bccName;
    private $bccEmail;
    private $subject;
    private $body;
    private $attachments;
    private $fakeFromName;
    private $fakeFromEmail;

    private $emailPath = 'app/data/email';

    public function __construct($config, $subject, $toName, $toEmail, $body, $addBcc = true, $prefixSubject = true, $attachments = [])
    {
        $this->projectIdentifier = str_replace(' ', '_', $config::$PROJECT_ID);
        $this->smtpServer = $config::$SMTP_SERVER;
        $this->smtpPort = $config::$SMTP_PORT;
        $this->ssl = $config::$SMTP_SSL;
        $this->authEmail = $config::$EMAIL;
        $this->authPass = $config::$EMAIL_PASS;
        $this->fromName = utf8_encode($config::$EMAIL_NAME);
        $this->fromEmail = $config::$EMAIL_FROM;
        $this->toName = utf8_encode($toName);
        $this->toEmail = $toEmail;
        $this->addBcc = $addBcc;
        $this->bccName = utf8_encode($config::$EMAIL_BCC_NAME);
        $this->bccEmail = $config::$EMAIL_BCC_EMAIL;
        $this->body = utf8_encode($body);
        $this->attachments = $attachments;
        if ($prefixSubject) {
            $this->subject = utf8_encode($config::$EMAIL_SUBJECT_PREFIX . ' ' . $subject);
        } else {
            $this->subject = utf8_encode($subject);
        }
        $this->fakeFromName = null;
        $this->fakeFromEmail = null;
    }
    public function setFakeFrom($name, $email)
    {
        $this->fakeFromName = $name;
        $this->fakeFromEmail = $email;
    }
    public function send()
    {
        $time = time();
        $arr = [
                'projectIdentifier' => $this->projectIdentifier,
                'timestamp' => $time,
                'smtpServer' => $this->smtpServer,
                'smtpPort' => $this->smtpPort,
                'ssl' => $this->ssl,
                'authEmail' => $this->authEmail,
                'fromName' => $this->fromName,
                'fromEmail' => $this->fromEmail,
                'toName' => $this->toName,
                'toEmail' => $this->toEmail,
                'addBcc' => $this->addBcc,
                'bccName' => $this->bccName,
                'bccEmail' => $this->bccEmail,
                'subject' => $this->subject,
                'body' => $this->body,
                'attachments' => $this->attachments,
        ];
        if ($this->fakeFromEmail) {
            $arr['fakeFromName'] = $this->fakeFromName;
            $arr['fakeFromEmail'] = $this->fakeFromEmail;
        }
        $jsonData = json_encode($arr, JSON_PRETTY_PRINT);
        if ($jsonData === false) {
            return json_last_error_msg();
        }
        $filename = $this->projectIdentifier . '.[' . date('YmdHis') .'].'. uniqid() . '.json';
        $file = $this->emailPath .'/json/' . $filename;
        $result = file_put_contents($file, $jsonData);

        if ($result !== false) {
            chmod($file, 0777);
            $cmd = 'php '. $this->emailPath .'/bin/email.send.php ' . $file . ' ' . $this->authPass;
            $suffix = "> /dev/null 2>/dev/null &";
            shell_exec($cmd . $suffix);
            return true;
        }

        return 'Não foi possível salvar o arquivo';
    }
}
