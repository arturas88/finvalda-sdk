<?php

declare(strict_types=1);

namespace Finvalda\Enums;

enum ItemClass: string
{
    // Products & Services
    case Product = 'Fvs.Preke';
    case Service = 'Fvs.Paslauga';

    // Clients & Addresses
    case Client = 'Fvs.Klientas';
    case Address = 'Fvs.Adresas';

    // Objects (6 levels)
    case Object1 = 'Fvs.ObjektasI';
    case Object2 = 'Fvs.ObjektasII';
    case Object3 = 'Fvs.ObjektasIII';
    case Object4 = 'Fvs.ObjektasIV';
    case Object5 = 'Fvs.ObjektasV';
    case Object6 = 'Fvs.ObjektasVI';

    // Reference data
    case Bank = 'Fvs.Bankas';
    case ClientType = 'Fvs.KlientoRusis';
    case ClientTag1 = 'Fvs.KlientoIPoz';
    case ClientTag2 = 'Fvs.KlientoIIPoz';
    case ClientTag3 = 'Fvs.KlientoIIIPoz';
    case PaymentTerm = 'Fvs.AtsTerminas';
    case Warehouse = 'Fvs.Sandelis';
    case ProductType = 'Fvs.PrekesRusis';

    // Product tags (1-20)
    case ProductTag1 = 'Fvs.PrekesPoz1';
    case ProductTag2 = 'Fvs.PrekesPoz2';
    case ProductTag3 = 'Fvs.PrekesPoz3';
    case ProductTag4 = 'Fvs.PrekesPoz4';
    case ProductTag5 = 'Fvs.PrekesPoz5';
    case ProductTag6 = 'Fvs.PrekesPoz6';
    case ProductTag7 = 'Fvs.PrekesPoz7';
    case ProductTag8 = 'Fvs.PrekesPoz8';
    case ProductTag9 = 'Fvs.PrekesPoz9';
    case ProductTag10 = 'Fvs.PrekesPoz10';
    case ProductTag11 = 'Fvs.PrekesPoz11';
    case ProductTag12 = 'Fvs.PrekesPoz12';
    case ProductTag13 = 'Fvs.PrekesPoz13';
    case ProductTag14 = 'Fvs.PrekesPoz14';
    case ProductTag15 = 'Fvs.PrekesPoz15';
    case ProductTag16 = 'Fvs.PrekesPoz16';
    case ProductTag17 = 'Fvs.PrekesPoz17';
    case ProductTag18 = 'Fvs.PrekesPoz18';
    case ProductTag19 = 'Fvs.PrekesPoz19';
    case ProductTag20 = 'Fvs.PrekesPoz20';

    /**
     * Get the ProductTag case for a given tag number (1-20).
     */
    public static function productTag(int $number): self
    {
        return self::from("Fvs.PrekesPoz{$number}");
    }
}
