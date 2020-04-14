#!/bin/bash

echo "before webpack:" 
du -sh www/css
du -sh www/js/modules
du -sh www/js/libaries
du -sh www/sites
du -sh www/lang
du -sh www/assets
echo ""
echo "after webpack:"
du -sh www/dist
