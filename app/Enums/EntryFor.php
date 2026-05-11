<?php

namespace App\Enums;

enum EntryFor: int
{
    case Customer = 1;
    case Channel = 2;
    case GreatDealOffer = 3;
    case EliteOffer = 4;
    case UltraSaverOffer = 5;
    case PrimeOffer = 6;
    case MegaOffer = 7;
    case PremiumOffer = 8;
    case StarOffer = 9;
    case BigOffer = 10;
    case SelfApply = 11;
    case LoanAgent = 12;

    public function label(): string
    {
        return match($this) {
            self::Customer => 'Customer',
            self::Channel => 'Channel',
            self::GreatDealOffer => 'Great Deal Offer',
            self::EliteOffer => 'Elite Offer',
            self::UltraSaverOffer => 'Ultra Saver Offer',
            self::PrimeOffer => 'Prime Offer',
            self::MegaOffer => 'Mega Offer',
            self::PremiumOffer => 'Premium Offer',
            self::StarOffer => 'Star Offer',
            self::BigOffer => 'Big Offer',
            self::SelfApply => 'SelfApply',
            self::LoanAgent => 'LoanAgent',
        };
    }
}
