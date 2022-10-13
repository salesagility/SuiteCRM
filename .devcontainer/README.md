# Stack to build SuiteCRM with Docker Compose

# Usage

This folder contains the files required for using the application inside docker containers.

It uses docker compose to create the main container with suiteCRM and another one for the database. Also it creates 3 volumes:
1. The root project is attached to `/var/www/html/suitecrm` to have the files in the required place for apache and enable the application in `localhost/suitecrm`
2. The `.devcontainer/config/php.ini` is attached to `/etc/php/7.4/apache2/php.ini` which allows you to place the required php configuration on this file.
3. The `/var/log/apache2` logs of the containers are placed inside `.devcontainer/logs` for debugging purposes.

Additionally, the xdebug is installed into the image and the configuration is placed in the php.ini file, this allows to use it directly from the containers.

_**NOTE: The first time the docker compose is runned, it needs to install some packages with composer, for this reason it may take a little longer to start**_


## General Pre-requisites
* Install Docker.
* In MacOS, open the docker desktop app, go to settings and enable the `Enable VirtioFS accelerated directory sharing` experimental feature.

## Configuration

The `config` folder inside `.devcontainer` contains a sample `php.ini` file with values that work for the application, this file will be used by the container to configure php.

Also, there is a `sample.env`, copy it into `.env` and update the values as needed, this will be the name and user for the database. These values will be required when installing suiteCRM for the first time.

_**NOTE: During the suiteCRM installation, the Host Name required for the database is the name of the docker compose service: `mariadb`**_

## To use it with VSCode

### Pre-requisites
* Install ms-vscode-remote.remote-containers.

### Steps
Open the project in vscode and press `ctrl+shift+p` to open the command palette and select the `Dev Containers: Reopen in Container` option. This will run the docker compose file inside `.devcontainer` and attach the editor to it. Then navigate to `localhost/suitecrm` and you will see the application.

## To use it with Docker Compose

Run `docker compose -f .devcontainer/docker-compose.yml up -d` from the root folder of the project to initialize the containers. Then navigate to `localhost/suitecrm` and you will see the application.

Use `docker compose -f .devcontainer/docker-compose.yml down` to delete them.
