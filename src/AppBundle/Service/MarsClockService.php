<?php
namespace AppBundle\Service;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class MarsClockService

{

    public function getMSD(String $utcTime)
    {
        if($this->checkIsAValidDate($utcTime)){
        $utcToMillis = strtotime($utcTime) * 1000;
        $twentyFourHoursToMillis = 86400000;
        $twentyFourHoursToSecs = 86400;
        $daysSinceUnixEpoch = ($utcToMillis / $twentyFourHoursToMillis);
        $JDUT = 2440587.5 + $daysSinceUnixEpoch;
        $TTminusUTC = 33.0 + 32.184;
        $JDTT = $JDUT + ($TTminusUTC / $twentyFourHoursToSecs);
        $delataT2000 = $JDTT - 2451545.0;
        $martianDaytoEartDayRatio = 1.027491252;
        $midDayAdjustmentforPositiveMSD = 44796.0;
        $midNightsAdjustmentDifference = 0.00096;
        $deltaAdjustment = 4.5;

        $MSD = ((($delataT2000 - $deltaAdjustment) / $martianDaytoEartDayRatio) + $midDayAdjustmentforPositiveMSD - $midNightsAdjustmentDifference);

        return $MSD;
        }
        else{
            throw new BadRequestHttpException("Given Input Date/Time is not valid");
        }
    }
    
    public function checkIsAValidDate($myDateString)
    {
        return (bool) strtotime($myDateString);
    }

    public function getMTC($MSD)
    {
        $mtc_24hrs = 24.0 * $MSD;
        $mtc = fmod($mtc_24hrs, 24.0);
        $mtcSeconds = $mtc * 3600;
        $hours = floor($mtcSeconds / 3600);
        $mins = floor($mtcSeconds / 60 % 60);
        $secs = floor($mtcSeconds % 60);
        $timeFormat = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
        return $timeFormat;
    }
}

?>