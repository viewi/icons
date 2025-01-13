<?php

namespace Viewi\Icons\Build;

use Viewi\Builder\Attributes\Skip;
use Viewi\Builder\BuildAction\BuildActionItem;
use Viewi\Builder\BuildAction\IPostBuildAction;
use Viewi\Builder\Builder;
use Viewi\Icons\ViewiIcons;
use Viewi\TemplateParser\TagItem;
use Viewi\TemplateParser\TagItemType;

#[Skip]
class IconsSpriteBuild implements IPostBuildAction
{
    public function build(Builder $builder, array $props): ?BuildActionItem
    {
        $tokens = $builder->getTokensMap();
        $fullSprite = file_get_contents(ViewiIcons::getSpritePath());
        $symbols = explode("<symbol ", $fullSprite);
        $sprite = $symbols[0];
        $length = count($symbols);
        $lastSymbol = explode('symbol>', $symbols[$length - 1]);
        $symbols[$length - 1] = $lastSymbol[0] . 'symbol>';
        $symbols[] = $lastSymbol[1];
        $i = 1;
        $length = count($symbols);
        $searchEnd = $length - 1;
        while ($i < $searchEnd) {
            // find id
            $pos = strpos($symbols[$i], "id=");
            if ($pos !== false) {
                $pos = $pos + 4;
                $posEnd = strpos($symbols[$i], '"', $pos);
                if ($posEnd !== false) {
                    $id = substr($symbols[$i], $pos, $posEnd - $pos);
                    $id = "bi-$id";
                    if (isset($tokens[$id])) {
                        $sprite .= '<symbol ' . str_replace("id=\"", "id=\"bi-", $symbols[$i]);
                    }
                }
            }
            $i++;
        }
        $sprite .= $symbols[$length - 1];

        // get build item
        $parser = $builder->getTemplateParser();
        $rootTag = $parser->parse('<div style="display: none;"></div>');
        $rawSprite = new TagItem();
        $rawSprite->Content = $sprite;
        $rawSprite->RawHtml = true;
        $rawSprite->Type = new TagItemType(TagItemType::TextContent);
        $divChildren = $rootTag->getChildren()[0]->getChildren();
        $rootTag->getChildren()[0]->setChildren([
            ...$divChildren,
            $rawSprite
        ]);
        $builder->replaceTemplate('IconsSprite', null, $rootTag);
        return null;
    }
}
