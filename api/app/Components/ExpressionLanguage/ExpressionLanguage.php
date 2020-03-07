<?php

namespace App\Components\ExpressionLanguage;

use Symfony\Component\ExpressionLanguage\ExpressionLanguage as SymfonyExpressionLanguage;

class ExpressionLanguage
{

    protected $symfonyExpressionLanguage;

    public function __construct(SymfonyExpressionLanguage $expressionLanguage)
    {
        $this->symfonyExpressionLanguage = $expressionLanguage;
    }

    public function validate(string $scope, string $expression)
    {

    }

    public function evaluate(string $expression, VariableBundleContract $bundle)
    {
        return $this->symfonyExpressionLanguage->evaluate($expression, $bundle->getVariables());
    }
}
