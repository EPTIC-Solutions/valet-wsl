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
No Vagrant, no `hosts` file manual management. You can even share your sites publicly using local tunnels. _Yeah, we
like it too._

Valet *WSL* configures your system to always run Nginx in the background when your machine starts.
Because of the WSL limitations, DnsMasq is not used, instead valet manages the hosts files when any website is linked or
unlinked.

In other words, a blazing fast PHP development environment that uses roughly 7mb of RAM. Valet *WSL* isn't a complete
replacement for Valet Linux+, Laravel Valet, Vagrant or Homestead, but provides a great alternative if you want flexible
basics, prefer extreme speed, or are working on a machine with a limited amount of RAM.

This is a port of [Valet Linux+](https://github.com/genesisweb/valet-linux-plus) made for WSL.
If you want the DnsMasq version of this project, please check it out.

## Official Documentation

### Installing `Valet WSL`

### Important
- Always run Valet commands from a WSL shell runned as administrator.

#### Requirements

|                |                                                          |
|----------------|----------------------------------------------------------|
| Required OS    | WSL Ubuntu 14.04+                                        |
| OS Packages    | sudo apt-get install jq xsel                             |
| PHP Version    | 7.4, 8.0, 8.1                                            |
| PHP Extensions | php-cli php-curl php-mbstring php-mcrypt php-xml php-zip |

#### Installation
- Install or update PHP to one of the versions mentioned in the requirements.
- Install [Composer](https://getcomposer.org/) from the official website.
- Install Valet WSL with Composer via `composer global require eptic/valet-wsl`.
- Add `export PATH="$PATH:$HOME/.config/composer/vendor/bin"` to your `.bashrc` file.
- Run the `valet install` command. This will configure and install Valet WSL with all the required services, it will also register the Valet's daemon to launch when your system starts.
- Once Valet WSL is installed, you can run `valet start` to start all the services, and you can check if valet is working by visiting the page `http://localhost`.

#### Switching PHP Version
Switch PHP version using the command:
```bash
valet use <version>
```

Example:
```bash
valet use 8.1
```
Use `--update-cli` flag to update PHP cli version as well.

### Database

Valet WSL automatically installs MySQL. It includes a tweaked my.cnf which is aimed at improving speed.

#### Change password
It can be single line of code to change your MySQL password. We don't have to always login to MySQL and find for the query and execute it. It's just that simple as below:
```bash
valet db:password <old-password> <new-password>
```

#### List databases
```bash
valet db:list
```

#### Creating database
Create a new database using:
```bash
valet db:create <database-name>
```

When no name is given it will use the current working directory as the name of the database
```bash
valet db:create
```

#### Dropping database
```bash
valet db:drop <name>
```

When no name is given it will use the current working directory as the name of the database
```bash
valet db:drop
```

### Domain Alias / Symlinks

Display all of the registered symbolic links:
```bash
valet links
```

Add the current folder as a symlink:
```bash
valet link
```
For example:
```bash
$(/src/beel) valet link
```
This will create a symbolic link for the current folder and point it to `beel.test`

### Securing sites with TLS
By default, Valet serves sites over plain HTTP. However, if you would like to serve a site over encrypted TLS using HTTP/2, use the secure command.  
For example, if your site is being served by Valet on the `example.test` domain, you should run the following command to secure it:
```bash
valet secure example
```

If you don't provide the name and the current working directory is linked to a domain, it will use the current working directory as the domain.
```bash
$(/src/beel) valet secure
```
This will make `beel.test` to work with `https://beel.test`

## License

Valet WSL is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
