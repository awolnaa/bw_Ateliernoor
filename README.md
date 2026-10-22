# bw_ateliernoor — Atelier Noor

Nederlandstalige woon- en decoratiewinkel, ontworpen en gebouwd door Monday Makers. Visueel geïnspireerd op Learts Decor Thriving, met een eigen Gutenberg-theme en oorspronkelijke teksten, fotografie en typografie. Geen code, logo’s of foto’s uit het commerciële voorbeeld overgenomen.

- Lokaal: http://localhost:10168/
- Live demo: https://ateliernoor.mondaymakers.be/
- Private repository: https://github.com/awolnaa/bw_ateliernoor
- Referentie: https://learts.thememove.com/decor-thriving/?learts-02

## Beheer

Producten, prijzen, varianten, voorraad, winkelmand, klanten en bestellingen: WooCommerce. Aanvullende productvelden voor materiaal en verzorging: ACF Pro. Sfeerfoto’s, titels en productkoppelingen van de homepage: Winkelinhoud (ACF). Inspiratie is een eigen inhoudstype met Gutenberg, uitgelichte foto en samenvatting. Algemene pagina’s zijn echte Gutenberg-inhoud. Winkelvragen worden privé opgeslagen en geven via de bestaande mailmodule een beheermelding aan info@mondaymakers.be.

De eigen code staat in `app/public/wp-content/themes/bw-ateliernoor`, `app/public/wp-content/plugins/bw-ateliernoor-manager` en de gedeelde, expliciet opgenomen mu-plugins. WooCommerce en Mollie zijn de twee extra functionele vendorplugins. ACF Pro en WP Mail SMTP worden gebruikt zoals in de andere projecten. Geen pagebuilder, vergelijkingsmodule, externe feed of wishlistplugin.

## Demo en betalingen

Mollie blijft verplicht in Test API-modus. De live API-sleutel wordt door de eigen managerplugin genegeerd en andere gateways worden niet aangeboden. Testbestellingen leiden nooit tot echte levering. De testsleutel wordt uitsluitend in de WordPress-database bewaard; niet in broncode, exports of Git. Webhook-afhandeling moet op een bereikbaar HTTPS-domein getest worden. Zonder testsleutel zijn betalingen niet operationeel; winkelmand en checkout blijven inspecteerbaar. De opdrachtgever vult de sleutel zelf in.

BE / EUR, prijzen inclusief 21% voorbeeld-btw, verzending €5,95, gratis vanaf €75, afhalen als demo-optie. Deze instellingen zijn voorbeelden, geen goedgekeurde commerciële of fiscale voorwaarden voor een echte winkel. Geen externe ordermails aan fictieve klanten: klant-orderbevestigingen zijn uitgeschakeld. De beheerder ontvangt nieuwe-order-meldingen.

## Design

Rustige aardetinten, lokaal geladen Hind en Zilla Slab, eigen typografisch logo, handmatig bediende hero-slides met productkaart, beeldzoom, scrollreveal en subtiele knop- en linktransities. Geen kanteling. `prefers-reduced-motion` schakelt beweging uit; inhoud blijft zichtbaar zonder JavaScript. Logo’s linken naar de homepage. Powered by is klein en rechts uitgelijnd op desktop en gecentreerd op mobiel, met link naar https://mondaymakers.be/.

## Verificatie en reproductie

`tools/seed.php` initialiseert uitsluitend de nieuwe lokale demo, bewaart oude klooninhoud herstelbaar in de prullenbak en heeft een eenmalige guard. Geen resettool voor een gevulde klantwinkel. Producten zijn echte WooCommerce-objecten. `tests/audit.php` verifieert ACF, varianten, voorraad, verzendregels en testbeveiliging. Browsercontrole van varianten, toevoegen aan winkelmand, verzendkosten en checkout. Contactformulier getest met herkenbare testgegevens, inclusief private opslag, SMTP-aanname en nonce-afwijzing. Ontvangst in de mailbox is niet onafhankelijk bewezen. Mollie-testbetaling blijft afhankelijk van de testsleutel.

Core, vendorplugins, wp-config, databases, logbestanden, klantgegevens en geheimen zijn uitgesloten van Git. Zie BEHEER.md, BETALINGEN.md en ASSETS.md.

## Actuele uitrolstatus

De demo staat live met HTTPS en centrale demo-afscherming en is opgenomen bij Winkels en retail. De testsleutel is gekoppeld en geldig. Het Mollie-profiel retourneert nog geen betaalmethodes; een echte testbetaling en webhook blijven daardoor onbevestigd. Zie DEPLOYMENT.md.
