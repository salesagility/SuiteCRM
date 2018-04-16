<?php
require_once __DIR__.'/vendor/autoload.php';
/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
class RoboFile extends \Robo\Tasks
{
    use \SuiteCRM\Robo\OperatingSystemTrait;
    use \SuiteCRM\Robo\EnvironmentVariablesTrait;
    use \SuiteCRM\Robo\SassTrait;
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
