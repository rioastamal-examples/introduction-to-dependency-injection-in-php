<?php
/**
 * @copyright   2018 Rio Astamal <rio@rioastamal.net>
 * @author      Rio Astamal <rio@rioastamal.net>
 * @link        https://github.com/rioastamal/introduction-to-dependency-injection-in-php
 * @license     https://opensource.org/licenses/mit-license.php MIT License
 */
namespace RioAstamal\Examples\DI\Mailer;

/*
 * Class used to build email message. This class used to define email headers
 * and message body.
 */
class Email
{
    /**
     * List of email headers
     *
     * @var array
     */
    protected $headers = [];

    /**
     * Email message
     *
     * @var string
     */
    protected $body = '';

    /**
     * @param string $to Recipient email address
     * @param string $subject
     * @param string $body
     * @param string $from Sender email address
     */
    public function __construct($to = '', $subject = '', $body = '', $from = '')
    {
        $this->setTo($to);
        $this->setSubject($subject);
        $this->setBody($body);
        $this->setFrom($from);
    }

    /**
     * @param array $header Key value pair dari header email
     * @return RioAstamal\Examples\DI\Mailer\Transport
     */
    public function addHeader(array $header)
    {
        $this->headers = array_merge($this->headers, $header);
    }

    /**
     * @param string $body
     * @return RioAstamal\Examples\DI\Mailer\Transport
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @param string $emailAddress Destination address
     * @return RioAstamal\Examples\DI\Mailer
     */
    public function setTo($emailAddress)
    {
        $this->addHeader(['To' => $emailAddress]);
        return $this;
    }

    /**
     * @param string $emailAddress Sender address
     * @return RioAstamal\Examples\DI\Mailer
     */
    public function setFrom($emailAddress)
    {
        $this->addHeader(['From' => $emailAddress]);
        return $this;
    }

    /**
     * @param string $subject Email subject
     * @return RioAstamal\Examples\DI\Mailer
     */
    public function setSubject($subject)
    {
        $this->addHeader(['Subject' => $subject]);
        return $this;
    }

    /**
     * @param array $name List of header name
     * @return array
     */
    public function getHeaders(array $name=[])
    {
        if (empty($name)) {
            return $this->headers;
        }

        $headers = [];
        foreach ($name as $currentName) {
            foreach ($this->headers as $headerName => $value) {
                if ($currentName === $headerName) {
                    $headers[$headerName] = $value;
                }
            }
        }

        return $headers;
    }

    /**
     * Property accessor so consumer can access protected property
     * directly.
     *
     * ```
     * $email = new Email('john@example.com');
     * echo $email->To; // Output will be john@example.com
     * ```
     *
     * @param string $propertyName
     * @return mixed|null
     */
    public function __get($propertyName)
    {
        if (array_key_exists($propertyName, $this->headers)) {
            return $this->headers[$propertyName];
        }

        if (property_exists($this, $propertyName)) {
            return $this->{$propertyName};
        }

        return null;
    }
}