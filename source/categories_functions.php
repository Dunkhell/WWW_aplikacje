<?php
session_start();

function handle_add_category() {
    include('cfg.php');



    $parent = $_POST['new_category_parent'];
    $name = htmlspecialchars($_POST['new_category_name']);

    $add_new_query = "INSERT INTO category (parent, name) VALUES ('$parent', '$name')";
    $result = mysqli_query($link, $add_new_query);


    if($result) {
        return 'Added successfully';
    }
    return mysqli_errno($link) . ": " . mysqli_error($link);
}

function handle_edit_category() {
    include('cfg.php');



    $id = $_POST['edit_id'];
    $name = $_POST['edit_name'];
    $parent = $_POST['edit_parent'];

    $update_query = "UPDATE `category` SET `name`='".$name."' , `parent`=' ".$parent." ' WHERE `id`=".$id." LIMIT 1";
    $result = mysqli_query($link, $update_query);


    if($result) {
        return 'Update successful';
    }
    return mysqli_errno($link) . ": " . mysqli_error($link);
}


function handle_delete_category() {
    include('cfg.php');


    $id = $_POST['category_to_delete_id'];
    $delete_query = "DELETE FROM `category` WHERE id=$id LIMIT 1";
    $result = mysqli_query($link, $delete_query);

    if($result) {
        return 'Deleted successfully';

    }
    return mysqli_errno($link) . ": " . mysqli_error($link);
}
