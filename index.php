<!DOCTYPE html>
<html lang="en">

<head>
    <?php
        // Add analytics code here
        include_once "gtag.txt";
    ?>
    <meta name="description" content="A Pizza-dough calculator">
    <meta name="viewport" content="width=device-width">

    <link rel="shortcut icon" href="">
    <!-- Bootstrap https://getbootstrap.com/docs/5.3/getting-started/introduction/ -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Jquery https://jquery.com/ -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Flatpickr https://flatpickr.js.org/ -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- dayJS  https://day.js.org/en/ -->
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>
    <script>
        dayjs().format()
    </script>

    <title>Pizza-dough Calculator</title>
</head>

<body>

    <div class="container">

        <nav class="navbar bg-primary mb-3" data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="/dough-calculator/">Pizza-dough Calculator</a>
                <span class="navbar-text"><a class="nav-link active"
                        href="https://github.com/raminhossaini/ramin-dough-calculator/commits/main">Version
                        1.0.230902</a></span>
            </div>
        </nav>

        <!-- DateTime Picker -->
        <div class="row g-3 align-items-center timeModule">
            <!-- ... (DateTime Picker HTML) ... -->
        </div>

        <div class="row g-3 align-items-center">
            <!-- Portions, Portion size, Hydration HTML -->
        </div>

        <div class="row">
            <div class="col">
                <div class="alert alert-warning" id="portion-warning" role="alert">
                    The poolish amount of 300:300 is ideal for portions up to 12. For more portions, I recommend splitting
                    the recipe in 2 or more!
                </div>
            </div>
        </div>

        <div class="row">
            <h2 class="">Final Result:</h2>
            <!-- ... (Final Result HTML) ... -->
        </div>

        <div class="row">
            <h2 class="gy-5">Step 1 - Make the poolish:</h2>
            <p class="timeModule" id="labelDateTimeToStart"></p>
            <!-- ... (Step 1 HTML) ... -->
        </div>

        <div class="row gy-1">
            <div class="col">
                <ul class="list-group">
                    <!-- ... (Step 1 Checklist) ... -->
                </ul>
            </div>
        </div>

        <div class="row">
            <h2 class="gy-5">Step 2 - Final Mix:</h2>
            <p class="timeModule" id="labelStep2DateTime"></p>
            <ul class="list-group">
                <!-- ... (Step 2 Checklist) ... -->
            </ul>
        </div>

        <div class="row gy-1">
            <!-- ... (Remaining Flour, Water, Salt HTML) ... -->
        </div>

        <div class="row">
            <h2 class="gy-5">Final Steps:</h2>
            <div class="col">
                <ul class="list-group">
                    <!-- ... (Final Steps Checklist) ... -->
                </ul>
            </div>
        </div>

        <style>
            .footer__col {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100px;
                /* Set a fixed height for the footer */
                background-color: #333;
                /* Add a background color for visibility */
            }

            .footer__item {
                text-align: center;
            }
        </style>

        <nav class="navbar navbar-dark bg-primary">
            <!-- Navbar content here -->
        </nav>

        <div class="col footer__col">
            <div class="footer__items clean-list">
                <li class="footer__item">
                    Hosted with <span style="color: red;">&hearts;</span>
                    <a href="https://deplo.io/" rel="noopener noreferrer">
                        <img src="https://docs.nine.ch/img/theme/deploio.svg" alt="Deplo.io Logo" width="110"
                            height="100" style="border: 1px solid red;">
                    </a>
                </li>
            </div>
        </div>

    </div> <!-- container -->

    <script>
