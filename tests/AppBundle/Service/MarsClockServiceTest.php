<?php
namespace Tests\AppBundle\Service;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Service\MarsClockService;

/**
 * Unit Tests for MSD and MTC calculations
 * *
 */
class MarsClockServiceTest extends WebTestCase

{

    public function testGetMSD()
    {
        $marsClockService = new MarsClockService();
        $testUTCDate = "25 Feb 20, 10:31:15 UTC";
        $expectedMSD = 51954.63820912443;
        $resultMSD = $marsClockService->getMSD($testUTCDate);
        $this->assertEquals($expectedMSD, $resultMSD);
    }

    public function testGetMTC()
    {
        $marsClockService = new MarsClockService();
        $testMSD = 51954.63820912443;
        $expectedMTC = "15:19:01";
        $resultMTC = $marsClockService->getMTC($testMSD);
        $this->assertEquals($expectedMTC, $resultMTC);
    }
}

?>