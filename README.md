=== RRZE Typesettings ===
Contributors: rrze-webteam
Plugin URI: https://github.com/RRZE-Webteam/rrze-typesettings/
Tags: code, syntax highlighting, shortcode, block
Requires at least: 6.4
Tested up to: 6.6
Requires PHP: 8.2
Stable tag: 1.2.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Author: RRZE Webteam
Author URI: https://blogs.fau.de/webworking/
Text Domain: rrze-typesettings
Domain Path: /languages

Plugin zur Darstellung von Code.


# RRZE-Typesettings

WordPress-Plugin: Shortcode und Gutenberg Block, für das Highlightening von Code 


## Verwendung als Block

Wählen Sie dazu den Block "Code Highlighter RRZE" aus.


## Verwendung als Shortcode

```html
[highlight-code]
...
[/highlight-code]

[highlight-code lang="php"]
...
[/highlight-code]

[highlight-code lang="python" theme="dark"]
...
[/highlight-code]

[highlight-code lang="sql" linenumbers="false"]
...
[/highlight-code]

[highlight-code copy="false"]
...
[/highlight-code]
```

## Alle Attribute des Shortcodes

```html
[highlight-code 
lang=".."
theme=".."
linenumbers=".."
copy=".."
]
```

Alle Attribute sind optional.

## Default

Zeilennummern werden angezeigt.
Javascript ist vorausgewählt.
Button "Copy to clipboard" wird angezeigt.

## Unterstützte Sprachen:

Sprache => Wert für "lang":

```
C => c,
C++ => cpp,
C# => csharp,
CSS => css,
HTML => markup,
Java => java,
JavaScript => javascript,
JSON => json,
Perl => perl,
PHP => php,
Python => python,
React => jsx,
Regex => regex,
SASS => sass,
SQL => sql,
XML => markup
```

## Unterstützte Themes:

```
default
light
dark
okaidia
```


