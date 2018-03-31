<?php
/**
 * @copyright   2018 Rio Astamal <rio@rioastamal.net>
 * @author      Rio Astamal <rio@rioastamal.net>
 * @link        https://github.com/rioastamal/introduction-to-dependency-injection-in-php
 * @license     https://opensource.org/licenses/mit-license.php MIT License
 */
namespace RioAstamal\Examples\DI\Mailer\Transport;

use RioAstamal\Examples\DI\Mailer\Transport\MailTransportInterface;
use RioAstamal\Examples\DI\Mailer\Email;

/**
 * Implementation of email transport using PHP's mail() function.
 */
class PhpMailTransport implements MailTransportInterface
{
    /**
     * @param array $config
     * @return RioAstamal\Examples\DI\Mailer\Transport\PhpMailTransport
     */
    public function setTransportConfig(array $config = [])
    {
        // No need configuration for this transport
        return $this;
    }

    /**
     * @param RioAstamal\Examples\DI\Mailer\Email $email
     * @return boolean
     */
    public function send(Email $email)
    {
        $headersWithoutToAndSubject = [];

        foreach ($email->getHeaders() as $name => $value) {
            if (! in_array($name, ['To', 'Subject'])) {
                $headersWithoutToAndSubject[] = sprintf('%s: %s', $name, $value);
            }
        }
        $headersWithoutToAndSubject = implode("\r\n", $headersWithoutToAndSubject);

        return mail($email->To, $email->Subject, $email->body, $headersWithoutToAndSubject);
    }
}