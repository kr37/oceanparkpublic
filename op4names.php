<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Path to Bliss: Away Retreat at Ocean Park</title>
    <style>
        td {border: 1px gray solid;}
        table {border-collapse: collapse;}
        .reserved {color: gray;}
        .reserved:after {content: " Reserved";}
    </style>
</head>

<body>

    <h2>Step 4: Names and linens</h2>

    <form action="op5personalInfo.php" method="get">
        <p>Total Cost: <span id="mainCost">$0 </span> 
        <input type="submit" value="Next"></p>
        <?php foreach($_GET as $key => $value) echo "        <input type='hidden' name='$key' value='$value'>\n"; ?>

        <?php
        include("opDatabase.php");
        $roomsChosen = array_keys($_GET);
        $roomIDs = [];
        foreach($roomsChosen as $room) //Put all valid roomIDs into an array
            if (substr($room, 0, 4) === 'room')
                $roomIDs[] = substr($room, 4);
        foreach ($roomIDs as $id) {
            $room = $rooms[$id]; $buildingID = $room['buildingID']; $building = $buildings[$buildingID];
            echo "<br>\n        $building[name] room  {$room['roomNumber']}: $room[description]<br>\n";
            echo "        <fieldset>\n";
            for ($i = 0; $i < $room['beds']; $i++) {
                $idStub = "Bldg{$buildingID}Rm{$id}Person{$i}";
                echo <<<INPUTS
                <input type='checkbox' class='chosen' id='$idStub' onclick='checkboxToggled($idStub);' data-p1='300' data-p2='240' data-p3='200'>
                <input type='text' name='{$idStub}Firstname' id='{$idStub}Firstname' placeholder='First name' disabled>
                <input type='text' name='{$idStub}Lastname' id='{$idStub}Lastname' placeholder='Last name' disabled>
                <label for="{$idStub}Age">Age</label> 
                <select name="{$idStub}Age" id="{$idStub}Age" disabled>
                    <option value="18+">18+</option>
                    <option value="17">17</option>
                    <option value="16">16</option>
                    <option value="15">15</option>
                    <option value="14">14</option>
                    <option value="13">13</option>
                    <option value="12">12</option>
                    <option value="11">11</option>
                    <option value="10">10</option>
                    <option value="9">9</option>
                    <option value="8">8</option>
                    <option value="7">7</option>
                    <option value="6">6</option>
                    <option value="5">5</option>
                    <option value="4">4</option>
                    <option value="3">3</option>
                    <option value="2">2</option>
                    <option value="1">1</option>
                    <option value="0">0</option>
                </select>
                Include linens $15 <input type='checkbox' name='{$idStub}Linens' id='{$idStub}Linens' disabled><br>

INPUTS;
            } 
            echo "            <p>Cost: <span id='cost$id'></span></p>\n";
            echo "        </fieldset>";
        }
    ?> 
    </form>
    <pre>
    <?php
        var_dump($_GET);
    ?>
    </pre>
    <script>
        function checkboxToggled(checkbox){
            id = checkbox.id; 
            toggleDisabled(id+'Firstname');
            toggleDisabled(id+'Lastname');
            toggleDisabled(id+'Linens');
            toggleDisabled(id+'Age');
            tallyAll();
        }

        function toggleDisabled(id) {
            var element = document.getElementById(id); element.disabled = !element.disabled;
        }
            
        function tallyAll(){
            var checked = document.querySelectorAll('input[class="chosen"]:checked');
            var cost = 0;
            for (var i=0; i < checked.length; i++) {
                cost += parseInt(checked[i].dataset.p1);
            }
            document.getElementById('mainCost').textContent = '$'+cost;
            //var allNames = document.getElementsByClassName('chosen');
        }
    </script>
</body>
</html>
