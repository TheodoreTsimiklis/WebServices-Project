<?php
require(dirname(__DIR__)."/vendor/autoload.php");

use Aws\S3\S3Client;
// Instantiate an Amazon S3 client.
$s3Client = new S3Client([
    'version' => 'latest',
    'region'  => 'us-east-1',
    'credentials' => [
        'key'    => 'AKIAUTZKO3SNYPVE6ILQ',
        'secret' => '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'
    ]
]);


$file_Path = __DIR__ . '/hospital-info.pdf';
$bucket = 'cnkbucket';
$key = basename($file_Path);


try {
    $s3Client->putObject([
        'Bucket' => $bucket,
        'Key'    => $key,
        'Body'   => fopen($file_Path, 'r')
    ]);
    echo "upload successfully";
} catch (Aws\S3\Exception\S3Exception $e) {
    echo "There was an error uploading the file.\n";
}



