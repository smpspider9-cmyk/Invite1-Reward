<?php
$PASS = 'changeme123';
if (($_GET['k'] ?? '') !== $PASS) exit('Forbidden');
$l = @file_get_contents('_9f2a.txt') ?: 'no hits yet';
echo '<pre style="font:13px/1.6 monospace;padding:20px;background:#0d0d0d;color:#4ade80">'
   . htmlspecialchars($l) . '</pre>';
