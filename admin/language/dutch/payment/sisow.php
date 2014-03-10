<?php
$_['heading_title_sisowideal']		= 'Sisow iDEAL';
$_['heading_title_sisowmc']			= 'Sisow MisterCash';
$_['heading_title_sisowde']			= 'Sisow SofortBanking';
$_['heading_title_sisowecare']		= 'Sisow ecare'; // <img src="view/image/payment/sisowecare.png" height="25" alt="Sisow ecare" />';
$_['heading_title_sisowovb']		= 'Sisow OverBoeking';
$_['heading_title_sisowwg']			= 'Sisow Webshop Giftcard';
$_['heading_title_sisowfijn']		= 'Sisow Fijncadeau';
$_['heading_title_sisowpp'] 		= 'Sisow PayPal';
$_['heading_title_sisowmob']		= 'Sisow Mobile';

// Text 
$_['text_payment']			= 'Betaalmethode';
$_['text_success']			= 'Gelukt: De instellingen zijn gewijzigd';
$_['text_all_zones']		= 'Alle Zones';
$_['text_sisow']			= '<a onclick="window.open(\'http://www.sisow.nl\');"><img src="view/image/payment/sisowklein.png" height="40" alt="Sisow" title="Sisow" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_sisowideal']		= $_['text_sisow'];
$_['text_sisowmc']			= $_['text_sisow'];
$_['text_sisowde']			= $_['text_sisow'];
$_['text_sisowecare']		= $_['text_sisow'];
$_['text_sisowovb']			= $_['text_sisow'];
$_['text_sisowwg']			= $_['text_sisow'];
$_['text_sisowfijn']		= $_['text_sisow'];
$_['text_sisowpp']			= $_['text_sisow'];
$_['text_version']			= 'Version 3.2 for Opencart 1.4.x and 1.5.x';

// Entry
$_['entry_merchantid']		= 'Sisow Merchant ID<br/><span class="help">De Sisow Merchant ID kunt u vinden in uw Sisow account in "Mijn Profiel".</span>';
$_['entry_merchantkey']		= 'Sisow Merchant Key<br/><span class="help">De Sisow Merchant Key kunt u vinden in uw Sisow account in "Mijn Profiel".</span>';
$_['entry_success']			= 'Bestelstatus<br/><span class="help">De bestelstatus voor geslaagde betalingen bijv. "Voltooid" (Complete).</span>';
$_['entry_testmode']		= 'Testmode<br/><span class="help">Indien u wilt testen met behulp van de Sisow Simulator kiest u hier "Ja".</span>';
$_['entry_total']			= 'Minimum Orderwaarde <br/><span class="help">Het minimale orderbedrag waarbij de betaalmethode beschikbaar mag komen.</span>';
$_['entry_totalmax']		= 'Maximum Orderwaarde <br/><span class="help">Het maximale orderbedrag waarbij de betaalmethode beschikbaar mag komen.</span>';
$_['entry_geo_zone']		= 'Geo Zone';
$_['entry_status']			= 'Status';
$_['entry_sort_order']		= 'Sorteervolgorde';
$_['entry_version_status']	= 'Module versie';
$_['entry_author']			= 'Auteur';

// Entry Sisow ecare
$_['entry_makeinvoice']		= 'Direct factureren<br/><span class="help">Indien "Ja", dan wordt ook direct de Sisow ecare factuur aangemaakt en gaat de betaaltermijn van 14 dagen in.</span>';
$_['entry_mailinvoice']		= 'Factuur mailen<br/><span class="help">Indien "Ja", wordt de Sisow ecare factuur direct na aanmaak via Sisow verzonden.</span>';
$_['entry_paymentfee']		= 'Payment Fee<br/><span class="help">Positief is het bedrag exclusief BTW, negatief een percentage.</span>';
$_['entry_sisowecarefee_tax'] = 'Belastinggroep Payment Fee<br/><span class="help">BTW van toepassing op Payment Fee.</span>';

// Entry Sisow OverBoeking
$_['entry_businessonly']	= 'Alleen zakelijk<br/><span class="help">OverBoeking alleen beschikbaar maken voor zakelijke klanten.</span>';
$_['entry_days']			= 'Dagen<br/><span class="help">Een herinneringsmail mail sturen, indien nog niet betaald, na het ingestelde aantal dagen.</span>';
$_['entry_paylink']			= 'Inclusief betaallink<br/><span class="help">OverBoeking e-mail naar klant voorzien van iDEAL betaallink.</span>';

// Entry Sisow PayPal
//$_['entry_paymentfee']		= 'Payment Fee<br/><span class="help">Positief is het bedrag exclusief BTW, negatief een percentage.</span>';
$_['entry_sisowppfee_tax'] 	= 'Belastinggroep Payment Fee<br/><span class="help">BTW van toepassing op Payment Fee.</span>';

// Error
$_['error_permission']  	= 'Waarschuwing: U heeft geen rechten om deze instellingen te wijzigen!';
$_['error_merchantid']  	= 'Sisow Merchant ID is verplicht!';
$_['error_merchantkey'] 	= 'Sisow Merchant Key is verplicht!';
?>
