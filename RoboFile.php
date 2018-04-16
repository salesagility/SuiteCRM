<?php
/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
class RoboFile extends \Robo\Tasks
{
    // define public methods as commands

    /**
     * configure environment for testing
     * @see https://docs.suitecrm.com/developer/appendix-c---automated-testing/#_environment_variables
     * @param array $opts optional command line arguments
     */
    public function configureTests(
        array $opts = [
            'database_driver' => '',
            'database_name' => '',
            'database_host' => '',
            'database_user' => '',
            'database_password' => '',
            'instance_url' => '',
            'instance_admin_user' => '',
            'instance_admin_password' => '',
            'instance_client_id' => '',
            'instance_client_secret' => '',
        ]
    ) {
        $this->say('Configure Test Environment');

        // Database
        $this->askDefaultOptionWhenEmpty('Database Driver eg. MYSQL or MSSQL:', 'MYSQL', $opts['database_driver']);
        $this->askDefaultOptionWhenEmpty('Database host:', 'localhost', $opts['database_host']);
        $this->askDefaultOptionWhenEmpty('Database Username:', 'suitecrm_tests', $opts['database_user']);
        $this->askDefaultOptionWhenEmpty('Database User password:', 'suitecrm_tests', $opts['database_password']);
        $this->askDefaultOptionWhenEmpty('Database Name:', 'sutiecrm_tests', $opts['database_name']);

        // SuiteCRM Instance
        $this->askDefaultOptionWhenEmpty('Instance URL:', 'http://localhost', $opts['instance_url']);
        $this->askDefaultOptionWhenEmpty('Instance Admin Username:', 'admin', $opts['instance_admin_user']);
        $this->askDefaultOptionWhenEmpty('Instance Admin Password:', 'admin1', $opts['instance_admin_password']);
        $this->askDefaultOptionWhenEmpty('Instance OAuth2 Client ID:', 'suitecrm_client', $opts['instance_client_id']);
        $this->askDefaultOptionWhenEmpty('Instance OAuth2 Client Secret:', 'secret', $opts['instance_client_secret']);

        if ($this->isOsWindows()) {
            $this->say('Windows detected');
            $this->installWindowsEnvironmentVariables($opts);
        } elseif ($this->isOsLinux()) {
            $this->say('Linux detected');
            $this->installUnixEnvironmentVariables($opts);
        } elseif ($this->isOsMacOsX()) {
            $this->say('Mac OS X detected');
            $this->installUnixEnvironmentVariables($opts);
        } elseif ($this->isOsBSD()) {
            $this->say('BSD detected');
            $this->installUnixEnvironmentVariables($opts);
        } elseif ($this->isOsSolaris()) {
            $this->say('Solaris detected');
            $this->installUnixEnvironmentVariables($opts);
        } elseif ($this->isOsUnknown()) {
            throw new \DomainException('Unknown Operating system');
        } else {
            throw new \DomainException('Unable to detect Operating system');
        }
    }

    /**
     * Build SuiteP theme
     * @params array $opts optional command line arguments
     * color_scheme - set which color scheme you wish to build
     */
    public function buildSuitep(array $opts = ['color_scheme' => ''])
    {
        $this->say('Compile SuiteP Theme (SASS)');
        if (empty($opts['color_scheme'])) {
            $this->buildSuitePColorScheme('Dawn');
            $this->buildSuitePColorScheme('Day');
            $this->buildSuitePColorScheme('Dusk');
            $this->buildSuitePColorScheme('Night');
        } else {
            $this->buildSuitePColorScheme($opts['color_scheme']);
        }
    }

    /**
     * @param string $path
     * @return string path converted for operating system eg Linux, Mac OS, Windows
     */
    private function toOsPath($path)
    {
        return str_replace('/', DIRECTORY_SEPARATOR, $path);
    }

    /**
     * @return bool true when operating system is BSD
     */
    private function isOsBSD() {
        return stristr(php_uname('s'), 'BSD') !== FALSE;
    }

    /**
     * @return bool true when operating system is Linux
     */
    private function isOsLinux() {
        return stristr(php_uname('s'), 'Linux') !== FALSE;
    }

    /**
     * @return bool true when operating system is Mac OS X
     */
    private function isOsMacOSX() {
        return stristr(php_uname('s'), 'Darwin') !== FALSE;
    }

    /**
     * @return bool true when operating system is Solaris
     */
    private function isOsSolaris() {
        return stristr(php_uname('s'), 'Solaris') !== FALSE;
    }

    /**
     * @return bool true when operating system is Unknown
     */
    private function isOsUnknown() {
        return php_uname('s') === 'Unknown';
    }

    /**
     * @return bool true when operating system is Windows
     */
    private function isOsWindows() {
        return stristr(php_uname('s'), 'Windows') !== FALSE;
    }

