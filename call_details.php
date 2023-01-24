<?php
include('header.php');
include('config/db.php');

$sql = "SELECT * FROM calls WHERE id=".$_GET['call_id']." Limit 1";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);


if($_POST){
        $time_in_24_hour_format  = date("Y-m-d H:i:s", strtotime($_POST['datetime']));

        $datetime = $time_in_24_hour_format;
        $details = $_POST['details'];
        $hours = $_POST['hours'];
        $minutes = $_POST['minutes'];
        $meridian = $_POST['meridian'];
    
        $sql = "INSERT INTO `call_details` (`id`, `call_id`, `datetime`, `details`, `hours`, `minutes`,`meridian`) 
                VALUES (NULL, '".$row['id']."', '".$datetime."', '".$details."', '".$hours."', '".$minutes."','".$meridian."');";
        if (mysqli_query($con, $sql)) {

            $sql = "SELECT * FROM call_details WHERE call_id = ".$row['id'];
            $times = array();
            $result = mysqli_query($con, $sql);
            while ($roww = mysqli_fetch_assoc($result)) {
                $time_in_24_hour_format  = date("H:i", strtotime($roww['hours'].":".$roww['minutes']." ".$roww['meridian']));
                array_push($times,$time_in_24_hour_format);
            }
            $total_time =  AddPlayTime($times);

            $update_sql = "UPDATE `calls` SET `total_time`='".$total_time."' WHERE `id` = ".$row['id'];
            mysqli_query($con, $update_sql);

            header("Location: call_details.php?call_id=".$row['id']."&success=1");
            die();
        } else {
            header("Location: call_details.php?call_id=".$row['id']."&error=1");
            die();
        }
}

function AddPlayTime($times) {
    $minutes = 0; //declare minutes either it gives Notice: Undefined variable
    // loop throught all the times
    foreach ($times as $time) {
        list($hour, $minute) = explode(':', $time);
        $minutes += $hour * 60;
        $minutes += $minute;
    }

    $hours = floor($minutes / 60);
    $minutes -= $hours * 60;

    // returns the time already formatted
    return sprintf('%02d:%02d', $hours, $minutes);
}



?>
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Add call details</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <a href="index.php" class="btn btn-danger">Back</a>
            </div>
        </div>

        <form method="POST" action="call_details.php?call_id=<?=$row['id']?>">

            <div class="row">
                <div class="col">
                    <label for="pwd" class="form-label"><b>Date Time:</b></label>
                    <div id="datetimepicker1" class="input-append date">
                        <input class="form-control" name="datetime" required placeholder="Select Date time" data-format="" type="datetime-local"></input>
                    </div>
                </div>
                <div class="col">
                    <label for="pwd" class="form-label"><b>Details:</b></label>
                    <input type="text" class="form-control" required placeholder="Enter Call details"  name="details" />
                </div>

                <div class="col">
                    <label for="pwd" class="form-label"><b>Hours: (00:00)</b></label>
                    <input type="text" id="hours" class="form-control" required name="hours" placeholder="Enter Hours">
                </div>

                <div class="col">
                    <label for="pwd" class="form-label"><b>Minutes: (00:00)</b></label>
                    <input type="text" id="minutes" class="form-control" required name="minutes" placeholder="Enter Minutes">
                </div>

                <div class="col">
                    <label for="pwd" class="form-label"><b>Meridian:</b></label>
                    <select name="meridian" class="form-control">
                        <option value="AM">AM</option>
                        <option value="PM">PM</option>
                    </select>
                </div>
            </div>
            <div class="row mt-4 text-center">
                <div class="col-lg-12">
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </div>
        </form>
        <hr/>

        <?php 
          
        ?>

        <label class="mb-3"><strong>Call ID : <?=$row['unique_id']?></strong></label>


        <?php $sql = "SELECT * FROM call_details WHERE call_id = ".$_GET['call_id']; ?>
            <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">Date Time</th>
                    <th scope="col">Details</th>
                    <th scope="col">Hours : Minutes (24hr)</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if ($result = mysqli_query($con, $sql)) {
                    // Fetch one and one row
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                    <tr>
                        <td><?=$row['datetime']?></td>
                        <td><?=$row['details']?></td>
                        <td><?=$time_in_24_hour_format  = date("H:i", strtotime($row['hours'].":".$row['minutes']." ".$row['meridian']));?></td>
                        <td> <a class="btn btn-sm btn-danger" href="delete.php?type=cl&id=<?=$row['id']?>&call_id=<?=$_GET['call_id']?>" onclick="return confirm('Are you sure you want to delete this log?');"> Delete</a></td>
                    </tr>
                    <?php  
                        }
                        mysqli_free_result($result);
                    }
                    mysqli_close($con);
                    ?>
            </tbody>
        </table>

    </main>
<?php include('footer.php');?>