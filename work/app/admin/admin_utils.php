<?php

namespace MyApp;

require_once(__DIR__ . '/../../app/config.php');

class AdminUtils
{
  public static function sexDbToValue($dbSex)
  {
    $valueSex = "";
    switch($dbSex)
    {
      case ADMIN_SEX_MALE_DB:
        $valueSex = ADMIN_SEX_MALE_VALUE;
        break;

      case ADMIN_SEX_FEMALE_DB:
        $valueSex = ADMIN_SEX_FEMALE_VALUE;
        break;

      default:
        break;
    }

    return $valueSex;
  }

  public static function sexValueToDb($valueSex)
  {
    $dbSex = ADMIN_SEX_MALE_VALUE;
    switch($valueSex)
    {
      case ADMIN_SEX_MALE_VALUE:
        $dbSex = ADMIN_SEX_MALE_DB;
        break;

      case ADMIN_SEX_FEMALE_VALUE:
        $dbSex = ADMIN_SEX_FEMALE_DB;
        break;
      
      default:
        break;
    }

    return $dbSex;
  }

  public static function sexValueToName($valueSex)
  {
    $nameSex = "";
    switch($valueSex)
    {
      case ADMIN_SEX_MALE_VALUE:
        $nameSex = ADMIN_SEX_MALE_NAME;
        break;
      
      case ADMIN_SEX_FEMALE_VALUE:
        $nameSex = ADMIN_SEX_FEMALE_NAME;
        break;

      default:
        break;
    }

    return $nameSex;
  }

  public static function sexDbToName($dbSex)
  {
    $nameSex = "";
    switch($dbSex)
    {
      case ADMIN_SEX_MALE_DB:
        $nameSex = ADMIN_SEX_MALE_NAME;
        break;

      case ADMIN_SEX_FEMALE_DB:
        $nameSex = ADMIN_SEX_FEMALE_NAME;
        break;

      default:
        break;
    }

    return $nameSex;
  }

  public static function isSexValueMale($valueSex)
  {
    $bRet = false;

    if(0 === strcmp(ADMIN_SEX_MALE_VALUE, $valueSex))
    {
      $bRet = true;
    }

    return $bRet;
  }

  public static function isSexValueFemale($valueSex)
  {
    $bRet = false;

    if(0 === strcmp(ADMIN_SEX_FEMALE_VALUE, $valueSex))
    {
      $bRet = true;
    }

    return $bRet;
  }

  public static function isSexDbMale($dbSex)
  {
    $bRet = false;

    if(ADMIN_SEX_MALE_DB === $dbSex)
    {
      $bRet = true;
    }

    return $bRet;
  }

  public static function isSexDbFemale($dbSex)
  {
    $bRet = false;

    if(ADMIN_SEX_FEMALE_DB === $dbSex)
    {
      $bRet = true;
    }

    return $bRet;
  }

  public static function officerDbToValue($dbOfficer)
  {
    $valueOfficer = "";
    switch($dbOfficer)
    {
      case ADMIN_OFFICER_MANAGER_DB:
        $valueOfficer = ADMIN_OFFICER_MANAGER_VALUE;
        break;

      case ADMIN_OFFICER_STAFF_DB:
        $valueOfficer = ADMIN_OFFICER_STAFF_VALUE;
        break;

      case ADMIN_OFFICER_DOCTOR_DB:
        $valueOfficer = ADMIN_OFFICER_DOCTOR_VALUE;
        break;

      default:
        break;
    }

    return $valueOfficer;
  }

  public static function officerValueToDb($valueOfficer)
  {
    $dbOfficer = ADMIN_OFFICER_MANAGER_DB;
    switch($valueOfficer)
    {
      case ADMIN_OFFICER_MANAGER_VALUE:
        $dbOfficer = ADMIN_OFFICER_MANAGER_DB;
        break;

      case ADMIN_OFFICER_STAFF_VALUE:
        $dbOfficer = ADMIN_OFFICER_STAFF_DB;
        break;

      case ADMIN_OFFICER_DOCTOR_VALUE:
        $dbOfficer = ADMIN_OFFICER_DOCTOR_DB;
        break;

      default:
        break;
    }

    return $dbOfficer;
  }

  public static function officerValueToName($valueOfficer)
  {
    $nameOfficer = "";
    switch($valueOfficer)
    {
      case ADMIN_OFFICER_MANAGER_VALUE:
        $nameOfficer = ADMIN_OFFICER_MANAGER_NAME;
        break;

      case ADMIN_OFFICER_STAFF_VALUE:
        $nameOfficer = ADMIN_OFFICER_STAFF_NAME;
        break;

      case ADMIN_OFFICER_DOCTOR_VALUE:
        $nameOfficer = ADMIN_OFFICER_DOCTOR_NAME;
        break;

      default:
        break;
    }

    return $nameOfficer;
  }

  public static function officerDbToName($dbOfficer)
  {
    $nameOfficer = "";
    switch($dbOfficer)
    {
      case ADMIN_OFFICER_MANAGER_DB:
        $nameOfficer = ADMIN_OFFICER_MANAGER_NAME;
        break;

      case ADMIN_OFFICER_STAFF_DB:
        $nameOfficer = ADMIN_OFFICER_STAFF_NAME;
        break;

      case ADMIN_OFFICER_DOCTOR_DB:
        $nameOfficer = ADMIN_OFFICER_DOCTOR_NAME;
        break;

      default:
        break;
    }

    return $nameOfficer;
  }

  public static function isOfficerValueManager($valueOfficer)
  {
    $bRet = false;

    if(0 === strcmp(ADMIN_OFFICER_MANAGER_VALUE, $valueOfficer))
    {
      $bRet = true;
    }

    return $bRet;
  }

  public static function isOfficerValueStaff($valueOfficer)
  {
    $bRet = false;

    if(0 === strcmp(ADMIN_OFFICER_STAFF_VALUE, $valueOfficer))
    {
      $bRet = true;
    }

    return $bRet;
  }

  public static function isOfficerValueDoctor($valueOfficer)
  {
    $bRet = false;

    if(0 === strcmp(ADMIN_OFFICER_DOCTOR_VALUE, $valueOfficer))
    {
      $bRet = true;
    }
    
    return $bRet;
  }

  public static function isOfficerDbManager($dbOfficer)
  {
    $bRet = false;

    if(ADMIN_OFFICER_MANAGER_DB === $dbOfficer)
    {
      $bRet = true;
    }

    return $bRet;
  }

  public static function isOfficerDbStaff($dbOfficer)
  {
    $bRet = false;

    if(ADMIN_OFFICER_STAFF_DB === $dbOfficer)
    {
      $bRet = true;
    }

    return $bRet;
  }

  public static function isOfficerDbDoctor($dbOfficer)
  {
    $bRet = false;

    if(ADMIN_OFFICER_DOCTOR_DB === $dbOfficer)
    {
      $bRet = true;
    }

    return $bRet;
  }
}

?>