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

    <form action="op5personalInfo.php" method="post">
        <p>Total Cost: $<span id="mainCost">0</span> 
        <input type="submit" value="Next" onclick='return validate(event);'></p>
        <p>Under 18: 1/2 price.  Under 6: $50.  Under 3: Free</p>

        <?php foreach($_POST as $key => $value) echo "        <input type='hidden' name='$key' value='$value'>\n"; ?>

        <?php
        include("../../nonpublic/oceanpark/opDatabase.php");
        $roomsChosen = array_keys($_POST);
        $roomIDs = [];
        foreach($roomsChosen as $room) //Put all valid roomIDs into an array
            if (substr($room, 0, 4) === 'room')
                $roomIDs[] = substr($room, 4);
        foreach ($roomIDs as $id) {
            $room = $rooms[$id]; $buildingID = $room['buildingID']; $building = $buildings[$buildingID];
            echo "\n        <fieldset id='fieldset$id' data-roomId='$id' $building[priceData]>\n";
            echo "                <p><strong>$building[name] room  {$room['roomNumber']}: $room[description]</strong></p>\n";
            echo "                <input type='hidden' class='roomCost' id='roomCost$id' name='roomCost$id' value='0'>\n";
            for ($i = 0; $i < $room['beds']; $i++) {
                $roomStub = "Bldg{$buildingID}Rm{$id}";
                $idStub = "Bldg{$buildingID}Rm{$id}Person{$i}";
                echo <<<INPUTS
                <input type='checkbox' class='chosen room$id' id='$idStub' onclick='checkboxToggled($idStub);' $building[priceData] data-roomStub='$roomStub'>
                <input type='text' name='{$idStub}Firstname' id='{$idStub}Firstname' placeholder='First name' disabled>
                <input type='text' name='{$idStub}Lastname' id='{$idStub}Lastname' placeholder='Last name' disabled>
                <label for="{$idStub}Age">Age</label> 
                <select class="AgesRm$id" name="{$idStub}Age" id="{$idStub}Age" onchange='updateCosts($id);' disabled>
                    <option value="18">18+</option>
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
                Include linens $15 <input type='checkbox' class='linens$id' name='{$idStub}Linens' id='{$idStub}Linens' onchange='updateCosts($id);' disabled>
                <input type='text' class='cost$id' id='{$idStub}cost' name='{$idStub}cost' value='' size='4' readonly='readonly'><br>

INPUTS;
            } 
            echo "            <p>Cost of this room: <span id='cost$id'></span></p>\n";
            echo "        </fieldset>";
        }
    ?> 
    </form>
    <pre>
    <?php
        //var_dump($_POST);
    ?>
    </pre>
    <script>
        function checkboxToggled(checkbox){
            var id = checkbox.id; 
            var roomStub = checkbox.dataset['roomStub'];
            toggleDisabled(id+'Firstname');
            toggleDisabled(id+'Lastname');
            toggleDisabled(id+'Linens');
            toggleDisabled(id+'Age');

            // Tally the cost for this room. First, figure out how many people.
            var matches = id.match(/Bldg\d+Rm(\d+)Person\d+/) //Get the room Number from the id
            var room = matches[1];

            updateCosts(room);
        }

        function toggleDisabled(id) {
            var element = document.getElementById(id); element.disabled = !element.disabled;
        }
            
        function updateCosts(room) {
            // Get the parent fieldset
            var parent = document.getElementById('fieldset'+room);
            // Find out how many people are staying in this room
            var checked = document.querySelectorAll('input[class="chosen room'+room+'"]:checked');
            var peopleInRoom = checked.length;
            // Get the price point for that Number of people
            var price = peopleInRoom > 0 ? parent.dataset['p'+peopleInRoom] : 0;

            //Now, loop through all the beds in the room, updating the cost for each bed
            var cost = 0;
            var allBedsInRoomChk = document.querySelectorAll('input[class="chosen room'+room+'"]');
            var allAgesInRoom    = document.querySelectorAll('select[class="AgesRm'+room+'"]');
            var allLinensInRoom  = document.querySelectorAll('input[class="linens'+room+'"]');
            var bedCosts         = document.querySelectorAll('input[class="cost'+room+'"]');
            for (i=0; i<bedCosts.length; i++) {
                var linenCost = allLinensInRoom[i].checked ? 15 : 0;
                if (allBedsInRoomChk[i].checked == true) {
                    var age = allAgesInRoom[i].value;
                    if (age > 17) 
                        bedCosts[i].value  = Number(linenCost) + Number(price);
                    else if (age > 5)
                        bedCosts[i].value  = Number(linenCost) + Number(price) / 2;
                    else if (age > 2)
                        bedCosts[i].value  = Number(linenCost) + 50;
                    else bedCosts[i].value = Number(linenCost);
                } else {
                    bedCosts[i].value = 0;
                }
                cost += parseInt(bedCosts[i].value);
            }
                
            // Display the cost for this room
            document.getElementById('cost'+room).textContent = '$'+cost;
            // Set hidden input with cost for this room
            document.getElementById('roomCost'+room).value = cost;
            // Update the total cost for all rooms
            tallyAll();
        }

        function tallyAll(){
            var inputs = document.querySelectorAll('input[class="roomCost"]');
            var cost = 0;
            for (var i=0; i < inputs.length; i++) {
                cost += parseInt(inputs[i].value);
            }
            document.getElementById('mainCost').textContent = cost;
            //var allNames = document.getElementsByClassName('chosen');
        }

        function validate(e) {
            var emptyName = 0;
            var allBedsInRoomChk = document.getElementsByClassName('chosen');
            for (i=0; i<allBedsInRoomChk.length; i++) {
                if (allBedsInRoomChk[i].checked) {
                    //Check that the names are filled in
                    var idStub = allBedsInRoomChk[i].id;
                    if (document.getElementById(idStub + 'Firstname').value == '') {
                        emptyName = 1;
                    } else if (document.getElementById(idStub + 'Lastname').value == '') {
                        emptyName = 1;
                    }
                }
            }
            if (emptyName) {
                alert('Please enter first and last names for everybody.');
                return false;
            } else {
                return true;
            }
        }
    </script>
</body>
</html>
