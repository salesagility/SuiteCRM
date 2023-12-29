<?php
namespace Consolidation\TestUtils;

class TestDataPermuter
{
  /**
   * Given an array of test data, where each element is
   * data to pass to a unit test AND each unit test requires
   * only scalar or object test value, find each array
   * in each test, and build all of the permutations for all
   * of the data provided in arrays.
   */
  public static function expandProviderDataArrays($tests)
  {
    $result = [];

    foreach($tests as $test) {
      $subsitutionIndex = 1;
      $permutationData = [];
      $replacements = [];

      foreach($test as $testValue) {
        if (is_array($testValue)) {
          $key = "{SUB$subsitutionIndex}";
          $replacements[$key] = $testValue;
          $permutationData[] = $key;
        }
        else {
          $permutationData[] = $testValue;
        }
      }

      $permuted = static::expandDataMatrix([$permutationData], $replacements);
      $result = array_merge($result, $permuted);
    }

    return $result;
  }

  /**
   * Given an array of test data, where each element is
   * data to pass to a unit test, expand all of the
   * permutations of $replacements, where each key
   * holds the placeholder value, and the value holds
   * an array of replacement values.
   */
  public static function expandDataMatrix($tests, $replacements)
  {
    foreach($replacements as $substitute => $values) {
      $tests = static::expandOneValue($tests, $substitute, $values);
    }
    return $tests;
  }

  /**
   * Given an array of test data, where each element is
   * data to pass to a unit test, find any element in any
   * one test item whose value is exactly $substitute.
   * Make a new test item for every item in $values, using
   * each as the substitution for $substitute.
   */
  public static function expandOneValue($tests, $substitute, $values)
  {
    $result = [];

    foreach($tests as $test) {
      $position = array_search($substitute, $test);
      if ($position === FALSE) {
        $result[] = $test;
      }
      else {
        foreach($values as $replacement) {
          $test[$position] = $replacement;
          $result[] = $test;
        }
      }
    }

    return $result;
  }
}
