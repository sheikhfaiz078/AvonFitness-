<?php
/**
 * =============================================================================
 *  AVON FITNESS MAHARASHTRA — SITE CONFIGURATION
 * =============================================================================
 *  This is the ONLY file you need to edit to change contact details, the
 *  enquiry recipient, the WhatsApp number or the social profiles.
 *
 *  After editing, save the file and re-upload it to:
 *      public_html/config/site.php
 *
 *  Nothing else on the site hard-codes these values.
 * =============================================================================
 */

return [

    /* ---------------------------------------------------------------------
     |  BRAND
     * ------------------------------------------------------------------- */
    'SITE_NAME'        => 'Avon Fitness Maharashtra',
    'SITE_SHORT'       => 'Avon Fitness',
    'SITE_URL'         => 'https://avonfitnessmaharashtra.in',
    'SITE_TAGLINE'     => 'Commercial & Home Gym Equipment — Supplied and Installed Across Maharashtra',

    /* ---------------------------------------------------------------------
     |  WHERE ENQUIRIES ARE SENT
     |  CONTACT_EMAIL     -> the inbox that receives every website enquiry
     |  EMAIL_FROM        -> must be an address ON THIS DOMAIN or Hostinger
     |                       will reject the mail (do NOT use gmail here)
     * ------------------------------------------------------------------- */
    'CONTACT_EMAIL'    => 'sales@pranadaequip.com',
    'CONTACT_EMAIL_CC' => '',                                   // optional second inbox
    'EMAIL_FROM'       => 'website@avonfitnessmaharashtra.in',
    'EMAIL_FROM_NAME'  => 'Avon Fitness Maharashtra Website',

    /* ---------------------------------------------------------------------
     |  PHONE / WHATSAPP
     |  CONTACT_PHONE      -> shown to visitors
     |  CONTACT_PHONE_RAW  -> used in tel: links (no spaces)
     |  WHATSAPP_NUMBER    -> digits only, with country code, no + or spaces
     * ------------------------------------------------------------------- */
    'CONTACT_PHONE'     => '+91 77189 22901',
    'CONTACT_PHONE_RAW' => '+917718922901',
    'WHATSAPP_NUMBER'   => '917718922901',

    /* ---------------------------------------------------------------------
     |  ADDRESS
     |  This is the Avon Fitness Machines Pvt. Ltd. registered manufacturing
     |  address, published on the manufacturer's own website. If you open a
     |  Maharashtra office/showroom, add it here.
     * ------------------------------------------------------------------- */
    'ADDRESS_LINE1'   => 'Avon Fitness Machines Pvt. Ltd.',
    'ADDRESS_LINE2'   => 'B-XXIX-476/9, Giaspura',
    'ADDRESS_CITY'    => 'Ludhiana',
    'ADDRESS_STATE'   => 'Punjab',
    'ADDRESS_PIN'     => '141003',
    'ADDRESS_COUNTRY' => 'India',
    'SERVICE_AREA'    => 'Maharashtra (Mumbai, Thane, Navi Mumbai, Pune, Nashik, Nagpur and across the state) with pan-India project supply',

    /* Manufacturer support desks (published by Avon Fitness Machines) */
    'FACTORY_ENQUIRY_PHONE' => '+91 87250 94200',
    'FACTORY_ENQUIRY_EMAIL' => 'enquiry@avonfitnessmachines.com',
    'FACTORY_SERVICE_EMAIL' => 'service@avonfitnessmachines.com',

    /* ---------------------------------------------------------------------
     |  BUSINESS HOURS
     * ------------------------------------------------------------------- */
    'HOURS_WEEKDAY' => '10:00 – 19:00',
    'HOURS_SATURDAY' => '10:00 – 18:00',
    'HOURS_SUNDAY'  => 'Closed',

    /* ---------------------------------------------------------------------
     |  SOCIAL PROFILES
     |  Leave a value EMPTY and the icon disappears from the footer.
     |  Only add a URL once you have confirmed the profile is official.
     * ------------------------------------------------------------------- */
    'SOCIAL_FACEBOOK'  => 'https://www.facebook.com/AvonFitnessMaharashtra',
    'SOCIAL_INSTAGRAM' => 'https://www.instagram.com/avonfitnessmaharashtra/',
    'SOCIAL_YOUTUBE'   => '',
    'SOCIAL_LINKEDIN'  => '',

    /* ---------------------------------------------------------------------
     |  ENQUIRY FORM BEHAVIOUR
     * ------------------------------------------------------------------- */
    'RATE_LIMIT_SECONDS' => 45,     // minimum gap between submissions per visitor
    'MIN_FILL_SECONDS'   => 3,      // a genuine human takes longer than this
    'LOG_ENQUIRIES'      => true,   // also write to api/enquiries.log as a backup
];
