<?php
include('header.php');
include('config/db.php');

if($_POST){
    $unique_id = $_POST['unique_id'];

    $sql = "SELECT * FROM calls WHERE unique_id = ".$unique_id." LIMIT 1";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    if($row <= 0){
        $itperson = $_POST['itperson'];
        $username = $_POST['username'];
        $subject = $_POST['subject'];
        $details = $_POST['details'];
        $status = $_POST['status'];
    
         $sql = "INSERT INTO `calls` (`id`, `unique_id`, `itperson`, `username`, `subject`, `details`, `total_time`,  `status`) 
                VALUES (NULL, '".$unique_id."', '".$itperson."', '".$username."', '".$subject."', '".$details."', '00:00', '".$status."');";
        if (mysqli_query($con, $sql)) {
            $last_id = mysqli_insert_id($con);
            header("Location: call_details.php?call_id=". $last_id);
            die();
        } else {
            header("Location: add.php?error=1");
            die();
        }
    }else{
        header("Location: add.php?error=2");
        die();
    }
}
?>
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Add new call Log</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <a href="index.php" class="btn btn-danger">Back</a>
            </div>
        </div>


        <?php 
            if($_GET){
                if(isset($_GET['error']) == 1){
                    $message = "Error while saving the record in database";
                    $class = "danger";
                }
                if(isset($_GET['error']) == 2){
                    $message = "Record already exsists with the given call id";
                    $class = "danger";
                }

                if(isset($_GET['success']) == 1){
                    $message = "Record created successfully";
                    $class = "success";
                }

                ?>
                    <div class="alert alert-<?=$class?> alert-dismissible fade show" role="alert">
                        <strong><?=$message?></strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
            <?php } ?>


        <?php 
        $sql = "SELECT * FROM calls ORDER BY id desc Limit 1";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
        $unique_id = 0;
        if($row <= 0){
            $unique_id = 1;
        }else{
            $unique_id = $row['unique_id'] + 1;
        }
        ?>

        <form method="POST" action="<?=$_SERVER['PHP_SELF'];?>">
            <div class="mb-3 mt-3">
                <label for="email" class="form-label">Unique id:</label>
                <input type="text" class="form-control" placeholder="Unique ID" readonly value="<?=$unique_id?>" name="unique_id">
            </div>
            <div class="mb-3">
                <label for="pwd" class="form-label">IT Person:</label>
                <input type="text" class="form-control" placeholder="Enter Name of IT Person" name="itperson">
            </div>

            <div class="mb-3">
                <label for="pwd" class="form-label">Username:</label>
                <input type="text" class="form-control" placeholder="Enter Person entering Call " name="username">
            </div>

            <div class="mb-3">
                <label for="pwd" class="form-label">Subject:</label>
                <input type="text" class="form-control" placeholder="Enter Short description of reason for Call" name="subject">
            </div>


            <div class="mb-3">
                <label for="pwd" class="form-label">Details:</label>
                <textarea class="form-control" placeholder="Enter Call details"  name="details" ></textarea>
            </div>

            <div class="mb-3">
                <label for="pwd" class="form-label">Status</label>
                <select class="form-control" name="status">
                    <option value="New">New</option>
                    <option value="In progress">In progress</option>
                    <option value="Completed">Completed</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    <?php 
       mysqli_free_result($result);
       mysqli_close($con);
    ?>
    </main>
    <?php include('footer.php');?>
