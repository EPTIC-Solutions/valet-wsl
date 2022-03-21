<?php

namespace Valet;

class Hosts
{
    const hosts_path = VALET_HOSTS_PATH;
    const comment = 'valet magic!';

    public $files;
    public $configuration;

    /**
     * Create a new instance.
     *
     * @param Filesystem     $files
     * @param Configuration  $configuration
     */
    public function __construct(
        Filesystem $files,
        Configuration $configuration,
    ) {
        $this->files = $files;
        $this->configuration = $configuration;
    }

    /**
     * Add a new record to the hosts file.
     * 
     * @param string $siteName
     */
    public function link(string $siteName)
    {
        $domain = $this->configuration->get('domain');
        $url = "$siteName.$domain";

        $contents = file(self::hosts_path);

        $urlAlreadyInHosts = false;
        foreach ($contents as $line) {
            if (strpos($line, $url)) {
                $urlAlreadyInHosts = true;
                break;
            }
        }

        if ($urlAlreadyInHosts) {
            return;
        }

        $contents[] = "127.0.0.1 $url #" . self::comment . "\r\n";

        $this->files->put(self::hosts_path, implode('', $contents));
        dump(file(self::hosts_path));
    }

    /**
     * Remove an existing record from the hosts file.
     * 
     * @param string $siteName
     */
    public function unlink(string $siteName)
    {
        $domain = $this->configuration->get('domain');
        $url = "$siteName.$domain";

        $contents = file(self::hosts_path);

        $urlWasRemoved = false;
        foreach ($contents as $lineNumber => $line) {
            if (strpos($line, $url) && strpos($line, self::comment)) {
                $urlWasRemoved = true;
                unset($contents[$lineNumber]);
                continue;
            }
        }

        if (!$urlWasRemoved) {
            return;
        }

        $this->files->put(self::hosts_path, implode('', $contents));
        dump(file(self::hosts_path));
    }
}
