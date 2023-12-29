# SelfUpdate

Symfony Console command to update a phar in place.

## Usage

To use the self:update command, instantiate it with the name of the application,
its current version, and the full name of the GitHub project.
```
$cmd = new SelfUpdateCommand('MyAppName', '1.0.0', 'org/my-app');
$app->add($cmd);
```

## Similar Projects

- https://github.com/DavaHome/self-update
- https://github.com/padraic/phar-updater
