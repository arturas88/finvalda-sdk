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
}
