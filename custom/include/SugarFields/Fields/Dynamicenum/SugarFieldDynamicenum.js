/**
 * Created with JetBrains PhpStorm.
 * User: matthew
 * Date: 11/07/13
 * To change this template use File | Settings | File Templates.
 */


function updateDynamicEnum(field, subfield){

    if(document.getElementById(subfield) != null){
        var selector = document.getElementById(subfield);
        var de_key = document.getElementById(field).value;

        var current = [];
        for (var i = 0; i < selector.length; i++) {
            if (selector.options[i].selected) current.push(selector.options[i].value);
        }


        if(de_entries[subfield]  == null){
           de_entries[subfield] =  new Array;
           for (var i=0; i<selector.options.length; i++){
                de_entries[subfield][selector.options[i].value] = selector.options[i].text;
           }
        }

        document.getElementById(subfield).innerHTML = '';

        for (var key in de_entries[subfield]) {
            if(key.indexOf(de_key+'_') == 0){
                selector.options[selector.options.length] = new Option(de_entries[subfield][key], key);
            }
        }

        for (var key in current) {
            for (var i = 0; i < selector.length; i++) {
                if(selector.options[i].value == current[key])
                selector[i].selected = true;
            }
        }
    }
}