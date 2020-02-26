<?php
namespace AppBundle\Service;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class MarsClockService

{

    public function getMSD(String $utcTime)
    {
        // constants used in the msd calculation
        $twentyFourHoursToMillis = 86400000;
        $twentyFourHoursToSecs = 86400;
        $martianDaytoEartDayRatio = 1.027491252;
        $midDayAdjustmentforPositiveMSD = 44796.0;
        $midNightsAdjustmentDifference = 0.00096;
        $deltaAdjustment = 4.5;
        $TTminusUTC = 33.0 + 32.184;

        // Referred from https://www.giss.nasa.gov/tools/mars24/help/algorithm.html

        if ($this->checkIsAValidDate($utcTime)) {
            $utcToMillis = strtotime($utcTime) * 1000;
            $daysSinceUnixEpoch = ($utcToMillis / $twentyFourHoursToMillis);
            $JDUT = 2440587.5 + $daysSinceUnixEpoch;
            $JDTT = $JDUT + ($TTminusUTC / $twentyFourHoursToSecs);
            $delataT2000 = $JDTT - 2451545.0;
            $MSD = ((($delataT2000 - $deltaAdjustment) / $martianDaytoEartDayRatio) + $midDayAdjustmentforPositiveMSD - $midNightsAdjustmentDifference);
            return $MSD;
        } else {
            throw new BadRequestHttpException("Given Input Date/Time is not valid");
        }
    }

    public function checkIsAValidDate($myDateString)
    {
        return (bool) strtotime($myDateString);
    }

    public function getMTC($MSD)
    {
        $secondsPerHour = 3600;
        $mtc_24hrs = 24.0 * $MSD;
        $mtc = fmod($mtc_24hrs, 24.0);
        $mtcSeconds = $mtc * $secondsPerHour; // convert to seconds
        $hours = floor($mtcSeconds / $secondsPerHour);
        $mins = floor($mtcSeconds / 60 % 60);
        $secs = floor($mtcSeconds % 60);
        $timeFormat = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
        return $timeFormat;
    }
}

?>