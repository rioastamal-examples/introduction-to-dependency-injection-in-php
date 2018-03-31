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
use \Closure;

/*
 * Implementation of email transport used for unit testing. It will dump the
 * output to file or callback specified in config.
 */
class TestMailTransport implements MailTransportInterface
{
    /**
     * @var array
     */
    protected $config = [];

    /**
     * @param array $config
     * @return RioAstamal\Examples\DI\Mailer\Transport\TestMailTransport
     */
    public function setTransportConfig(array $config = [])
    {
        $defaultConfig = [
            // Output of the email could be file or a callback
            'output' => './email.dump'
        ];
        $this->config = $config + $defaultConfig;

        return $this;
    }

    /**
     * @param RioAstamal\Examples\DI\Mailer\Email $email
     * @return boolean
     */
    public function send(Email $email)
    {
        $response = [
            'headers' => $email->getHeaders(),
            'body' => $email->body
        ];

        // Dump the content of the response to the output which
        // specified in the config
        $output = $this->config['output'];

        if ($output instanceof Closure) {
            // Pass the response as an argument of the callback
            $output($response);

            return true;
        }

        if (file_exists($output)) {
            file_put_contents($output, serialize($response));
        }

        return true;
    }
}