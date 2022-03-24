<p align="center">
    <a href="https://solutions.eptic.ro" target="_blank"><img src="https://raw.githubusercontent.com/eptic-solutions/art/master/cover.png" width="400px"/></a>
</p>
<p align="center">
    <a href="https://packagist.org/packages/eptic/valet-wsl"><img src="https://poser.pugx.org/eptic/valet-wsl/downloads.svg" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/eptic/valet-wsl"><img src="https://poser.pugx.org/eptic/valet-wsl/v/stable.svg" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/eptic/valet-wsl"><img src="https://poser.pugx.org/eptic/valet-wsl/v/unstable.svg" alt="Latest Unstable Version"></a>
    <a href="https://packagist.org/packages/eptic/valet-wsl"><img src="https://poser.pugx.org/eptic/valet-wsl/license.svg" alt="License"></a>
</p>

## Introduction

Valet *WSL* is an advanced development environment for Windows Subsystem for Linux.
No Vagrant, no `hosts` file manual management. You can even share your sites publicly using local tunnels. _Yeah, we like it too._

Valet *WSL* configures your system to always run Nginx in the background when your machine starts.
Because of the WSL limitations, DnsMasq is not used, instead valet manages the hosts files when any website is linked or unlinked.

In other words, a blazing fast PHP development environment that uses roughly 7mb of RAM. Valet *WSL* isn't a complete replacement for Valet Linux+, Laravel Valet, Vagrant or Homestead, but provides a great alternative if you want flexible basics, prefer extreme speed, or are working on a machine with a limited amount of RAM.

This is a port of [Valet Linux+](https://github.com/genesisweb/valet-linux-plus) made for WSL.
If you want the DnsMasq version of this project, please check it out.

## Official Documentation

WIP - Coming soon

## License

Laravel Valet is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
