<?php
    session_start();
    define('AES_256_CBC', 'aes-256-cbc');
    if (isset($_POST['submit'])) {
        $data = file_get_contents($_FILES['image']['tmp_name']);
        $encryption_key = $_POST['key'];
        $parts = $_SESSION['parts'];
        $decrypted = openssl_decrypt($parts[0], AES_256_CBC, $encryption_key, 0, base64_decode($parts[1]));
        $imgName = date('dmYHis') . '_' . $_FILES['image']['name'];
        file_put_contents('uploads/' . $imgName, $decrypted);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AES Decryption</title>
    <?php include 'inc/lib.php' ?>
</head>
<body>
    <?php include 'inc/nav.php' ?>
    <div class="container">
        <h2 class="mt-4 mb-4">AES Decryption Image</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="image">Choose image: <span class="text-danger">*</span></label>
                <div class="custom-file">
                    <input type="file" id="image" name="image" accept=".png,.gif,.jpg,.jpeg"  required/>
                </div>
            </div>
            <div class="image-preview mb-4" id="imagePreview">
                <img src="" alt="Image Preview" class="image-preview__image" />
                <span class="image-preview__default-text">Image</span>
            </div>
            <div class="form-group">
                <label>Key</label>
                <textarea name="key" class="form-control" cols="10" rows="3" required></textarea>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Decrypt</button>
        </form>
        <?php if (isset($decrypted)): ?>
            <img class="mt-4" src="./uploads/<?= $imgName ?>" width="200" />
            <a class="mt-2" href="./uploads/<?= $imgName ?>" download="">Download</a>
        <?php endif ?>
    </div>
    <script src="js/image.js"></script>
</body>
</html>