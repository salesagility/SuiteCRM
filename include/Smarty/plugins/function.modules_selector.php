<?php

use SuiteCRM\Search\SearchModules;

/**
 * Prints a panel that allows you to select modules.
 *
 * Options: $name, $selectedModules.
 *
 * The list of modules will be stored as a json array in an hidden field named $name.
 *
 * @param $params
 */
function smarty_function_modules_selector($params)
{
    $modules = SearchModules::getModulesList();
    $name = $params['name'];

    echo
    "<div class=\"modules-container\" id='$name-container'>",
    "<input type='hidden' name='$name' id='$name'/>";

    foreach ($modules as $module => $translation) {
        $checked = in_array($module, $params['selectedModules']) ? 'checked' : null;

        echo
        '<div class="form-check">',
        "<input type='checkbox' class='form-check-input' id='mod-$module' name='{$module}' $checked>",
        "&nbsp;<label class='form-check-label' for='mod-$module'>$translation</label>",
        '</div>';
    }

    echo '</div>';

    script($name);
}

/**
 * Prints the javascript code.
 *
 * @param string $name Name of the field
 */
function script($name)
{
    ?>
    <script>
        var selector, hiddenInput;

        $(function () {
            selector = $('#<?php echo $name?>-container .form-check input');
            hiddenInput = $('#<?php echo $name?>-container input[type=hidden]');

            selector.change(function () {
                updateModuleSelector();
            });

            updateModuleSelector();
        });

        function updateModuleSelector() {
            var modules = [];

            selector.each(function (key, item) {
                if (item.checked) {
                    modules.push(item.getAttribute('name'))
                }
            });

            hiddenInput.val(JSON.stringify(modules));
        }
    </script>
    <?php
}