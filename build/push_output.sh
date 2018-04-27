#!/bin/bash
set -e;
SCRIPT=$(readlink -f $0);
SCRIPTPATH=`dirname $SCRIPT`;
ROOTPATH=`dirname $SCRIPTPATH`;

function push_output {
FILE=$1;
echo $FILE;
curl -F "file=@$FILE" https://file.io;
echo " ";
}

#
cd $ROOTPATH/tests/_output

# push fail.png
for filename in *.png; do
    [ -e "$file" ] || continue
    push_output $filename
done