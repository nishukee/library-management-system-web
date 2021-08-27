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
            @font-face {
                font-family: 'bootstrap_cons';
                src: url('../../fonts/bootstrap-icons.woff') format('woff');
            }

            a { text-decoration: none;}
        </style>
        <title>AdminPage</title>
    </head>
    <body>
        <header id="header">
           <div class="navbar bg-dark navbar-dark">
               <div class="container-fluid">
                    <a class="navbar-brand" href="../adminpage.php">   
                        <img src="../../icons/book.svg" width="40" height="40" alt=""> Library
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
                        <a class="nav-link" href="../Books/books.php">Books</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Members/members.php">Members</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Issue_Return/issue_return.php">Issue/Return</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Records</a>
                    </li>
                </ul>
            </div>
            <div class="d-flex p-3 justify-content-end">   
                <button type='button' class='btn btn-secondary' onClick="exportData()"><img src="../../icons/download.svg" width="25" height="25"> Download Table</button>
            </div>
            <div class="container-fluid table-responsive">
                <table class="table table-striped caption-top" id="records_table">
                    <caption>List of Records</caption>
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Book ID</th>
                            <th scope="col">Book Name</th>
                            <th scope="col">Member ID</th>
                            <th scope="col">Member Name</th>
                            <th scope="col">Issued Date</th>
                            <th scope="col">Return By</th>
                            <th scope="col">Returned On</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $query = "SELECT * from records";
                            $stmt = $conn->prepare($query);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            if ($result->num_rows > 0){
                                $rows = $result->fetch_all(MYSQLI_ASSOC);
                                foreach ($rows as $row) {
                                    $id = $row['id'];
                                    $bookId = $row['bookId'];
                                    $bookName = $row['bookName'];
                                    $memberId = $row['memberId'];
                                    $memberName = $row['memberName'];
                                    $issuedDate = $row['issuedDate'];
                                    $returnBy = $row['returnBy'];
                                    $returnedDate = $row['returnedDate'];
                                    $status = $row['status'];
                            ?>
                        <tr>
                            <td>
                                <?php echo $id; ?>
                            </td>
                            <td>
                                <?php echo $bookId; ?>
                            </td>
                            <td>
                                <?php echo $bookName; ?>
                            </td>
                            <td>
                                <?php echo $memberId; ?>
                            </td>
                            <td>
                                <?php echo $memberName; ?>
                            </td>
                            <td>
                                <?php echo $issuedDate; ?>
                            </td>
                            <td>
                                <?php echo $returnBy; ?>
                            </td>
                            <td>
                                <?php echo $returnedDate; ?>
                            </td>
                            <td>
                                <?php echo $status; ?>
                            </td>
                        </tr>
                        <?php
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
        <script type="text/javascript" src="../../js/bootstrap.js"></script>
    </body>
<html>
