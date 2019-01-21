=== SDROST CLASSES ===
Contributors: sdwebdevelopment
Tags: classes, timetable, responsive
Requires at least: 4.9.5
Tested up to: 5.0
Stable tag: 1.2.1
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Mit diesem Plugin können sie Kurszeiten verwalten und in einer Tabelle in Seiten und Beiträgen integrieren.
Zeiten und Standorte können für verschiedene Kurse festgelegt werden.

== Description ==

Das Plugin **SDrost Classes** ermöglicht es, Kurse zu verwalten. Informationen wie Zeiten, Ort und Trainer
können einfach bearbeitet werden. Die unterschiedlichen Standorte können separat erstellt und mit den
Kursen verküpft werden.

Für die Einbettung der Kurszeiten steht der Shortcode `[sdrost_classes]` bereit. Über das Attribut `class` kann ein
Kurs referenziert werden, z.B. `[sdrost_classes class="volleyball"]`. Voraussetzung ist, dass eine Seite für den
entsprechenden Kurs existiert.

Die farbliche Gestaltung der Tabelle kann in der Einstellungsseite angepasst werden.

*Momentan gibt es das Plugin nur in der deutschen Variante.*

Core Features auf einen Blick:
------------------------------

* Kurszeiten für verschiedene Kurse anlegen
* Standorte anlegen und mit Kursen verknüpfen
* Trainer anlegen und mit den Kursen verknüpfen
* responsive Ausgabe der Kurszeiten in Tabellenform
* Farbe der Tabellenausgabe kann angepasst werden

== Installation ==

1. Lade das Plugin auf deinen Server in das `/wp-content/plugins/sdrost-classes` Verzeichnis oder nutze direkt die Wordpress Plugin Seite, um das Plugin zu intsallieren
2. Aktiviere das Plugin unter dem Menüpunkt 'Plugins' im Adminbereich in WordPress


== Frequently Asked Questions ==

= Wie kann ich die Kurse anzeigen =

Um die Kurstabelle in Seiten und Beiträgen zu integrieren muss der Shortcode `[sdrost_classes class="Seite"]` genutzt werden.
In das Class-Attribut muss die entsprechende Kursseite eingefügt werden.

= Wie kann ich die Farbe der Tabellen-Header ändern? =

Um die Farbe an ihr Theme anzupassen, gehen Sie einfach unter Einstellungen -> SDrost Classes. Dort können sie eine beliebige Farbe setzen.

== Screenshots ==

1. Anzeige der Kurse in Seiten und Beiträgen
2. Verwaltung von Kurszeiten
3. Standort bearbeiten
4. Kurs bearbeiten

== Changelog ==

= 1.2.1 =
* Limit für Trainer Auswahl erhöhen

= 1.2.0 =
* Trainer anlegen und mit den Kursen verknüpfen
* Kurse nach Ort gruppieren

= 1.1.0 =
* Optimierungen in der Darstellung
* Kursnotiz hinzugefügt
* Screenshots hinzugefügt

= 1.0.0 =
* erste stabile Version
