<?php
if (isset($_POST['submit'])) {
	if (isset($_POST['url'])) {
		$url = $_POST['url'];
	} else {
		header("Location: index.php");
	}
} else {
	header("Location: index.php");
}
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
	<script src="jquery.min.js"></script>
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

	<div class="hasil">
	
		<div class="text-center">
			<h3>Image analyze</h3>
		</div>

		<script type="text/javascript">
			$(document).ready(function () {
				var subscriptionKey = "0ee517919c3c41a38d3539b38f2f2870";
				var uriBase = "https://southeastasia.api.cognitive.microsoft.com/vision/v2.0/analyze";

				// Request parameters.
				var params = {
					"visualFeatures": "Categories,Description,Color",
					"details": "",
					"language": "en",
				};

				// Display the image.
				var sourceImageUrl = "<?php echo $url ?>";
				document.querySelector("#sourceImage").src = sourceImageUrl;

				// Make the REST API call.
				$.ajax({
					url: uriBase + "?" + $.param(params),

					// Request headers.
					beforeSend: function(xhrObj){
						xhrObj.setRequestHeader("Content-Type","application/json");
						xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key", subscriptionKey);
					},
					type: "POST",

					// Request body.
					data: '{"url": ' + '"' + sourceImageUrl + '"}',
				})
					.done(function(data) {

					// Show formatted JSON on webpage.
					$("#responseTextArea").val(JSON.stringify(data, null, 2));
					$("#description").text(data.description.captions[0].text);
				})
					.fail(function(jqXHR, textStatus, errorThrown) {

					// Display error message.
					var errorString = (errorThrown === "") ? "Error. " :
					errorThrown + " (" + jqXHR.status + "): ";
					errorString += (jqXHR.responseText === "") ? "" :
					jQuery.parseJSON(jqXHR.responseText).message;
					alert(errorString);
				});
			});
		</script>
		<br>

		<div class="text-center" id="wrapper" style="width:1020px; display:table;">
			<div id="imageDiv" style="width:420px; display:table-cell;">
				<b >Image:</b><br><br>
				<img id="sourceImage" width="400" /><br>
				<h3 id="description">...</h3>
			</div>

			<div id="jsonOutput" style="width:600px; display:table-cell;">
				<b>Response:</b><br><br>
				<textarea id="responseTextArea" class="UIInput"
						style="width:580px; height:400px;" readonly></textarea>
			</div>
			
		</div>
	</div>
</div>
</body>
</html>
