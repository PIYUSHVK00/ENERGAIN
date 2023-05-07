<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dashbord</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../style/index.css" />
</head>

<body>
    <?php
        session_start();
        require_once('../../db_connect.php');

        // Check if user is logged in, otherwise redirect to login page
        if(!isset($_SESSION['email'])) {
            header("Location: login.php");
            exit();
        }

        // Get meter id for logged-in user
        $email = $_SESSION['email'];
        $meter_id_query = "SELECT meter_id FROM users WHERE email = '$email'";
        $meter_id_result = mysqli_query($conn, $meter_id_query);
        $meter_id_row = mysqli_fetch_assoc($meter_id_result);
        $meter_id = $meter_id_row['meter_id'];

        // Get data for the logged-in user with their meter id from electricityuses table
        $electricityuses_query = "SELECT * FROM electricityuses WHERE meter_id = '$meter_id'";
        $electricityuses_result = mysqli_query($conn, $electricityuses_query);
        $electricityuses_data = array();
        if(mysqli_num_rows($electricityuses_result) > 0) {
            while($row = mysqli_fetch_assoc($electricityuses_result)) {
                $electricityuses_data[] = $row;
            }
        }

        // Get data for the logged-in user with their meter id from solarusages table
        $solarusages_query = "SELECT * FROM solarusages WHERE meter_id = '$meter_id'";
        $solarusages_result = mysqli_query($conn, $solarusages_query);
        $solarusages_data = array();
        if(mysqli_num_rows($solarusages_result) > 0) {
            while($row = mysqli_fetch_assoc($solarusages_result)) {
                $solarusages_data[] = $row;
            }
        }

    ?>

    <div class="flex">
        <?php

            require_once('../../components/User/navbar.php');

        ?>

        <div class="w-full pl-72 bg-[#DFEBE7] p-6 overscroll-auto">
            <div id="notice">Notice</div>
            <div class="flex flex-wrap">
                <div id="card" class="w-60 text-2xl h-36 ml-10 text-white">
                    Current Unit :- 60
                </div>
                <div id="card2" class="w-60 text-2xl h-36 ml-10 text-white">
                    Last Month Unit :- 130
                </div>
                <div id="card3" class="w-60 text-2xl h-36 ml-10 text-white">
                    Current Slab :-
                </div>
            </div>
            <div id="title-bar1">Electricity Usages</div>


            <?php
                if (!empty($electricityuses_data)) {
            ?>

            <table class="w-full bg-[#D9D9D9] border-collapse border border-slate-500">
                <thead>
                    <tr class="bg-[black] text-white text-2xl font-light">
                        <th class="border border-slate-600 ...">Sr.No.</th>
                        <th class="border border-slate-600 ...">Date </th>
                        <th class="border border-slate-600 ...">Units Consumed</th>
                        <th class="border border-slate-600 ...">Price</th>
                    </tr>
                </thead>
                <tbody class="text-xl text-center font-normal">
                    <?php
                        foreach ($electricityuses_data as $row) {
                    ?>
                    <tr>
                        <td class="border border-slate-700 ..."><?php echo $row['srno']; ?></td>
                        <td class="border border-slate-700 ..."><?php echo $row['data']; ?></td>
                        <td class="border border-slate-700 ..."><?php echo $row['unitconsume']; ?> Units</td>
                        <td class="border border-slate-700 ..."><?php echo $row['price']; ?> ₹</td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <?php
            } else {
                echo "No data found.";
            }
            ?>

            <div id="title-bar1">Solar Electricity Usages</div>

            <?php
                if (!empty($solarusages_data)) {
            ?>

            <table class="w-full bg-[#D9D9D9] border-collapse border border-slate-500">
                <thead>
                    <tr class="bg-[black] text-white text-2xl font-light">
                        <th class="border border-slate-600 ...">Sr.No.</th>
                        <th class="border border-slate-600 ...">Date </th>
                        <th class="border border-slate-600 ...">Units Consumed</th>
                        <th class="border border-slate-600 ...">Price</th>
                    </tr>
                </thead>
                <tbody class="text-xl text-center font-normal">
                    <?php
                        foreach ($solarusages_data as $row) {
                    ?>
                    <tr>
                        <td class="border border-slate-700 ..."><?php echo $row['srno']; ?></td>
                        <td class="border border-slate-700 ..."><?php echo $row['date']; ?></td>
                        <td class="border border-slate-700 ..."><?php echo $row['unitconsume']; ?> Units</td>
                        <td class="border border-slate-700 ..."><?php echo $row['price']; ?> ₹</td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <?php
            } else {
                echo "No data found.";
            }
            ?>
        </div>
    </div>

</body>

</html>