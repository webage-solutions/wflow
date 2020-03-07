<?php

namespace App\Components\ExpressionLanguage\LanguageProviders;

use function MongoDB\BSON\fromPHP;
use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;

class NativeLanguageProvider implements ExpressionFunctionProviderInterface
{

    /**
     * @return ExpressionFunction[] An array of Function instances
     */
    public function getFunctions()
    {
        return [
            //ExpressionFunction::fromPHP('trim');
        ];
    }
}
