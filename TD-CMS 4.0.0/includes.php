<?php

include BASE_DIR . "/functions.php";

if (file_exists(TEMP_DIR . "/functions.php")) {
  require TEMP_DIR . "/functions.php";
}


// include the template
if (file_exists(TEMP_DIR . "/index.php") AND file_exists(TEMP_DIR . "/styles.css")) {
  require TEMP_DIR . "/index.php";
}
else {
  echo "please create a template<br><br>";
  echo "the minimum required files are \"styles.css\" and \"index.php\" in the template directory<br>";
  echo "We also recommend to create a header.php, a footer.php and a content.php<br><br>";
  
  // This piece of code is used to troubleshoot the required files (index.php and styles.css)
  if (file_exists(TEMP_DIR . "/index.php")) {
    echo "index.php is found<br><br>";
  }
  else {
    echo "index.php is not found<br><br>";
  }

  if (file_exists(TEMP_DIR . "/styles.css")) {
    echo "styles.css is found<br><br>";
  }
  else {
    echo "styles.css is not found<br><br>";
  }
}