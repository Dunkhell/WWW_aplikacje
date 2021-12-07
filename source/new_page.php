<?php


function NewPageForm() {

    $new_page_form = "
        <div>
        <div>
            <h1>Add new page</h1>
            <form method='post'>
            <table style='width:100%; height: 400px'>
                <thead>
                    <th><span class='text'>Title</span></th>
                    <th><span class='text' id='content'>Content</span></th>
                </thead>
                <tbody>
                    <td><input type='text' name='new_page_title' placeholder='Your site title here...'/></td><td><textarea style='height: 98%; width: 99%' name='new_page_content' placeholder='Your codes goes here...'></textarea></td> </tr>       
                </tbody>
            </table>
            <button type='submit'>Save</button>
            </form>
        </div>
        </div>
        ";
    return $new_page_form;
}

function handleEditPage() {
    include('cfg.php');

    if(empty($_POST['new_page_title'])) {
        return;
    }

    $title = $_POST['new_page_title'];
    $content = htmlspecialchars($_POST['new_page_content']);


    $query = "INSERT INTO page_list (page_title, page_content) VALUES ('$title', '$content')";
    $result = mysqli_query($link, $query);


    if($result) {
        return "<script>popupAlert('Added successfully')</script>";
    }
    return "<script>popupAlert('Failed adding page')</script>";

}

echo NewPageForm();
echo handleEditPage();
echo "<button onclick=location.href='?idp=admin' type='button'>
Back to Admin Panel
</button>";