<?php

namespace Viewi\Icons\UI;

use Viewi\Components\Attributes\PostBuildAction;
use Viewi\Components\BaseComponent;
use Viewi\Icons\Build\IconsSpriteBuild;

#[PostBuildAction(IconsSpriteBuild::class)]
class IconsSprite extends BaseComponent
{
    
}