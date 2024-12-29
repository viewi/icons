<?php

namespace Viewi\Icons\Build;

use Viewi\Builder\Attributes\Skip;
use Viewi\Builder\BuildAction\BuildActionItem;
use Viewi\Builder\BuildAction\IPostBuildAction;
use Viewi\Builder\Builder;
use Viewi\TemplateParser\TagItemConverter;
use Viewi\Icons\ViewiIcons;

#[Skip]
class IconsSpriteBuild implements IPostBuildAction
{
    public function build(Builder $builder, array $props): ?BuildActionItem
    {
        $tokens = $builder->getTokensMap();
        $fullSprite = file_get_contents(ViewiIcons::getComponentsPath() . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'bootstrap-icons.svg');
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
                    if (isset($tokens[$id])) {
                        $sprite .= '<symbol ' . $symbols[$i];
                    }
                }
            }
            $i++;
        }
        $sprite .= $symbols[$length - 1];

        // get build item
        $parser = $builder->getTemplateParser();
        $rootTag = $parser->parse('<div style="display: none;">' . $sprite . '</div>');
        // parse template
        $templateCompiler = $builder->getTemplateCompiler();
        $buildItem = $builder->getBuildItem('IconsSprite');

        $template = $templateCompiler->compile($rootTag, $buildItem);
        // build render function
        $buildItem->RenderFunction = $template;
        $buildItem->RootTag = $rootTag;
        $content = $buildItem->RenderFunction->generatePhpContent();
        $renderRelativePath = DIRECTORY_SEPARATOR . $buildItem->RelativePath;
        $buildPath = $builder->getBuildPath();
        $renderFunctionDir = $buildPath . $renderRelativePath;
        $renderFunctionPath = $renderRelativePath . DIRECTORY_SEPARATOR .
            $buildItem->ComponentName . '.php';
        file_put_contents($buildPath . $renderFunctionPath, $content);
        $meta = $builder->getMeta();

        $meta->meta['components'][$buildItem->ComponentName]['Path'] = $renderFunctionPath;
        $meta->meta['components'][$buildItem->ComponentName]['Function'] = $buildItem->RenderFunction->renderName;
        // build js render
        $meta->publicJson[$buildItem->ComponentName]['nodes'] = TagItemConverter::getRaw($buildItem->RootTag);



        return null;
    }
}
