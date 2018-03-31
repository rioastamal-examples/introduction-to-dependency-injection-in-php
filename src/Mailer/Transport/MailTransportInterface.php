<?php
/**
 * All implementation of email transport should based on this interface.
 *
 * @copyright   2018 Rio Astamal <rio@rioastamal.net>
 * @author      Rio Astamal <rio@rioastamal.net>
 * @link        https://github.com/rioastamal/introduction-to-dependency-injection-in-php
 * @license     https://opensource.org/licenses/mit-license.php MIT License
 */
namespace RioAstamal\Examples\DI\Mailer\Transport;
use RioAstamal\Examples\DI\Mailer\Email;

interface MailTransportInterface
{
    /**
     * @param array $config
     * @return RioAstamal\Examples\DI\Mailer\Transport
     */
    public function setTransportConfig(array $config = []);

    /**
     * @return boolean Return true on success or false on fails
     */
    public function send(Email $email);
}