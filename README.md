# Viewi Icons package

## SVG Sprites:

- Has bootstrap icons on board [https://icons.getbootstrap.com/](https://icons.getbootstrap.com/)

## SVG sprite vs. Font icons

An SVG sprite renders directly into the page (or can be accessed as an asset with a URL). Then, you can use the icon from that sprite.
Sprite includes only those icons that you really want to use.

Font icons require you to include links to the font and css, which have all the icons altogether, even if you are not using most of them.

## How to use

`composer require viewi/icons`

In your Viewi config:

Add `use Viewi\Icons\ViewiIcons;`

Use the package `->use(ViewiIcons::class)`;

```php

<?php

use Viewi\AppConfig;
use Viewi\Icons\ViewiIcons;

// ...

$viewiConfig = (new AppConfig('my-app'))
    ->use(ViewiIcons::class)
    
// ...

return $viewiConfig;
```

Add sprite component `IconsSprite` at the beginning of the `body` tag in your layout component, for example:

```html
<!DOCTYPE html>
<html lang="en" data-bs-theme="{ $darkMode->dark ? 'dark' : 'light' }">

<head>
    <title>
        $title | {t('layout.title')}
    </title>
    ...
</head>

<body>
    <IconsSprite />
    ...
    <ViewiAssets />
</body>

</html>
```

`IconsSprite` renders the sprite (or SVG map) with icons that you use. 

Package will analyze your source code and include only those icons that you really use.

For example, if you use `emoji-sunglasses` icon only, it will render something like this:

```html
<div style="display: none;">
    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <symbol class="bi bi-emoji-sunglasses" viewBox="0 0 16 16" id="emoji-sunglasses">
            <path d="M4.968 9.75a.5.5 0 1 0-.866.5A4.5 4.5 0 0 0 8 12.5a4.5 4.5 0 0 0 3.898-2.25.5.5 0 1 0-.866-.5A3.5 3.5 0 0 1 8 11.5a3.5 3.5 0 0 1-3.032-1.75M7 5.116V5a1 1 0 0 0-1-1H3.28a1 1 0 0 0-.97 1.243l.311 1.242A2 2 0 0 0 4.561 8H5a2 2 0 0 0 1.994-1.839A3 3 0 0 1 8 6c.393 0 .74.064 1.006.161A2 2 0 0 0 11 8h.438a2 2 0 0 0 1.94-1.515l.311-1.242A1 1 0 0 0 12.72 4H10a1 1 0 0 0-1 1v.116A4.2 4.2 0 0 0 8 5c-.35 0-.69.04-1 .116"></path>
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-1 0A7 7 0 1 0 1 8a7 7 0 0 0 14 0"></path>
        </symbol>
    </svg>
</div>
```

Use the icon:

```html
<Icon name="emoji-sunglasses" />
```

This will render something like this:

```html
<svg>
    <use xlink:href="#emoji-sunglasses"></use>
</svg>
```

Custom class with `classList`:

```html
<Icon name="emoji-sunglasses" classList="my-icon" />
```

Will render:

```html
<svg class="my-icon">
    <use xlink:href="#emoji-sunglasses"></use>
</svg>
```

Support
--------

We all have full-time jobs and dedicate our free time to this project, and we would appreciate Your help of any kind. If you like what we are creating here and want us to spend more time on this, please consider supporting:

 - Give us a star⭐.
 - Support me on [buymeacoffee](https://www.buymeacoffee.com/ivan.v)
 - Follow us on [Twitter/X](https://x.com/viewiphp).
 - Contribute by sending pull requests.
 - Any other ideas or proposals? Please mail me voitovych.ivan.v@gmail.com.
 - Feel welcome to share this project with your friends.


License
--------

Copyright (c) 2020-present Ivan Voitovych

Please see [MIT](/LICENSE) for license text