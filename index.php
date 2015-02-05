<?php
require "src/Flickr/Pagination.php";
require "src/Flickr/Common/ConfigProvider.php";
require "src/Flickr/Services/ApiService.php";

use Flickr\Service\ApiService;
$flickerApiService = new ApiService();

$criteria = (empty($_GET["criteria"])) ? '' : $_GET["criteria"];
$perPage = (empty($_GET["per_page"])) ? 20 : $_GET["per_page"];

?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Page <?= $_GET["page"]; ?></title>
    <style type="text/css">
        .crop {
            overflow: hidden;
            display: inline-block;
            margin: 5px;
            box-shadow: 0 0 6px #999;
        }

        .images {
            margin-top: 20px;
        }

        .pagination a,
        .pagination span {
            text-decoration: none;
            display: inline-block;
            width: 20px;
            height: 20px;
            background: #DDD;
            margin: 3px;
            padding: 5px;
            text-align: center;
            vertical-align: middle;
        }

        .pagination span {
            color: black;
        }
    </style>
</head>
<body>
    <form action="index.php" method="get">
        <input type="hidden" name="page" value="1" />
        <input type="hidden" name="per_page" value="<?= $perPage ?>" />

        <input type="text" value="<?= $criteria ?>" placeholder="Search..." name="criteria" required>

        <?= \Flickr\Pagination::buildCountSelector($perPage); ?>

        <input type="submit" value="Search">
    </form>
    <div class="images">
        <?php
            if($criteria !== '') {
                if(!empty($_GET["page"])) {
                    $page = ($_GET["page"] < 1) ? 1 : $_GET["page"];
                } else {
                    $page = 1;
                }

                $images = $flickerApiService->searchImages($criteria, $perPage, $page);
        ?>

        <div class="pagination">
            <?= \Flickr\Pagination::buildPagination($criteria, $page, $perPage, $flickerApiService->lastPageCount); ?>
        </div>

        <?php foreach($images as $image) { ?>
            <div class="crop">
                <a href="<?= ApiService::getPhotoDetailsUrl($image) ?>" title="<?= $image["title"] ?>">
                    <img src="<?= ApiService::getImageSrc($image) ?>" width="200px" height="200px" />
                </a>
            </div>
        <?php }
          } ?>
    </div>
</body>
</html>