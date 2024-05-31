<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artworks</title>
    <link rel="icon" type="image/png" href="adminpanel/assets/uploads/logo.png">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap-touch-slider.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .product-container {
            margin-bottom: 30px;
        }
    
        .product-link {
            display: block;
            color: inherit;
            text-decoration: none;
        }
    
        .thumb {
            position: relative;
            overflow: hidden;
            border-radius: 5px;
            margin-bottom: 15px;
        }
    
        .photo {
            width: 100%;
            height: 200px;
            background-size: cover;
            background-position: center;
        }
    
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
    
        .thumb:hover .overlay {
            opacity: 1;
        }
    
        .text {
            padding: 0 15px;
        }
    
        .out-of-stock {
            color: #111111;
            display: inline-block;
            padding: 10px 0;
            width: calc(100% - 5px);
            box-sizing: border-box;
            margin-bottom: 2px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }

        .col-md-4 {
            flex: 0 0 auto;
            width: 33.3333333333%;
            max-width: 33.3333333333%;
            padding-right: 15px;
            padding-left: 15px;
        }
    </style>
</head>

<body>
    <?php require_once('header.php'); ?>

    <?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $banner_product_category = $row['banner_product_category'];
}
$basePath = "/";
?>

<?php
if (!isset($_REQUEST['id']) || !isset($_REQUEST['type'])) {
    exit;
} else {
    $top = $mid = $end = $size = $orientation = array(); // Initialize arrays

    if (!in_array($_REQUEST['type'], ['top-category', 'mid-category', 'end-category', 'size-category', 'orientation-category'])) {
        header('location: index.php');
        exit;
    } else {
        $statement = $pdo->prepare("SELECT * FROM tbl_top_category");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $top[] = $row['tcat_id'];
            $top1[] = $row['tcat_name'];
        }

        $statement = $pdo->prepare("SELECT * FROM tbl_mid_category");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $mid[] = $row['mcat_id'];
            $mid1[] = $row['mcat_name'];
            $mid2[] = $row['tcat_id'];
        }

        $statement = $pdo->prepare("SELECT * FROM tbl_end_category");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $end[] = $row['ecat_id'];
            $end1[] = $row['ecat_name'];
            $end2[] = $row['mcat_id'];
        }

        $statement = $pdo->prepare("SELECT * FROM tbl_size");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $size[] = $row['size_id'];
            $size1[] = $row['size_name'];
        }

        $statement = $pdo->prepare("SELECT * FROM tbl_orientation");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $orientation[] = $row['o_id'];
            $orientation1[] = $row['o_name'];
        }

        if ($_REQUEST['type'] == 'top-category') {
            if (!in_array($_REQUEST['id'], $top)) {
                header('location: index.php');
                exit;
            } else {
                for ($i = 0; $i < count($top); $i++) {
                    if ($top[$i] == $_REQUEST['id']) {
                        $title = $top1[$i];
                        break;
                    }
                }
                $arr1 = array();
                $arr2 = array();
                for ($i = 0; $i < count($mid); $i++) {
                    if ($mid2[$i] == $_REQUEST['id']) {
                        $arr1[] = $mid[$i];
                    }
                }
                for ($j = 0; $j < count($arr1); $j++) {
                    for ($i = 0; $i < count($end); $i++) {
                        if ($end2[$i] == $arr1[$j]) {
                            $arr2[] = $end[$i];
                        }
                    }
                }
                $final_ecat_ids = $arr2;
            }
        }

        if ($_REQUEST['type'] == 'mid-category') {
            if (!in_array($_REQUEST['id'], $mid)) {
                header('location: index.php');
                exit;
            } else {
                for ($i = 0; $i < count($mid); $i++) {
                    if ($mid[$i] == $_REQUEST['id']) {
                        $title = $mid1[$i];
                        break;
                    }
                }
                $arr2 = array();
                for ($i = 0; $i < count($end); $i++) {
                    if ($end2[$i] == $_REQUEST['id']) {
                        $arr2[] = $end[$i];
                    }
                }
                $final_ecat_ids = $arr2;
            }
        }

        if ($_REQUEST['type'] == 'end-category') {
            if (!in_array($_REQUEST['id'], $end)) {
                header('location: index.php');
                exit;
            } else {
                for ($i = 0; $i < count($end); $i++) {
                    if ($end[$i] == $_REQUEST['id']) {
                        $title = $end1[$i];
                        break;
                    }
                }
                $final_ecat_ids = array($_REQUEST['id']);
            }
        }

        if ($_REQUEST['type'] == 'size-category') {
            if (!in_array($_REQUEST['id'], $size)) {
                header('location: index.php');
                exit;
            } else {
                for ($i = 0; $i < count($size); $i++) {
                    if ($size[$i] == $_REQUEST['id']) {
                        $title = $size1[$i];
                        break;
                    }
                }
                $final_size_ids = array($_REQUEST['id']);
            }
        }

        if ($_REQUEST['type'] == 'orientation-category') {
            if (!in_array($_REQUEST['id'], $orientation)) {
                header('location: index.php');
                exit;
            } else {
                for ($i = 0; $i < count($orientation); $i++) {
                    if ($orientation[$i] == $_REQUEST['id']) {
                        $title = $orientation1[$i];
                        break;
                    }
                }
                $final_orientation_ids = array($_REQUEST['id']);
            }
        }
    }
}
?>

    <div class="page">
        <div class="container">
            <div class="row">
                <?php require_once('sidebar-category.php'); ?>
                <div class="col-md-9">
                    <h3><?php echo LANG_VALUE_51; ?> "<?php echo $title; ?>"</h3>
                    <div class="product product-cat">
                        <div class="row">
                        <?php
                        $prod_count = 0;
                        $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_qty > 0");
                        $statement->execute();
                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($result as $row) {
                            $prod_table_ecat_ids[] = $row['ecat_id'];
                            $prod_table_size_ids[] = $row['size_id'];
                            $prod_table_orientation_ids[] = $row['o_id'];
                        }

                        if ($_REQUEST['type'] == 'size-category') {
                            if (isset($prod_table_size_ids) && is_array($prod_table_size_ids)) {
                                for ($ii = 0; $ii < count($final_size_ids); $ii++) {
                                    if (in_array($final_size_ids[$ii], $prod_table_size_ids)) {
                                        $prod_count++;
                                    }
                                }
                            }
                        } elseif ($_REQUEST['type'] == 'orientation-category') {
                            if (isset($prod_table_orientation_ids) && is_array($prod_table_orientation_ids)) {
                                for ($ii = 0; $ii < count($final_orientation_ids); $ii++) {
                                    if (in_array($final_orientation_ids[$ii], $prod_table_orientation_ids)) {
                                        $prod_count++;
                                    }
                                }
                            }
                        } else {
                            if (isset($prod_table_ecat_ids) && is_array($prod_table_ecat_ids)) {
                                for ($ii = 0; $ii < count($final_ecat_ids); $ii++) {
                                    if (in_array($final_ecat_ids[$ii], $prod_table_ecat_ids)) {
                                        $prod_count++;
                                    }
                                }
                            }
                        }

                        if ($prod_count == 0) {
                            echo '<div class="pl_15">' . LANG_VALUE_153 . '</div>';
                        } else {
                            if ($_REQUEST['type'] == 'size-category') {
                                for ($ii = 0; $ii < count($final_size_ids); $ii++) {
                                    $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE size_id=? AND p_is_active=? AND p_qty > 0");
                                    $statement->execute(array($final_size_ids[$ii], 1));
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                        ?>
                                        <div class="col-md-4 item item-product-cat product-container">
                                            <div class="inner">
                                                <a href="product.php?id=<?php echo $row['p_id']; ?>" class="product-link">
                                                    <div class="thumb">
                                                        <div class="photo"
                                                            style="background-image:url(adminpanel/assets/uploads/<?php echo $row['p_featured_photo']; ?>);">
                                                        </div>
                                                        <div class="overlay"></div>
                                                    </div>
                                                    <div class="text">
                                                        <h3 style="font-size: 20px;"><?php echo $row['p_name']; ?></h3>
                                                        <h4 style="font-size: 14px;">
                                                            <?php echo '₱ ' . number_format($row['p_current_price'], 2); ?>
                                                        </h4>
                                                        <?php if ($row['p_qty'] == 0): ?>
                                                            <div class="out-of-stock">
                                                                <div class="inner">Sold</div>
                                                            </div>
                                                        <?php else: ?>
                                                               <div class="button-container" style="margin-top: 15px;">
                                                                    <span onclick="window.location.href='product.php?id=<?php echo $row['p_id']; ?>'" style="cursor: pointer;">
                                                                        View Product
                                                                    </span>
                                                                </div>

                                                        <?php endif; ?>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                            } elseif ($_REQUEST['type'] == 'orientation-category') {
                                for ($ii = 0; $ii < count($final_orientation_ids); $ii++) {
                                    $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE o_id=? AND p_is_active=? AND p_qty > 0");
                                    $statement->execute(array($final_orientation_ids[$ii], 1));
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                        ?>
                                        <div class="col-md-4 item item-product-cat product-container">
                                            <div class="inner">
                                                <a href="product.php?id=<?php echo $row['p_id']; ?>" class="product-link">
                                                    <div class="thumb">
                                                        <div class="photo"
                                                            style="background-image:url(adminpanel/assets/uploads/<?php echo $row['p_featured_photo']; ?>);">
                                                        </div>
                                                        <div class="overlay"></div>
                                                    </div>
                                                    <div class="text">
                                                        <h3 style="font-size: 20px;"><?php echo $row['p_name']; ?></h3>
                                                        <h4 style="font-size: 14px;">
                                                            <?php echo '₱ ' . number_format($row['p_current_price'], 2); ?>
                                                        </h4>
                                                        <?php if ($row['p_qty'] == 0): ?>
                                                            <div class="out-of-stock">
                                                                <div class="inner">Sold</div>
                                                            </div>
                                                        <?php else: ?>
                                                               <div class="button-container" style="margin-top: 15px;">
                                                                    <span onclick="window.location.href='product.php?id=<?php echo $row['p_id']; ?>'" style="cursor: pointer;">
                                                                        View Product
                                                                    </span>
                                                                </div>

                                                        <?php endif; ?>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                            } else {
                                for ($ii = 0; $ii < count($final_ecat_ids); $ii++) {
                                    $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE ecat_id=? AND p_is_active=? AND p_qty > 0");
                                    $statement->execute(array($final_ecat_ids[$ii], 1));
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                        ?>
                                        <div class="col-md-4 item item-product-cat product-container">
                                            <div class="inner">
                                                <a href="product.php?id=<?php echo $row['p_id']; ?>" class="product-link">
                                                    <div class="thumb">
                                                        <div class="photo"
                                                            style="background-image:url(adminpanel/assets/uploads/<?php echo $row['p_featured_photo']; ?>);">
                                                        </div>
                                                        <div class="overlay"></div>
                                                    </div>
                                                    <div class="text">
                                                        <h3 style="font-size: 20px;"><?php echo $row['p_name']; ?></h3>
                                                        <h4 style="font-size: 14px;">
                                                            <?php echo '₱ ' . number_format($row['p_current_price'], 2); ?>
                                                        </h4>
                                                        <?php if ($row['p_qty'] == 0): ?>
                                                            <div class="out-of-stock">
                                                                <div class="inner">Sold</div>
                                                            </div>
                                                        <?php else: ?>
                                                                <div class="button-container" style="margin-top: 15px;">
                                                                    <span onclick="window.location.href='product.php?id=<?php echo $row['p_id']; ?>'" style="cursor: pointer;">
                                                                        View Product
                                                                    </span>
                                                                </div>

                                                        <?php endif; ?>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                            }
                        }
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once('footer.php'); ?>
</body>

</html>
