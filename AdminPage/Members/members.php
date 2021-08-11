<?php
include_once 'php/connect.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../../css/bootstrap.css">  
        <script type="text/javascript" src="js/download_excel.js"></script>
        <style>
            a { text-decoration: none;}
        </style>
        <title>AdminPage</title>
    </head>
    <body>
        <header id="header">
           <div class="navbar bg-dark navbar-dark">
               <div class="container-fluid">
                    <a class="navbar-brand" href="../adminpage.php">   
                        <img src="../../icons/book.svg" width="40" height=40 alt=""> Library
                    </a>
                    <a href="../../index.php" class="btn btn-primary" role="button">Sign-Out</a>
                </div>
            </div>
        </header>
        <br>
        <main id="main">
            <div class="container-fluid">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link" href="../Issue_Return/issue_return.php">Issue/Return</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Books/books.php">Books</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Members</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Records/records.php">Records</a>
                    </li>
                </ul>
            </div>
            <div class="container-fluid py-3"> 
                <div class="d-flex justify-content-between">     
                    <button type='button' class='btn btn-success' data-bs-toggle='modal' data-bs-target='#addMember'><img src="../../icons/plus-square.svg" width="25" height="25" alt=""> Add Members</button>
                    <button type='button' class='btn btn-secondary' onClick="exportData()"><img src="../../icons/download.svg" width="25" height="25" alt=""> Download Table</button>
                </div>
            </div>
            <div class="container-fluid table-responsive">
                <table class="table table-striped caption-top" id="members_table">
                    <caption>List of Members</caption>
                    <thead>
                        <tr>
                            <th scope="col">Member ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Mobile</th>
                            <th scope="col">Email</th>
                            <th scope="col">Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $query = "SELECT * from members";
                            $stmt = $conn->prepare($query);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            if ($result->num_rows > 0){
                                $rows = $result->fetch_all(MYSQLI_ASSOC);
                                foreach ($rows as $row) {
                                    $id = $row['memberId'];
                                    $memberName = $row['memberName'];
                                    $mobileNo = $row['mobileNo'];
                                    $emailId = $row['emailId'];
                                    $address = $row['address'];
                            ?>
                        <tr>
                            <td>
                                <?php echo $id; ?>
                            </td>
                            <td>
                                <?php echo $memberName; ?>
                            </td>
                            <td>
                                <?php echo $mobileNo; ?>
                            </td>
                            <td>
                                <?php echo $emailId; ?>
                            </td>
                            <td>
                                <?php echo $address; ?>
                            </td>
                            <td>
                                <button type='button' class='btn btn-warning btn-md' data-bs-toggle='modal' data-bs-target='#edit<?php echo $id;?>'><img src='../../icons/pencil-square.svg'></button></a>
                                <button type='button' class='btn btn-danger btn-md' data-bs-toggle='modal' data-bs-target='#delete<?php echo $id;?>'><img src='../../icons/trash.svg'></button>
                            </td>
                            <div id="edit<?php echo $id;?>" class="modal fade" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="title">Edit Member</h2>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="container-fluid">
                                                <form method="POST">
                                                    <div class="mb-3">
                                                        <label for="memberId" class="form-label">Member Id</label>
                                                        <input type="number" name="memberId" class="form-control" id="memberID" value="<?php echo $id?>" placeholder="Member Id" readonly>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="memberName" class="form-label">Member Name</label>
                                                        <input type="text" name="memberName" class="form-control" id="memberName" value="<?php echo $memberName?>" placeholder="Member Name" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="mobileNo" class="form-label">Mobile</label>
                                                        <input type="number" max="9999999999" min="1000000000" name="mobileNo" class="form-control" id="mobileNo" value="<?php echo $mobileNo?>" placeholder="Mobile" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="emailId" class="form-label">Email</label>
                                                        <input type="email" name="emailId" class="form-control" id="emailId" value="<?php echo $emailId?>" placeholder="Email">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="address" class="form-label">Address</label>
                                                        <input type="text" name="address" class="form-control" id="address" value="<?php echo $address?>" placeholder="Address" required>
                                                    </div>
                                                    <div class="d-flex p-3 justify-content-end">
                                                        <button type="submit" class="btn btn-primary" name="edit_member">Edit Member</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="delete<?php echo $id;?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="title">Delete Member</h2>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST">
                                                <div class="container-fluid">
                                                    <input type="hidden" name="delete_id" value="<?php echo $id;?>">
                                                    <p>
                                                        Are you sure you want to delete this book?<br/>
                                                        <b>Member Id</b>   : <?php echo $id;?><br/>
                                                        <b>Member Name</b> : <?php echo $memberName?>
                                                    </p>
                                                </div>
                                                <div class="d-flex p-3 justify-content-end">
                                                    <button type="submit" class="btn btn-danger" name="delete_member">Delete Member</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </tr>
                        <?php
                                }
                            }
                            if(isset($_POST['add_member'])){
                                $memberName = $_POST['memberName'];
                                $mobileNo = $_POST['mobileNo'];
                                $emailId = $_POST['emailId'];
                                $address = $_POST['address'];
                            
                                $query = "INSERT INTO members (memberId, memberName, mobileNo, emailId, address) VALUES (DEFAULT,?,?,?,?)";
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("siss", $memberName, $mobileNo, $emailId, $address);
                                if ($stmt->execute()) {
                                    echo "<script language='javascript'>alert('Data Successfully Added');</script>";
                                    echo "<script language='javascript'>location.href = 'members.php';</script>";
                                }
                                else{
                                    echo "<script language='javascript'>alert('Could not enter data.\n Check if database exists with table in server.');</script>";
                                    echo "<script language='javascript'>location.href = 'members.php';</script>";
                                }
                            }
                            
                            if(isset($_POST['edit_member'])){
                                $memberId = $_POST['memberId'];
                                $memberName = $_POST['memberName'];
                                $mobileNo = $_POST['mobileNo'];
                                $emailId = $_POST['emailId'];
                                $address = $_POST['address'];
                            
                                $query = "UPDATE members SET memberName=?, mobileNo=?, emailId=?, address=? WHERE memberId=?";
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("sissi",$memberName,$mobileNo,$emailId,$address,$memberId);
                            
                                if($stmt->execute()){
                                    echo "<script language='javascript'>alert('Data Successfully Updated');</script>";
                                    echo "<script language='javascript'>location.href = 'members.php';</script>";
                                }
                                else{
                                    echo "<script language='javascript'>alert('Could not update data.\n Check if database exists with table in server.');</script>";
                                    echo "<script language='javascript'>location.href = 'memberss.php';</script>";
                                }
                            }
                            
                            if(isset($_POST['delete_member'])){
                                $delete_id = $_POST['delete_id'];
                                $query = "DELETE FROM members WHERE memberId=?";
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("i",$delete_id);
                            
                                if($stmt->execute()){
                                    echo "<script language='javascript'>alert('Data Successfully Deleted');</script>";
                                    echo "<script language='javascript'>location.href = 'members.php';</script>";
                                }
                                else{
                                    echo "<script language='javascript'>alert('Could not delete data.\n Check if database exists with table in server.');</script>";
                                    echo "<script language='javascript'>location.href = 'members.php';</script>";
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="modal fade" id="addMember" tabindex="-1" aria-labelledby="addMemberModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                           <h2 class="title">Add Member</h2>
                           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">   
                                <form method="POST">
                                    <div class="mb-3">
                                        <label for="memberName" class="form-label">Member Name</label>
                                        <input type="text" name="memberName" class="form-control" id="memberName" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="mobileNo" class="form-label">Mobile</label>
                                        <input type="number" max="9999999999" min="1000000000" name="mobileNo" class="form-control" id="mobileNo" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="emailId" class="form-label">Email</label>
                                        <input type="text" name="emailId" class="form-control" id="emailId">
                                    </div>
                                    <div class="mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" name="address" class="form-control" id="address" required>
                                    </div>
                                    <div class="d-flex p-3 justify-content-end">
                                        <button type="submit" class="btn btn-primary" name="add_member">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>      
                    </div>
                </div>
            </div>
        </main>
        <script type="text/javascript" src="../../js/bootstrap.js"></script>
    </body>
</html>