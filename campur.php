<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Analyze Image</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <link rel="shortcut icon" href="image.jpg" type="image/jpg" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        html,
        body {
            height: 100%;
        }

        body {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f5f5f5;
        }

        .form-signin {
            width: 100%;
            max-width: 330px;
            padding: 15px;
            margin: auto;
        }

        .form-signin .checkbox {
            font-weight: 400;
        }

        .form-signin .form-control {
            position: relative;
            box-sizing: border-box;
            height: auto;
            padding: 10px;
            font-size: 12px;
        }

        .form-signin .form-control:focus {
            z-index: 2;
        }

        .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
    </style>
</head>

<body class="text-center">
    <script type="text/javascript">
        function processImage(url) {
            // **********************************************
            // *** Update or verify the following values. ***
            // **********************************************

            // Replace <Subscription Key> with your valid subscription key.
            var subscriptionKey = "a209cfea7938448cb0a2174a069bf6d0";

            // You must use the same Azure region in your REST API method as you used to
            // get your subscription keys. For example, if you got your subscription keys
            // from the West US region, replace "westcentralus" in the URL
            // below with "westus".
            //
            // Free trial subscription keys are generated in the "westus" region.
            // If you use a free trial subscription key, you shouldn't need to change
            // this region.
            var uriBase =
                "https://southeastasia.api.cognitive.microsoft.com/vision/v2.0/analyze";

            // Request parameters.
            var params = {
                "visualFeatures": "Categories,Description,Color",
                "details": "",
                "language": "en",
            };

            // Display the image.
            var sourceImageUrl = document.getElementById("inputImage").value;
            console.log(sourceImageUrl)
            document.querySelector("#sourceImage").src = url;

            // Make the REST API call.
            $.ajax({
                    url: uriBase + "?" + $.param(params),

                    // Request headers.
                    beforeSend: function(xhrObj) {
                        xhrObj.setRequestHeader("Content-Type", "application/json");
                        xhrObj.setRequestHeader(
                            "Ocp-Apim-Subscription-Key", subscriptionKey);
                    },

                    type: "POST",

                    // Request body.
                    data: '{"url": ' + '"' + url + '"}',
                })

                .done(function(data) {
                    // Show formatted JSON on webpage.
                    var a = JSON.stringify(data, null, 2);
                    console.log(data.description.captions[0].text);
                    console.log(data.description.tags);
                    $("#responseTextArea").val(JSON.stringify(data, null, 2));
                    $("#desc").html(JSON.stringify(data.description.captions[0].text, null, 2).toUpperCase());
                    $("#tags").html("tags = " + JSON.stringify(data.description.tags, null, 2));
                })

                .fail(function(jqXHR, textStatus, errorThrown) {
                    // Display error message.
                    var errorString = (errorThrown === "") ? "Error. " :
                        errorThrown + " (" + jqXHR.status + "): ";
                    errorString += (jqXHR.responseText === "") ? "" :
                        jQuery.parseJSON(jqXHR.responseText).message;
                    alert(errorString);
                });
        };
    </script>
    <div class="container">
        <div class="row">
            <div class="col-3">
                <form class="form-signin" action="campur.php" method="POST" enctype="multipart/form-data">
                    <h1 class="h3 mb-3 font-weight-normal">Please upload image to analyze</h1>
                    <label for="inputImage" class="sr-only">Image</label>
                    <input type="file" name="file" id="inputImage" class="form-control" placeholder="Image" required autofocus>
                    <br>
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
                </form>
            </div>
            <div class="col-9">
                <center>
                    <img id="sourceImage" width="200" />
                    <br>
                    <div id="jsonOutput" style="display:table-cell;">
                        <h2 id="desc"></h2>
                        <p id="tags"></p>
                    </div>
                </center>
            </div>
        </div>
    </div>
</body>

</html>

<?php
/**----------------------------------------------------------------------------------
 * Microsoft Developer & Platform Evangelism
 *
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *
 * THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY KIND, 
 * EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE IMPLIED WARRANTIES 
 * OF MERCHANTABILITY AND/OR FITNESS FOR A PARTICULAR PURPOSE.
 *----------------------------------------------------------------------------------
 * The example companies, organizations, products, domain names,
 * e-mail addresses, logos, people, places, and events depicted
 * herein are fictitious.  No association with any real company,
 * organization, product, domain name, email address, logo, person,
 * places, or events is intended or should be inferred.
 *----------------------------------------------------------------------------------
 **/

/** -------------------------------------------------------------
# Azure Storage Blob Sample - Demonstrate how to use the Blob Storage service. 
# Blob storage stores unstructured data such as text, binary data, documents or media files. 
# Blobs can be accessed from anywhere in the world via HTTP or HTTPS. 
#
# Documentation References: 
#  - Associated Article - https://docs.microsoft.com/en-us/azure/storage/blobs/storage-quickstart-blobs-php 
#  - What is a Storage Account - http://azure.microsoft.com/en-us/documentation/articles/storage-whatis-account/ 
#  - Getting Started with Blobs - https://azure.microsoft.com/en-us/documentation/articles/storage-php-how-to-use-blobs/
#  - Blob Service Concepts - http://msdn.microsoft.com/en-us/library/dd179376.aspx 
#  - Blob Service REST API - http://msdn.microsoft.com/en-us/library/dd135733.aspx 
#  - Blob Service PHP API - https://github.com/Azure/azure-storage-php
#  - Storage Emulator - http://azure.microsoft.com/en-us/documentation/articles/storage-use-emulator/ 
#
 **/

