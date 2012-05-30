<?php
/**
 * This class helps to integrate PHPUnit to TeamCity.
 * For each important function it prints special message which could be
 * parsed and handled by TeamCity
 *
 * @author sery0ga
 * 
 * Realweb 2012
 */
class TeamCityListener implements PHPUnit_Framework_TestListener {

    /**
     * Print message on error
     *
     * @attention TeamCity doesn't support errors so we handle them as failures
     * @param PHPUnit_Framework_Test $test
     * @param Exception $e
     * @param integer $time
     */
    public function addError(PHPUnit_Framework_Test $test, Exception $e, $time) {
        echo $e->getMessage();
        printf(
            "##teamcity[testFailed name='%s' details='See full log for details']\n",
            $test->getName()
        );
    }

    /**
     * Print message on failure
     *
     * @param PHPUnit_Framework_Test $test
     * @param PHPUnit_Framework_AssertionFailedError $e
     * @param integer $time
     */
    public function addFailure(
        PHPUnit_Framework_Test $test,
        PHPUnit_Framework_AssertionFailedError $e,
        $time
    ) {
        echo $e->getMessage();
        printf(
            "##teamcity[testFailed name='%s' details='See full log for details']\n",
            $test->getName()
        );
    }

    /**
     * Print message on incomplete test
     *
     * @attention TeamCity doesn't support incomplete tests so we handle them as skipped
     * @param PHPUnit_Framework_Test $test
     * @param Exception $e
     * @param integer $time
     */
    public function addIncompleteTest(
        PHPUnit_Framework_Test $test,
        Exception $e,
        $time
    ) {
        printf(
            "##teamcity[testIgnored name='%s' message='%s']\n",
            $test->getName(),
            str_replace("\n", "|n|r ", $e->getMessage())
        );
    }

    /**
     * Print message on skipped test
     *
     * @param PHPUnit_Framework_Test $test
     * @param Exception $e
     * @param integer $time
     */
    public function addSkippedTest(
        PHPUnit_Framework_Test $test,
        Exception $e,
        $time
    ) {
        printf(
            "##teamcity[testIgnored name='%s' message='%s']\n",
            $test->getName(),
            str_replace("\n", "|n|r ", $e->getMessage())
        );
    }

    /**
     * Print message when test starts
     *
     * @param PHPUnit_Framework_Test $test
     */
    public function startTest(PHPUnit_Framework_Test $test) {
        printf(
            "##teamcity[testStarted name='%s' captureStandardOutput='true']\n",
            $test->getName()
        );
    }

    /**
    * Print message when test ends
    *
    * @param PHPUnit_Framework_Test $test
    * @param integer $time
    */
    public function endTest(PHPUnit_Framework_Test $test, $time) {
        printf(
            "##teamcity[testFinished name='%s' duration='%s']\n",
            $test->getName(),
            $time*1000
        );
    }

    /**
     * Print message when test suite starts
     *
     * @param PHPUnit_Framework_TestSuite $suite
     */
    public function startTestSuite(PHPUnit_Framework_TestSuite $suite) {
        printf("##teamcity[testSuiteStarted name='%s']\n", $suite->getName());
    }

    /**
     * Print message when test suite ends
     *
     * @param PHPUnit_Framework_TestSuite $suite
     */
    public function endTestSuite(PHPUnit_Framework_TestSuite $suite) {
        printf("##teamcity[testSuiteFinished name='%s']\n", $suite->getName());
    }
}
