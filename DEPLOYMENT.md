# Uitrol — 22 oktober 2026

- Live doel: https://ateliernoor.mondaymakers.be/
- Afzonderlijke WordPress-tabellen met prefix `bw_ateliernoor_`; bestaande sites en klantdata niet overschreven.
- Schone WordPress-core, officiële WooCommerce/Mollie/WP Mail SMTP en bestaande ACF Pro, eigen theme en managerplugin.
- Unieke sterke productie-login staat in het bestaande privébestand `wordpress-toegang-20261021.json`, buiten Git.
- HTTPS publiek gevalideerd; het certificaat bevat 27 hostnamen en automatische vernieuwing is actief.
- Centrale demopoort actief. Anonieme bezoekers gaan naar het formulier bij Monday Makers; normale beheerdersauthenticatie blijft mogelijk.
- Geen lokale aanvragen, orders, klanten, betaal-API-sleutels of sessies in het uitrolpakket. De door de eigenaar ingevoerde Mollie-testsleutel is apart via versleutelde invoer overgenomen. SMTP is apart vanuit de hoofdsite ingesteld.
- Mollie-verbinding accepteert de testsleutel (HTTP 200). Het profiel biedt bij de controle nog nul betaalmethodes aan; daarom is geen volledige betaling of webhook bevestigd. Livebetalingen zijn door de demoguard onmogelijk.
- Retailgalerij lokaal en live uitgebreid met zes screenshots; de bronmanifesten en beide repositories zijn bijgewerkt.

## Controles

24 lokale pagina’s, productdetail, categorie en zoekresultaten: HTTP 200, één pagina-h1, geen zichtbare PHP-fouten, geen defecte afbeeldingen. ACF-winkelinhoud rechtstreeks opgeslagen in de admin. Varianten en toevoegen aan winkelmand in Firefox gecontroleerd. Voorraadstatus, verzending €5,95, gratis vanaf €75 en afhalen geïntegreerd getest. Contactnonce-afwijzing, private opslag en SMTP-aanname gecontroleerd. Mobiel menu en lay-out op 390 px bekeken. De chatbrowser initialiseert sommige klassieke WooCommerce-scripts niet volledig; de normale Firefox-browser doet dit wel.

Live: HTTPS, demopoort, sterke beheerlogin, winkelmand €18,50 + €5,95 = €24,45, checkout en afwijzing van een ongeldige betaalmethode gecontroleerd. De extra h1 in de HTML van een gevulde checkout hoort bij de standaard verborgen WooCommerce-voorwaardenweergave, niet bij een dubbele zichtbare paginatitel.

Nog nodig na activeren van een Mollie-betaalmethode: betaald/mislukt/geannuleerd, webhook en herhaalde webhook, orderstatus, voorraadmutatie en ordermelding. Gebruik uitsluitend testgegevens en Mollie Test API.
