<?php
require(__DIR__."/api/index.php");
$openapi = \OpenApi\Generator::scan([__DIR__.'/api']);
header('Content-Type: application/x-yaml');
$output = $openapi->toYaml();
$file = 'C:/xampp/htdocs/webservice/open_api_doc.yaml';
file_put_contents($file, $output);