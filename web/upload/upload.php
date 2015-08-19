if (file_exists("img/"; . $_FILES["upload"]["name"]))
{
 echo $_FILES["upload"]["name"] . " already exists please choose another image.";
}
else
{
 move_uploaded_file($_FILES["upload"]["tmp_name"],
 "img/" . $_FILES["upload"]["name"]);
 echo "Stored in: " . "img/" . $_FILES["upload"]["name"];
}