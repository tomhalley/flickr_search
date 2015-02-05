<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require "src/Flickr/Common/ConfigProvider.php";
require "src/Flickr/Services/ApiService.php";

?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
    <style type="text/css">
        .crop {
            overflow: hidden;
            display: inline-block;
            margin: 5px;
            box-shadow: 0 0 8px #888;
        }

        .crop img {

        }
    </style>
</head>
<body>
    <form action="index.php" method="get">
        <input type="text" value="<?php if(!empty($_GET["criteria"])) echo $_GET["criteria"] ?>" placeholder="Search..." name="criteria" required>
        <input type="submit" value="Search">
    </form>
    <div class="images">
    <?php
        if(!empty($_GET["criteria"])) {
            $flickerApiService = new Flickr\Service\ApiService();
            $images = $flickerApiService->searchImages($_GET["criteria"]);
    ?>




        <?php foreach($images as $image) { ?>
            <div class="crop">
                <img src="<?php echo $image ?>" width="200px" height="200px" />
            </div>
        <?php } ?>
    <?php } ?>
    </div>
</body>
</html>