<?php
/**
 * @copyright   2018 Rio Astamal <rio@rioastamal.net>
 * @author      Rio Astamal <rio@rioastamal.net>
 * @link        https://github.com/rioastamal/introduction-to-dependency-injection-in-php
 * @license     https://opensource.org/licenses/mit-license.php MIT License
 */
namespace RioAstamal\Examples\DI\Test\App;
use PHPUnit\Framework\TestCase;
use RioAstamal\Examples\DI\Application;

/**
 * Perform test to Application instance and inspect the email output. We uses
 * TestMailTransport class and a Callback to catch the response.
 */
final class AppTest extends TestCase
{
    public function testSendEmail()
    {
        $emailResponse = [];
        $config = [
            'mailer' => [
                'class' => '\RioAstamal\Examples\DI\Mailer\Transport\TestMailTransport',
                'config' => [
                    'output' => function($response) use (&$emailResponse) {
                        // Dump the array of email response to $emailResponse
                        // The response array should contains 'headers' and 'body' key
                        $emailResponse = $response;
                    }
                ]
            ]
        ];
        $server = ['PATH_INFO' => '/home'];
        $post = [
            'to' => 'john@example.com',
            'from' => 'smith@example.com',
            'subject' => 'Email from unit testing',
            'body' => 'Hello John, long time no see!',
            'send_email' => 'Send Email'
        ];

        $app = new Application($config);
        $appResponse = $app->run($server, $post, []);

        $this->assertContains('Email sent!', $appResponse);
        $this->assertSame($post['to'], $emailResponse['headers']['To']);
        $this->assertSame($post['from'], $emailResponse['headers']['From']);
        $this->assertSame($post['subject'], $emailResponse['headers']['Subject']);
        $this->assertSame($post['body'], $emailResponse['body']);
    }
}