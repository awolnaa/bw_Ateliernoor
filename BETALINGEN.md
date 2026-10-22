# Mollie-tests

De officiële plugin Mollie Payments for WooCommerce is actief. Bancontact, iDEAL en kaart zijn voorbereid. Vul zelf de Test API key in onder WooCommerce → Instellingen → Mollie Settings en sla op. Laat Live API key leeg.

De eigen demoguard forceert testmodus, negeert een live-sleutel en verwijdert niet-Mollie-gateways. De testsite moet voor Mollies servermeldingen bereikbaar zijn via HTTPS. De normale democookie mag webhooks niet blokkeren; controleer het volledige traject op productie. Alleen een terugkeer naar de bedankpagina bewijst de webhook niet.

Controleer na koppelen: betaald, geannuleerd, mislukt, herhaalde webhook (geen dubbele order/voorraadafname), orderstatus, e-mailwaarschuwing en gereserveerde voorraad. Voor bepaalde methodes verschillen testmogelijkheden van live; er worden in deze opdracht geen echte betalingen uitgevoerd.

Zonder geldige testsleutel wordt geen betaalmethode aangeboden. Er is geen verzonnen gateway die een echte betaling suggereert.
