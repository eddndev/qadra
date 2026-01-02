#!/bin/bash
git add .
git commit -m "Update privacy policy and terms pages"
git push > push_output.log 2>&1
echo "Done"
