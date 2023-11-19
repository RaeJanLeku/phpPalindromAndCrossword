<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Palindrom Checker</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">
    <h1>Palindrom Checker</h1>
    
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Form gönderildiğinde, metni al ve palindrom kontrolü yap
        $inputText = $_POST["textInput"];

        // Türkçe karakter düzenlemesi
        $inputText = mb_strtolower($inputText, 'UTF-8');
        $inputText = preg_replace('/[^a-zığüşöçı\s]/u', '', $inputText);

        // Her kelimenin palindrom kontrolü
        $words = preg_split('/\s+/', $inputText, -1, PREG_SPLIT_NO_EMPTY);
        $palindromes = [];
        foreach ($words as $word) {
            $reversedWord = reverseString($word);
            if ($word != '' && $word == $reversedWord) {
                $palindromes[] = $word;
            }
        }

        // Sonucu ekrana yazdır
        echo '<div id="result">';
        if (!empty($palindromes)) {
            echo "Girilen metin içindeki palindrom kelimeler: " . implode(', ', $palindromes) . "<br>";
            echo "Girilen metin içindeki palindrom sayısı: " . count($palindromes);
        } else {
            echo "Girilen metin içinde palindrom kelime bulunamadı.";
        }
        echo '</div>';
    }

    // Özel fonksiyon: Metni ters çevir
    function reverseString($str) {
        $length = mb_strlen($str, 'UTF-8');
        $reversed = '';
        for ($i = $length - 1; $i >= 0; $i--) {
            $reversed .= mb_substr($str, $i, 1, 'UTF-8');
        }
        return $reversed;
    }
    ?>

    <form method="post" action="">
        <label for="textInput">Metin Girin:</label>
        <input type="text" name="textInput" id="textInput" placeholder="Bir metin girin..." required>
        <button type="submit">Kontrol Et</button>
    </form>
</div>

</body>
</html>
