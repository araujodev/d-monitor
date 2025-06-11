<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class MeasurementTypeEnum extends Enum
{
    const EmJejum = 0;
    const PosCafe = 1;
    const PreAlmoco = 2;
    const PosAlmoco = 3;

    const PosLancheDaTarde = 4;

    const PreJantar = 5;
    const PosJantar = 6;

    public static function getMappedLabels(): array
    {
        return [
            self::EmJejum => self::getDescription(self::EmJejum),
            self::PosCafe => self::getDescription(self::PosCafe),
            self::PreAlmoco => self::getDescription(self::PreAlmoco),
            self::PosAlmoco => self::getDescription(self::PosAlmoco),
            self::PosLancheDaTarde => self::getDescription(self::PosLancheDaTarde),
            self::PreJantar => self::getDescription(self::PreJantar),
            self::PosJantar => self::getDescription(self::PosJantar),
        ];
    }


}
