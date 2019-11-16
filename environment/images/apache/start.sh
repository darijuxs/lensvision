#!/usr/bin/env bash

a2ensite /ent/apache2/sistes-available/api.vm.local.conf
service apache2 restart

sleep 30d