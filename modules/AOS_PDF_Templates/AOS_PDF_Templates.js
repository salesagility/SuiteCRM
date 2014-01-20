
var selected = 0;

function showVariable(fld){
    document.getElementById('variable_text').value=fld;
}

function setType(type){
    document.getElementById("type").value = type;
    populateModuleVariables(type);
}

function populateVariables(type){
    reg_values =  regularOptions[type];

    document.getElementById('variable_name').innerHTML = '';
    document.getElementById('variable_text').value = '';

    var selector = document.getElementById('variable_name');
    for (var i in reg_values) {
        selector.options[selector.options.length] = new Option(reg_values[i], i);
    }

}

function populateModuleVariables(type){
    mod_values =  moduleOptions[type];

    document.getElementById('module_name').innerHTML = '';

    var selector = document.getElementById('module_name');
    for (var i in mod_values) {
        selector.options[selector.options.length] = new Option(mod_values[i], i);
    }

    populateVariables(type);
}

function insert_variable(text) {
    if (text != ''){
        var inst = tinyMCE.getInstanceById("description");
        if (inst) inst.getWin().focus();
        inst.execCommand('mceInsertContent', false, text);
        inst.execCommand('mceToggleEditor');
        inst.execCommand('mceToggleEditor');
    }
}

function insertSample(smpl){
    if(smpl != 0){
        var body = tinyMCE.getInstanceById("description");
        var header = tinyMCE.getInstanceById("pdfheader");
        var footer = tinyMCE.getInstanceById("pdffooter");
        var cnf = true;
        if(body.getContent() != '' || header.getContent() != '' || footer.getContent() != ''){
            cnf=confirm(SUGAR.language.get('AOS_PDF_Templates', 'LBL_WARNING_OVERWRITE'));
        }
        if(cnf){
            smpl = eval(smpl);
            setType(smpl[0]);
            body.setContent(smpl[1]);
            header.setContent(smpl[2]);
            footer.setContent(smpl[3]);
            selected = document.getElementById('sample').options.selectedIndex;
        }
        else{
            document.getElementById('sample').options.selectedIndex =selected;
        }
    }
}
