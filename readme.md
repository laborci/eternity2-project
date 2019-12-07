# Install

- edit: `composer create-project laborci/eternity2project YOUR-PROJECT`
- run: `./phlex dirs` - létrehozza a még nem létező mappákat
- edit: `etc/ini/env.yml` - Az alső sorban állítsd be a kívánt root domain-t
- edit: `etc/ini/config/database.yml` - Állítsd be az adatbázisod hozzáférést
- run: `./phlex vhost` - generálja a vhost állományt
- edit: Az apache kiszolgáló httpd.conf fájljában inklúdáld a generált vhost fájlt.
`Include <porject-path>/var/virtualhost.conf`
- indítsd újra az apache kiszolgálót (vagy legalább reload)
- hozd létre a beállításaidnak megfelelő üres adatbázist
- run `./phlex install -tu` - létrehozza az user táblát és egy alap felhasználót
- run: `npm install`
- run: `npm run work`
- test: próbáld ki a beállított domaint, azt várjuk: it works!
- test: próbáld ki az admint (`admin.YOURDOMAIN`). User: elvis@eternity Pass: vegas

# Fájlstruktúra

A fájlrendszer úgy lett kialakítva, hogy a fejlesztés közben a legfontosabb
fájlok könnyen elérhetőek legyenek. A fájlstruktúra szabadon módosítható bizonyos
keretek között. Az útvonalakra hivatkozások az alábbi fájlokban találhatóak:
- `composer.json` `autoload/psr-4` 
- `package.json`
- `etc/ini`
 
## app.ghost

> namespace: `\Ghost` 

Itt tartja a rendszer az entitásokat.

## app

Az alkalmazásod központi fájljai
- `Module` - központi modulok
- `Service` - központi szervizek
- `index.php` - bootstrap file

## Missionök

Az `app@...` folderek a Missionök rootjai. Általános szerkezetként a telepített
példából az `app@web` tekinthető, a többi három bizonyos szempontból egyedi.

### app@admin

Az admin felülethez tartozó állományok
- `app` - az alkalmazásod frontend rootja
- `codex` - formleírók helye
> namespace: `\Application\AdminCodex` 
- `style` - stílus fájlok az adminhoz. Alapvetően a fontok betöltése.

> mivel az admin alkalmazás nagy része npm és composer csomagokban van, és az
> egész modulként kerül betöltésre, itt már csak annak kiegészítései szerepelnek.

### app@api

> namespace: `\Application\Mission\Api` 

Az alkalmazásod API ágának Mission-je.

> mivel itt nincs front-end, ezért maga a folder a mission root.


### app@cli

> namespace: `\Application\Cli` 

A saját cli parancsaid helye.

> a cli megvalósítása teljesen az *eternity* feladata, ezért itt csak a saját
> parancsaidat kell felsorolnod.

### app@web

- `app` - az alkalmazásod frontend rootja
- `mission` - a web alkalmazás missionje
> namespace: `\Application\Mission\Web` 
- `style` - stílus fájlok
- `templates` - twig template-ek  

## assets

Az alkalmazásod assetei. Alapvetően az apache rewreite-ok úgy vannak megírva,
hogy az `~` jellel kezdődő útvonalakat nem bántják, az nem kerül átadásra a
`router`-nek. Ezért az assetek is tipikusan `~web`, `~admin` és hasonló mappákba
kerülnek.

## data

Az alkalmazásod itt tárolja az adatait. Ide tehetsz te is fájlokat.

- `attachment` - az entitásaidhoz kapcsolt fájlok ide kerülnek, webről az `~fs/`
útvonalról érhetőek el.
- `attachment-meta` - az entitásokhoz kapcsolt fájlokat leíró sqlite3 adatbázisok
kerülnek ide. 

## dev

A fejlesztéshez kapcsolódó fájlok helye.

- `dump` - adatbázis dumpok kerülnek ide, amiket a `phlex dump` cli paranccsal
generálhatsz.

## etc

- `ini` - a rendszer konfiguráció helye
- `vhost` - a vhost template helye

## public

A kiszolgálás gyökér, ide kerülnek átmásolásra az assetek, ide fordít a z-build,
ide másolódik át az `app/index.php` fájl is. Bármikor üríthető, a tartalma 
újra generálható.

## var

Log és cache állományok helye, teljes egészében törölhető, a tartalma generálható.

- `annotations-cache` - a php annotáció olvasó cache mappája
- `output-cache` - a responderek kimeneti cache mappája 
- `template-cache` - a twig állományok cache mappája
- `thumbnail` -  a legyártott thumbnail-ek helye
- `tmp` - tmp
- `error.log` - apache log
- `app.log` - az alkalmazásod default logfájlja
- `env.php` - az `etc.ini`-ben levő yml fájlok php verziója
- `virtualhost.conf` - a generált virtualhost file

## / (root)

- `build-number` - az alkalmazásod frontend build verziója 
- `composer.json`
- `package.json`
- `phlex` - cli interface belépési pont 
- `webpack.config.js` - felkonfigurált zengular fordító
