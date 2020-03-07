<?php

namespace App\Components\ExpressionLanguage;

use App;
use App\Components\ExpressionLanguage\LanguageProviders\NativeLanguageProvider;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage as SymfonyExpressionLanguage;

class ExpressionLanguageServiceProvider extends ServiceProvider
{
    public function boot()
    {

    }

    public function register()
    {
        App::bind(SymfonyExpressionLanguage::class, function () {
            $expressionLanguage = new SymfonyExpressionLanguage();
            $expressionLanguage->registerProvider(new NativeLanguageProvider());
            return $expressionLanguage;
        });
        App::bind('expressionlanguage', ExpressionLanguage::class);
    }
}
