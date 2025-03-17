<?php



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $search = $_POST['search'];
    $jsonData = json_decode(file_get_contents('data.json'), true);
     $searchPattern= '/'.$search.'/i';
    foreach ($jsonData as $key => $value) {
        if (preg_match($searchPattern, $value['name'])){
            $searchedData[] = $value;
        }

    $searchedData = [];

    header("Location: index.php?search=1");
   
    exit;
}

}