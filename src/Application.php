<?php
/**
 * @copyright   2018 Rio Astamal <rio@rioastamal.net>
 * @author      Rio Astamal <rio@rioastamal.net>
 * @link        https://github.com/rioastamal/introduction-to-dependency-injection-in-php
 * @license     https://opensource.org/licenses/mit-license.php MIT License
 */
namespace RioAstamal\Examples\DI;

use RioAstamal\Examples\DI\Mailer\Mailer;
use RioAstamal\Examples\DI\Mailer\Email;
use Exception;

/**
 * Simple application class to to demonstrate Dependency Injection for
 * Mailer class.
 *
 * To keep everything simple there's no validation performed.
 */
class Application
{
    /**
     * @var array
     */
    protected $config = [
        'mailer' => [
            'class' => '\RioAstamal\Examples\DI\Mailer\Transport\PhpMailTransport',
            // Transport specific config
            'config' => [],
        ]
    ];

    /**
     * Map request path with method name
     *
     * @var array
     */
    protected $routes = [
        '/' => 'homeController',
        'home' => 'homeController',
    ];

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config = $config + $this->config;
    }

    public function run($server, $post, $get)
    {
        $this->server = $server;
        $this->post = $post;
        $this->get = $get;

        if (!array_key_exists('PATH_INFO', $this->server)) {
            $this->server['PATH_INFO'] = '/';
        }

        // Get the first segement
        $path = explode('/', $this->server['PATH_INFO'], 3);
        $route = $path[1] ? $path[1] : '/';

        if (!array_key_exists($route, $this->routes)) {
            throw new Exception(sprintf('Route %s not found.', $route));
        }
        $handler = $this->routes[$route];
        $response = $this->$handler();

        return $response;
    }

    public function homeController()
    {
        $statusMessage = '';
        if (isset($this->post['send_email'])) {
            $statusMessage = $this->sendEmail();
        }

        return $this->homeView($statusMessage);
    }

    public function homeView($statusMessage='')
    {
        return <<<EOF
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <title>Send Email</title>
    <style>
    body { position: relative; font-family: "Helvetica Neue", sans-serif; }
    h1 { border-bottom: 1px solid #ccc; padding-bottom: 6px; }
    .block { display: block; min-width: 100%; max-width: 100%; box-sizing: border-box; }
    .label { background-color: #f1f1f1; padding: 8px 4px; width: 100%; }
    </style>
</head>
<body>
    <h1>Send Email</h1>
    <form action="" method="post">
        <label class="block label">To</label>
        <input type="text" name="to" class="block" value="" required>
        <label class="block label">From</label>
        <input type="text" name="from" class="block" value="" required>
        <label class="block label">Subject</label>
        <input type="text" name="subject" class="block" value="" required>
        <label class="block label">Message Body</label>
        <textarea class="block" name="body"></textarea>
        <input type="submit" name="send_email" value="Send Email">
    </form>
    $statusMessage
</body>
</html>
EOF;
    }

    protected function sendEmail()
    {
        $transportClass = $this->config['mailer']['class'];
        $mailerConfig = $this->config['mailer']['config'];
        $transporter = new $transportClass();
        $transporter->setTransportConfig($mailerConfig);

        $email = new Email(
            $this->post['to'],
            $this->post['subject'],
            $this->post['body'],
            $this->post['from']
        );
        $mailer = new Mailer($email, $transporter);
        if ($mailer->send()) {
            return '<p>Email sent!</p>';
        }

        return '<p>Email failed to send.</p>';
    }
}