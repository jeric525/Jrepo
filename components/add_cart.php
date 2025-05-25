<?php
if (isset($_POST['add_to_cart'])) {
    if ($user_id == '') {
        header('location:login.php');
        exit(); // Stop further execution
    } else {
        // Sanitize input data
        $pid = filter_var($_POST['pid'], FILTER_SANITIZE_STRING);
        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $price = filter_var($_POST['price'], FILTER_SANITIZE_STRING);
        $image = filter_var($_POST['image'], FILTER_SANITIZE_STRING);
        $qty = filter_var($_POST['qty'], FILTER_SANITIZE_STRING);

        // Check if the product is out of stock
        $check_stock = $conn->prepare("SELECT quantity FROM `products` WHERE name = ?");
        $check_stock->execute([$name]);
        $product_quantity = $check_stock->fetchColumn();

        if ($product_quantity === false || $product_quantity < $qty) {
            $message[] = 'Product is out of stock!';
        } else {
            $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
            $check_cart_numbers->execute([$name, $user_id]);

            if ($check_cart_numbers->rowCount() > 0) {
                $message[] = 'Already added to cart!';
            } else {
                // Insert the product into the cart
                $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
                $insert_cart->execute([$user_id, $pid, $name, $price, $qty, $image]);
                $message[] = 'Added to cart!';

                // Now, let's reduce the quantity of the product in the products table
                $reduce_quantity = $conn->prepare("UPDATE `products` SET quantity = quantity - ? WHERE name = ?");
                $reduce_quantity->execute([$qty, $name]);
            }
        }
    }
}
?>
