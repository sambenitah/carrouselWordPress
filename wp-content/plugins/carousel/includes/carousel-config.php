<?php if(isset($_POST['saveConfig'])) {

    global $wpdb;

    $navigation = isset($_POST['navigation']) ? 1 : 0;
    $direction = isset($_POST['direction']) ? 1 : 0;
    $autoplay = isset($_POST['autoplay']) ? 1 : 0;
    $transition = isset($_POST['transition']) ? 1 : 0;

    $query = "update wp_carousel set text = '" . $_POST['text'] . "',delay =" . $_POST['delay'] . "
    ,navigation = " . $navigation . ",autoplay  = " . $autoplay . ",direction  = " . $direction . "
    ,transition  = " . $transition;

    $config = $wpdb->get_results($query);

    echo "<div class=\"w-100 alert alert-success text-center mb-4 mt-4\" role=\"alert\">
            Configuration Saved
        </div>";
}


?>


<?php if(isset($_POST['delete'])) {

    global $wpdb;

    $images = $wpdb->get_results("delete from wp_carouselMedia where id = " . $_POST['id']);

    echo "<div class=\"w-100 alert alert-success text-center mb-4 mt-4\" role=\"alert\">
            Image Deleted
        </div>";
}

?>


<?php if(isset($_POST['upload'])) {

    $wordpress_upload_dir = wp_upload_dir();
    $i = 1;

    $carouselImage = $_FILES['carouselImage'];
    $new_file_path = $wordpress_upload_dir['path'] . '/' . $carouselImage['name'];
    $new_file_mime = mime_content_type($carouselImage['tmp_name']);

    if (empty($carouselImage))
        die('File is not selected.');

    if ($carouselImage['error'])
        die($carouselImage['error']);

    if ($carouselImage['size'] > wp_max_upload_size())
        die('It is too large than expected.');

    if (!in_array($new_file_mime, get_allowed_mime_types()))
        die('WordPress doesn\'t allow this type of uploads.');

    while (file_exists($new_file_path)) {
        $i++;
        $new_file_path = $wordpress_upload_dir['path'] . '/' . $i . '_' . $carouselImage['name'];
    }

    if (move_uploaded_file($carouselImage['tmp_name'], $new_file_path)) {

        $upload_id = wp_insert_attachment(array(
            'guid' => $new_file_path,
            'post_mime_type' => $new_file_mime,
            'post_title' => preg_replace('/\.[^.]+$/', '', $carouselImage['name']),
            'post_content' => '',
            'post_status' => 'inherit'
        ), $new_file_path);

        require_once(ABSPATH . 'wp-admin/includes/image.php');

        wp_update_attachment_metadata($upload_id, wp_generate_attachment_metadata($upload_id, $new_file_path));

        global $wpdb;

        $results = $wpdb->get_results("insert into wp_carouselMedia (url) values
        ('".$wordpress_upload_dir['url'] . '/' . basename($new_file_path)."')");

        echo "<div class=\"w-100 alert alert-success text-center mb-4 mt-4\" role=\"alert\">
            Image Uploaded
        </div>";

    }
}


?>


<?php
global $wpdb;

$config = $wpdb->get_row("select * from wp_carousel");
?>

<div class="col-md-12 mb-5">
    <div class="row">
        <h1 class="w-100 text-center">Our Carousel</h1>
    </div>
</div>

<div class="offset-md-1 col-md-10">
    <div class="row">
        <form action="#" method="post">
            <div class="form-group">
                <label for="text">Description</label>
                <textarea type="text" class="form-control" id="text" name="text"><?=$config->text?></textarea>
            </div>
            <div class="form-group">
                <label for="delay">Delay seconds</label>
                <input type="number" class="form-control" id="delay" value="<?=$config->delay?>" name="delay">
            </div>
            <div class="form-group form-check">
                <label class="form-check-label">
                    <input <?php if($config->navigation) echo "checked" ?> type="checkbox" id="navigation" name="navigation"> Navigation (arrows)
                </label>
            </div>
            <div class="form-group form-check">
                <label class="form-check-label">
                    <input <?php if($config->autoplay) echo "checked" ?> type="checkbox" id="autoplay" name="autoplay"> Autoplay
                </label>
            </div>
            <div class="form-group form-check">
                <label class="form-check-label">
                    <input <?php if($config->transition) echo "checked" ?> type="checkbox" id="transition" name="transition"> Fade Transition (default slide)
                </label>
            </div>
            <button type="submit"  name="saveConfig" class="btn btn-primary">Save Configuration</button>
        </form>
<!--
        <div class="w-100 alert alert-primary text-center mb-4 mt-4" role="alert">
            List of medias :
        </div>
-->
        <?php

      /*  global $wpdb;

        $images = $wpdb->get_results("select * from wp_carouselMedia");

        */?><!--

        <table class="table">
            <thead>
            <tr>
                <th scope="col">Image</th>
                <th scope="col">Delete</th>
            </tr>
            </thead>
            <tbody>
            <?php
/*
            foreach ($images as $image) {

                */?>

                <tr>
                    <td><img class="img-fluid" src ="<?/*=$image->url*/?>"></td>
                    <td>
                        <form action="#" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?/*=$image->id*/?>">
                            <button type="submit" name="delete" class="btn btn-primary">Delete</button>
                        </form>
                    </td>
                </tr>
-->
<!--            --><?php
/*
            }

            */?>
            </tbody>
        </table>



<!--        <form action="#" method="post" enctype="multipart/form-data">
            <div class="form-group form-check">
                <label class="form-check-label">
                    <input type="file" name="carouselImage" size="25" /> Your Photo
                </label>
            </div>
            <button type="submit" name="upload" class="btn btn-primary">Upload</button>
        </form>-->

    </div>


</div>
