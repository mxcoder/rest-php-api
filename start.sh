#!/bin/bash

composer initialize
open || xdg-open http://127.0.0.1:8000/ &>/dev/null &
php -S 127.0.0.1:8000 -t .
