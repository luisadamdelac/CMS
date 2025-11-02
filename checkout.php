<?php
// Front-controller shim so requests to /RMS/checkout.php work the same as /RMS/public/checkout.php
// This preserves POST data (we include the public script) and avoids 404s when client-side code posts to ../checkout.php
require_once __DIR__ . '/public/checkout.php';
