<?php

/**
 * SuiteCRM is a customer relationship management program developed by SalesAgility Ltd.
 * Copyright (C) 2021 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SALESAGILITY, SALESAGILITY DISCLAIMS THE
 * WARRANTY OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see http://www.gnu.org/licenses.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License
 * version 3, these Appropriate Legal Notices must retain the display of the
 * "Supercharged by SuiteCRM" logo. If the display of the logos is not reasonably
 * feasible for technical reasons, the Appropriate Legal Notices must display
 * the words "Supercharged by SuiteCRM".
 */

require_once __DIR__ . '/../../../install/install_utils.php';
require_once __DIR__ . '/../../utils.php';
require_once __DIR__ . '/../../utils/sugar_file_utils.php';
require_once __DIR__ . '/Traits/InstallErrorTrait.php';
require_once __DIR__ . '/Traits/InstallValidationTrait.php';
require_once __DIR__ . '/Traits/InstallValidationTrait.php';
require_once __DIR__ . '/../../SugarLogger/LoggerManager.php';

class InstallValidation
{
    use InstallValidationTrait;
    use InstallErrorTrait;

    /**
     * @var string $name
     */
    private $name;

    /**
     * @var array $data
     */
    private $data;

    /**
     * @var boolean
     */
    private $ignoreWarnings;

    /**
     * @var string
     */
    private $type;

    /**
     * Set entity name.
     *
     * @param string $name
     * @return self
     */
    public function name(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Set entity type.
     *
     * @param string $type
     * @return self
     */
    public function type(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Return validated array items
     *
     * @return array
     */
    public function getData() : array
    {
        $result = $this->data;
        if (!empty($this->ignoreWarnings) && $this->ignoreWarnings) {
            $type = 'warning';
            $result = array_filter($this->data, static function ($item) use ($type) {
                return $item['type'] !== $type;
            });
        }

        return $result;
    }

    /**
     * @param string $status
     * @param string $value
     * @param array $data
     * @return array
     */
    public function setData(string $status, string $value = '', array $data = []): array
    {
        $this->data[$this->name]['type'] = $this->type;

        $message = $this->messages[$this->name];
        $this->data[$this->name]['label'] = $message['label'];
        if ($status === 'error') {
            $this->data[$this->name]['error'] = $message['error'];
        }

        $this->data[$this->name]['status'] = $status;

        $this->data[$this->name]['info'] = $value;
        $this->data[$this->name]['data'] = $data;

        return $this->data;
    }

    /**
     * Validation result.
     *
     * errors, warnings, info
     *
     * @return array
     */
    public function result(): array
    {
        $data = $this->getData();

        $status = 'error';
        $errors = array_filter($data, static function ($item) use ($status) {
            return $item['status'] === $status;
        });

        return [
            'data' => $data ?? [],
            'hasValidationError' => !empty($errors)
        ];
    }

    /**
     * @param array $context
     * @return $this
     */
    public function validate(array $context): self
    {
        $this->ignoreWarnings = $this->isTrue($context['inputs']['sys_check_option'] ?? false);

        $this->name('phpVersion')->type('info')->phpVersion();
        $this->name('PCREVersion')->type('info')->PCREVersion();
        $this->name('iisVersion')->type('info')->iisVersion();

        $this->name('xml_parser_create')->type('error')->functionExists();
        $this->name('json_decode')->type('error')->functionExists();
        $this->name('mb_strlen')->type('error')->functionExists();
        $this->name('gzclose')->type('error')->functionExists();
        $this->name('imagecreatetruecolor')->type('error')->functionExists();
        $this->name('ZipArchive')->type('error')->classExists();
        $this->name('IsWritableCacheDir')->type('error')->IsWritableCacheDir();
        $this->name('IsWritableModDir')->type('error')->IsWritableModDir();
        $this->name('IsWritableConfig')->type('error')->IsWritableConfig();
        $this->name('IsWritableConfigO')->type('error')->IsWritableConfigOverride();
        $this->name('IsWritableCustomDir')->type('error')->IsWritableCustomDir();

        $this->name('IsWritableUploadDir')->type('warning')->IsWritableUploadDir();
        $this->name('curl_init')->type('warning')->functionExists();
        $this->name('imap')->type('warning')->imapCheck();
        $this->name('upload_limit')->type('warning')->uploadLimit();
        $this->name('memory_limit')->type('warning')->memoryLimit();

        return $this;
    }

    /**
     * @param $value
     * @return bool
     */
    protected function isTrue($value): bool
    {
        return $value === 'true' || $value === '1' || $value === true || $value === 1;
    }
}
