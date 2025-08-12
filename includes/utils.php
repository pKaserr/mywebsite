<?php
/**
 * Generate a random alphanumeric string of given length.
 * This function can be used in other files by including this file or moving it to a shared utility file.
 *
 * @param int $length Length of the generated string
 * @return string Random alphanumeric string
 */
function randomHash($length)
{
   $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
   $pass = array();
   $alphaLength = strlen($alphabet) - 1;
   for ($i = 0; $i < $length; $i++) {
      $n = rand(0, $alphaLength);
      $pass[] = $alphabet[$n];
   }
   return implode($pass);
}
?>
