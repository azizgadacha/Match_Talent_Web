<?php

namespace App\Service;
use Endroid\QrCode\Builder\BuilderInterface;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Label\Font\NotoSans;

class QR_code_generator_api
{
    /**
     * @var BuilderInterface
     */
    protected $builder;
    public function __construct(BuilderInterface $builder)
    {$this->builder=$builder;
    }


    public function qrcode($query)
    {
        $path = dirname(__DIR__, 2).'/public/assets/';

        $result=$this->builder
            ->data($query)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
            ->size(800)
            ->margin(10)
            ->labelText("Montrer votre qr code au prochain rendez vous")
            ->labelAlignment(new LabelAlignmentCenter())
            ->logoPath($path.'img/logo.png')
            ->logoResizeToWidth('100')
            ->logoResizeToHeight('100')
            ->build();
        $namePng = uniqid('', '') . '.png';
        $result->saveToFile($path.'qr-code/'.$namePng);
        return ($namePng);
    }

}