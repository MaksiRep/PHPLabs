<html>

<head>
    <title> ex4 </title>
</head>

<body>
    <?php
    $mysqli_user = "root";
    $mysqli_password = "";
    $conn = mysqli_connect("localhost", $mysqli_user, $mysqli_password);
    if (!$conn)
        die("��� ���������� � MySQL");
    $database = "sample";
    mysqli_select_db($conn, $database)
        or die("������ ������� $database");
    mysqli_set_charset($conn, "cp1251");


    $tab_res = mysqli_query($conn, "SHOW TABLES");
    print "<dl><dd>\n";
    while ($tab_rows = mysqli_fetch_row($tab_res)) {
        if ($tab_rows[0] == "notebook") {
            print "<form action='{$_SERVER['PHP_SELF']}' method='post'>";
            print "<table border='1'>";
            $query_res = mysqli_query($conn, "SELECT * from $tab_rows[0]");
            $num_fields = mysqli_num_fields($query_res);
            print "<tr>";
            for ($x = 0; $x < $num_fields; $x++) {
                $properties = mysqli_fetch_field_direct($query_res, $x);
                print "<th>";
                print $properties->name;
                print "</th>";
            }
            print "<th>";
            print "���������";
            print "</th>";
            print "</tr>";
            while ($a_row = mysqli_fetch_row($query_res)) {
                $id = $a_row[0];
                print "<tr>\n";
                foreach ($a_row as $field)
                    print "\t<td>$field</td>\n";
                print "\t<td><input type='radio' name='id' value = $id></td>\n";
                print "</tr>\n";
            }

            print "</table>";
            print "<p><input type='submit' value='�������'>";
            print "</form>";
        }
    }



    if ($_POST["id"] != '') {
        $id = $_POST["id"];
        $val_array;
        $tab_res = mysqli_query($conn, "SHOW TABLES");
        while ($tab_row = mysqli_fetch_row($tab_res)) {
            if ($tab_row[0] == "notebook") {
                print "<form action='ex4-help.php' method='post'>";
                print "<input type=hidden name=id value=$id>";
                print "<select size='1' name='res[]'>";
                $query_res = mysqli_query($conn, "SELECT * from $tab_row[0]");
                while ($a_row = mysqli_fetch_row($query_res)) {
                    if ($id == $a_row[0]) {
                        print "<option value='name'>";
                        print $a_row[1];
                        print "</option><option value='city'>";
                        print $a_row[2];
                        print "</option><option value='address'>";
                        print $a_row[3];
                        print "</option><option value='birthday'>";
                        print $a_row[4];
                        print "</option><option value='mail'>";
                        print $a_row[5];
                        print "</option>";
                    }
                }
                print "</select>";
                print " ������� ����� ��������";
                print " <input type='text' name='value'>";
                print "<p><input type='submit' value='��������'>";
                print "</form>";
            }
        }
    }

    print "<p><a href='ex3.php'>������� �� �������</a>";
    ?>
</body>

</html>