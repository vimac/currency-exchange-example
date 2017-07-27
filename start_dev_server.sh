#!/bin/bash

cd $(dirname $0)
php -S localhost:8888 -t public public/index.php
