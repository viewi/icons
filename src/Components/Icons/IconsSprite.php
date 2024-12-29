<?php

namespace ViewiIcons\Icons;

use Viewi\Components\Attributes\PostBuildAction;
use Viewi\Components\BaseComponent;

#[PostBuildAction(IconsSpriteBuild::class)]
class IconsSprite extends BaseComponent
{
    
}