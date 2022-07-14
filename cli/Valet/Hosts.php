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

        $contentsText = "127.0.0.1     $url";

        for ($i = 0; $i < 24 - strlen($url); $i++) {
            $contentsText .= ' ';
        }
        $contents[] = $contentsText . "#" . self::comment . "\r\n";

        $this->files->put(self::hosts_path, implode('', $contents));
    }

    /**
     * Clear all linked websites from the hosts file.
     *
     * @return void
     */
    public function clear()
    {
        $domain = $this->configuration->get('domain');

        $contents = file(self::hosts_path);
        $contentsCount = count($contents);

        for ($i = 0; $i < $contentsCount; $i++) {
            if (strpos($contents[$i], '.' . $domain) !== false) {
                unset($contents[$i]);
            }
        }

        $this->files->put(self::hosts_path, implode('', $contents));
    }

    /**
     * Add all the websites currently linked to the hosts file.
     *
     * @return void
     */
    public function linkAll()
    {
        foreach ($this->files->scanDir(VALET_HOME_PATH . '/Sites') as $site) {
            $this->link($site);
        }
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
    }
}
