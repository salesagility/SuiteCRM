#!/bin/bash
set -e;
SCRIPT=$(readlink -f $0);
SCRIPTPATH=`dirname $SCRIPT`;
ROOTPATH=`dirname $SCRIPTPATH`;

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
BLUE='\033[0;36m'
NC='\033[0m' # No Color

function push_output {
FILE=$1;
# html extension is not supported
echo -n "Error: ScreenShot $FILE: open ";
echo -ne $BLUE;
curl -i -F file=@$FILE https://uguu.se/api.php?d=upload-tool
echo -en $NC;
echo " in your favorite web browser";
echo " "
}

#
cd $ROOTPATH/tests/_output

# push fail.png
for filename in *.png; do
    if [ -f $filename ]; then
        push_output $filename;
    else
        echo "$filename is not a file";
        continue;
    fi;
done


# push fail.png
for filename in *.html; do
    if [ -f $filename ]; then
        cp $filename "$filename.txt"
        push_output "$filename.txt";
    else
        echo "$filename is not a file";
        continue;
    fi;
done