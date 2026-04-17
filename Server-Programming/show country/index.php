<?php
    function extract_countries($text) {
        $globe = array(
            "Afghanistan", "Albania", "Algeria", "Andorra", "Angola", "Antigua and Barbuda", "Argentina", "Armenia", "Australia",
            "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bhutan", "Bolivia",
            "Bosnia and Herzegovina", "Botswana", "Brazil", "Brunei", "Bulgaria", "Burkina Faso", "Burundi", "Cabo Verde", "Cambodia", "Cameroon",
            "Canada", "Central African Republic", "Chad", "Chile", "China", "Colombia", "Comoros", "Congo", "Costa Rica", "Cote d'Ivoire", "Croatia",
            "Cuba", "Cyprus", "Czechia", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea",
            "Eritrea", "Estonia", "Eswatini", "Ethiopia", "Fiji", "Finland", "France", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Greece", "Grenada",
            "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Honduras", "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq", "Ireland",
            "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Kosovo", "Kuwait", "Kyrgyzstan", "Laos", "Latvia", "Lebanon",
            "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta",
            "Marshall Islands", "Mauritania", "Mauritius", "Mexico", "Micronesia", "Moldova", "Monaco", "Mongolia", "Montenegro", "Morocco", "Mozambique",
            "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "New Zealand", "Nicaragua", "Niger", "Nigeria", "North Korea", "North Macedonia", "Norway",
            "Oman", "Pakistan", "Palau", "Palestine", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Poland", "Portugal", "Qatar", "Romania",
            "Russia", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe",
            "Saudi Arabia", "Senegal", "Serbia", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa",
            "South Korea", "South Sudan", "Spain", "Sri Lanka", "Sudan", "Suriname", "Sweden", "Switzerland", "Syria", "Taiwan", "Tajikistan", "Tanzania",
            "Thailand", "Timor-Leste", "Togo", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates",
            "United Kingdom", "United States", "Uruguay", "Uzbekistan", "Vanuatu", "Vatican City", "Venezuela", "Vietnam", "Yemen", "Zambia", "Zimbabwe"
        );

        $asia_countries = [
            "Kazakhstan","Kyrgyzstan","Tajikistan","Uzbekistan",
            "China","Hong Kong","Macao","Japan","Mongolia","South Korea","North Korea",
            "Afghanistan","Bangladesh","Bhutan","India","Iran","Maldives","Nepal","Pakistan","Sri Lanka",
            "Brunei","Cambodia","Indonesia","Laos","Malaysia","Myanmar","Philippines","Singapore","Thailand","Timor-Leste","Vietnam",
            "Armenia","Azerbaijan","Bahrain","Cyprus","Georgia","Iraq","Israel","Jordan","Kuwait","Lebanon","Oman","Qatar","Saudi Arabia",
            "Palestine","Syria","Turkey","United Arab Emirates","Yemen"
        ];

        $text = strtolower($text);
        $globe = array_map('strtolower', $globe);
        $countries_found = [];

        foreach ($globe as $country) {
            if (strpos($text, strtolower($country)) !== false) {
                $countries_found[] = $country;
            }
        }

        $asia = [];
        $others = [];
        foreach ($countries_found as $country) {
            if (in_array($country, array_map('strtolower', $asia_countries))) {
                $asia[] = $country;
            } else {
                $others[] = $country;
            }
        }

        $countries_found = array_unique($countries_found);
        sort($countries_found);

        return [$asia, $others, $countries_found];
    }

    $article = '';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $article = $_POST['article'];
        list($asia, $others, $all_countries) = extract_countries($article);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Country Extraction</title>
</head>
<body>
    <h2>แยกชื่อประเทศจากบทความ</h2>

    <form method="post" action="">
        <textarea name="article" rows="10" cols="50" placeholder="กรอกบทความภาษาอังกฤษที่นี่..."><?php echo htmlspecialchars($article); ?></textarea><br><br>
        <input type="submit" value="แยกประเทศ">
    </form>

    <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
        <h3>ประเทศทั้งหมดที่พบเจอ</h3>
        <ul>
            <?php foreach ($all_countries as $country): ?>
                <li><?php echo htmlspecialchars(ucwords($country)); ?></li>
            <?php endforeach; ?>
        </ul>

        <h3>ประเทศในโซนเอเชีย</h3>
        <ul>
            <?php foreach ($asia as $country): ?>
                <li><?php echo htmlspecialchars(ucwords($country)); ?></li>
            <?php endforeach; ?>
        </ul>

        <h2>ประเทศโซนอื่นๆ</h2>
        <ul>
            <?php foreach ($others as $country): ?>
                <li><?php echo htmlspecialchars(ucwords($country)); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>