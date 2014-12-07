<?php
error_reporting(E_ALL);

$rootDir = dirname(__DIR__);

require($rootDir . "/vendor/autoload.php");

// need the fake response sender from the Aura.Web tests
require($rootDir . "/vendor/aura/web/tests/unit/src/FakeResponseSender.php");
