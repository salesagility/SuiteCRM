#!/bin/bash

if [ "$#" -ne 1 ]; then
    echo "You should use fixtures path as parameter"
    exit 1
fi

set -ex

cd $1

echo "Get wonder current version"
./wonder info | grep "1.2"

echo "Backup current binary"
cp ./wonder ./wonder-backup

echo "Self update --stable"
cp -r ./wonder-backup wonder && ./wonder self:update --stable
./wonder info | grep "2.0"

echo "Self update"
cp -r ./wonder-backup wonder && ./wonder self:update
./wonder info | grep "2.0"

echo "Self update --preview"
cp -r ./wonder-backup wonder && ./wonder self:update --preview
./wonder info | grep "2.1-beta1"

echo "Self update --stable --compatible"
cp -r ./wonder-backup wonder && ./wonder self:update --stable --compatible
./wonder info | grep "1.3"

echo "Self update --compatible"
cp -r ./wonder-backup wonder && ./wonder self:update --compatible
./wonder info | grep "1.3"

echo "Self update version_constraint arg test #1"
cp -r ./wonder-backup wonder && ./wonder self:update ^1.2
./wonder info | grep "1.3"

echo "Self update version_constraint arg test #2"
cp -r ./wonder-backup wonder && ./wonder self:update 2.0
./wonder info | grep "2.0"

echo "Self update version_constraint arg test #3"
cp -r ./wonder-backup wonder && ./wonder self:update ^1 --preview
./wonder info | grep "1.4-alpha1"

echo "Self update version_constraint arg test #4"
cp -r ./wonder-backup wonder && ./wonder self:update ^1 --stable
./wonder info | grep "1.3"
