# RRZE-Typesettings
WordPress-Plugin: Shortcode und Gutenberg Block, für das Highlightening von Code 

## Verwendung des Shortcodes

```html
[highlight-code]
[highlight-code lang="php"]
[highlight-code lang="python" theme="dark"]
[highlight-code lang="sql" linenumbers="off"]
```

## Alle Attribute des Shortcodes

```html
[highlight-code 
lang=".."
theme=".."
linenumbers=".."
]
```

Alle Attribute sind optional.

## Default

Zeilennummern werden angezeigt.
Javascript ist vorausgewählt.

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
