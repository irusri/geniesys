#!/usr/bin/bash

git submodule update --remote  scripts && git add . && git commit -m "update submodule scripts" && git push
