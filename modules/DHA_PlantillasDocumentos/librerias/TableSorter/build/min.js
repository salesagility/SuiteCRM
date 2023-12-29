load("build/jsmin.js", "build/writeFile.js");

var f = jsmin('', readFile(arguments[0]), 3);

writeFile( arguments[1], f );
