<?php
session_start();

// check apakah session username sudah ada atau belum.
// jika belum maka akan diredirect ke halaman index (login)
if( empty($_SESSION['username']) ){
    header('Location: login.php');
}



require_once 'vendor/autoload.php';
require_once "./random_string.php";

use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions;
use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;

$connectionString = "DefaultEndpointsProtocol=https;AccountName=dewstorageazure;AccountKey=AUMp6LAigknbzU1qMzpBLFxvry1VA5LqD7I8G3tzjXcKyp2tAGMqa9WJdhKkjwmJCiMRXwmVP9M88Xrt81HJeQ==;EndpointSuffix=core.windows.net";
$blobClient = BlobRestProxy::createBlobService($connectionString);

$containerName = "dewcontainer";

if (isset($_POST['submit'])) {
	$fileToUpload = $_FILES["fileToUpload"]["name"];
	$content = fopen($_FILES["fileToUpload"]["tmp_name"], "r");
	echo fread($content, filesize($fileToUpload));

	$blobClient->createBlockBlob($containerName, $fileToUpload, $content);
	header("Location: index.php");
}

$listBlobsOptions = new ListBlobsOptions();
$listBlobsOptions->setPrefix("");
$result = $blobClient->listBlobs($containerName, $listBlobsOptions);
?>

<!DOCTYPE html>
<html>
 <head>
 <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
     
     <!-- Bootstrap CSS -->
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
     <title>Dew Azure Web</title>
  </head>
<body>

<div class="container">


<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

  <a class="navbar-brand" href="#">DewAzure</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
      </li>
    </ul>
    <form class="form-inline">
		<a class="" href="logout.php">Logout</a>
	</form>
  </div>

</nav>

	<main role="main" class="container">
		<div class="starter-template text-center"> <br>
			<h1>DewAzure Computer Vision</h1>
			<hr>
			<h5 class="lead">Tambah Data</h5>
			<span class="border-top my-3"></span>

			<form action="index.php" method="post" enctype="multipart/form-data">
				<input type="file" name="fileToUpload" accept=".jpeg,.jpg,.png" required="" >
				<input type="submit" name="submit" value="Upload" class="btn btn-primary">
			</form>
			<hr>
		</div>

		<br>
		<br>
		<h4>Total Files : <?php echo sizeof($result->getBlobs())?></h4>

		<div class="dewTabel table-responsive">
			<table class='table table-hover table-striped table-dark table-bordered'>
				<thead class="thead-dark">
					<tr>
						<th>No</th>
						<th>File Name</th>
						<th>File URL</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					do {
						$nomor = 1;
						foreach ($result->getBlobs() as $blob)
						{
							?>
							<tr>
								<td><?php echo $nomor++; ?></td>
								<td><?php echo $blob->getName() ?></td>
								<td><?php echo $blob->getUrl() ?></td>
								<td>
									<form action="dewCompVis.php" method="post">
										<input type="hidden" name="url" value="<?php echo $blob->getUrl()?>">
										<input type="submit" name="submit" value="Analisa" class="btn btn-secondary">
									</form>
								</td>
							</tr>
							<?php
						}
						$listBlobsOptions->setContinuationToken($result->getContinuationToken());
					} while($result->getContinuationToken());
					?>
				</tbody>
			</table>
		</div>

	</div>
</div>

<script src="jquery.min.js"></script>
<script src="https://getbootstrap.com/docs/4.0/assets/js/vendor/popper.min.js"></script>
<script src="https://getbootstrap.com/docs/4.0/dist/js/bootstrap.min.js"></script>
</body>
</html>