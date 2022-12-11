<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
class CdnController
{

    public function __construct()
    {

    }

    public function getFileFromCDN()
    {
        $bucket = 'cnkbucket';
        $file_key = "hospital-info.pdf";
        $s3 = S3Client::factory(array(
            'region' => 'us-east-1',
            'version' => 'latest',
            'credentials' => [
                'key' => 'AKIAUTZKO3SNYPVE6ILQ',
                'secret' => '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',

            ],
        ));

        $cmd = $s3->getCommand('GetObject', [
            'Bucket' => $bucket,
            'Key' => $file_key,

        ]);

        $request = $s3->createPresignedRequest($cmd, '+20 minutes');
        // Get the actual presigned-url
        $presignedUrl = (string) $request->getUri();

        // echo $presignedUrl;
        $result = array(
            'fileURL' => $presignedUrl,
        );
        return $result;

    }
}
