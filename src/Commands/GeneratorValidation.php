<?php

namespace GrupoCometa\Validations\Commands;

use GrupoCometa\Validations\Generators\FacadeGenerator;
use Illuminate\Console\Command;


class GeneratorValidation extends Command
{
    protected $signature = 'validations:generator {namespaceModel}';
    protected $description = 'Gere validações baseas em suas migrations Ex: php artisan  validai';

    public function handle()
    {
        $strClass = $this->argument('namespaceModel');
        $model = new $strClass;

        $facadeGenerator = new FacadeGenerator($model);

        $facadeGenerator->validationStore();
        $facadeGenerator->validationUpdate();
    }
}
