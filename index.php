<?php 
include('header.php');
include('config/db.php');
?>
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Call Log Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="add.php" class="btn btn-primary">Add call log</a>
        </div>
      </div>

          <?php 
            if($_GET){
                if(isset($_GET['error']) == 1){
                    $message = "Error while deleted the call record";
                    $class = "danger";
                }
                if(isset($_GET['success']) == 1){
                    $message = "Record deleted successfully";
                    $class = "success";
                }
                ?>
                    <div class="alert alert-<?=$class?> alert-dismissible fade show" role="alert">
                        <strong><?=$message?></strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
            <?php } ?>

      <div class="table-responsive">
      <?php 
      $sql = "SELECT * FROM calls";
    ?>
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">Unique Id</th>
              <th scope="col">Date</th>
              <th scope="col">IT Person</th>
              <th scope="col">Username</th>
              <th scope="col">Subject</th>
              <th scope="col">Details</th>
              <th scope="col">Total Time</th>
              <th scope="col">Status</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php 
              if ($result = mysqli_query($con, $sql)) {
                // Fetch one and one row
                // $times = array();
                while ($row = mysqli_fetch_assoc($result)) {
                  // array_push($times,$row['hours'].":".$row['minutes']);
              ?>
                <tr>
                  <td><?=$row['unique_id']?></td>
                  <td><?=$row['date']?></td>
                  <td><?=$row['itperson']?></td>
                  <td><?=$row['username']?></td>
                  <td><?=$row['subject']?></td>
                  <td><?=$row['details']?></td>
                  <td><?=$row['total_time']?></td>
                  <td>
                    <?php 
                      if($row['status'] == "New"){ $class="primary";}
                      if($row['status'] == "In progres"){ $class="warning";} 
                      if($row['status'] == "Completed"){ $class="success";}
                     ?>
                    <span class="badge bg-<?=$class?>"><?=$row['status']?></span> 
                  </td>
                  <td>
                    <a class="btn btn-sm btn-primary" href="call_details.php?call_id=<?=$row['id']?>"> Call details</a>
                    <a class="btn btn-sm btn-danger" href="delete.php?type=c&id=<?=$row['id']?>" onclick="return confirm('Are you sure you want to delete call log?');"> Delete</a>
                  </td>
                </tr>
                <?php  
                    }
                    mysqli_free_result($result);
                  }
                  mysqli_close($con);
                ?>
          </tbody>
        </table>
      </div>
    </main>
    <?php include('footer.php');?>