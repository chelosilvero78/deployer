<?php

namespace REBELinBLUE\Deployer\Scripts;

use Illuminate\Support\Facades\Log;
use REBELinBLUE\Deployer\Server;
use Symfony\Component\Process\Process;

/**
 * Class which runs scripts.
 */
class Runner
{
    const TEMPLATE_INPUT = true;
    const DIRECT_INPUT = false;

    private $process;
    private $script;
    private $server;
    private $private_key;
    private $is_local = true;

    /**
     * Class constructor.
     *
     * @param string $input
     * @param array  $tokens
     * @param int    $script_source
     */
    public function __construct($input, array $tokens = [], $script_source = self::TEMPLATE_INPUT)
    {
        $this->process = new Process('');
        $this->process->setTimeout(null);

        if ($script_source === self::TEMPLATE_INPUT) {
            $this->script = with(new Parser)->parseFile($input, $tokens);
        } else {
            $this->script = with(new Parser)->parseString($input, $tokens);
        }
    }

    /**
     * Prepend commands to the beginning of the script.
     *
     * @param  string $script
     * @return self
     */
    public function prependScript($script)
    {
        $this->script = trim($script . PHP_EOL . $this->script);

        return $this;
    }

    /**
     * Append commands to the end of the script.
     *
     * @param  string $script
     * @return self
     */
    public function appendScript($script)
    {
        $this->script = trim($this->script . PHP_EOL . $script);

        return $this;
    }

    /**
     * Runs a script locally.
     *
     * @param  callable|null $callback
     * @return int
     */
    public function run($callback = null)
    {
        $command = $this->wrapCommand($this->script);

        $this->process->setCommandLine($command);

        return $this->process->run($callback);
    }

    /**
     * Sets the script to run on a remote server.
     *
     * @param  Server $server
     * @param  string $private_key
     * @return self
     */
    public function setServer(Server $server, $private_key)
    {
        $this->server      = $server;
        $this->private_key = $private_key;
        $this->is_local    = false;

        return $this;
    }

    /**
     * Wraps the command in either local or remote wrappers.
     *
     * @param  string $script
     * @return string
     */
    private function wrapCommand($script)
    {
        $wrapper = 'Locally';
        $tokens  = [
            'script' => trim($script),
        ];

        if (!$this->is_local) {
            $wrapper = 'OverSSH';
            $tokens  = array_merge($tokens, [
                'private_key' => $this->private_key,
                'username'    => $this->server->user,
                'port'        => $this->server->port,
                'ip_address'  => $this->server->ip_address,
            ]);
        }

        $output = with(new Parser)->parseFile('RunScript' . $wrapper, $tokens);

        Log::debug($output);

        return $output;
    }

    /**
     * Overloading call to undefined methods to pass them to the process object.
     *
     * @param  string $method
     * @param  array  $arguments
     * @return mixed
     * @throws RuntimeException
     */
    public function __call($method, array $arguments = [])
    {
        if (!is_callable([$this->process, $method])) {
            throw new \RuntimeException('Method ' . $method . ' not exists');
        }

        return call_user_func([$this->process, $method], $arguments);
    }
}
