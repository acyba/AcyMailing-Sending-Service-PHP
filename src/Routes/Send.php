<?php

namespace AcyMailer\Routes;

use Exception;
use PHPMailer\PHPMailer\PHPMailer;

trait Send
{
    private array $options;

    /**
     * @throws Exception
     */
    public function send(array $options = []): array
    {
        $this->options = $options;
        $this->checkRequiredOptions();
        $this->checkOptionsTypes();
        $this->addDefaultOption();

        return $this->apiService->request('/api/send', [
            'method' => 'POST',
            'body' => [
                'email' => $this->getMime(),
                'domainsUsed' => $this->getDomainsUsed(),
            ],
        ]);
    }

    /**
     * @throws Exception
     */
    private function checkRequiredOptions(): void
    {
        $requiredOptions = ['to', 'subject', 'body', 'from_email', 'from_name'];

        foreach ($requiredOptions as $requiredOption) {
            if (!array_key_exists($requiredOption, $this->options)) {
                throw new Exception('Missing required option: '.$requiredOption);
            }
        }
    }

    /**
     * @throws Exception
     */
    private function checkOptionsTypes(): void
    {
        $optionsTypes = [
            'to' => 'string',
            'subject' => 'string',
            'body' => 'string',
            'alt_body' => 'string',
            'from_email' => 'string',
            'from_name' => 'string',
            'reply_to_email' => 'string',
            'reply_to_name' => 'string',
            'cc' => 'array',
            'attachments' => 'array',
        ];

        foreach ($optionsTypes as $option => $type) {
            if (isset($this->options[$option]) && gettype($this->options[$option]) !== $type) {
                throw new Exception('Invalid type for option: '.$option);
            }
        }
    }

    private function addDefaultOption(): void
    {
        if (!isset($this->options['bounce_email'])) {
            $this->options['bounce_email'] = $this->options['from_email'];
        }

        if (!isset($this->options['reply_to_email'])) {
            $this->options['reply_to_email'] = $this->options['from_email'];
        }

        if (!isset($this->options['reply_to_name'])) {
            $this->options['reply_to_name'] = $this->options['from_name'];
        }

        if (!isset($this->options['alt_body'])) {
            $this->options['alt_body'] = strip_tags($this->options['body']);
        }
    }

    /**
     * @throws \PHPMailer\PHPMailer\Exception
     */
    private function getMime(): string
    {
        $mail = new PHPMailer(true);

        //Recipients
        $mail->setFrom($this->options['from_email'], $this->options['from_name']);
        $mail->addAddress($this->options['to']);
        $mail->addReplyTo($this->options['reply_to_email'], $this->options['reply_to_name']);

        if (isset($this->options['cc'])) {
            foreach ($this->options['cc'] as $cc) {
                $mail->addCC($cc);
            }
        }

        if (isset($this->options['attachments'])) {
            foreach ($this->options['attachments'] as $attachment) {
                $mail->addAttachment($attachment);
            }
        }

        $mail->isHTML();
        $mail->Subject = $this->options['subject'];
        $mail->Body = $this->options['body'];
        $mail->AltBody = $this->options['alt_body'];
        $mail->Sender = $this->options['bounce_email'];

        $mail->send();

        return $mail->getSentMIMEMessage();
    }

    private function getDomainsUsed(): array
    {
        $emailDomainsOptions = ['from_email', 'reply_to_email', 'bounce_email'];

        $domains = [];
        foreach ($emailDomainsOptions as $emailDomainsOption) {
            $domains[] = explode('@', $this->options[$emailDomainsOption])[1];
        }

        return array_unique($domains);
    }
}
