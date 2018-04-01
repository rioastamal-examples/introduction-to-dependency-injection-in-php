<?php
/**
 * @copyright   2018 Rio Astamal <rio@rioastamal.net>
 * @author      Rio Astamal <rio@rioastamal.net>
 * @link        https://github.com/rioastamal/introduction-to-dependency-injection-in-php
 * @license     https://opensource.org/licenses/mit-license.php MIT License
 */
namespace RioAstamal\Examples\DI\Mailer;

use RioAstamal\Examples\DI\Mailer\Transport\MailTransportInterface;
use RioAstamal\Examples\DI\Mailer\Email;

/*
 * Class used to encapsuled building email message and defining email transport
 * to be used.
 */
class Mailer
{
    /**
     * Email's instance.
     *
     * @var RioAstamal\Examples\DI\Mailer\Email
     */
    protected $email = null;

    /**
     * Instance of MailTransportInterface implementation.
     *
     * @var RioAstamal\Examples\DI\Mailer\MailTransportInterface
     */
    protected $transport = null;

    /**
     * Constructor
     *
     * @param RioAstamal\Examples\DI\Mailer\Email $email
     * @param RioAstamal\Examples\DI\Mailer\MailTransportInterface $transport
     * @return void
     */
    public function __construct(Email $email, MailTransportInterface $transport)
    {
        $this->email = $email;
        $this->transport = $transport;
    }

    /**
     * @param MailTransportInterface $transport
     * @return RioAstamal\Examples\DI\Mailer\Email\Mailer
     */
    public function setTransport(MailTransportInterface $transport)
    {
        $this->transport = $transport;
        return $this;
    }

    /**
     * @param RioAstamal\Examples\DI\Mailer\Email $email
     * @return RioAstamal\Examples\DI\Mailer\Email\Mailer
     */
    public function setEmail(Email $email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return boolean
     */
    public function send()
    {
        return $this->transport->send($this->email);
    }

    /**
     * Property accessor so consumer can access protected property
     * directly.
     *
     * ```
     * $mailer = new Mailer($email, $transport);
     * $mailer->email; // Instance of Email
     * ```
     *
     * @param string $propertyName
     * @return mixed|null
     */
    public function __get($propertyName)
    {
        if (property_exists($this, $propertyName)) {
            return $this->{$propertyName};
        }

        return null;
    }
}