function refresh_data() {
    var portionSize = parseInt($("#inputPortionSize").val());
    var portions = parseInt($("#inputPortions").val());
    var hydration = parseInt($("#inputHydration").val());
    
    var totalDoughWeight = Math.round( portions * portionSize );                //Dough weight is PORTIONS * PORTION-SIZE
    var flourWeight = Math.round( totalDoughWeight / ((hydration/100)+1) );     //Flour weight is TOTAL-DOUGH-WEIGHT / ((HYDRATION / 100) + 1)
    var waterWeight = Math.round((hydration / 100) * flourWeight);              //Water is HYDRATION /100 * flourWeight
    var saltWeight = Math.round( 0.03 * flourWeight);                           //Salt is 3% of Flour weight


    // Time calculations. Working backwards from time to eat
    var dateTimeString = $("#inputDate").val() + " " + $("#inputTime").val();
    var eatDateTime = dayjs(dateTimeString);

    //work backwards
    // The last steps should be started 2-3 hours before the eating time
    var step2DateTime = dayjs(eatDateTime).subtract(2, 'hour');
    var step2StartTime = dayjs(step2DateTime).format("ddd, DD-MMM-YYYY HH:mm");
    
    var step2EarliestDateTime = dayjs(eatDateTime).subtract(3, 'hour');
    var step2EarliestStartTime = dayjs(step2EarliestDateTime).format("ddd, DD-MMM-YYYY HH:mm");

    $("#labelStep2DateTime").html("<i class='bi bi-clock'></i> Recommended time to start: <b>" + step2EarliestStartTime + "</b> and <b>" + step2StartTime + "</b>");

    //Next step is to calculate the 16 + 1 hour ferment
    var latestStartDateTime = dayjs(eatDateTime).subtract(17+3, 'hour').format("ddd, DD-MMM-YYYY HH:mm");

    //And lastly the longest ferment of 24 + 1 hours
    var earliestStartDateTime = dayjs(eatDateTime).subtract(25+3, 'hour').format("ddd, DD-MMM-YYYY HH:mm");

    //set date & time to start
    $("#labelDateTimeToStart").html("<i class='bi bi-clock'></i> Recommended time to start: Between <b>" + earliestStartDateTime + "</b> and <b>" + latestStartDateTime + "</b>");


    //Show a warning if making more than 12 portions
	if (portions > 12) {
		$("#portion-warning").show();	
	}
	else {
		$("#portion-warning").hide();
	}

    $("#inputTotalDoughWeight").val(totalDoughWeight); 
    $("#inputFlour").val(flourWeight); 
    $("#inputWater").val(waterWeight); 
    $("#inputSalt").val(saltWeight); 

    if (waterWeight < 401) {
        $("#inputPoolishFlour").val("100");
        $("#inputPoolishWater").val("100");
        $("#inputPoolishYeast").val("3");
        $("#inputPoolishHoney").val("2");
    }
    else if (waterWeight > 400 && waterWeight < 2501) {
        $("#inputPoolishFlour").val("300");
        $("#inputPoolishWater").val("300");
        $("#inputPoolishYeast").val("6");
        $("#inputPoolishHoney").val("6");
    }

    var poolishFlourWeight = parseInt($("#inputPoolishFlour").val());
    var poolishWaterWeight = parseInt($("#inputPoolishWater").val());
    var poolishYeastWeight = parseInt($("#inputPoolishYeast").val());

    var remainingFlour = Math.round( flourWeight - poolishFlourWeight );
    var remainingWater = Math.round( waterWeight - poolishWaterWeight );
    var remainingSalt = Math.round( saltWeight );

    $("#inputRemainingFlour").val(remainingFlour);
    $("#inputRemainingWater").val(remainingWater);
    $("#inputRemainingSalt").val(remainingSalt);

}

//Refresh when key is pressed
$( "input" ).keyup(function() {
    refresh_data();
});
$( "input" ).change(function() {
    refresh_data();
});

$("#toggleTime").click(function () {
    $(".timeModule").toggle();
});

//Initial refresh of numbers when page loads
$( document ).ready(function() {

    $("#inputDate").flatpickr({
        minDate: "today"
    });

    $("#inputTime").flatpickr({
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true
    });

    refresh_data();
    
});

    </script>

</body>

</html>
