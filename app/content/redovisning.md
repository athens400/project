Redovisning
==============

Kmom01
--------------

Ja, då var man vilse i skogen igen. Eller nja. Till viss del förstår jag ju vad som sker. Men det är en faslig massa spårföljande genom det olika klasserna för att skapa sig en uppfattning om vad som egentligen händer. Det tog ganska lång tid att bara börja förstå ramverket. På sätt och vis är det som sitt eget språk, ett extermt högnivåspråk, men ändå.

Jag är inte bekant med ramverk sedan tidigare. Inte över huvudtaget. Många av begreppen var också helt nya för mig i det här sammanhanget. Routes, dispatcher, MVC. Patterns är väl det jag stött på en del tidigare i så fall.

Jag har svårt att ge någon speciell uppfattning om Anax-MVC eftersom jag inte känner att jag har någon större kollpå begränsningarna och möjligheterna med ramverk i allmänhet och anax i synnerhet ännu. Däremot verkar det spännande. Det är ett, för mig, nytt sätt att skapa webbsidor på. Ju mer jag förstår, desto mer vill jag sätta mig ner och skriva ett eget ramverk från scratch för att verkligen sätta mig in i det. Men det är ett projekt som jag misstänker tar ganska lång tid. 

Jag använder mig Firefox, Xampp, Notepad++, Filezilla på Windows 8.

Kmom02
-------------

Composer kändes bra att jobba med. I den mån jag använde det. Det kändes ju lite "hemligt" i den mening att jag kanske inte riktigt förstod vad som hände, eller snarare hur det hände. 

Hela idéen med packagist och composer är jättebra. Jag hittade inget jag just nu ville prova att använda, hade fullt upp med uppgiften. Men tanken att på ett enkelt sätt kunna inkludera paket med moduler och liknande är extremt bra. Jag har kodat en del (väldigt lite) i java under terminen också och det är en bit på vägen till det inbyggda stöd med kodbibliotek som finns inbyggt i java.

Det tog lite tid att få ihop allt men till slut gick det, nästan, som jag hade tänkt mig. Det var mycket tid som gick åt att bara tänka, rita vägar på papper och känna sig smått korkad. Jag har inte stenkoll på alla möjliga vägar, varför vissa av mina lösningar kändes lite makeshift. Det vill säga, jag fick lösa det på de sätten jag kunde, inte alltid på de sätten jag ville. Men det kommer väl också ju mer jag använder mig av ramverket. Principen förstår jag, hur kommunikationen går till, men det krävdes en del detektivarbete, att försöka följa ett "kodspår" genom klasserna. Svårigheten är ju, åtminstone för mig, att det blir lite svarta lådan över alltihop. Sen är jag inte helt hemma med callbacks och anonyma funktioner heller så jag kunde inte tolka riktigt allt i koderna.

Jag vet inte om jag vill kalla det svagheter men jag fick lägga till några metoder i de respektive klasserna för att hantera en flerdimensionell kommentarsarray. När kag tittade på hur dispatcher->forward fungerade såg jag att den förutom controller och action accepterade 'params', men jag förtod inte hur jag skulle lyckas använda variabeln. Det var inte förrän efter ett felmeddelande jag såg att det hade skickats med till viewAction i CommentController men det fanns ju ingen parameter i viewAction() som hanterade det. Så jag la till viewAction($pageId).

En annan svaghet jag tänkte på, men inte hunnit förbättra, är validering av input. Eftersom min lösning innebär att kommentarens id och sidtillhörighet syns i URI:n kan man gå utanför indexet och undantag/fel uppstår. Som sagt, inget jag fixat än. Såg att det finns en valideringstjänst i ramverket men inget jag försökt mig på att använda i nuläget.


Kmom03
---------

Det enda jag använt mig av i css-ramverksväg tidigare är 960grid, om man nu kan kalla det ett ramverk. Jag visste inte att den här typen av css ramverk fanns. Under de tidigare kurserna har jag faktiskt funderat på att skriva något liknande själv. Kanske inte lika omfattande men ändå möjliggöra användandet av variabler i css. 

Less och lessphp var riktigt intressant att jobba med. Som sagt har jag saknat vissa funktioner i "vanilj"-css. Semantic.gs var också bra och inblandningen av mixins och variabler för att flytta design från logik är ett strukturellt förståeligt steg. Dock kan jag tycka att det ibland blir lite nitiskt i och med att många av de klasser som är en del av "grovstrukturen" i layout deklareras i viewsen. Därmed är views också en del av layouten eller en del av bryggan mellan logik och layout och "layout-klasser" skulle alltså kunna få finnas där. Men det beror ju på vilken standard man vill följa och så.

I allmänt gillar jag att arbeta med gridbaserad layout eftersom det ger en bra grund att arbeta på och avhjälper enhetlighet i sidorna. Horisontellt har jag använd mig av en del tidigare. Vertikalt gridbaserad layout har jag däremot inte använt tidigare. Men det var ett välkommet inslag med typografi och leading. Jag la kanske ner lite väl mycket tid på det dock.

Font awesome kan säkert vara ett bra verktyg. Kan tänka mig att jag använder det framöver för navigeringssymboler till exempel. Dock gillar jag ju photoshop och att kunna göra mina egna bilder och ikoner så det kommer jag förmodligen fortsätta att använda mig av. Jag fördjupade mig inte närmre i exakt vad Normalize gör. Jag använde Reset ganska flitigt tidigare och om Normalize dessutom lyckas enhetliggöra de olika webbläsarnas output är det jättebra. 

