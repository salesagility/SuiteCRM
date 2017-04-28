{literal}
<script>
    if(!SuiteEditor) {

        /**
         * Suite Editor interface
         */
        var SuiteEditor = {
            interfaceError: function() {
                throw 'function is not implemented';
            }
        };

        /**
         * connector function for get value from suite editors
         */
        SuiteEditor.getValue = function() { SuiteEditor.interfaceError(); };

        /**
         * connector function for set value in suite editors
         */
        SuiteEditor.apply = function(html) { SuiteEditor.interfaceError(); };
    }
</script>
{/literal}
{$editor}