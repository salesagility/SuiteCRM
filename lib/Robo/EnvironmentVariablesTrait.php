<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */
namespace SuiteCRM\Robo;

trait EnvironmentVariablesTrait
{

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
export INSTANCE_CLIENT_ID={$opts['instance_client_id']};
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
            // write current file to backup file
            file_put_contents($bashAliasesPath . '~', $bashAliasesFile);
            // write new file to abash_aliases
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

}
