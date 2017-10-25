<div id="infoi" style="height: 100%; position: fixed; top: 400px; left: 10px; z-index: 1100;">

    <div style="background-color: deepskyblue">
        <?php
        /*foreach($_SERVER as $x => $x_value) {
            echo $x . " " .$x_value . "</br>";
        }
        */
            echo "Variables -- Server" . "</br>";
            echo "REDIRECT_URL = " . $_SERVER[REDIRECT_URL];
        ?>
    </div>

    <div style="background-color: darkorange">
        <?php
            echo "Variables -- Session" . "</br>";
            foreach($_SESSION as $x => $x_value) {
                echo $x . " " .$x_value . "</br>";
            }
        ?>
    </div>

</div>