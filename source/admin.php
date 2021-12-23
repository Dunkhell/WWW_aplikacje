<?php
session_start();

// Funkcja wylistuje kontent tabeli w bazie danych, która zawiera informacje na temat stron, w prostej do czytania tabeli
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

// Funkcja po otrzymaniu odpowiedniego POST'a wyświetli nam możliwą do edytowania zawartość naszej strony, którą potem przekażemy funkcji handleEditPage
function EditPageForm() {
    include('cfg.php');

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

// Funkcja przechwtuje id strony z EditPageForm() i wykonuje odpowiednie zapytanie do bazy SQL aby zedytować stronę
function handleEditPage() {
    include('cfg.php');

    if(empty($_POST['edit_id'])) {
        return;
    }

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

// Funkcja po wciśnięciu przycisku delete przechwyci id strony na której zainkowowaliśmy usuwanie i wykona odpowiednie zapytanie do bazy SQL aby tego dokonać.
function handleDeletePage() {
    include('cfg.php');
    if(empty($_POST['id_page_to_delete'])) {
        return;
    }
    $id = $_POST['id_page_to_delete'];
    $query = "DELETE FROM `page_list` WHERE id=$id LIMIT 1";
    $result = mysqli_query($link, $query);

    if($result) {
        return "<script>popupAlert('Deleted successfully')</script>";

    }
    return "<script>popupAlert('Failed deleting record!')</script>";
}

echo "<button onclick=location.href='?idp=' type='button'>
    Back
    </button>";

// Sprawdzam, czy użytkownik zalogował się poprzez formularz logowania czy "zhackował" dostęp do admin panelu, wyświetlam kontent tylko gdy użytkownik zalogował się poprawnie
if($_SESSION['loginFailed'] == 0) {

    // Buttony wyświetlane na górze strony służące do przemieszczania się po niej
    echo "<button onclick=location.href='?idp=new_page' type='button'>
    Add new page
    </button>";

    echo "<button onclick=location.href='?idp=mailer' type='button'>
    Mailer
    </button>";

    echo EditPageForm();
    echo handleEditPage();
    echo handleDeletePage();
    ListPages();
} else {
    // w przeciwnym razie wypisuje mu na ekran że jest nie zalogowany
    echo "User not logged in";
}


