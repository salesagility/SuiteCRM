load("build/ParseMaster.js", "build/packer.js", "build/writeFile.js");

var out = readFile( arguments[0] );

writeFile( arguments[1], pack( out, 62, true, false ) );
