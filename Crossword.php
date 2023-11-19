
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Crossword Game</title>
    <style>
        table {
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: center;
            width: 30px;
            height: 30px;
            cursor: pointer;
        }

        .white {
            background-color: white;
        }

        .black {
            background-color: #191919;
        }

        form {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<?php
$words = [
    "php" => "A server-side scripting language",
    "html" => "A markup language for creating web pages",
    "css" => "A style sheet language used for describing the look and formatting of a document written in HTML",
    "javascript" => "A programming language commonly used to create interactive effects within web browsers",
    "python" => "A high-level, interpreted programming language known for its readability and versatility",
    "ddos" => "A malicious attempt to disrupt the regular functioning of a network or website",
    "dos" => "An attempt to make a machine or network resource unavailable to its intended users",
    "server" => "A computer or system that manages network resources and provides services to other computers, known as clients",
    "client" => "A computer program or device that requests services or resources from a server",
    "web" => "Referring to the World Wide Web, a system of interlinked hypertext documents accessed via the internet",
    "database" => "A structured set of data stored and organized for easy retrieval and manipulation",
    "API" => "Application Programming Interface, a set of tools and protocols for building software applications",
    
];

function generateGrid($words)
{
    $gridSize = 12;
    $grid = array_fill(0, $gridSize, array_fill(0, $gridSize, ''));

    // Sort words by length in descending order
    uksort($words, function ($a, $b) {
        return strlen($b) - strlen($a);
    });

    foreach ($words as $word => $clue) {
        $direction = rand(0, 1); // 0 for horizontal, 1 for vertical
        $length = strlen($word);
        $placed = false;

        while (!$placed) {
            $startX = rand(0, $gridSize - 1);
            $startY = rand(0, $gridSize - 1);

            if ($direction == 0 && $startX + $length <= $gridSize) {
                $validPlacement = true;

                // Check if there are no conflicting letters from other words
                for ($i = 0; $i < $length; $i++) {
                    if ($grid[$startY][$startX + $i] !== '' && $grid[$startY][$startX + $i] !== $word[$i]) {
                        $validPlacement = false;
                        break;
                    }
                }

                // Check if black blocks can be placed on both sides of the word
                if ($validPlacement && ($startX == 0 || $grid[$startY][$startX - 1] === '') && ($startX + $length == $gridSize || $grid[$startY][$startX + $length] === '')) {
                    for ($i = 0; $i < $length; $i++) {
                        $grid[$startY][$startX + $i] = $word[$i];
                    }
                    $placed = true;
                }
            } elseif ($direction == 1 && $startY + $length <= $gridSize) {
                $validPlacement = true;

                // Check if there are no conflicting letters from other words
                for ($i = 0; $i < $length; $i++) {
                    if ($grid[$startY + $i][$startX] !== '' && $grid[$startY + $i][$startX] !== $word[$i]) {
                        $validPlacement = false;
                        break;
                    }
                }

                // Check if black blocks can be placed on both sides of the word
                if ($validPlacement && ($startY == 0 || $grid[$startY - 1][$startX] === '') && ($startY + $length == $gridSize || $grid[$startY + $length][$startX] === '')) {
                    for ($i = 0; $i < $length; $i++) {
                        $grid[$startY + $i][$startX] = $word[$i];
                    }
                    $placed = true;
                }
            }
        }
    }

    return $grid;
}


function displayGrid($grid)
{
    echo "<table>";

    foreach ($grid as $row) {
        echo "<tr>";
        foreach ($row as $cell) {
            $class = $cell == '' ? 'black' : 'white'; // Set class based on cell content
            echo "<td class='$class' onclick='fillCell(this)'>$cell</td>";
        }
        echo "</tr>";
    }

    echo "</table>";
}

$crosswordGrid = generateGrid($words);
displayGrid($crosswordGrid);
?>

<script>
    function fillCell(cell) {
        if (cell.classList.contains('white') && cell.innerHTML.trim() === '') {
            var userGuess = prompt('Enter your guess:');
            cell.innerHTML = userGuess;

            // Check if the entered text matches any of the words
            if (Object.keys(<?php echo json_encode($words); ?>).includes(userGuess.toLowerCase())) {
                alert('You won!');
            }
        }
    }
</script>

<table>
    <tr>
        <th>Rank</th>
        <th>Word</th>
        <th>Clue</th>
    </tr>
    <?php
$i = 1; // Initialize counter variable
foreach ($words as $word => $clue) {
    echo "<tr>";
    echo "<td>" . $i . "</td>";
    echo "<td>$word</td>";
    echo "<td>$clue</td>";
    echo "</tr>";
    $i++;
}
?>
</table>

</body>
</html>
