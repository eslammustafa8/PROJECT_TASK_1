<?php

$jsonData = json_decode(file_get_contents('data.json'), true) ?? [];

$search = isset($_POST['search']) ? trim($_POST['search']) : '';

if ($search) {
    $searchPattern = '/' . preg_quote($search, '/') . '/i';
    $jsonData = array_filter($jsonData, function ($item) use ($searchPattern) {
        return preg_match($searchPattern, $item['name']);
    });
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            background-color: #f4f4f4;
        }
        
        .wrapper {
            display: flex;
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .container {
            flex: 1;
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }
        
        .form-container {
            flex-basis: 30%;
            min-width: 350px;
        }
        
        .data-container {
            flex-basis: 70%;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }
        
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }
        
        .form-group input:focus,
        .form-group textarea:focus {
            border-color: #007bff;
            outline: none;
        }
        
        .form-group button {
            padding: 20px 25px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s ease;
        }
        
        .form-group button:hover {
            background: #0056b3;
        }
        
        .search-bar {
            margin-bottom: 25px; 
            display: flex;
        }
        
        .search-bar input {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
        }
        
        .data-list {
            display: grid;
            gap: 15px;
        }
        
        .data-item {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #007bff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }
        
        .data-item strong {
            color: #007bff;
            margin-right: 8px;
        }
        
      
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Form Container -->
        <div class="container form-container">
            <h2 style="text-align: center; margin-bottom: 25px;">Contact Form</h2>
            <form id="contactForm" method="POST" action="store.php" >

                <?php if (isset($_GET['errorPhone'])): ?>
                    <div style="color: red; margin-bottom: 15px;">Invalid phone number</div>
                    <?php endif; ?>
                <?php if (isset($_GET['errorEmail'])): ?>
                    <div style="color: red; margin-bottom: 15px;">Invalid email address</div>
                    <?php endif; ?>
                <?php if (isset($_GET['success'])): ?>
                    <div style="color: green; margin-bottom: 15px;">Data submitted successfully</div>
                    <?php endif; ?> 
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" id="phone" name="phone" required>
                </div>

                <div class="form-group">
                    <button type="submit">Submit</button>
                </div>
            </form>
        </div>

        <!-- Data Container -->
        <div class="container data-container">
            <h2 style="text-align: center; margin-bottom: 25px;">Submitted Data</h2>
            <form action="index.php" method="POST">
                <div class="search-bar" >
                    <input type="text" id="searchInput" placeholder="Search by name" name="search" value="<?php echo htmlspecialchars($search); ?>">
                    <div class="form-group" style=""><button type="submit"  >Search</button></div>
                </div>
            </form>
            <div class="data-list" id="dataList">
                <?php if (!empty($jsonData)): ?>
                    <?php foreach ($jsonData as $data): ?>
                        <div class="data-item">
                            <strong>Name:</strong> <?php echo htmlspecialchars($data['name']); ?><br>
                            <strong>Email:</strong> <?php echo htmlspecialchars($data['email']); ?><br>
                            <strong>Phone:</strong> <?php echo htmlspecialchars($data['phone']); ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="color: red;">No results found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

</body>
</html>
