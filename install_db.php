#!/usr/bin/php

<?php

$fill_db = true;

ini_set("display_errors", "1");


//try to connect to the database using new settings and register administrator
include("./cfg/connect.inc.php");

//choose database file to include
include("./includes/database/mysql.php");

$sel = NULL;
$conn = db_connect(DB_HOST, DB_USER, DB_PASS, DB_CHARSET);
if ($conn) {
    if (!(db_select_db(DB_NAME))) //database connect failed
    {
        $error = "Database connection error " . DB_NAME ;
    }

} else
    $error = "Server connection error)";


if (!isset($error)) //successful!
{
    //create tables
    include("./includes/database/install/mysql.php");


    if ($fill_db) //fill DB with demo content
    {
        //fill products and categories tables
        $helper = "[#%int!g%#]"; //helper
        if (file_exists("./cfg/demo_database.sql")) {
            $f = implode("", file("./cfg/demo_database.sql"));
            $f = explode("INSERT INTO", $f);

            for ($i = 1; $i < count($f); $i++) {
                db_query(trim("INSERT INTO " . str_replace($helper, "INSERT INTO", $f[$i]))) or die (db_error());
            }
        }

    }
    print ("install_db Done\n");
} else {
    print ("install_db Error $error\n");
}

