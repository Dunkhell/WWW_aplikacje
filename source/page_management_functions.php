<?php
// Funkcja po wciśnięciu przycisku delete przechwyci id strony na której zainkowowaliśmy usuwanie i wykona odpowiednie zapytanie do bazy SQL aby tego dokonać.
function handleDeletePage() {
    include('cfg.php');

    $id = $_POST['id_page_to_delete'];
    $query = "DELETE FROM `page_list` WHERE id=$id LIMIT 1";
    $result = mysqli_query($link, $query);

    if($result) {
        return "<script>popupAlert('Deleted successfully')</script>";

    }
    return "<script>popupAlert('Failed deleting record!')</script>";
}

// Funkcja przechwtuje id strony z EditPageForm() i wykonuje odpowiednie zapytanie do bazy SQL aby zedytować stronę
function handleEditPage() {
    include('cfg.php');



    $id = $_POST['edit_id'];
    $title = $_POST['edit_title'];
    $content = $_POST['edit_content'];

    $query = "UPDATE `page_list` SET `page_title`='".$title."' , `page_content`=' ".htmlspecialchars($content)." ' WHERE `id`=".$id." LIMIT 1";
    $result = mysqli_query($link, $query);

    if($result) {
        return "<script>popupAlert('Update successful')</script>";
    }
    return "<script>popupAlert('Failed updating record!')</script>";

}