Jag gjorde inga större utsvävningar i strukturen utan höll mig till vad vi gjorde i övningarna. Headern la jag dock ovanför wrappern så att den kan fylla ut bredden på förnstret om man så vill. Däremot skrev jag några mixins som jag själv tycker fungerar ganska bra. En bakgrundsmixin som kombinerar bild, färg och opacitet, en som jämnar ut border och padding så att höjden på elementen håller sig till baslinjen och nån till.

Jag gjorde inte extrauppgiften.

Kmom04
--------

Formulärhanteringen fungerar ganska bra. Jag är fortfarande inte helt med på hur callbacks, anonyma funktioner och closures ska användas så jag känner att jag måste fördjupa mig lite mer i det. Det innebär att jag hade lite problem med att få UserController att utföra något utifrån vad som hände i CFormUser. 

Jag tyckte det var skönt att slippa SQL så jag välkomnar databashanteringen. Efter förra kursen känner jag mig ganska säker på SQL men det känns ändå bra att ha en klass som sköter det så att man inte behöver tänka på det så mycket. Och det faktum att det klarar av olika dialekter är ju väldigt hjälpsamt. 

Basklassen förblev ganska tomma. Comment fick ett par extra metoder i vilka kommentarernas sidtillhörighet kunde användas för att läsa och radera kommentarer.

Min implementering av kommentarer var ganska lik den vi gjorde för användare i övningen. En Comment som är barn till CDatabaseModel och som sagt har extra "sidspecifika" metoder. CommentsController innehåller routes för att skapa, ändra och ta bort kommentarer. CommentsController skapar en CFormComment som innehåller form för kommentarer. På så sätt kan koden i CommentsController kortas ner och all form-elementkod läggs i CFormComment. Jag brottades lite med vilken klass som skulle ha ansvar för att kalla på respektive metod för databashantering, CFormComment eller CommentsController. Jag funderade på att göra en setshared på Comment (och user) och på så sätt låta respektive CForm utföra $this->comment->save(). Men jag kände mig osäker på om det skulle inneburit något annat, kanske säkerhetsrisker eller tyngre applikation, så jag lät CommentsController göra en check som svarade true eller false och utifrån det utföra save(). Hoppas det går att förstå vad jag menar. Kommentarer är tillgängligt under Home och Redovisning.

Det känns som att det blir allt tydligare hur routes, dispatch och ramverket i stort fungerar även om jag inte känner att jag på något sätt bemästrat det än. Vettig uppgift. Kanske skulle den ligga tidigare i kursen?

Jag gjorde inte extrauppgiften. Känner att jag ligger efter nog som det är.


Kmom05
---------

Jag valde att göra en Flash-modul. Jag funderade på en del andra men flash, som var ett av exemplana, verkade relativt enkel och därför en bra "första-modul". Dessutom kände jag att jag hade behövt en under tidigare kursmoment. Nu fick jag tid att skriva en.

Det var inga problem att utveckla flash-modulen. Jag höll den väldigt simpel. Det blev lite rörigt när jag först skrev modulen i ANAX och sen tog bort den för att testa den som extern modul. Lite förvirring med namespaces och så men det löste sig snabbt. 

Att publicera på Packagist var inga större problem heller. Jag blev tillsagd om att det skulle vara liten bokstav i repot. Annars inget strul.

Dokumentationen kändes lite ovan. Jag tittade en del på hur andra skrivit för att få lite hjälp. Av någon anledning är det nästan svårare att skriva dokumentation för sitt eget verk än för någon annans. Men jag hoppas att det går att förstå.

Även om koden i sig är extremt basic var det en ganska häftig känsla när flash-modulen funkade efter composer-installationen.

Jag gjorde inte extrauppgiften.


Kmom06
--------

Jag var inte bekant med någon av teknikerna sedan tidigare.

Det gick bra att göra testfall med PHPUnit. Det handlar ju bara om att spegla grundkoden och jämföra med vad man förväntar sig. Det är säkerligen oftast mycket mer avancerat än vad det blev för mig. Men med min enkla modul var det inga konstigheter. Däremot blev det lite besvärligare när jag skrev en ANAX-specifik child-class.  Tack och lov fanns ju en utmärkt guide att följa när ANAX MVC var en dependancy.

Travis fungerade hur bra som helst. Det är ju väldigt lätt och smärtfritt att sammanfoga Git och Travis. Däremot fastnade genomgången först. Efter lite ångest upptäcjte jag att det inte var något fel jag hade gjort utan att Scrutinizer låg nere så Travis kom inte riktigt vidare.

Inga större problem att integrera med Scrutinizer heller. Förutom, som sagt, att den låg nere nån timme när jag var som mest aktiv med kursmomentet vilket var lite frustrerande. Dock förstår jag inte riktigt varför Scrutinizer ger mig lägre code coverage än min lokala phpunit gör. Lokalt fick jag 100% men scrutinizer verkar inte följa riktigt samma principer.

Lite krångligt var det ju att jobba med verktygen. Däremot kan jag tänka mig att det är ganska givande. Det är verktyg som hjälper till att sätta en standard, vilket många verkar tycka behövs i alla fall. Jag vet inte om jag kommer att fortsätta använda verktygen, det kommer förmodligen bero på sammanhang. Men jag vet samtidigt hur jobbigt det är att upptäcka en bugg timmar eller dagar efter att en kod skrivits. Ges tester en större roll och rutinmässig plats kan det arbetet förenklas väldigt mycket. Och lyssnar man på den feedback man får är det också misstag som man kan utvecklas till att inte begå igen (iaf inte lika ofta).

Jag gjorde inte extrauppgiften.