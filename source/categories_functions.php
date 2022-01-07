<?php
session_start();

function handle_add_category() {
    include('cfg.php');



    $parent = $_POST['new_category_parent'];
    $name = htmlspecialchars($_POST['new_category_name']);

    $add_new_query = "INSERT INTO category (parent, name) VALUES ('$parent', '$name')";
    $result = mysqli_query($link, $add_new_query);


    if($result) {
        return "<script>popupAlert('Added successfully')</script>";
    }
    return "<script>popupAlert('Failed adding page')</script>";
}

function handle_edit_category() {
    include('cfg.php');



    $id = $_POST['edit_id'];
    $name = $_POST['edit_name'];
    $parent = $_POST['edit_parent'];

    $update_query = "UPDATE `category` SET `name`='".$name."' , `parent`=' ".$parent." ' WHERE `id`=".$id." LIMIT 1";
    $result = mysqli_query($link, $update_query);


    if($result) {
        return "<script>popupAlert('Update successful')</script>";
    }
    return "<script>popupAlert('Failed updating record!')</script>";
}


function handle_delete_category() {
    include('cfg.php');


    $id = $_POST['category_to_delete_id'];
    $delete_query = "DELETE FROM `category` WHERE id=$id LIMIT 1";
    $result = mysqli_query($link, $delete_query);

    if($result) {
        return "<script>popupAlert('Deleted successfully')</script>";

    }
    return "<script>popupAlert('Failed deleting record!')</script>";
}
include "cfg.php";

echo "<button onclick=location.href='?idp=admin' type='button'>
    Back
    </button>";
