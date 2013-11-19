<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <?php include 'includes/headers.php'; ?>

        <!-- choose a theme file -->
        <link rel="stylesheet" href="/css/theme.default.css">
        <!-- load jQuery and tablesorter scripts -->
        <script type="text/javascript" src="/includes/jquery.tablesorter.js"></script>
    </head>
    <body>
        <div class="wrapper">
            <div class="container">
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped table-bordered table-hover tablesorter">
                        <thead>
                            <tr>
                                <th>Last Name</th>
                                <th>First Name</th>
                                <th>Email</th>
                                <th>Due</th>
                                <th>Web Site</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Smith</td>
                                <td>John</td>
                                <td>jsmith@gmail.com</td>
                                <td>$50.00</td>
                                <td>http://www.jsmith.com</td>
                            </tr>
                            <tr>
                                <td>Bach</td>
                                <td>Frank</td>
                                <td>fbach@yahoo.com</td>
                                <td>$50.00</td>
                                <td>http://www.frank.com</td>
                            </tr>
                            <tr>
                                <td>Doe</td>
                                <td>Jason</td>
                                <td>jdoe@hotmail.com</td>
                                <td>$100.00</td>
                                <td>http://www.jdoe.com</td>
                            </tr>
                            <tr>
                                <td>Conway</td>
                                <td>Tim</td>
                                <td>tconway@earthlink.net</td>
                                <td>$50.00</td>
                                <td>http://www.timconway.com</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(function() {
                $("#myTable").tablesorter();
            });
        </script>
    </body>
</html>
