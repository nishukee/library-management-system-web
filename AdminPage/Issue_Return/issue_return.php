<?php
include_once 'php/connect.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
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
                    <a class="navbar-brand" href=#>
                        <i class="bi bi-book-fill"></i>    
                        Library
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
                        <a class="nav-link active" aria-current="page" href="#">Issue/Return</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Books/books.php">Books</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Members/members.php">Members</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Records/records.php">Records</a>
                    </li>
                </ul>
            </div>
            <div class="container-fluid py-3">
                <div class="d-flex gap-2">
                    <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#issue'><i class="bi bi-box-arrow-right"></i> Issue Book</button>
                    <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#return'><i class="bi bi-box-arrow-in-left"></i> Return Book</button> 
                    <button type='button' class='btn btn-secondary ms-auto' onClick="exportData()"><i class="bi bi-download"></i> Download Table</button>
                </div>
            </div>
            
            <div class="container-fluid table-responsive">
                <table class="table table-striped caption-top" id="issue_table">
                    <caption>List of Issued Books</caption>
                    <thead>
                        <tr>
                            <th scope="col">Member ID</th>
                            <th scope="col">Book ID</th>
                            <th scope="col">Issued Date</th>
                            <th scope="col">Return By</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $query = "SELECT * from issue";
                            $stmt = $conn->prepare($query);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            if ($result->num_rows > 0){
                                $rows = $result->fetch_all(MYSQLI_ASSOC);
                                foreach ($rows as $row) {
                                    $memberId = $row['memberId'];
                                    $bookId = $row['bookId'];
                                    $issuedDate = $row['issuedDate'];
                                    $returnBy = $row['returnBy'];
                                    $status = $row['status'];
                            ?>
                        <tr>
                            <td>
                                <?php echo $memberId; ?>
                            </td>
                            <td>
                                <?php echo $bookId; ?>
                            </td>
                            <td>
                                <?php echo $issuedDate; ?>
                            </td>
                            <td>
                                <?php echo $returnBy; ?>
                            </td>
                            <td>
                                <?php echo $status; ?>
                            </td>
                        </tr>
                        <?php
                                }
                            }
                            if (isset($_POST['issue_book'])){
                                $bookId = $_POST['bookId'];
                                $memberId = $_POST['memberId'];
                                $issuedDate = $_POST['issuedDate'];
                                $returnBy = date('Y-m-d',strtotime($issuedDate. ' + 15 days'));
                                $query1 = "SELECT * FROM books WHERE bookId=?";
                                $stmt1 = $conn->prepare($query1);
                                $stmt1->bind_param("i",$bookId);
                                $stmt1->execute();
                                $result1 = $stmt1->get_result();
                                $row1 = $result1->fetch_assoc();
                                $query2 = "SELECT * FROM members WHERE memberId=?";
                                $stmt2 = $conn->prepare($query2);
                                $stmt2->bind_param("i",$memberId);
                                $stmt2->execute();
                                $result2 = $stmt2->get_result();
                                $row2 = $result2->fetch_assoc();
                                if(($result1->num_rows > 0) && ($result2->num_rows > 0)){
                                    $sql1 = "SELECT COUNT(*) as countm FROM issue WHERE memberId=?";
                                    $check1 = $conn->prepare($sql1);
                                    $check1->bind_param("i",$memberId);
                                    $check1->execute();
                                    $res1 = $check1->get_result();
                                    $rowm = $res1->fetch_assoc();
                                    $sql2 = "SELECT COUNT(*) as countb FROM issue WHERE bookID=?";
                                    $check2 = $conn->prepare($sql2);
                                    $check2->bind_param("i",$bookId);
                                    $check2->execute();
                                    $res2 = $check2->get_result();
                                    $row_issued = $res2->fetch_assoc();
                                    $sql3 = "SELECT no_of_copies, status FROM books WHERE bookID=?";
                                    $check3 = $conn->prepare($sql3);
                                    $check3->bind_param("i",$bookId);
                                    $check3->execute();
                                    $res3 = $check3->get_result();
                                    $row_copies = $res3->fetch_assoc();
                                    if($rowm['countm'] > 0){
                                        echo "<script language='javascript'>alert('Member has already been issued a book');</script>";
                                        echo "<script language='javascript'>location.href = 'issue_return.php';</script>";
                                        exit();
                                    }
                                    else if(($row_copies['no_of_copies'] == 0) || ($row_copies['status'] == "Damaged/Lost")){
                                        echo "<script language='javascript'>alert('Book not available');</script>";
                                        echo "<script language='javascript'>location.href = 'issue_return.php';</script>";
                                        exit();
                                    }
                                    else if($row_issued['countb'] == $row_copies['no_of_copies']){
                                        echo "<script language='javascript'>alert('All Copies of the book have been borrowed');</script>";
                                        echo "<script language='javascript'>location.href = 'issue_return.php';</script>";
                                        exit();
                                    }
                                    else{
                                        $bookName = $row1['bookName'];
                                        $memberName = $row2['memberName'];
                                        $insertq = "INSERT INTO issue (memberId, bookId, issuedDate, returnBy, status) VALUES (?,?,?,?,DEFAULT)";
                                        $insstmt = $conn->prepare($insertq);
                                        $insstmt->bind_param("iiss",$memberId, $bookId, $issuedDate, $returnBy);
                                        $insertq2 = "INSERT INTO records (id, bookId, bookName, memberId, memberName, issuedDate, returnBy, returnedDate, status) VALUES (DEFAULT,?,?,?,?,?,?,NULL,DEFAULT)";
                                        $insstmt2 = $conn->prepare($insertq2);
                                        $insstmt2->bind_param("isisss",$bookId, $bookName, $memberId, $memberName, $issuedDate, $returnBy);
                                        if (($row_issued['countb']+1) == $row_copies['no_of_copies']){
                                                $updateq = "UPDATE books SET status='Issued All' WHERE bookId=?";
                                                $upstmt = $conn->prepare($updateq);
                                                $upstmt->bind_param("i",$bookId);
                                                $upstmt->execute();
                                            }
                                        if(($insstmt->execute()) AND ($insstmt2->execute())){
                                            $str1 = $bookName." Issued to ".$memberName;
                                            $str2 = "Return By ".$returnBy;
                                            echo "<script language='javascript'>alert('{$str1}\\n{$str2}');</script>";
                                            echo "<script language='javascript'>location.href = 'issue_return.php';</script>";
                                            exit();
                                        }
                                        else {
                                            echo "<script language='javascript'>alert('Could not issue book.\\n Check if databse exists with table in server.');</script>";
                                            echo "<script language='javascript'>location.href = 'issue_return.php';</script>";
                                            exit();
                                        }
                                    }
                                }
                                else {
                                    echo "<script language='javascript'>alert('Enter Valid Book ID or Member ID');</script>";
                                    exit();
                                }
                            }
                            if(isset($_POST['return_book'])){
                                $bookId = $_POST['bookId'];
                                $memberId = $_POST['memberId'];
                                $returnedDate = date('Y-m-d',strtotime($_POST['returnedDate']));
                                $returnedDateObj = new DateTime($returnedDate);
                                $status = $_POST['status'];
                                $query1 = "SELECT * FROM books WHERE bookId=?";
                                $stmt1 = $conn->prepare($query1);
                                $stmt1->bind_param("i",$bookId);
                                $stmt1->execute();
                                $result1 = $stmt1->get_result();
                                $row1 = $result1->fetch_assoc();
                                $query2 = "SELECT * FROM members WHERE memberId=?";
                                $stmt2 = $conn->prepare($query2);
                                $stmt2->bind_param("i",$memberId);
                                $stmt2->execute();
                                $result2 = $stmt2->get_result();
                                $row2 = $result2->fetch_assoc();
                                if(($result1->num_rows > 0) && ($result2->num_rows > 0)){
                                    $sql1 = "SELECT * FROM issue WHERE bookId=? AND memberId=?";
                                    $stm1 = $conn->prepare($sql1);
                                    $stm1->bind_param("ii", $bookId, $memberId);
                                    $stm1->execute();
                                    $res1 = $stm1->get_result();
                                    $rows1 = $res1->fetch_assoc();
                                    if($res1->num_rows > 0){
                                        $returnBy = date('Y-m-d',strtotime($rows1['returnBy']));
                                        $returnByObj = new DateTime($returnBy);
                                        $interval = date_diff($returnedDateObj,$returnByObj);
                                        $dDiff = $interval->format('%a days');
                                        $upsql1 = "UPDATE records SET status=?, returnedDate=? WHERE (memberId=? AND bookId=?) AND returnedDate is NULL";
                                        $upstmt1 = $conn->prepare($upsql1);
                                        $upstmt1->bind_param("ssii",$status, $returnedDate, $memberId, $bookId);
                                        $delsql = "DELETE FROM issue WHERE bookId=? AND memberId=?";
                                        $delstmt = $conn->prepare($delsql);
                                        $delstmt->bind_param("ii",$bookId, $memberId);
                                        if(($upstmt1->execute()) AND ($delstmt->execute())){
                                            if ($returnedDateObj == $returnByObj){
                                                echo "<script language='javascript'>alert('Returned Book on Due Date.');</script>";
                                                    if($status=="Returned"){
                                                    $upsql2 = "UPDATE books SET status='Available' WHERE status='Issued All' AND bookId=?";
                                                    $upstmt2 = $conn->prepare($upsql2);
                                                    $upstmt2->bind_param("i",$bookId);
                                                    $upstmt2->execute();
                                                    echo "<script language='javascript'>location.href = 'issue_return.php';</script>";
                                                    exit();
                                                }
                                                else if($status=="Damaged/Lost"){
                                                    $upsql2 = "UPDATE books SET status=?, no_of_copies=no_of_copies-1 WHERE bookId=?";
                                                    $upstmt2 = $conn->prepare($upsql2);
                                                    $upstmt2->bind_param("si",$status, $bookId);
                                                    $upstmt2->execute();
                                                    $pricesql = "SELECT price from books WHERE bookId=?";
                                                    $pricestmt = $conn->prepare($pricesql);
                                                    $pricestmt->bind_param("i",$bookId);
                                                    $pricestmt->execute();
                                                    $result = $pricestmt->get_result();
                                                    $prow = $result->fetch_assoc();
                                                    $price = $prow['price'];
                                                    echo "<script language='javascript'>alert('Member has to pay ₹{$price} for damaging or losing the issued book.');</script>";
                                                    echo "<script language='javascript'>location.href = 'issue_return.php';</script>";
                                                    exit();
                                                }
                                            }
                                            else if($returnedDateObj < $returnByObj){
                                                echo "<script language='javascript'>alert('Returned Book {$dDiff} before Due Date.');</script>";
                                                if($status=="Returned"){
                                                    $upsql2 = "UPDATE books SET status='Available' WHERE status='Issued All' AND bookId=?";
                                                    $upstmt2 = $conn->prepare($upsql2);
                                                    $upstmt2->bind_param("i",$bookId);
                                                    $upstmt2->execute();
                                                    echo "<script language='javascript'>location.href = 'issue_return.php';</script>";
                                                    exit();
                                                }
                                                else if($status=="Damaged/Lost"){
                                                    $upsql2 = "UPDATE books SET status=?, no_of_copies=no_of_copies-1 WHERE bookId=?";
                                                    $upstmt2 = $conn->prepare($upsql2);
                                                    $upstmt2->bind_param("si",$status, $bookId);
                                                    $upstmt2->execute();
                                                    $pricesql = "SELECT price from books WHERE bookId=?";
                                                    $pricestmt = $conn->prepare($pricesql);
                                                    $pricestmt->bind_param("i",$bookId);
                                                    $pricestmt->execute();
                                                    $result = $pricestmt->get_result();
                                                    $prow = $result->fetch_assoc();
                                                    $price = $prow['price'];
                                                    echo "<script language='javascript'>alert('Member has to pay ₹{$price} for damaging or losing the issued book.');</script>";
                                                    echo "<script language='javascript'>location.href = 'issue_return.php';</script>";
                                                    exit();
                                                }
                                            }
                                            else if($returnedDateObj > $returnByObj) {
                                                echo "<script language='javascript'>alert('Returned Book {$dDiff} after Due Date. ');</script>";
                                                if($status=="Returned"){
                                                    $upsql2 = "UPDATE books SET status='Available' WHERE status='Issued All' AND bookId=?";
                                                    $upstmt2 = $conn->prepare($upsql2);
                                                    $upstmt2->bind_param("i",$bookId);
                                                    $upstmt2->execute();
                                                    echo "<script language='javascript'>location.href = 'issue_return.php';</script>";
                                                    exit();
                                                }
                                                else if($status=="Damaged/Lost"){
                                                    $upsql2 = "UPDATE books SET status=?, no_of_copies=no_of_copies-1 WHERE bookId=?";
                                                    $upstmt2 = $conn->prepare($upsql2);
                                                    $upstmt2->bind_param("si",$status, $bookId);
                                                    $upstmt2->execute();
                                                    $pricesql = "SELECT price from books WHERE bookId=?";
                                                    $pricestmt = $conn->prepare($pricesql);
                                                    $pricestmt->bind_param("i",$bookId);
                                                    $pricestmt->execute();
                                                    $result = $pricestmt->get_result();
                                                    $prow = $result->fetch_assoc();
                                                    $price = $prow['price'];
                                                    echo "<script language='javascript'>alert('Member has to pay ₹{$price} for damaging or losing the issued book.');</script>";
                                                    echo "<script language='javascript'>location.href = 'issue_return.php';</script>";
                                                    exit();
                                                }
                                            }
                                        }
                                        else {
                                            echo "<script language='javascript'>alert('Could not return book.\\n Check if databse exists with table in server.');</script>";
                                            echo "<script language='javascript'>location.href = 'issue_return.php';</script>";
                                            exit();
                                        }
                                    }
                                    else{
                                        echo "<script language='javascript'>alert('Member has not been issued this book.');</script>";
                                        echo "<script language='javascript'>location.href = 'issue_return.php';</script>";
                                        exit();
                                    }
                                }
                                else {
                                    echo "<script language='javascript'>alert('Enter Valid Book ID or Member ID');</script>";
                                    exit();
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="modal fade" id="issue" tabindex="-1" aria-labelledby="issueBookModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="title">Issue Book</h2>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <form method="POST">
                                    <div class="mb-3">
                                        <label for="memberId" class="form-label">Member Id</label>
                                        <input type="number" name="memberId" class="form-control" id="memberId" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="bookId" class="form-label">Book Id</label>
                                        <input type="number" name="bookId" class="form-control" id="bookId" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="issuedDate" class="form-label">Issued Date</label>
                                        <input type="date" name="issuedDate" class="form-control" id="issuedDate" value="<?php echo date("Y-m-d"); ?>" required>
                                    </div>
                                    <div class="d-flex p-3 justify-content-end">
                                        <button type="submit" class="btn btn-primary" name="issue_book">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="return" tabindex="-1" aria-labelledby="returnBookModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="title">Return Book</h2>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <form method="POST">
                                    <div class="mb-3">
                                        <label for="memberId" class="form-label">Member Id</label>
                                        <input type="number" name="memberId" class="form-control" id="memberId" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="bookId" class="form-label">Book Id</label>
                                        <input type="number" name="bookId" class="form-control" id="bookId" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="returnedDate" class="form-label">Return Date</label>
                                        <input type="date" name="returnedDate" class="form-control" id="returnedDate" value="<?php echo date("Y-m-d"); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-select" name="status" id="status" arial-label="Select Book Status">
                                            <option value="Returned">Returned</option>
                                            <option value="Damaged/Lost">Damaged/Lost</option>   
                                        </select>
                                    </div>
                                    <div class="d-flex p-3 justify-content-end">
                                        <button type="submit" class="btn btn-primary" name="return_book">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>