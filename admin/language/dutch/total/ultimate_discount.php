<?php
// Version! DO NOT CHANGE!
$_['_version'] = "125";

/**
 * Ultimate Discount extension for Opencart.
 *
 * @author Anthony Lawrence <freelancer@anthonylawrence.me.uk>
 * @version 1.0
 * @copyright © Anthony Lawrence 2011
 * @license Creative Common's ShareAlike License - http://creativecommons.org/licenses/by-sa/3.0/
 */

// Heading
$_['heading_title']    = 'Algehele korting';

// Tabs
$_['tab_general']      = 'Algameen';
$_['tab_store']      = 'Bewaar breed';
$_['tab_category']      = 'Categorie gebaseerd';
$_['tab_multi']      = 'Multibuy';

// Text
$_['text_total']       = 'Order totalen';
$_['text_success']     = 'Gelukt: u heeft uw Algehele korting veranderd!';

// Entry
$_['entry_category']   = 'Categorie:';
$_['entry_customer']   = 'Klant groep:';
$_['entry_total']      = 'Minimum totale bestelling:<span class="help">Het minimum orderbedrag voor de korting is bereikt.</span>';
$_['entry_amount']     = 'Totale korting:';
$_['entry_type']       = 'Kortings vorm:';
$_['entry_rule']       = 'Regeren:';
$_['entry_rule_amount'] = 'Regeren bedrag:';
$_['entry_rules_once'] = 'Een keer na:';
$_['entry_rules_every'] = 'Iedere:';
$_['entry_date_start'] = 'Start datum:<span class="help">De datum waarop de korting zal worden toegepast.</span>';
$_['entry_date_end']   = 'Eind datum:<span class="help">De datum wanneer de korting NIET MEER wordt toegepast.</span>';
$_['entry_status']     = 'Status:';
$_['entry_sort_order'] = 'Sorteervolgorder:';
$_['entry_multi_override'] = 'Overschrijven Multi-Buy Kortingen:';

// Descriptions
$_['description_store'] = "If you wish to have graded discounts, for example:<br />
                    <ul>
                        <li>Spend over £500, get 10% off.</li>
                        <li>Spend over £300, get 5% off.</li>
                        <li>Spend over £100, get 3% off.</li>
                    </ul>
                    List all discount bands below with the same date range and the system will automatically choose the highest discount amount at the checkout screen.";
$_['description_category'] = '<strong>If a produce is listed in more than one category, it may receive double discount if you list all categories here! For example, if a camera is listed in
                            "mobile devices" and "cameras", and both have a &pound;10 saving, the camera will attract a &pound;20 discount!</strong>  Choose your categories carefully.';
$_['description_multi'] = 'Any rules listed here will be applied regardless of any other discounts that have been set.';
$_['description_multi_override'] = 'Indien ingesteld in staat te stellen, de eerste mogelijke korting voor een multi-buy discount <strong> per-categorie </ strong> wordt toegepast en anderen zullen worden genegeerd.';

// Error
$_['error_permission'] = 'Waarschuwing: u heeft geen toestemming om veranderingen aan te brengen aan de Algehele kortingen!';
?>