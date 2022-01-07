<?php
session_start();

function list_categories() {
    include "cfg.php";

    $query="SELECT * FROM category WHERE parent = 0";
    $result=mysqli_query($link, $query);

    while($row = mysqli_fetch_array($result)) {
        $id=$row['id'];
        $parent = $row['parent'];
        $name=$row['name'];

        $child_query = "SELECT * FROM category WHERE parent = $id";
        $child_categories = mysqli_query($link, $child_query);


        $page_result  = "
        <div >
        <div>
            <table>
                <thead>
                    <th><span>ID</span></th>
                    <th><span>name</span></th>
                    <th><span>actions</span></th>
                </thead>
                <tbody>
                    <tr> 
                    <td>".$id."</td>
                    <td>".$name."</td>
                    <td><form method='post'>
                        <input type='hidden' name='category_id' value='".$id."'/>
                        <input type='hidden' name='category_parent' value='".$parent."'/>
                        <input type='hidden' name='category_name' value='".$name."'/>
                        <input type='submit' name='edit' value='Edit'/>
                    </form>
                    <form method='post'>
                        <input type='hidden' name='category_to_delete_id' value='".$id."'/>
                        <input type='submit' name='delete' value='Delete'/>
                    </form></td>
                    </tr>       
                </tbody>
            </table>
            
        </div>
        
        </div>
        <br>
        ";
        echo $page_result;
        while ($child_row = mysqli_fetch_array($child_categories)) {

            $child_id = $child_row['id'];
            $child_parent = $child_row['parent'];
            $child_name = $child_row['name'];

            $children_result = "
            <div >
            <div >
                <table>
                    <thead>
                        <th><span >ID</span></th>
                        <th><span >parent</span></th>
                        <th><span >name</span></th>
                        <th><span>actions</span></th>
                    </thead>
                    <tbody>
                        <tr> 
                        <td >".$child_id."</td> 
                        <td >".$child_parent." ".$name."</td>
                        <td >".$child_name."</td>
                        <td><form method='post'>
                            <input type='hidden' name='category_id' value='".$child_id."'/>
                            <input type='hidden' name='category_parent' value='".$child_parent."'/>
                            <input type='hidden' name='category_name' value='".$child_name."'/>
                            <input type='submit' name='edit' value='Edit'/>
                        </form>
                        <form method='post'>
                            <input type='hidden' name='category_to_delete_id' value='".$child_id."'/>
                            <input type='submit' name='delete' value='Delete'/>
                        </form></td>
                        </tr>
                    </tbody>
                </table>
                
            </div>
           
            </div>
        ";

        echo $children_result;
        }
        echo "<br><hr style='height: 2px; background: red'><br>";

    }
}

function add_category_form() {
    $new_page_form = "
        <div>
        <div>
            <h1>Add new category</h1>
            <form method='post'>
            <table style='width: 100%'>
                <thead>
                    <th style='width: 50%'><span>parent</span></th>
                    <th  style='width: 50%'><span>name</span></th>
                </thead>
                <tbody>
                    <tr>
                    <td>
                    <input style='width: 99%' type='text' name='new_category_parent' placeholder='Your category parent id here..'/>
                    </td>
                    <td>
                    <input style='width: 99%' type='text' name='new_category_name' placeholder='Your category name goes here...'/>
                    </td>
                    </tr>       
                </tbody>
            </table>
            <button type='submit'>Save</button>
            </form>
        </div>
        </div>
        ";
    return $new_page_form;
}

function edit_category_form() {
    include('cfg.php');

    $id = $_POST['category_id'];
    $parent = $_POST['category_parent'];
    $name = $_POST['category_name'];


    $edit_form = "
        <div>
        <div>
            <h1>Edit category ".$name." #".$id."</h1>
            <form method='post'>
            <table style='width:100%; height: 400px'>
                <thead>
                    <th><span>ID</span></th>
                    <th><span>parent</span></th>
                    <th><span>name</span></th>
                </thead>
                <tbody>
                <tr>
                     <td><input type='text' readonly value='".$id."' name='edit_id'/></td>
                     <td><input type='text' name='edit_parent' value='".$parent."'/></td>
                     <td><input type='text' name='edit_name' value='".$name."'></td> 
                 </tr>       
                </tbody>
            </table>
            <button type='submit'>Zapisz</button>
            </form>
        </div>
        </div>
        <br><br>
        ";
    echo $edit_form;
}

echo "<button onclick=location.href='?idp=' type='button'>
    Back
    </button>";

if($_SESSION['loginFailed'] == 0) {
    echo "<form method='post'>
    <input type='submit' name='add_new' id='add_new' value='add new category' /><br/>
    </form>";


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(isset($_POST['category_id'])) {
            edit_category_form();
        }

        if(array_key_exists('add_new',$_POST)){
            echo add_category_form();
        }

        include_once("categories_functions.php");


        if(isset($_POST['new_category_parent']) || isset($_POST['new_category_name'])) {
            echo handle_add_category();

            header("Location: ?idp=shop");
            exit;
        }


        if(isset($_POST['category_to_delete_id'])) {
            handle_delete_category();

            header("Location: ?idp=shop");
            exit;
        }

        if(isset($_POST['edit_id'])) {
            echo handle_edit_category();
            header("Location: ?idp=shop");
            exit;
        }

    }


    list_categories();
} else {
    echo "User not logged in";
}