    /**
     * Install unix environment variables for the testing framework
     * @param array $opts optional command line arguments
     */
    private function installUnixEnvironmentVariables(array $opts)
    {
$environment_string_unix = "
export DATABASE_DRIVER={$opts['database_driver']};
export DATABASE_NAME={$opts['database_name']};
export DATABASE_HOST={$opts['database_host']};
export DATABASE_USER={$opts['database_user']};
export DATABASE_PASSWORD={$opts['database_password']};
export INSTANCE_URL={$opts['instance_url']};
export INSTANCE_ADMIN_USER={$opts['instance_admin_user']};
export INSTANCE_ADMIN_PASSWORD={$opts['instance_admin_password']};
expo}t INSTANCE_CLIENT_ID={$opts['instance_client_id']};
export INSTANCE_CLIENT_SECRET={$opts['instance_client_secret']};";

        $home = getenv("HOME");
        $bashAliasesPath = $home.DIRECTORY_SEPARATOR.'.bash_aliases';

        // create bash alias file?
        if (!file_exists($bashAliasesPath)) {
            $this->say('Creating ' . $bashAliasesPath);
            file_put_contents($bashAliasesPath, '');
        }

        $bashAliasesFile = file_get_contents($bashAliasesPath);
        $bashAliasesLines = explode(PHP_EOL, $bashAliasesFile);

        $this->say('Get File Contents ' . $bashAliasesPath);
        $self = $this;
        // Delete existing variables
        foreach ($opts as $optionKey => $optionValue) {
            // find option key
            $bashAliasesLines = array_map(function($line) use ($self, $optionKey) {
                // delete line
                if (stristr($line, $optionKey) !== false) {
                    $self->say('Removed: '.$optionKey);
                    return '';
                } else {
                    return $line;
                }
            }, $bashAliasesLines);

        }

        $this->writeln('Generate a new .bash_aliases file');
        $newBashAliasesFile = '';
        // Only add lines which are not empty to the new file
        foreach ($bashAliasesLines as $line) {
            if (!empty($line)) {
                $newBashAliasesFile .= $line;
            }
        }
        $newBashAliasesFile .= $environment_string_unix;
        $this->writeln($newBashAliasesFile);
        if ($this->confirm('May I overwrite '.$bashAliasesPath .'?')) {
            $this->say('Exporting variables to ' . $bashAliasesPath);
            // write backup file
            file_put_contents($bashAliasesPath . '~', $newBashAliasesFile);
            // write actual file
            file_put_contents($bashAliasesPath, $newBashAliasesFile);
            $this->writeln('Please restart your terminal or run `bash`');
        } else {
            $this->say('Skipping overwrite' . $bashAliasesPath);
        }
    }

    /**
     * Install windows environment variables for the testing framework
     * @param array $opts optional command line arguments
     */
    private function installWindowsEnvironmentVariables($opts)
    {
        $windows_environment_variables = "
setx DATABASE_DRIVER {$opts['database_driver']}
setx DATABASE_NAME {$opts['database_name']}
setx DATABASE_HOST {$opts['database_host']}
setx DATABASE_USER {$opts['database_user']}
setx DATABASE_PASSWORD {$opts['database_password']}
setx INSTANCE_URL {$opts['instance_url']}
setx INSTANCE_ADMIN_USER {$opts['instance_admin_user']}
setx INSTANCE_ADMIN_PASSWORD {$opts['instance_admin_password']}
setx INSTANCE_CLIENT_ID {$opts['instance_client_id']}
setx INSTANCE_CLIENT_SECRET {$opts['instance_client_secret']}";
        $this->writeln("Generate Script");
        $this->writeln($windows_environment_variables);

        if ($this->confirm('May I overwrite the environment variables?')) {
            $this->say('Overwriting environment variables');
            $environment_variables = explode(PHP_EOL, $windows_environment_variables);
            foreach ($environment_variables as $command) {
                $this->_exec($command);
            }
            $this->writeln('Please restart your command prompt or powershell');
        } else {
            $this->say('Skipping overwrite');
        }
    }

    /**
     * @param string $colorScheme eg Dawn
     */
    private function buildSuitePColorScheme($colorScheme)
    {
        $this->_exec(
            $this->toOsPath(
                "./vendor/bin/pscss -f compressed themes/SuiteP/css/{$colorScheme}/style.scss > themes/SuiteP/css/{$colorScheme}/style.css"
            )
        );
    }

    /**
     * Asks user to set option when option is empty
     * @param string $question
     * @param string $default
     * @param &string key to options param
     */
    private function askDefaultOptionWhenEmpty($question, $default, &$option)
    {
        if (empty($option)) {
            $option = $this->askDefault($question, $default);
        }
    }
}
