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
// echo $key;
// Upload a publicly accessible file. The file size and type are determined by the SDK.
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




// // Check if the form was submitted

//     if (isset($_FILES["anyfile"]) && $_FILES["anyfile"]["error"] == 0) {
//         $allowed = array("mp4" => "video/mp4");
//         $filename = $_FILES["anyfile"]["name"];
//         $filetype = $_FILES["anyfile"]["type"];
//         $filesize = $_FILES["anyfile"]["size"];
//         // Validate file extension
//         $ext = pathinfo($filename, PATHINFO_EXTENSION);
//         if (!array_key_exists($ext, $allowed)) die("Error: Please select a valid file format.");
//         // Validate file size - 10MB maximum
//         $maxsize = 10 * 1024 * 1024;
//         if ($filesize > $maxsize) die("Error: File size is larger than the allowed limit.");
//         // Validate type of the file
//         if (in_array($filetype, $allowed)) {
//             // Check whether file exists before uploading it
//             if (file_exists("upload/" . $filename)) {
//                 echo $filename . " is already exists.";
//             } else {
//                 if (move_uploaded_file($_FILES["anyfile"]["tmp_name"], "upload/" . $filename)) {
//                     $bucket = 'cnkbucket';
//                     $file_Path = __DIR__ . '/upload/' . $filename;
//                     $key = basename($file_Path);
//                     try {
//                         $result = $s3Client->putObject([
//                             'Bucket' => $bucket,
//                             'Key'    => $key,
//                             'Body'   => fopen($file_Path, 'r')
//                         ]);
//                         echo "Video uploaded successfully. Video path is: " . $result->get('ObjectURL');
//                     } catch (Aws\S3\Exception\S3Exception $e) {
//                         echo "There was an error uploading the file.\n";
//                         echo $e->getMessage();
//                     }
//                     echo "Your file was uploaded successfully.";
//                 } else {
//                     echo "File is not uploaded";
//                 }
//             }
//         } else {
//             echo "Error: There was a problem uploading your file. Please try again.";
//         }
//     } else {
//         echo "Error: " . $_FILES["anyfile"]["error"];
//     }