require_once 'vendor/autoload.php';
require_once "./random_string.php";

use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions;
use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;

$connectionString = "DefaultEndpointsProtocol=https;AccountName=" . getenv('ACCOUNT_NAME') . ";AccountKey=" . getenv('ACCOUNT_KEY');

// Create blob client.
$blobClient = BlobRestProxy::createBlobService($connectionString);

if (isset($_FILES["file"])) {
    $target_file = getcwd();
    $a = str_replace('\\', '/', $target_file);
    $b = $a . '/' . basename($_FILES["file"]["name"]);
    $c = basename($_FILES["file"]["name"]);
    $fileToUpload = $c;
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $b)) {
        echo "<script type='text/javascript'>alert('The file $c has been uploaded.');</script>";
        if (!isset($_GET["Cleanup"])) {
            // Create container options object.
            $createContainerOptions = new CreateContainerOptions();

            // Set public access policy. Possible values are
            // PublicAccessType::CONTAINER_AND_BLOBS and PublicAccessType::BLOBS_ONLY.
            // CONTAINER_AND_BLOBS:
            // Specifies full public read access for container and blob data.
            // proxys can enumerate blobs within the container via anonymous
            // request, but cannot enumerate containers within the storage account.
            //
            // BLOBS_ONLY:
            // Specifies public read access for blobs. Blob data within this
            // container can be read via anonymous request, but container data is not
            // available. proxys cannot enumerate blobs within the container via
            // anonymous request.
            // If this value is not specified in the request, container data is
            // private to the account owner.
            $createContainerOptions->setPublicAccess(PublicAccessType::CONTAINER_AND_BLOBS);

            // Set container metadata.
            $createContainerOptions->addMetaData("key1", "value1");
            $createContainerOptions->addMetaData("key2", "value2");

            $containerName = "blockblobs" . generateRandomString();

            try {
                // Create container.
                $blobClient->createContainer($containerName, $createContainerOptions);

                // Getting local file so that we can upload it to Azure
                $myfile = fopen($fileToUpload, "r") or die("Unable to open file!");
                fclose($myfile);

                # Upload file as a block blob
                // echo "Uploading BlockBlob: " . PHP_EOL;
                // echo $fileToUpload;
                // echo "<br />";

                $content = fopen($fileToUpload, "r");

                //Upload blob
                $blobClient->createBlockBlob($containerName, $fileToUpload, $content);

                // List blobs.
                $listBlobsOptions = new ListBlobsOptions();
                $listBlobsOptions->setPrefix($c);

                // echo "These are the blobs present in the container: ";

                do {
                    $result = $blobClient->listBlobs($containerName, $listBlobsOptions);
                    foreach ($result->getBlobs() as $blob) {
                        // echo $blob->getName() . ": " . $blob->getUrl() . "<br />";
                        echo "<script type='text/javascript'>processImage('" . $blob->getUrl() . "');</script>";
                    }
                    $listBlobsOptions->setContinuationToken($result->getContinuationToken());
                } while ($result->getContinuationToken());
                echo "<br />";

                // Get blob.
                // echo "This is the content of the blob uploaded: ";
                // $blob = $blobClient->getBlob($containerName, $fileToUpload);
                // fpassthru($blob->getContentStream());
                // echo "<br />";
            } catch (ServiceException $e) {
                // Handle exception based on error codes and messages.
                // Error codes and messages are here:
                // http://msdn.microsoft.com/library/azure/dd179439.aspx
                $code = $e->getCode();
                $error_message = $e->getMessage();
                echo $code . ": " . $error_message . "<br />";
            } catch (InvalidArgumentTypeException $e) {
                // Handle exception based on error codes and messages.
                // Error codes and messages are here:
                // http://msdn.microsoft.com/library/azure/dd179439.aspx
                $code = $e->getCode();
                $error_message = $e->getMessage();
                echo $code . ": " . $error_message . "<br />";
            }
        } else {

            try {
                // Delete container.
                echo "Deleting Container" . PHP_EOL;
                echo $_GET["containerName"] . PHP_EOL;
                echo "<br />";
                $blobClient->deleteContainer($_GET["containerName"]);
            } catch (ServiceException $e) {
                // Handle exception based on error codes and messages.
                // Error codes and messages are here:
                // http://msdn.microsoft.com/library/azure/dd179439.aspx
                $code = $e->getCode();
                $error_message = $e->getMessage();
                echo $code . ": " . $error_message . "<br />";
            }
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
    // print_r($fileToUpload);
}
?>

<!-- 
<form method="post" action="index.php?Cleanup&containerName=<?php echo $containerName; ?>">
    <button type="submit">Press to clean up all resources created by this sample</button>
</form> -->