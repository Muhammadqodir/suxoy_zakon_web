<?php
function validateRequest(){
  if(!isset($_POST["phone"])){
    return false;
  }
  return true;
}