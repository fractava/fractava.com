#!/bin/bash

echo "JS:"
sloc -k total,source,comment,files ./www/js

echo "Sites:"
sloc -k total,source,comment,files ./www/sites

echo "CSS:" >> lines-of-code.txt
sloc -k total,source,comment,files ./www/css
