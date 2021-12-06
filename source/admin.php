<?php
ini_set( 'error_reporting', E_ALL );
ini_set( 'display_errors', true );

echo "<button onclick=location.href='?idp=new_page' type='button'>
Add new page
</button>";


function LoginForm() {
    $form = '
    <div class="logowanie">
        <h1 class="heading">Panel admin:</h1>
            <div class="logowanie">
                <form method="post" name="LoginForm" enctype="multipart/form-data" action="'.$_SERVER['REQUEST_URI'].'">
                <table class="logowanie">
                    <tr><td class=""log4_t>[email]</td><td><input type="text" name="login_email" class="logowanie" /></td></tr>
                    <tr><td class=""log4_t>[haslo]</td><td><input type="text" name="login_password" class="logowanie" /></td></tr>
                    <tr><td class=""log4_t>&nbsp;</td><td><input type="submit" name="x1_submit" class="logowanie" value="zaloguj" /></td></tr>
                </table>
            </form>
        </div>
    </div>
    ';
    return $form;
}


function ListPages() {
    include "cfg.php";

    $query="SELECT * FROM page_list";
    $result=mysqli_query($link, $query);
    while($row = mysqli_fetch_array($result)) {
        $id=$row['id'];
        $page_content=htmlspecialchars($row['page_content']);
        $page_title=$row['page_title'];

        $page_result  = "
        <div id='table-wrapper'>
        <div id='table-scroll'>
            <table>
                <thead>
                    <th><span class='text'>ID</span></th>
                    <th><span class='text'>Title</span></th>
                    <th><span class='text' id='content'>Content</span></th>
                </thead>
                <tbody>
                    <tr> <td class='upper-content'>".$id."</td><td class='upper-content'>".$page_title."</td><td>".$page_content."</td> </tr>       
                </tbody>
            </table>
            
        </div>
        <form method='post'>
            <input type='hidden' name='id_page' value='".$id."'/>
            <input type='hidden' name='title_page' value='".$page_title."'/>
            <input type='hidden' name='content_page' value='".$page_content."'/>
            <input type='submit' name='edit' value='Edit'/>
        </form>
        <form method='post'>
            <input type='hidden' name='id_page_to_delete' value='".$id."'/>
            <input type='submit' name='delete' value='Delete'/>
        </form>
        </div>
        ";
        echo $page_result;
    }
}


function EditPageForm() {

    if(empty($_POST['id_page'])) {
        return "";
    }

    $id = $_POST['id_page'];
    $title = $_POST['title_page'];
    $content = htmlspecialchars($_POST['content_page']);


    $edit_form = "
        <div>
        <div>
            <h1>Edytuj strone ".$title." #".$id."</h1>
            <form method='post'>
            <table style='width:100%; height: 400px'>
                <thead>
                    <th><span class='text'>ID</span></th>
                    <th><span class='text'>Title</span></th>
                    <th><span class='text' id='content'>Content</span></th>
                </thead>
                <tbody>
                    <tr> <td><input type='text' readonly value='".$id."' name='edit_id'/></td><td><input type='text' name='edit_title' value='".$title."'/></td><td><textarea style='height: 98%; width: 99%' name='edit_content'>".$content." </textarea></td> </tr>       
                </tbody>
            </table>
            <button type='submit'>Zapisz</button>
            </form>
        </div>
        </div>
        ";
    return $edit_form;
}

function handleEditPage() {

    if(empty($_POST['edit_id'])) {
        return;
    }

    $id = $_POST['edit_id'];
    $title = $_POST['edit_title'];
    $content = $_POST['edit_content'];

    include('cfg.php');
    $query = "UPDATE `page_list` SET `page_title`='".$title."' , `page_content`=' ".htmlspecialchars($content)." ' WHERE `id`=".$id." ";
    $result = mysqli_query($link, $query);

    if($result) {
        return "Update successful";
    }
    return "Failed updating record!";

}

function handleDeletePage() {
    if(empty($_POST['id_page_to_delete'])) {
        return;
    }
    include('cfg.php');
    $id = $_POST['id_page_to_delete'];
    $query = "DELETE FROM `page_list` WHERE id=$id";
    $result = mysqli_query($link, $query);

    if($result) {
        return "Deleted successfully";
    }
    return "Failed deleting record!";
}

echo EditPageForm();
echo handleEditPage();
echo handleDeletePage();

ListPages();


